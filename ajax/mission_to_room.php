<?php
require_once ('../config.php');

//get POSTs
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;
$mission_id = (isset($_POST['missionID'])) ? $_POST['missionID'] : '' ;
$author = (isset($_POST['author'])) ? $_POST['author'] : '' ;



// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$room_id):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;
// Passo 1.5 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();


// Passo 2 - Verifica se o professor é autor ou se a missão já está aberta
$sql = 'SELECT author FROM missions WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $mission_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

if($stc->author!=$author){
    $retorno = array('codigo' => 0, 'mensagem' => 'O professor não é o autor da missão.');
    echo json_encode($retorno);
    exit();
}
$sql = 'SELECT missions FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);


if (empty($stc->missions)) {
    $missions_in_room = array();
} else {
    $missions_in_room = unserialize($stc->missions);
}

if (!empty($missions_in_room) && in_array($mission_id, $missions_in_room)) {
    $retorno = array('codigo' => 0, 'mensagem' => 'O missão já está na sala.');
    echo json_encode($retorno);
    exit();
}
// Passo 3 - inserir mission id na tabela de missões da sala

$missions_in_room[] = $mission_id;
$missions_in_room_array = serialize($missions_in_room);
$sql2 = 'UPDATE rooms SET missions = ? WHERE id = ?';
$stm2 = $conexao->prepare($sql2);
$stm2->bindValue(1, $missions_in_room_array);
$stm2->bindValue(2, $room_id);
$stm2->execute(); 



$retorno = array('codigo' => 1, 'mensagem' => 'Nova missão adicionada.');
echo json_encode($retorno);
exit();

?>