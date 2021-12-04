$(document).ready(function () {

  
  
  /* === envio de formulário  === */
   //criar nova sala
	$('#btnCreateRoom').click(function (e) { 
		e.preventDefault();
		var data = $('#formHomeCreateRoom').serialize();

			$.ajax({
				type: "POST",
				url  : path+'ajax/create_room.php',
				data: data,
				dataType: "json",
				beforeSend: function()
				{	
				},
				success: function (response) {
					alert(response.mensagem);
          if(response.codigo == '1'){
            $('#formHomeCreateRoom')[0].reset();
            $('#modalCreateRoom').modal('hide');
          }
          
				}
			});
	});  
   //criar novo estudante
	$('#btnCreateStudent').click(function (e) { 
		e.preventDefault();
		var data = $('#formHomeCreateStudent').serialize();

			$.ajax({
				type: "POST",
				url  : path+'ajax/create_student.php',
				data: data,
				dataType: "json",
				beforeSend: function()
				{	
				},
				success: function (response) {
					alert(response.mensagem);
          if(response.codigo == '1'){
            $('#formHomeCreateStudent')[0].reset();
            $('#modalCreateStudent').modal('hide');
          }
          
				}
			});
	});  
  // edit user
  $('#btnEditUser').click(function (e) { 
    e.preventDefault();
    var data = $("#formHomeEditUser").serialize();

    $.ajax({
      type: "POST",
      url: path+'ajax/edit_user.php',
      data: data,
      dataType: "json",
      success: function (response) {
        alert(response.nome+'\n'+response.sobrenome+'\n'+response.birthday+'\n'+response.senha+'\n');
        //document.getElementById("formHomeEditUser").reset();
        $('#modalEditUser').modal('hide');
      }
    });
    
  });
  //enable/disable alterar senha in edit user form
  $('#home_alterar_senha').change(function (e) { 
    e.preventDefault();
    if($('.input_senha').prop("disabled")){
    $('.input_senha').prop("disabled", false);
  }else{
    $('.input_senha').prop("disabled", true);
  }
    
  });
  //modal estudantes criados
  $('#modalStudentsCreated').on('shown.bs.modal', function () {
    $.ajax({
      url: path+'ajax/students_created.php',
      dataType: "json",
      success: function (response) {  
        //console.log(response[0]);
        $('#modal-body-students-created').empty();
        for (var i = 0; i < response.length; i++) {        
        var card = '<div class="card card-list"><div class="card-body"><h4 class="card-title">'+response[i]['nome']+' '+response[i]['sobrenome']+'</h4><p class="card-text">'+'Matrícula: '+response[i]['id']+' Senha: '+response[i]['senha']+'</p></div></div><br>';
        $('#modal-body-students-created').append(card);        
        }      
                       
      }
    });
  })
  //modals minhas salas
  $('#modalRoomsCreated').on('shown.bs.modal', function () {
    $.ajax({
      url: path+'ajax/rooms_created.php',
      dataType: "json",
      success: function (response) {  
        console.log('retorno');
        $('#modal-body-rooms-created').empty();
        for (var i = 0; i < response.length; i++) {        
        var card = '<a href="'+path+'room?sala='+response[i].id+'"><div class="card card-list-rooms"><div class="card-body"><h4 class="card-title">'+response[i]['id']+' '+response[i]['name']+'</h4><p class="card-text">'+'Escola: '+response[i]['school']+'</p></div></div><br></a>';
        $('#modal-body-rooms-created').append(card);        
        }      
                       
      }
    });
  })

  $('#modalMyRooms').on('shown.bs.modal', function () {
    $.ajax({
      url: path+'ajax/my_rooms.php',
      dataType: "json",
      success: function (response) {  
        console.log('retorno');
        $('#modal-body-modalMyRooms').empty();
        for (var i = 0; i < response.length; i++) {        
        var card = '<a href="'+path+'room?sala='+response[i].id+'"><div class="card card-list-rooms"><div class="card-body"><h4 class="card-title">'+response[i]['id']+' '+response[i]['name']+'</h4><p class="card-text">'+'Escola: '+response[i]['school']+'</p></div></div><br></a>';
        $('#modal-body-modalMyRooms').append(card);        
        }      
                       
      }
    });
  })

});