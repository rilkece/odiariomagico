<!-- mission/mission.php -->
<?php
?>
<main>
    <div class="container-fluid h-100 border-top-0">
        <div class="row">    
            <div class="col-12 text-center pr-0 pl-0">
               <img class="mission-cover w-100" src="<?php echo INCLUDE_PATH.'imgs/mission.png' ?>" data-holder-rendered="true">  
            </div>
            <div class="container">     
                    <div class="btn-group col-12 justify-content-center" role="group" aria-label="Exemplo básico">
                        <?php if($user->cargo == 'professor'): ?>
                        <a type="button" class="btn btn-primary" id="btnNewMission" data-toggle="modal" data-target="#modalCreateMission"><i class="fas fa-plus    "></i> Missão</a>
                        <?php endif?>
                        <a href="<?php echo INCLUDE_PATH.'home' ?>" type="button" class="btn btn-secondary" id="btnGoHomeFromMissionPage"><i class="fas fa-home    "></i> Início</a>
                        <a href="<?php INCLUDE_PATH ?>logout" type="button" class="btn btn-danger" id="btnSignOutFromMissionPage"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
                    </div>
                    <div id="myMissionsContainer" class="col-12">
                    </div>
            </div>
        </div>    
    </div>                
</main>
<!-- END/ mission/mission.php -->