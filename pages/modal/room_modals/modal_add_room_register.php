<!-- modal/room_modals/modal_add_room_register.php -->
<div class="modal fade" id="modalAddRoomRegister" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title-modalAddRoomRegister" class="modal-title w-100 text-center">Novo registro da sala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-modalAddRoomRegister" class="modal-body">
                <form class="form-inline" id="form-modalAddRoomRegister">  
                        <div class="form-group p-1 w-100">
                            <label for="missionName-form-modalAddRoomRegister">Título:</label>
                            <input type="text" name="mission-name" id="missionName-form-modalAddRoomRegister" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="form-group p-1 w-100 mt-2">
                            <label for="missionTipo-form-modalAddRoomRegister">Tipo de registro:</label>
                            <select name="mission-tipo" id="missionTipo-form-modalAddRoomRegister" class="form-control w-100 btn-outline-blue">
                                <option hidden disabled selected value=""> -- escolha um tipo de registro -- </option>
                                <option value="Relato">Relato</option>
                                <option value="Evento">Evento</option>
                                <option value="Objeto">Objeto</option>
                                <option value="Pessoa">Pessoa</option>
                                <option value="Animal">Animal</option>
                                <option value="Estrutura">Estrutura</option>
                                
                            </select>
                        </div>
                        <div class="form-group p-1 w-100">
                            <label for="missionDescription-form-modalAddRoomRegister">Descrição do registro:</label>
                            <textarea name="mission-description" id="missionDescription-form-modalAddRoomRegister" class="form-control btn-outline-blue w-100" placeholder="" aria-describedby="helpId"></textarea>
                        </div>                        
                        <div class="input-group w-100 p-1">
                            <label for="missionDateIni-form-modalAddRoomRegister">Data Inicial:</label>                            
                            <input type="datetime-local" name="mission-image" id="missionDateIni-form-modalAddRoomRegister" class="btn-outline-blue w-100" placeholder="imagem" accept="image/*">
                        </div>
                        <div class="input-group w-100 p-1">
                            <label for="missionDateEnd-form-modalAddRoomRegister">Data Final (Se houver):</label>                            
                            <input type="datetime-local" name="mission-image" id="missionDateEnd-form-modalAddRoomRegister" class="btn-outline-blue w-100" placeholder="imagem" accept="image/*">
                        </div>
                        <div class="input-group w-100 p-1">
                            <label for="missionFile-form-modalAddRoomRegister">Foto do registro (opcional):</label>
                            <input type="file" name="mission-image" id="missionFile-form-modalAddRoomRegister" class="btn-outline-blue w-100" placeholder="imagem" accept="image/*">
                        </div>
                    </form>
            </div>
                    <div class="modal-footer">                
                        <button type="button" class="btn btn-danger">Cancelar</button>               
                        <button id="btnAddRoomRegister-modalAddRoomRegister" type="button" class="btn btn-primary">Criar registro</button>  
                    </div>                    
                </div>               
            </div>
        </div>
    </div>

<!-- END/ modal/room_modals/modal_add_room_register.php -->