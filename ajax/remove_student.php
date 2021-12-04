<?php
require_once ('../config.php');

//get POSTs
$user_id  = (isset($_POST['id'])) ? $_POST['id'] : '' ;
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$room_id):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.5 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 2 - Remove student from room
$sql = 'SELECT students FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$students_from_room = unserialize($stc->students);

$key_students_from_room = array_search($user_id, $students_from_room);

array_splice($students_from_room, $key_students_from_room, 1);

$students_to_room = serialize($students_from_room);

$sql = 'UPDATE rooms SET students = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $students_to_room);
$stm->bindValue(2, $room_id);
$stm->execute();

// Passo 3 - Remove room from student

$sql = 'SELECT rooms FROM students_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $user_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$rooms_from_students_info = unserialize($stc->rooms);

$key_rooms_from_students_info = array_search($room_id, $rooms_from_students_info);

array_splice($rooms_from_students_info, $key_rooms_from_students_info, 1);

$rooms_to_students_info = serialize($rooms_from_students_info);

$sql = 'UPDATE students_info SET rooms = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $rooms_to_students_info);
$stm->bindValue(2, $user_id);
$stm->execute();

$retorno = array('codigo' => 1, 'mensagem' => 'Estudante removido da sala!');
echo json_encode($retorno);
exit();

?>