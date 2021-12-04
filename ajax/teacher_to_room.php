<?php
require_once ('../config.php');

//get POSTs
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;
$teacher_id = (isset($_POST['teacherID'])) ? $_POST['teacherID'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$room_id):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.5 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();


// Passo 2 - Verifica se o professor é autor ou se ele já está adicionado
$sql = 'SELECT author, teachers FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

if($stc->author==$teacher_id){
    $retorno = array('codigo' => 0, 'mensagem' => 'O professor é o autor da sala.');
    echo json_encode($retorno);
    exit();
}

$teachers_in_room = unserialize($stc->teachers);

if (!empty($teachers_in_room) && in_array($teacher_id, $teachers_in_room)) {
    $retorno = array('codigo' => 0, 'mensagem' => 'O professor já está na sala.');
    echo json_encode($retorno);
    exit();
}


// Passo 3 - inserir teacher id na tabela de professores da sala e da sala na tabela do professor

$teachers_in_room[] = $teacher_id;
$teachers_in_room_array = serialize($teachers_in_room);
$sql2 = 'UPDATE rooms SET teachers = ? WHERE id = ?';
$stm2 = $conexao->prepare($sql2);
$stm2->bindValue(1, $teachers_in_room_array);
$stm2->bindValue(2, $room_id);
$stm2->execute(); 

$sql = 'SELECT rooms FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $teacher_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$teacher_rooms = unserialize($stc->rooms);


if (!empty($teacher_rooms) && in_array($room_id, $teacher_rooms)) {
}else{
    $teacher_rooms[]= $room_id; 
    $teacher_rooms_array = serialize($teacher_rooms);
    $sql2 = 'UPDATE teachers_info SET rooms = ? WHERE id = ?';
    $stm2 = $conexao->prepare($sql2);
    $stm2->bindValue(1, $teacher_rooms_array);
    $stm2->bindValue(2, $teacher_id);
    $stm2->execute(); 
}

$retorno = array('codigo' => 0, 'mensagem' => 'Novo professor adicionado.');
echo json_encode($retorno);
exit();

?>