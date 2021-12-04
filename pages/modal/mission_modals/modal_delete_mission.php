<!-- modal/mission_modals/modal_delete_mission.php -->
<?php
?>
<div class="modal fade" id="modalDeleteMission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center">Deletar Missão?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-modalDeleteMission" class="modal-body container">
                <p> Essa missão ficará inativa para ser usada no futuro, mas as salas que tiverem elas abertas ainda poderão completá-la.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="save-modalDeleteMission" type="button" class="btn btn-primary">Deletar</button>
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/mission_modals/modal_delete_mission.php -->