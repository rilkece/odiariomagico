<!-- home/home_menu.php -->
<?php

?>
<div class="row">
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_journal" href="<?php echo INCLUDE_PATH.'diary'; ?>">
        <div id="home_menu_card_journal" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/018-notebook.png" class="img-fluid" alt="">
                <h6 class="card-title">Diário Mágico</h6>                
            </div>
        </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_missions_created" href="<?php echo INCLUDE_PATH.'mission'; ?>">
        <div id="home_menu_card_missions_created" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/021-medal.png" class="img-fluid" alt="">
                <h6 class="card-title">Missões</h6>                
            </div>
        </div>
        </a>
    </div>  
    <?php if($user->cargo == 'estudante'): ?>
        <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_students_rooms" data-toggle="modal" data-target="#modalMyRooms">
        <div id="home_menu_card_students_rooms" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/004-backpack.png" class="img-fluid" alt="">
                <h6 class="card-title">Minhas Salas</h6>                
            </div>
        </div>
        </a>
    </div>
    <?php endif?>  
    <?php if($user->cargo == 'professor'): ?>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_rooms_created" data-toggle="modal" data-target="#modalRoomsCreated">
        <div id="home_menu_card_rooms_created" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/003-apple.png" class="img-fluid" alt="">
                <h6 class="card-title">Minhas salas</h6>                
            </div>
        </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_students_created" data-toggle="modal" data-target="#modalStudentsCreated">
        <div id="home_menu_card_students_created" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/030-student.png" class="img-fluid" alt="">
                <h6 class="card-title">Estudantes Criados</h6>                
            </div>
        </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_create_room" data-toggle="modal" data-target="#modalCreateRoom">
        <div id="home_menu_card_create_room" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/teacher_desk.png" class="img-fluid" alt="">
                <h6 class="card-title">Criar Sala</h6>                
            </div>
        </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_create_student" data-toggle="modal" data-target="#modalCreateStudent">
        <div id="home_menu_card_create_student" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/add_student.png" class="img-fluid" alt="">
                <h6 class="card-title">Criar Estudante</h6>                
            </div>
        </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_edit_user" data-toggle="modal" data-target="#modalEditUser"  >
        <div id="home_menu_card_edit_user" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/edit_user.png" class="img-fluid" alt="">
                <h6 class="card-title">Editar Usuário</h6>                
            </div>
        </div>
        </a>
    </div>      
    <?php endif ?>
    <div class="col-12 col-md-6 col-lg-3 mt-5">
        <a id="link_home_menu_card_sair" href="<?php INCLUDE_PATH ?>logout" >
        <div id="home_menu_card_sair" class="card">            
            <div class="card-body text-center">
                <img src="<?php echo INCLUDE_PATH; ?>imgs/delete_cross.png" class="img-fluid" alt="">
                <h6 class="card-title">Sair</h6>                
            </div>
        </div>
        </a>
    </div>
</div>
<!-- END/ home/home_menu.php -->