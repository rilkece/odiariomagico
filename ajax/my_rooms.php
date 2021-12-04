<?php
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

// Passo 2 - pegar array de rooms

$sql = 'SELECT rooms FROM students_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $_SESSION['id']);
$stm->execute();
$room_crt = $stm->fetch(PDO::FETCH_OBJ);
$my_rooms = unserialize($room_crt->rooms);
if (empty($my_rooms)) {
	$my_rooms = array();
}

$rooms_info = array();

for ($i=0; $i < count($my_rooms); $i++) { 
    
	$sql = 'SELECT * FROM rooms WHERE id = ?';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $my_rooms[$i]);
	$stm->execute();
	$rms_info = $stm->fetch(PDO::FETCH_OBJ);    

	$rooms_array = array('id' => $rms_info->id, 'name' => $rms_info->name, 'created' => $rms_info->created, 'school' => $rms_info->school, 'school_birthday' => $rms_info->school_birthday, 'room_info' => $rms_info->room_info, 'author' => $rms_info->author, 'students' => $rms_info->students, 'students' => $rms_info->students);
	
    $rooms_info[] = $rooms_array;    

}



//$retorno = array('codigo' => 1, 'mensagem' => 'kihk j jk ');
echo json_encode($rooms_info);
exit();




?>