<?php
//setar timezone
date_default_timezone_set('America/Fortaleza');

require_once ('../config.php');

// Recebe os dados do formulário
$menuID = (isset($_POST['menuID'])) ? $_POST['menuID'] : '' ;
$userID = (isset($_POST['userID'])) ? $_POST['userID'] : '' ;
$context = (isset($_POST['context'])) ? $_POST['context'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'diary'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.1 Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();



$retorno = file_get_contents(INCLUDE_PATH.'pages/diary/diary_'.$menuID.'.php');
echo $retorno;
exit();
?>