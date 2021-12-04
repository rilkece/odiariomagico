<?php
//setar timezone
date_default_timezone_set('America/Fortaleza');

require_once ('../config.php');

// Recebe os dados do formulário
$author = (isset($_POST['author'])) ? $_POST['author'] : '' ;
$mission_name = (isset($_POST['mission_name'])) ? $_POST['mission_name'] : '' ;
$mission_desc = (isset($_POST['mission_desc'])) ? $_POST['mission_desc'] : '' ;
$mission_type = (isset($_POST['mission_type'])) ? $_POST['mission_type'] : '' ;
$mission_xp = (isset($_POST['mission_xp'])) ? $_POST['mission_xp'] : '' ;
$mission_img = (isset($_POST['mission_img'])) ? $_POST['mission_img'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'mission'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.1 Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

//Passo 1.2 - cria a tabela caso não exista

$sql = 'CREATE TABLE IF NOT EXISTS missions (
    id int(11) NOT NULL AUTO_INCREMENT,
    author int(11) NOT NULL,
    created datetime NOT NULL,
    name varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    type varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    xp int(11) NOT NULL,
    description varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    cover longblob NOT NULL,
    status varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
$stm = $conexao->prepare($sql);
$stm->execute();

// Passo 2 - posta a missão no banco de dados


$sql = "INSERT INTO missions (author, created, name, type, xp, description, cover, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $author);
$stm->bindValue(2, date('Y-m-d H:i:s'));
$stm->bindValue(3, $mission_name);
$stm->bindValue(4, $mission_type);
$stm->bindValue(5, $mission_xp);
$stm->bindValue(6, $mission_desc);
$stm->bindValue(7, $mission_img);
$stm->bindValue(8, 'A');
$stm->execute();

$last_id = $conexao->lastInsertId();

// Passo 3 - posta a missão na tabela do professor
$sql = 'SELECT missions_created
FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $author);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$teacher_missions = unserialize($stc->missions_created);

$teacher_missions[] = $last_id;

$serialized_teacher_missions = serialize($teacher_missions);

$sql = 'UPDATE teachers_info
SET missions_created = ?
WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $serialized_teacher_missions);
$stm->bindValue(2, $author);
$stm->execute();

$retorno = array('codigo' => 0, 'mensagem' => 'Missão criada com sucesso. ID: '.$last_id);
echo json_encode($retorno);
exit();





?>