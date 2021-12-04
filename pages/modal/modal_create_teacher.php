<!-- modal/modal_create_teacher.php -->
<div class="modal fade " id="modalCreateTeacher" tabindex="-1" role="dialog" aria-labelledby="Create Teacher" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="TituloModalCreateTeacher">Criar nova conta de professor.</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCreateTeacher" class="form-row">
            <div class="col-12">
                <label for="createTeacherNome">Nome:</label>
                <input type="text" class="form-control  mb-3" id="createTeacherNome" name="nome" placeholder="Digite seu nome" required>                          
            </div>
            <div class="col-12">
                <label for="createTeacherSobrenome">Sobrenome:</label>
                <input type="text" class="form-control  mb-3" id="createTeacherSobrenome" name="sobrenome" placeholder="Digite seu sobrenome" required>                          
            </div>
            <div class="col-12">
                <label for="createTeacherEmail">Email:</label>
                <input type="email" class="form-control  mb-3" id="createTeacherEmail" name="createEmail" placeholder="Digite seu email" required>                          
            </div>
            <div class="col-12">
                <label for="confirmCreateTeacherEmail">Confirmação Email:</label>
                <input type="email" class="form-control  mb-3" id="confirmCreateTeacherEmail" name="confirmEmail" placeholder="Confirme seu email" required>                          
            </div>
            <div class="col-12">
                <label for="createPassword">Senha:</label>
                <input type="password" class="form-control  mb-3" id="createTeacherPassword" name="createSenha" placeholder="Digite a senha" required>                
            </div>                  
            <div class="col-12">
                <label for="confirmCreatePassword">Confirmação Senha:</label>
                <input type="password" class="form-control  mb-3" id="confirmCreateTeacherPassword" name="confirmSenha" placeholder="Confirme sua senha" required>                
            </div>  
            <div class="form-group row">
                <label id="labelVerifyCreateTeacher" for="verifyCreateEmail" class="col-sm-6 col-form-label"></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control  mb-3" id="verifyCreateTeacher" name="verifyCreate" placeholder="Resposta" required>
                </div>
            </div>              
        </form>  
        <div id="msg-error-create-teacher" class="bg-danger white-text d-none">
                    <small></small>                    
        </div>  
        <div id="progress_create_teacher" class="progress d-none">
            <div  class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Criando Professor...</div>
        </div>   
            
      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btnCreateTeacher" type="button" class="btn btn-primary">Criar Professor</button>
      </div>
    </div>
  </div>
</div>
<!-- END/ modal/modal_create_teacher.php -->