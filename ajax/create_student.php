<?php
//setar timezone
date_default_timezone_set('America/Fortaleza');

require_once ('../config.php');

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'home'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Recebe os dados do formulário
$nomeStudent = (isset($_POST['novo_estudante_nome'])) ? $_POST['novo_estudante_nome'] : '' ;
$sobrenomeStudent = (isset($_POST['novo_estudante_sobrenome'])) ? $_POST['novo_estudante_sobrenome'] : '' ;
$birthdayStudent= (isset($_POST['novo_estudante_nascimento'])) ? $_POST['novo_estudante_nascimento'] : '' ;
$senhaStudent = (isset($_POST['novo_estudante_senha'])) ? $_POST['novo_estudante_senha'] : '' ;
$confirmSenhaCriadaStudent = (isset($_POST['novo_estudante_confirma_senha'])) ? $_POST['novo_estudante_confirma_senha'] : '' ;

// Passo 2 - Validações de preenchimento e se todos campos foram preenchidos
if (empty($nomeStudent)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha o nome!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($sobrenomeStudent)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha o sobrenome!');
	echo json_encode($retorno);
	exit();
endif;
if (empty($birthdayStudent)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu nascimento!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($senhaStudent)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha a senha!');
	echo json_encode($retorno);
	exit();
endif;
if (empty($confirmSenhaCriadaStudent)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Confirme a senha');
	echo json_encode($retorno);
	exit();
endif;

// Passo 3 - Cria a tabela caso não exista

$sql = 'CREATE TABLE IF NOT EXISTS users_students (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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



$sql = 'CREATE TABLE IF NOT EXISTS students_info (
	id int(11) PRIMARY KEY,
	profile_pic LONGBLOB NOT NULL,
	rooms varchar(3000) NOT NULL,
	cargo varchar(33) NOT NULL,
	xp int(11) NOT NULL,
	badges varchar(3000) NOT NULL

);';
$stm = $conexao->prepare($sql);
$stm->execute();
 
//Passo 4 Verifica as senhas

// Gera o Hash da senha
$hash = password_hash($senhaStudent, PASSWORD_DEFAULT);


if(!password_verify($confirmSenhaCriadaStudent, $hash)){
    $retorno = array('codigo' => 0, 'mensagem' => 'Senhas fornecidas são diferentes!');
	echo json_encode($retorno);
	exit();
}

// Passo 5 - Criar usuário estudante
$sql = 'INSERT INTO users_students 	(nome, sobrenome, data_nascimento, data_criado, data_ultimo_login, senha, status, online) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $nomeStudent);
$stm->bindValue(2, $sobrenomeStudent);
$stm->bindValue(3, $birthdayStudent);
$stm->bindValue(4, date('Y-m-d H:i:s'));
$stm->bindValue(5, '');
$stm->bindValue(6, $senhaStudent);
$stm->bindValue(7, 'A');
$stm->bindValue(8, 'N');
$stm->execute();

$last_id = $conexao->lastInsertId();

$sql = 'INSERT INTO  students_info (id, profile_pic, rooms, cargo, xp, badges) VALUES (?, "", "", "estudante", ?, "")';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $last_id);
$stm->bindValue(2, 0);
$stm->execute();


$sql = 'SELECT students_created FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $_SESSION['id']);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$students_created = unserialize($stc->students_created);
$students_created[] = $last_id;
$students_created_array = serialize($students_created);
$sql = 'UPDATE teachers_info SET students_created = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $students_created_array);
$stm->bindValue(2, $_SESSION['id']);
$stm->execute(); 


$retorno = array('codigo' => 1, 'mensagem' => 'Novo estudante criado cadastrado. Matrícula: '.$last_id.'. Senha: '.$senhaStudent);
echo json_encode($retorno);
exit();

    ?>