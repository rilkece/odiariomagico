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
$mat = (isset($_POST['matricula'])) ? $_POST['matricula'] : '' ;
$senha = (isset($_POST['senhaAluno'])) ? $_POST['senhaAluno'] : '' ;



// Passo 2 - Validações de preenchimento e-mail e senha se foi preenchido o e-mail
if (empty($mat)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha sua matrícula');
	echo json_encode($retorno);
	exit();
endif;

if (empty($senha)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha sua senha!');
	echo json_encode($retorno);
	exit();
endif;



// Passo 3 - Válida os dados do usuário com o banco de dados
$sql = "SELECT *  FROM users_students WHERE id = ? AND status = ? LIMIT 1";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $mat);
$stm->bindValue(2, 'A');
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);



// Passo 3.5 Gera o Hash da senha
if (!empty($retorno)) {
    $hash = password_hash($retorno->senha, PASSWORD_DEFAULT);
}

// Passo 4 - Válida a senha utlizando a API Password Hash
if(!empty($retorno) && password_verify($senha, $hash)):
	$_SESSION['logado'] = 'SIM';
	$_SESSION['email'] = 'estudante';
	$_SESSION['senha'] = $retorno->senha;
	$_SESSION['id'] = $retorno->id;
	$_SESSION['nome'] = $retorno->nome;
	$_SESSION['sobrenome'] = $retorno->sobrenome; 
	$_SESSION['nascimento'] = $retorno->data_nascimento; 
	$_SESSION['data_criado'] = $retorno->data_criado; 
	$_SESSION['cargo'] = 'estudante';


	// Passo 4.5 Grava o último login
	$sql = 'UPDATE users_students SET data_ultimo_login = ? WHERE users_students.id = ? ';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, date('Y-m-d H:i:s'));
	$stm->bindValue(2, $retorno->id);
	$stm->execute();
else:
	$_SESSION['logado'] = 'NAO';

endif;

// Se logado envia código 1, senão retorna mensagem de erro para o login
if ($_SESSION['logado'] == 'SIM'):
	$retorno = array('codigo' => 1, 'mensagem' => 'Logado com sucesso!');
	echo json_encode($retorno);
	exit();
else:	
		$retorno = array('codigo' => '0', 'mensagem' => 'Usuário não autorizado, fale com seu professor ou professora.');
		echo json_encode($retorno);
		exit();
endif;

$retorno = array('codigo' => 0, 'mensagem' => 'Opaaa!');
	echo json_encode($retorno);
	exit();

?>