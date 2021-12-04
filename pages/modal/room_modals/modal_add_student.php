<!-- modal/room_modals/modal_add_student.php -->
<div class="modal fade" id="modalAddStudent" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Estudante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div id="modal-body-addStudent" class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" name="" id="registerStudentSearch" aria-describedby="helpId" placeholder="Matrícula">
                    <small id="helpId" class="form-text text-muted">Insira a matrícula do estudante</small>
                </div>
                <button id="modal-body-btnVerifyStudent" type="button" class="btn btn-green"><i class="fa fa-search" aria-hidden="true"></i> Verificar</button>   
                <div id="verifyStudentResultsDiv">                  
                </div>
            </div>
            <div class="modal-footer">
                <button id="modal-body-btnAddStudent" type="button" class="btn btn-primary d-none">Adicionar estudante</button>
            </div>
        </div>
    </div>
</div>
<!-- END/ modal/room_modals/modal_add_student.php -->