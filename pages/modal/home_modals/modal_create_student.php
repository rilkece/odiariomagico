<!-- modal/home_modals/modal_create_student.php -->
<div class="modal fade" id="modalCreateStudent" tabindex="-1" role="dialog" aria-labelledby="Create Teacher" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center" >Criar Estudante</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  
      <form class="form-inline" id="formHomeCreateStudent">
        <div class="form-group w-100 mt-3">
          <label for="home_student_name">Nome:</label>
          <input type="text" name="novo_estudante_nome" id="home_student_name" class="form-control" placeholder="">
        </div>
        <div class="form-group w-100 mt-3">
          <label for="home_student_surname">Sobrenome:</label>
          <input type="text" name="novo_estudante_sobrenome" id="home_student_surname" class="form-control" placeholder="" >
        </div>       
        <div class="form-group  w-100 mt-3">
          <label for="home_student_birthday">Data de Nascimento:</label>
          <input type="date" id="home_student_birthday" name="novo_estudante_nascimento" value="">      
        </div>   
        <div class="form-group w-100 mt-1">
          <label for="home_edit_student_password">Senha:</label>
          <input type="password" id="home_edit_student_password" class="input_senha" name="novo_estudante_senha">    
        </div>
        <div class="form-group w-100 mt-1">
          <label for="home_edit_confirm_password">Confirmar senha:</label>
          <input type="password" id="home_edit_confirm_password" class="input_senha" name="novo_estudante_confirma_senha">     
        </div>    
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btnCreateStudent" type="button" class="btn btn-primary">Criar</button>
      </div>
    </div>
  </div>
</div>
<!-- END/ modal/home_modals/modal_create_student.php -->