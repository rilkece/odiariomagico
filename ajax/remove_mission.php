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

// Passo 2 - Remove mission from room
$sql = 'SELECT missions FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$missions_from_room = unserialize($stc->missions);

$key_missions_from_room = array_search($user_id, $missions_from_room);

array_splice($missions_from_room, $key_missions_from_room, 1);

$missions_to_room = serialize($missions_from_room);

$sql = 'UPDATE rooms SET missions = ? WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $missions_to_room);
$stm->bindValue(2, $room_id);
$stm->execute();

$retorno = array('codigo' => 1, 'mensagem' => 'Missão removida da sala!');
echo json_encode($retorno);
exit();

?>