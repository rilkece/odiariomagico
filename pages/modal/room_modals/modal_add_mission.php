<!-- modal/room_modals/modal_add_mission.php -->
<div class="modal fade" id="modalAddMissionToRoom" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center">Adicionar Missão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-modalAddMissionToRoom" class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" name="" id="idMissionSearch" aria-describedby="Id da missão" placeholder="ID da Missão">
                    <small id="helpId" class="form-text text-muted">Insira o id da Missão.</small>
                </div>
                <button id="modal-body-btnVerifyMission" type="button" class="btn btn-green"><i class="fa fa-search" aria-hidden="true"></i> Verificar</button>   
                <div id="verifyMissionResultsDiv">                  
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnAdd-modalAddMissionToRoom" type="button" class="btn btn-primary d-none">Adicionar</button>
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/room_modals/modal_add_mission.php -->