<?php
require_once ('../config.php');

// Recebe os dados do formulário
$cargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '' ;
$id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
$type = (isset($_POST['type'])) ? $_POST['type'] : '' ;
$date= (isset($_POST['date'])) ? $_POST['date'] : '' ;
$tag= (isset($_POST['tag']))&&$_POST['tag']!='' ? '#'.$_POST['tag'] : '' ;
$interval= (isset($_POST['interval'])) ? $_POST['interval'] : 'no' ;



// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'diary'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;


// Passo 2 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

//Pesquisa os registros que há nessa data e retorna a quantida e os dados

if ($interval=='si') {
	$sql = 'SELECT COUNT(*) AS count FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $type);
	$stm->bindValue(2, "%".$date."%");
	$stm->bindValue(3, "%".$tag."%");
	$stm->bindValue(4, "0000-00-00 00:00:00");
	$stm->execute();
	$register_count = $stm->fetch(PDO::FETCH_OBJ);

	$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $type);
	$stm->bindValue(2, "%".$date."%");
	$stm->bindValue(3, "%".$tag."%");
	$stm->bindValue(4, "0000-00-00 00:00:00");
	$stm->execute();
	//$register_info = $stm->fetch(PDO::FETCH_OBJ);
	$register_array = $stm->fetchAll();

	$retorno = array( 'linhas' => $register_array);
	echo json_encode($retorno);
	exit();
} else {
	$sql = 'SELECT COUNT(*) AS count FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $type);
	$stm->bindValue(2, "%".$date."%");
	$stm->bindValue(3, "%".$tag."%");
	$stm->execute();
	$register_count = $stm->fetch(PDO::FETCH_OBJ);

	$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $type);
	$stm->bindValue(2, "%".$date."%");
	$stm->bindValue(3, "%".$tag."%");
	$stm->execute();
	//$register_info = $stm->fetch(PDO::FETCH_OBJ);
	$register_array = $stm->fetchAll();

	$retorno = array( 'linhas' => $register_array);
	echo json_encode($retorno);
	exit();
}
?>