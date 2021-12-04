<?php
    

//from http://www.devwilliam.com.br/php/sistema-de-login-com-ajax-e-php
//setar timezone
date_default_timezone_set('America/Fortaleza');

// Constante com a quantidade de tentativas aceitas
define('TENTATIVAS_ACEITAS', 5); 

// Constante com a quantidade minutos para bloqueio
define('MINUTOS_BLOQUEIO', 30); 

require_once ('../config.php');

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'login'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;


// Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Recebe os dados do formulário
$email = (isset($_POST['email'])) ? $_POST['email'] : '' ;
$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '' ;


// Passo 2 - Validações de preenchimento e-mail e senha se foi preenchido o e-mail
if (empty($email)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu e-mail!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($senha)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha sua senha!');
	echo json_encode($retorno);
	exit();
endif;


// Passo 3 - Verifica se o formato do e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
    $retorno = array('codigo' => 0, 'mensagem' => 'Formato de e-mail inválido!');
	echo json_encode($retorno);
	exit();
endif;


// Passo 4 - Verifica se o usuário já excedeu a quantidade de tentativas erradas do dia
$sql = 'CREATE TABLE IF NOT EXISTS log_tentativas (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	ip varchar(100) NOT NULL,
	data_hora datetime NOT NULL DEFAULT current_timestamp(),
	email varchar(100) NOT NULL,
	senha varchar(100) NOT NULL,
	origem varchar(100) NOT NULL,
	bloqueado char(3) NOT NULL
);';
$stm = $conexao->prepare($sql);
$stm->execute();      


$sql = "SELECT count(*) AS tentativas, MINUTE(TIMEDIFF(NOW(), MAX(data_hora))) AS minutos , data_hora AS tempo FROM log_tentativas WHERE ip = ?  AND bloqueado = ?";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $_SERVER['SERVER_ADDR']);
$stm->bindValue(2, 'SIM');
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);


if (!empty($retorno->tentativas) && intval($retorno->minutos) <= MINUTOS_BLOQUEIO):
	$_SESSION['tentativas'] = 0;
	$retorno = array('codigo' => 0, 'mensagem' => 'Você excedeu o limite de '.TENTATIVAS_ACEITAS.' tentativas, login bloqueado por '.MINUTOS_BLOQUEIO.' minutos!'.$retorno->minutos.' - '.$retorno->tempo);
	echo json_encode($retorno);
	exit();
endif;  


// Passo 5 - Válida os dados do usuário com o banco de dados
$sql = "SELECT id, email, nome, sobrenome, senha, data_criado  FROM users_teachers WHERE email = ? AND status = ? LIMIT 1";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $email);
$stm->bindValue(2, 'A');
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);


// Passo 5.5 Gera o Hash da senha
if (!empty($retorno)) {
    $hash = password_hash($retorno->senha, PASSWORD_DEFAULT);
}

// Passo 6 - Válida a senha utlizando a API Password Hash
if(!empty($retorno) && password_verify($senha, $hash)):
	$_SESSION['logado'] = 'SIM';
	$_SESSION['email'] = $email;
	$_SESSION['id'] = $retorno->id;
	$_SESSION['nome'] = $retorno->nome;
	$_SESSION['sobrenome'] = $retorno->sobrenome; 
	$_SESSION['data_criado'] = $retorno->data_criado; 
	$_SESSION['tentativas'] = 0;
	$_SESSION['cargo'] = 'professor';

	if(isset($_POST['login_remember'])){
		setcookie('login_remember',true,time()+(60*60*24),'/');
		setcookie('email',$email,time()+(60*60*24),'/');
		setcookie('senha',$senha,time()+(60*60*24),'/');
	}else{
		setcookie('login_remember',true,time()-1,'/');
		setcookie('email',$email,time()-1,'/');
		setcookie('senha',$senha,time()-1,'/');	
	}  

	// Passo 6.5 Grava o último login
	$sql = 'UPDATE users_teachers SET data_ultimo_login = ? WHERE users_teachers.id = ? ';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, date('Y-m-d H:i:s'));
	$stm->bindValue(2, $retorno->id);
	$stm->execute();
else:
	$_SESSION['logado'] = 'NAO';
	$_SESSION['tentativas'] = (isset($_SESSION['tentativas'])) ? $_SESSION['tentativas'] += 1 : 1;
	$bloqueado = ($_SESSION['tentativas'] == TENTATIVAS_ACEITAS) ? 'SIM' : 'NAO';

	// Passo 7 - Grava a tentativa independente de falha ou não
	$sql = 'INSERT INTO log_tentativas 	(ip, email, senha, origem, bloqueado) VALUES (?, ?, ?, ?, ?)';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $_SERVER['SERVER_ADDR']);
	$stm->bindValue(2, $email);
	$stm->bindValue(3, $senha);
	$stm->bindValue(4, $_SERVER['HTTP_REFERER']);
	$stm->bindValue(5, $bloqueado);
	$stm->execute();
endif;


// Passo 8 -Se logado envia código 1, senão retorna mensagem de erro para o login
if ($_SESSION['logado'] == 'SIM'):
	$retorno = array('codigo' => 1, 'mensagem' => 'Logado com sucesso!');
	echo json_encode($retorno);
	exit();
else:
	if ($_SESSION['tentativas'] == TENTATIVAS_ACEITAS):
		$retorno = array('codigo' => 0, 'mensagem' => 'Você excedeu o limite de '.TENTATIVAS_ACEITAS.' tentativas, login bloqueado por '.MINUTOS_BLOQUEIO.' minutos!');
		echo json_encode($retorno);
		exit();
	else:
		$retorno = array('codigo' => '0', 'mensagem' => 'Usuário não autorizado, você tem mais '. (TENTATIVAS_ACEITAS - $_SESSION['tentativas']) .' tentativa(s) antes do bloqueio! ');
		echo json_encode($retorno);
		exit();
	endif;
endif;