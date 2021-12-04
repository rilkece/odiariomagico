<?php
require_once ('../config.php');

// Recebe os dados do formulário
$cargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '' ;
$id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
$type = (isset($_POST['type'])) ? $_POST['type'] : '' ;
$date= (isset($_POST['date'])) ? $_POST['date'] : '' ;
$tag= (isset($_POST['tag']))&&$_POST['tag']!='' ? '#'.$_POST['tag'] : '' ;
$tag2= (isset($_POST['tag2']))&&$_POST['tag2']!='' ? '#'.$_POST['tag2'] : '' ;
$tag3= (isset($_POST['tag3']))&&$_POST['tag3']!='' ? '#'.$_POST['tag3'] : '' ;
$tag4= (isset($_POST['tag4']))&&$_POST['tag4']!='' ? '#'.$_POST['tag4'] : '' ;
$tag5= (isset($_POST['tag5']))&&$_POST['tag5']!='' ? '#'.$_POST['tag5'] : '' ;
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
	$retorno = array();
	if ($tag!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag."%");
		$stm->bindValue(4, "0000-00-00 00:00:00");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();

		if (empty($register_array)) {
			$retorno['tag'] = 'no';
		} else {
			$retorno['tag'] = $register_array;
		}   
	}else{
		$retorno['tag'] = 'no';
	}
	if ($tag2!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag2."%");
		$stm->bindValue(4, "0000-00-00 00:00:00");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();

		if (empty($register_array)) {
			$retorno['tag2'] = 'no';
		} else {
			$retorno['tag2'] = $register_array;
		}   
	}else{
		$retorno['tag2'] = 'no';
	}
	if ($tag3!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag3."%");
		$stm->bindValue(4, "0000-00-00 00:00:00");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();

		if (empty($register_array)) {
			$retorno['tag3'] = 'no';
		} else {
			$retorno['tag3'] = $register_array;
		}   
	}else{
		$retorno['tag3'] = 'no';
	}
	if ($tag4!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag4."%");
		$stm->bindValue(4, "0000-00-00 00:00:00");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();

		if (empty($register_array)) {
			$retorno['tag4'] = 'no';
		} else {
			$retorno['tag4'] = $register_array;
		}   
	}else{
		$retorno['tag4'] = 'no';
	}
	if ($tag5!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? AND NOT date_end =  ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag5."%");
		$stm->bindValue(4, "0000-00-00 00:00:00");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();

		if (empty($register_array)) {
			$retorno['tag5'] = 'no';
		} else {
			$retorno['tag5'] = $register_array;
		}   
	}else{
		$retorno['tag5'] = 'no';
	}
	
	echo json_encode($retorno);
	exit();
} else {
	$retorno = array();
	if ($tag!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag."%");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();
	
		if (empty($register_array)) {
			$retorno['tag'] = 'no';
		} else {
			$retorno['tag'] = $register_array;
		}   
	}else{
		$retorno['tag'] = 'no';
	}
	if ($tag2!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag2."%");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();
	
		if (empty($register_array)) {
			$retorno['tag2'] = 'no';
		} else {
			$retorno['tag2'] = $register_array;
		}   
	}else{
		$retorno['tag2'] = 'no';
	}
	if ($tag3!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag3."%");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();
	
		if (empty($register_array)) {
			$retorno['tag3'] = 'no';
		} else {
			$retorno['tag3'] = $register_array;
		}   
	}else{
		$retorno['tag3'] = 'no';
	}
	if ($tag4!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag4."%");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();
	
		if (empty($register_array)) {
			$retorno['tag4'] = 'no';
		} else {
			$retorno['tag4'] = $register_array;
		}   
	}else{
		$retorno['tag4'] = 'no';
	}
	if ($tag5!='') {
		$sql = 'SELECT * FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ? ORDER BY date_ini';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(1, $type);
		$stm->bindValue(2, "%".$date."%");
		$stm->bindValue(3, "%".$tag5."%");
		$stm->execute();
		//$register_info = $stm->fetch(PDO::FETCH_OBJ);
		$register_array = $stm->fetchAll();
	
		if (empty($register_array)) {
			$retorno['tag5'] = 'no';
		} else {
			$retorno['tag5'] = $register_array;
		}   
	}else{
		$retorno['tag5'] = 'no';
	}
		
		echo json_encode($retorno);
		exit();

}

?>