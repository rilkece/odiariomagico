<!-- modal/mission_modals/modal_edit_mission.php -->
<?php
?>
<!-- Modal -->
<div class="modal fade" id="modalEditMission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Editar Missão</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-modalEditMission" class="modal-body">
                <div class="container">
                    <form id="form-modalEditMission">
                        <div class="form-group p-1">
                            <label for="inputName-modalEditMission" class="col-sm-1-12 col-form-label">Nome:&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" name="inputName-edit" id="inputName-modalEditMission" placeholder="">
                            
                        </div>
                        <div class="form-group p-1 w-100 mt-2">
                            <label for="inputType-modalEditMission">Tipo de registro:</label>
                            <select name="mission-tipo" id="inputType-modalEditMission" class="form-control w-100 btn-outline-blue">
                                <option hidden disabled selected value=""> -- escolha um registro -- </option>
                                <option value="Relato">Relato</option>
                                <option value="Evento">Evento</option>
                                <option value="Objeto">Objeto</option>
                                <option value="Pessoa">Pessoa</option>
                                <option value="Animal">Animal</option>
                                <option value="Estrutura">Estrutura</option>
                                
                            </select>
                        </div>
                        <div class="form-group p-1 mt-2">
                            <label for="inputDesc-modalEditMission" class="col-sm-1-12 col-form-label">Descrição:&nbsp;&nbsp;</label>
                            <textarea name="mission-description" id="inputDesc-modalEditMission" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId"></textarea>                           
                        </div>
                        <div class="form-group p-1 w-100">
                            <label for="missionXP-form-modalEditMission">Experiência da missão:</label> 
                            <div class="range-wrap w-100">
                                <div class="range-value" id="rangeV-edit"></div>
                                <input id="missionXP-form-modalEditMission" class="form-control w-100 p-0" type="range" min="0" max="100" value="35" step="1">
                            </div>                       
                        </div>
                        <div class="input-group w-100 p-1">
                        <label for="missionFile-form-modalEditMission">Capa da missão (opcional):</label>
                        <input type="file" name="mission-image" id="missionFile-form-modalEditMission" class="btn-outline-blue w-100" placeholder="imagem" accept="image/*">
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="save-modalEditMission" type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/mission_modals/modal_edit_mission.php -->