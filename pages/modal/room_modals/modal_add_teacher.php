<!-- modal/room_modals/modal_add_teacher.php -->
<div class="modal fade" id="modalAddTeacher" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Professor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-addTeacher" class="modal-body">
                <div class="form-group">
                    <input type="email" class="form-control" name="" id="emailTeacherSearch" aria-describedby="helpId" placeholder="Email">
                    <small id="helpId" class="form-text text-muted">Insira o email do professor</small>
                </div>
                <button id="modal-body-btnVerifyTeacher" type="button" class="btn btn-green"><i class="fa fa-search" aria-hidden="true"></i> Verificar</button>   
                <div id="verifyTeacherResultsDiv">                  
                </div>
            </div>
            <div class="modal-footer">
                <button id="modal-body-btnAddTeacher" type="button" class="btn btn-primary d-none">Adicionar professor</button>
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/room_modals/modal_add_teacher.php -->