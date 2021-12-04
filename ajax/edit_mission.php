<?php

require_once ('../config.php');

// Recebe os dados do formulário
$author = (isset($_POST['author'])) ? $_POST['author'] : '' ;
$mission_name = (isset($_POST['mission_name'])) ? $_POST['mission_name'] : '' ;
$mission_desc = (isset($_POST['mission_desc'])) ? $_POST['mission_desc'] : '' ;
$mission_type = (isset($_POST['mission_type'])) ? $_POST['mission_type'] : '' ;
$mission_xp = (isset($_POST['mission_xp'])) ? $_POST['mission_xp'] : '' ;
$mission_img = (isset($_POST['mission_img'])) ? $_POST['mission_img'] : '' ;
$mission_id = (isset($_POST['mission_id'])) ? $_POST['mission_id'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'mission'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.1 Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 2 - atualiza a missão no banco de dados

if ($mission_name!='') {
    $sql = 'UPDATE missions
    SET name = ?
    WHERE id = ?;';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $mission_name);
    $stm->bindValue(2, $mission_id);
    $stm->execute();
};
if ($mission_desc!='') {
    $sql = 'UPDATE missions
    SET description = ?
    WHERE id = ?;';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $mission_desc);
    $stm->bindValue(2, $mission_id);
    $stm->execute();
};
if ($mission_type!='') {
    $sql = 'UPDATE missions
    SET type = ?
    WHERE id = ?;';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $mission_type);
    $stm->bindValue(2, $mission_id);
    $stm->execute();
};
if ($mission_xp!='') {
    $sql = 'UPDATE missions
    SET xp = ?
    WHERE id = ?;';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $mission_xp);
    $stm->bindValue(2, $mission_id);
    $stm->execute();
};
if ($mission_img!='') {
    $sql = 'UPDATE missions
    SET cover = ?
    WHERE id = ?;';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $mission_img);
    $stm->bindValue(2, $mission_id);
    $stm->execute();
};


$retorno = array('codigo' => 1, 'mensagem' => 'Missão atualizada com sucesso.');
echo json_encode($retorno);
exit();





?>