<!-- room/room.php -->
<?php
$room_id = htmlspecialchars($_GET["sala"]);

$room_connect = Conexao::connect();

$classroom = Classroom::getClassroom($room_id);

?>
<main class="">
<div class="container-fluid h-100 border-top-0">
    <div class="row">    
        <div class="col-12 text-center pr-0 pl-0">
            <?php
                if(isset($classroom->classroom_pic)){
                    echo '<img class="z-depth-2 classroom-pic w-100" src="data:image/jpg;charset=utf8;base64,'.base64_encode($classroom->classroom_pic).'" data-holder-rendered="true">';                   
                }else{
                    echo '<img class=" classroom-pic w-100" src="'.INCLUDE_PATH.'imgs/classroom_profile.jpg'.'" data-holder-rendered="true">';
                }                
            ?>   
            <p class="room-title"><?php echo $classroom->name; ?></p>
            <p class="room-school"><?php echo $classroom->school; ?></p>
        </div>
        <div  class="col-12 d-md-none">
            <a href="#" id="small_link_diarioClasse"><img id="icon_link_diarioClasse" class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/027-book.png" data-holder-rendered="true"></a>
            <a href="#" id="small_link_professores"><img id="icon_link_professores" class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/019-glasses.png" data-holder-rendered="true"></a>
            <a href="#" id="small_link_estudantes"><img id="icon_link_estudantes" class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/031-student.png" data-holder-rendered="true"></a>
            <a href="#" id="small_link_missoes"><img id="icon_link_missoes" class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/036-pin.png" data-holder-rendered="true"></a>
        </div>           
        <div class="col-12 col-md-3 bg-primary">
                <a href="<?php echo  INCLUDE_PATH."diary_room?id=".$classroom->id; ?>" id="link_diarioClasse" class="d-none d-md-block"><img class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/027-book.png" data-holder-rendered="true"></a>
            <div id="divIn-diarioClasse" class="d-md-block">
                 <a href="#"><p class="mt-5 mb-3 w-100 text-center white-text h4">Diário da Classe</p></a> 
                <p class="white-text h5">Atualizações:</p>
                <div id="feedDiarioClasse">
                </div>
                <?php if($user->cargo == 'professor'): ?>
                <div id="addRegistersToRoom" class="w-100 text-center mt-5">
                    <button id="btnAddRegistersToRoom" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddRoomRegister">Adicionar Registro</button>
                </div>
                <?php endif?>
            </div>
        </div>       
        <div class="col-12 col-md-3 bg-danger">
                <a href="#" id="link_professores" class="d-none d-md-block"><img class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/019-glasses.png" data-holder-rendered="true"></a>
            <div id="divIn-professores" class="d-none d-md-block">
                <p class="mt-5 mb-3 w-100 text-center white-text h4">Professores</p>
                <div id="authorTeachersDiv">
                    <?php 
                    $teacher = User::getTeacher($classroom->author);
                     echo '<a href="'.INCLUDE_PATH.'profile?cargo=teacher&id='.$classroom->author.'"><p class="h5 text-white"><i class="fa fa-star" aria-hidden="true"></i>'.$teacher->nome.' '.$teacher->sobrenome.'</p></a>'; ?>   
                     <div id="teachersDiv">
                     </div>                  
                </div>
                <?php if($user->cargo == 'professor'): ?>
                <div id="addTeachersToRoom" class="w-100 text-center mt-5">
                    <button id="btnAddTeachersToRoom" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddTeacher">Adicionar Professor</button>
                </div>
                <?php endif?>
            </div>
        </div>       
        <div class="col-12 col-md-3 bg-success">
                <a href="#" id="link_estudantes" class="d-none d-md-block"><img class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/031-student.png" data-holder-rendered="true"></a>
            <div id="divIn-estudantes" class="d-none d-md-block">
                <p class="mt-5 mb-3 w-100 text-center white-text h4">Estudantes</p>
                <div id="feedEstudantes">

                </div>
                <?php if($user->cargo == 'professor'): ?>
                <div id="addStudentsToRoom" class="w-100 text-center mt-5">
                    <button id="btnAddStudentsToRoom" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddStudent">Adicionar Estudante</button>
                </div>
                <?php endif?>
            </div>
        </div>       
        <div class="col-12 col-md-3 bg-warning">
                <a href="#" id="link_missoes" class="d-none d-md-block"><img class="rounded-circle z-depth-2 classroom-icon bg-white" alt="Diário da classe" src="<?php INCLUDE_PATH ?>imgs/036-pin.png" data-holder-rendered="true"></a>
            <div id="divIn-missoes" class="d-none d-md-block">
                <p class="mt-5 mb-3 w-100 text-center white-text h4">Missões</p>
                <p class="white-text h5">Missões abertas:</p>
                <div id="feedMissions">                    
                </div>
                <?php if($user->cargo == 'professor'): ?>
                <div id="addMissionsToRoom" class="w-100 text-center mt-5">
                    <button id="btnAddMissionsToRoom" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddMissionToRoom">Adicionar Missão</button>
                </div>
                <?php endif?>
            </div>
        </div>       
    </div>      
</div>
</main>
<!-- END/ room/room.php -->