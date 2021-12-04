<?php

require_once ('../config.php');

// Recebe os dados do formulário
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

// Passo 2 - atualiza a missão no banco de dados com status F

if ($mission_id!='') {
    $sql = 'UPDATE missions
    SET status = ?
    WHERE id = ?;';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, 'F');
    $stm->bindValue(2, $mission_id);
    $stm->execute();

    $retorno = array('codigo' => 1, 'mensagem' => 'Missão deletada com sucesso.');
    echo json_encode($retorno);
    exit();
}else{
    $retorno = array('codigo' => 0, 'mensagem' => 'Não foi possível deletar a missão.');
    echo json_encode($retorno);
    exit();
}








?>