<?php
require_once ('../config.php');
//room number
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : 'asds' ;



// Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

//set info user
$user_basic = User::getBasic($_SESSION['id'], $_SESSION['cargo']);
$user2 = User::getUser($_SESSION['id'], $_SESSION['cargo']);

//get all infos from room
$sql = 'SELECT * FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$room_info = $stm->fetch(PDO::FETCH_OBJ);

$room_teachers = (isset($room_info->teachers)) ? unserialize($room_info->teachers) : '';
$room_students = (isset($room_info->students)) ? unserialize($room_info->students) : '';

$belong = false;
if($user2->cargo == 'professor'){
    if ($room_info->author == $user_basic->id) {
        $belong = true;
    }else if($room_teachers != '' && in_array($user_basic->id, $room_teachers)){
        $belong = true;
    }
}else{
    if ($room_students != '' && in_array($_SESSION['id'], $room_students)) {
        $belong = true;
    }
}


$retorno = array('belong' => $belong, 'sala' => $room_id, 'id' => $room_info->id,'name' => $room_info->name, 'created' => $room_info->created, 'school' => $room_info->school, 'school_birthday' => $room_info->school_birthday, 'room_info' => $room_info->room_info, 'author' => $room_info->author, 'teachers' => $room_info->teachers, 'students' => $room_info->students);
echo json_encode($retorno);
exit();
?>