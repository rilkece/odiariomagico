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

// Passo 2 - Remove teacher from room
$sql = 'SELECT teachers FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$teachers_from_room = unserialize($stc->teachers);

$key_teachers_from_room = array_search($user_id, $teachers_from_room);

$prof = $teachers_from_room[$key_teachers_from_room];

array_splice($teachers_from_room, $key_teachers_from_room, 1);

$teachers_to_room = serialize($teachers_from_room);

$sql = 'UPDATE rooms SET teachers = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $teachers_to_room);
$stm->bindValue(2, $room_id);
$stm->execute();

// Passo 3 - Remove room from teacher

$sql = 'SELECT rooms FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $user_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$rooms_from_teachers_info = unserialize($stc->rooms);

$key_rooms_from_teachers_info = array_search($room_id, $rooms_from_teachers_info);

array_splice($rooms_from_teachers_info, $key_rooms_from_teachers_info, 1);

$rooms_to_teachers_info = serialize($rooms_from_teachers_info);

$sql = 'UPDATE teachers_info SET rooms = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $rooms_to_teachers_info);
$stm->bindValue(2, $user_id);
$stm->execute();

$retorno = array('codigo' => 1, 'mensagem' => 'Professor removido da sala!');
echo json_encode($retorno);
exit();

?>