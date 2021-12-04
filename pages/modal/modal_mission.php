<!-- modal/modal_mission.php -->
<?php
if($user->cargo=='professor'){
include 'mission_modals/modal_create_mission.php';
include 'mission_modals/modal_edit_mission.php';
include 'mission_modals/modal_delete_mission.php';
}else{
}
?>
<!-- END/ modal/modal_mission.php -->