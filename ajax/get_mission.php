<?php
require_once ('../config.php');

//get POSTs
$author  = (isset($_POST['author'])) ? $_POST['author'] : '' ;
$missionID = (isset($_POST['missionID'])) ? $_POST['missionID'] : '' ;

// Passo 1 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 2 - Pegar dados da missão e retornar

$sql = 'SELECT * FROM missions WHERE id = ? AND status = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $missionID);
$stm->bindValue(2, 'A');
$stm->execute();
$mission_info = $stm->fetch(PDO::FETCH_OBJ);

if (!empty($mission_info)) {
    $retorno = array('codigo' => 1, 'mensagem' => 'Missão encontrada!', 'id' => $mission_info->id, 'author' => $mission_info->author, 'created' => $mission_info->created, 'name' => $mission_info->name, 'type' => $mission_info->type, 'description' => $mission_info->description, 'cover' => $mission_info->cover, 'xp' => $mission_info->xp);
	echo json_encode($retorno);
	exit();
} else {
    $retorno = array('codigo' => 0, 'mensagem' => 'Missão não encontrada!');
	echo json_encode($retorno);
	exit();
}

?>