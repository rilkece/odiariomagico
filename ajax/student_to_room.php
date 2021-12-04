<?php
require_once ('../config.php');

//get POSTs
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;
$student_id = (isset($_POST['id'])) ? $_POST['id'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$room_id):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.5 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();


// Passo 2 - Verifica se o estudante já está adicionado
$sql = 'SELECT students FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);


$students_in_room = unserialize($stc->students);

if (!empty($students_in_room) && in_array($student_id, $students_in_room)) {
    $retorno = array('codigo' => 0, 'mensagem' => 'O estudante já está na sala.');
    echo json_encode($retorno);
    exit();
}


// Passo 3 - inserir student id na tabela de professores da sala e id da sala na tabela do estudante

$students_in_room[] = $student_id;
$students_in_room_array = serialize($students_in_room);
$sql2 = 'UPDATE rooms SET students = ? WHERE id = ?';
$stm2 = $conexao->prepare($sql2);
$stm2->bindValue(1, $students_in_room_array);
$stm2->bindValue(2, $room_id);
$stm2->execute(); 

$sql = 'SELECT rooms FROM students_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $student_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$student_rooms = unserialize($stc->rooms);


if (!empty($student_rooms) && in_array($room_id, $student_rooms)) {
}else{
    $student_rooms[]= $room_id; 
    $student_rooms_array = serialize($student_rooms);
    $sql2 = 'UPDATE students_info SET rooms = ? WHERE id = ?';
    $stm2 = $conexao->prepare($sql2);
    $stm2->bindValue(1, $student_rooms_array);
    $stm2->bindValue(2, $student_id);
    $stm2->execute(); 
}

$retorno = array('codigo' => 0, 'mensagem' => 'Novo estudante adicionado.');
echo json_encode($retorno);
exit();

?>