<!-- modal/room_modals/modal_complete_mission.php -->
<div class="modal fade" id="modalCompleteMission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title-modalCompleteMission" class="modal-title w-100 text-center"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-modalCompleteMission" class="modal-body">
                <div id="rowInstruction-modal-body-modalCompleteMission" class="row p-1">
                    <div class="col-12 text-center">
                        <img id="img-rowInstruction-modal-body-modalCompleteMission" src="" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 text-center">
                        <p id="desc-rowInstruction-modal-body-modalCompleteMission" class="mt-2"></p>
                    </div>
                    <div class="col-12">
                        <small id="footer-rowInstruction-modal-body-modalCompleteMission"></small>
                    </div>
                    <hr class="w-100">  
                    <div class="col-12 text-right">                 
                        <button id="btnSeeMission-modalCompleteMission" type="button" class="btn btn-secondary">Ir para missão</button>  
                    </div>                  
                </div>
                <div id="rowMission-modal-body-modalCompleteMission" class="row p-1 d-none">
                    <form class="form-inline" id="form-modalCompleteMission">  
                        <div class="form-group p-1 w-100">
                            <label id="label-missionName-form-modalCompleteMission" for="missionName-form-modalCompleteMission"></label>
                            <input type="text" name="mission-name" id="missionName-form-modalCompleteMission" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="form-group p-1 w-100">
                            <label for="missionDescription-form-modalCompleteMission">Descrição:</label>
                            <textarea name="mission-description" id="missionDescription-form-modalCompleteMission" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId"></textarea>
                        </div>
                        <div class="input-group w-100 p-1">
                            <label for="missionDateIni-form-modalCompleteMission">Data Inicial:</label>                            
                            <input type="datetime-local" name="mission-image" id="missionDateIni-form-modalCompleteMission" class="btn-outline-blue w-100" placeholder="Data Inicial">
                        </div>
                        <div class="input-group w-100 p-1">
                            <label for="missionDateEnd-form-modalCompleteMission">Data Final (Se houver):</label>                            
                            <input type="datetime-local" name="mission-image" id="missionDateEnd-form-modalCompleteMission" class="btn-outline-blue w-100" placeholder="Data Final">
                        </div>
                        <div class="input-group w-100 p-1">
                            <label for="missionFile-form-modalCompleteMission">Imagem:</label>
                            <input type="file" name="mission-image" id="missionFile-form-modalCompleteMission" class="btn-outline-blue w-100" placeholder="imagem" accept="image/*">
                        </div>
                    </form>
                    <hr class="w-100">  
                    <div class="col-6 text-right">                 
                        <button id="btnSeeDescription-modalCompleteMission" type="button" class="btn btn-secondary">Ver Instrução</button>  
                    </div> 
                    <div class="col-6 text-right">                 
                        <button id="btnCompleteMission-modalCompleteMission" type="button" class="btn btn-primary">Completar Missão</button>  
                    </div> 
                </div>
               
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/room_modals/modal_complete_mission.php -->