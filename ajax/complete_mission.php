<?php
//setar timezone
date_default_timezone_set('America/Fortaleza');

require_once ('../config.php');

// Recebe os dados do formulário
$sala = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;
$missionID = (isset($_POST['missionID'])) ? $_POST['missionID'] : '' ;
$missionName = (isset($_POST['missionName'])) ? $_POST['missionName'] : '' ;
$missionDesc = (isset($_POST['missionDesc'])) ? $_POST['missionDesc'] : '' ;
$missionType = (isset($_POST['missionType'])) ? $_POST['missionType'] : '' ;
$missionDateIni = (isset($_POST['missionDateIni'])) ? $_POST['missionDateIni'] : '' ;
$missionDateEnd = (isset($_POST['missionDateEnd'])) ? $_POST['missionDateEnd'] : '' ;
$student = (isset($_POST['student'])) ? $_POST['student'] : '' ;
$image = (isset($_POST['image'])) ? $_POST['image'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$sala):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 2 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

//Passo 3 - cria a tabela caso não exista
$student_table = 'student_registers_'.$student;
$sql = 'CREATE TABLE IF NOT EXISTS '.$student_table.' (
     id INT(11) NOT NULL AUTO_INCREMENT , 
     mission_id INT(11) NOT NULL , 
     created DATETIME NOT NULL , 
     name VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , 
     description VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , 
     type VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , 
     date_ini DATETIME NOT NULL , 
     date_end DATETIME NOT NULL , 
     image LONGBLOB NOT NULL , 
     room INT(11) NOT NULL , 
     PRIMARY KEY (id)) 
     ENGINE = InnoDB;';
$stm = $conexao->prepare($sql);
$stm->execute();

//Passo 4 - inserir dados na tabela
$sql = 'INSERT INTO '.$student_table.' (mission_id, created, name, description, type, date_ini, date_end, image, room)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $missionID);
$stm->bindValue(2, date('Y-m-d H:i:s'));
$stm->bindValue(3, $missionName);
$stm->bindValue(4, $missionDesc);
$stm->bindValue(5, $missionType);
$stm->bindValue(6, $missionDateIni);
$stm->bindValue(7, $missionDateEnd);
$stm->bindValue(8, $image);
$stm->bindValue(9, $sala);
$stm->execute();

$retorno = array('codigo' => 1, 'mensagem' => 'Parabéns! Missão completada com sucesso.');
echo json_encode($retorno);
exit();

?>