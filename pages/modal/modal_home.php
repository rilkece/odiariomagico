<!-- modal/modal_home.php -->
<?php
if($user->cargo=='professor'){
include 'home_modals/modal_edit_user.php';
include 'home_modals/modal_create_student.php';
include 'home_modals/modal_create_room.php';
include 'home_modals/modal_rooms_created.php';
include 'home_modals/modal_students_created.php';
}else{
include 'home_modals/modal_my_rooms.php';
}
?>
<!-- END/ modal/modal_home.php -->
