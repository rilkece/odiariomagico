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
$room  = (isset($_POST['nova_sala_nome'])) ? $_POST['nova_sala_nome'] : '' ;
$school  = (isset($_POST['nova_escola_nome'])) ? $_POST['nova_escola_nome'] : '' ;
$school_birthday  = (isset($_POST['nova_escola_nascimento'])) ? $_POST['nova_escola_nascimento'] : '' ;
$room_desc  = (isset($_POST['nova_sala_info'])) ? $_POST['nova_sala_info'] : '' ;

// Passo 2 - Validações de preenchimento e se todos campos foram preenchidos
if (empty($room)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha o nome da sala!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($school)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha o nome da escola!');
	echo json_encode($retorno);
	exit();
endif;
if (empty($school_birthday)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha a data de fundação da escola!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($room_desc)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Preencha a descrição da escola');
	echo json_encode($retorno);
	exit();
endif;

//Passo 3 - Criar tabela se não existe



$sql = 'CREATE TABLE IF NOT EXISTS rooms (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name varchar(100) NOT NULL,
	created datetime NOT NULL DEFAULT current_timestamp(),
	school varchar(100) NOT NULL,
	school_birthday date DEFAULT NULL,
	room_info varchar(1000) NOT NULL,
	author varchar(1000) NOT NULL,
	teachers varchar(3000) NOT NULL,
	students varchar(3000) NOT NULL,
	missions varchar(3000) NOT NULL
);';
$stm = $conexao->prepare($sql);
$stm->execute();

//Passo 4 - Criação da sala
$sql = 'INSERT INTO rooms (name, created, school, school_birthday, room_info, author, teachers, students, missions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room);
$stm->bindValue(2, date('Y-m-d H:i:s'));
$stm->bindValue(3, $school);
$stm->bindValue(4, $school_birthday);
$stm->bindValue(5, $room_desc);
$stm->bindValue(6, $_SESSION['id']);
$stm->bindValue(7, '');
$stm->bindValue(8, '');
$stm->bindValue(9, '');
$stm->execute();

$last_id = $conexao->lastInsertId();

$sql = 'SELECT rooms_created FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $_SESSION['id']);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$rooms_created = unserialize($stc->rooms_created);
$rooms_created[] = $last_id;
$rooms_created_array = serialize($rooms_created);
$sql = 'UPDATE teachers_info SET rooms_created = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $rooms_created_array);
$stm->bindValue(2, $_SESSION['id']);
$stm->execute(); 

$retorno = array('codigo' => 1, 'mensagem' => 'Nova sala criada com sucesso.');
echo json_encode($retorno);
exit();

?>