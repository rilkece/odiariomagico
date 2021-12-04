
<!-- Modal create room-->
<div class="modal fade" id="modalCreateRoom" tabindex="-1" role="dialog" aria-labelledby="Create Teacher" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center" >Criar Sala</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  
      <form class="form-inline" id="formHomeCreateRoom">
        <div class="form-group w-100 mt-3">
          <label for="home_room_name">Nome da Sala:</label>
          <input type="text" name="nova_sala_nome" id="home_room_name" class="form-control" placeholder="Sala">
        </div>
        <div class="form-group w-100 mt-3">
          <label for="home_school_name">Escola:</label>
          <input type="text" name="nova_escola_nome" id="home_school_name" class="form-control" placeholder="Escola" >
        </div>       
        <div class="form-group  w-100 mt-3">
          <label for="home_school_birthday">Criação da Escola:</label>
          <input type="date" id="home_school_birthday" name="nova_escola_nascimento">      
        </div>   
        <div class="form-group w-100 mt-3">
          <label for="home_room_info">Descrição:</label>
          <input type="text" name="nova_sala_info" id="home_room_info" class="form-control" placeholder="Descrição">
        </div>   
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btnCreateRoom" type="button" class="btn btn-primary">Criar Sala</button>
      </div>
    </div>
  </div>
</div>