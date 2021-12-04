<?php
//from http://www.devwilliam.com.br/php/sistema-de-login-com-ajax-e-php
//setar timezone
date_default_timezone_set('America/Fortaleza');


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
$nome = (isset($_POST['nome'])) ? $_POST['nome'] : '' ;
$sobrenome = (isset($_POST['sobrenome'])) ? $_POST['sobrenome'] : '' ;
$emailCriado = (isset($_POST['createEmail'])) ? $_POST['createEmail'] : '' ;
$senhaCriada = (isset($_POST['createSenha'])) ? $_POST['createSenha'] : '' ;
$confirmEmailCriado = (isset($_POST['confirmEmail'])) ? $_POST['confirmEmail'] : '' ;
$confirmSenhaCriada = (isset($_POST['confirmSenha'])) ? $_POST['confirmSenha'] : '' ;

// Passo 2 - Validações de preenchimento e-mail e senha e se todos os campos foram preenchidos
if (empty($nome)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu nome!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($sobrenome)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu sobrenome!');
	echo json_encode($retorno);
	exit();
endif;
if (empty($emailCriado)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu e-mail!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($senhaCriada)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha sua senha!');
	echo json_encode($retorno);
	exit();
endif;
if (empty($confirmEmailCriado)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Confirme seu e-mail!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($confirmSenhaCriada)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Confirme sua senha!');
	echo json_encode($retorno);
	exit();
endif;



// Passo 3 - Verifica se o formato do e-mail é válido
if (!filter_var($emailCriado, FILTER_VALIDATE_EMAIL)):
    $retorno = array('codigo' => 0, 'mensagem' => 'Formato de e-mail inválido!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 3.5 Gera o Hash da senha
$hash = password_hash($senhaCriada, PASSWORD_DEFAULT);
 
//Passo 4 Verifica a confirmação do email e senhas
if($emailCriado != $confirmEmailCriado){
    $retorno = array('codigo' => 0, 'mensagem' => 'Emails fornecidos são diferentes!');
	echo json_encode($retorno);
	exit();
}

if(!password_verify($confirmSenhaCriada, $hash)){
    $retorno = array('codigo' => 0, 'mensagem' => 'Senhas fornecidas são diferentes!');
	echo json_encode($retorno);
	exit();
}

// Passo 5 - Criar tabela se não existir

$sql = 'CREATE TABLE IF NOT EXISTS users_teachers (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	email varchar(33) NOT NULL,
	nome varchar(100) NOT NULL,
	sobrenome varchar(100) NOT NULL,
	data_nascimento date DEFAULT NULL,
	senha varchar(100) NOT NULL,
	data_criado datetime NOT NULL DEFAULT current_timestamp(),
	data_ultimo_login  datetime DEFAULT NULL,
	status char(3) NOT NULL,
	online char(3) NOT NULL
);';
$stm = $conexao->prepare($sql);
$stm->execute();



$sql = 'CREATE TABLE IF NOT EXISTS teachers_info (
	id int(11) PRIMARY KEY,
	profile_pic LONGBLOB NOT NULL,
	rooms varchar(3000) NOT NULL,
	students_created varchar(3000) NOT NULL,
	rooms_created varchar(3000) NOT NULL,
	missions_created varchar(3000) NOT NULL,
	cargo varchar(33) NOT NULL
);';
$stm = $conexao->prepare($sql);
$stm->execute();

// Passo 6 - Procura se o email já existe no banco de dados
$sql = "SELECT  email  FROM users_teachers WHERE email = ?";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $emailCriado);
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);

if(!empty($retorno->email)){
    $retorno = array('codigo' => 0, 'mensagem' => 'Esse email já está cadastrado');
	echo json_encode($retorno);
	exit();
}




// Passo 7 - Criar usuário professor
	$sql = 'INSERT INTO users_teachers 	(email, nome, sobrenome, data_criado, senha, status) VALUES (?, ?, ?, ?, ?, ?)';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $emailCriado);
	$stm->bindValue(2, $nome);
	$stm->bindValue(3, $sobrenome);
	$stm->bindValue(4, date('Y-m-d H:i:s'));
	$stm->bindValue(5, $senhaCriada);
	$stm->bindValue(6, 'A');
	$stm->execute();

	$last_id = $conexao->lastInsertId();

	$sql = 'INSERT INTO  teachers_info (id, profile_pic, birthday, rooms, students_created, rooms_created, missions_created, cargo) SELECT  ?, "", "", "", "", "", "", "professor" WHERE NOT EXISTS ( SELECT 1 FROM teachers_info WHERE id = ? )';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $last_id);
	$stm->bindValue(2, $last_id);
	$stm->execute();

    $retorno = array('codigo' => 1, 'mensagem' => 'Novo professor cadastrado.');
	echo json_encode($retorno);
	exit();