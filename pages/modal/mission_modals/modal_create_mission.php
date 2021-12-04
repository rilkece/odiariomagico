<!-- modal/mission_modals/create_mission.php -->
<?php
?>
<div class="modal fade" id="modalCreateMission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Criar missão</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-modalCreateMission" class="modal-body">
                <form class="form-inline" id="form-modalCreateMission">  
                    <div class="form-group p-1 w-100">
                        <label for="missionName-form-modalCreateMission">Nome da missão:</label>
                        <input type="text" name="mission-name" id="missionName-form-modalCreateMission" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group p-1 w-100 mt-2">
                        <label for="missionTipo-form-modalCreateMission">Tipo de registro:</label>
                        <select name="mission-tipo" id="missionTipo-form-modalCreateMission" class="form-control w-100 btn-outline-blue">
                            <option hidden selected value=""> -- escolha um registro -- </option>
                            <option value="Relato">Relato</option>
                            <option value="Evento">Evento</option>
                            <option value="Objeto">Objeto</option>
                            <option value="Pessoa">Pessoa</option>
                            <option value="Animal">Animal</option>
                            <option value="Estrutura">Estrutura</option>
                            
                        </select>
                    </div>
                    <div class="form-group p-1 w-100">
                        <label for="missionDescription-form-modalCreateMission">Descrição da missão:</label>
                        <textarea name="mission-description" id="missionDescription-form-modalCreateMission" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId"></textarea>
                    </div>
                    <div class="form-group p-1 w-100">
                        <label for="missionXP-form-modalCreateMission">Experiência da missão:</label> 
                        <div class="range-wrap w-100">
                            <div class="range-value" id="rangeV"></div>
                            <input id="missionXP-form-modalCreateMission" class="form-control w-100 p-0" type="range" min="0" max="100" value="50" step="1">
                        </div>                       
                    </div>
                    <div class="input-group w-100 p-1">
                        <label for="missionFile-form-modalCreateMission">Capa da missão (opcional):</label>
                        <input type="file" name="mission-image" id="missionFile-form-modalCreateMission" class="btn-outline-blue w-100" placeholder="imagem" accept="image/*">
                    </div>
                </form>
                <div id="blobResult"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="btn-form-modalCreateMission" type="button" class="btn btn-primary">Criar missão</button>
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/mission_modals/create_mission.php -->