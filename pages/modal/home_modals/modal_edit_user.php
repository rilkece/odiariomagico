<!-- modal/home_modals/modal_edit_user.php -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="Create Teacher" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center" >Editar Usuário</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  
      <form class="form-inline" id="formHomeEditUser">         
        <div class="form-group w-100">
          <label for="">Email:</label>
          <?php echo $basic_user->email ?>
        </div>
        <div class="form-group w-100 mt-3">
          <label for="home_edit_name">Nome:</label>
          <input type="text" name="novo_nome" id="home_edit_name" class="form-control" placeholder="<?php echo $basic_user->nome ?>">
        </div>
        <div class="form-group w-100 mt-3">
          <label for="home_edit_surname">Sobrenome:</label>
          <input type="text" name="novo_sobrenome" id="home_edit_surname" class="form-control" placeholder="<?php echo $basic_user->sobrenome ?>" >
        </div>       
        <div class="form-group  w-100 mt-3">
          <label for="home_edit_birthday">Data de Nascimento:</label>
          <input type="date" id="home_edit_birthday" name="nascimento" value="<?php if ($basic_user->data_nascimento!=null ) {echo $basic_user->data_nascimento;} else {echo '0000-00-00';}?>">      
        </div>
        <?php if($user->cargo=='professor'): ?>                 
          <div class="form-check w-100">
            <label class="home_alterar_senha_label mt-3">
              <input id="home_alterar_senha" type="checkbox" class="form-check-input " name="check_home_alterar_senha" >
              <strong>Alterar senha</strong> 
            </label>
          </div>  
        <div class="form-group w-100 mt-3">
          <label for="home_edit_senha">Senha atual:</label>
          <input type="password" id="home_edit_senha" class="input_senha" name="home_senha"  disabled>     
        </div>
        <div class="form-group w-100 mt-1">
          <label for="home_edit_nova_senha">Nova senha:</label>
          <input type="password" id="home_edit_nova_senha" class="input_senha" name="nova_senha" disabled>    
        </div>
        <div class="form-group w-100 mt-1">
          <label for="home_edit_confirma_nova_senha">Confirmar senha:</label>
          <input type="password" id="home_edit_confirma_nova_senha" class="input_senha" name="confirma_nova_senha" disabled>     
        </div>
        <?php endif; ?>        
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btnEditUser" type="button" class="btn btn-primary">Atualizar</button>
      </div>
    </div>
  </div>
</div>
<!-- END/ modal/home_modals/modal_edit_user.php -->