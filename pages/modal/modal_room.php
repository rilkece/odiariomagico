<!-- modal/modal_room.php -->
<?php
if($user->cargo=='professor'){
    include 'room_modals/modal_add_register.php';
    include 'room_modals/modal_add_teacher.php';
    include 'room_modals/modal_add_student.php';
    include 'room_modals/modal_add_mission.php';
    include 'room_modals/modal_remove_user.php';
    include 'room_modals/modal_remove_mission.php';
    include 'room_modals/modal_add_room_register.php';
}else{
    include 'room_modals/modal_complete_mission.php';
}
?>
<!-- END/ modal/modal_room.php -->