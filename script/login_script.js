$('document').ready(function(){

	
	/*  ====variáveis ==== */
	//notificação gerais de login do modal
	$notification_title = '';
	$notification_msg = '';
	//operadores de verificação para criar nova conta de professor
	$num1 = Math.floor(Math.random() * 100);  
	$num2 = Math.floor(Math.random() * 100); 
	$resposta = $num1 + $num2; 

	/* === envio de formulário  === */
	//fazer login de professor
	$("#login_teacher").click(function(e){
        e.preventDefault();
		var data = $("#formLoginTeacher").serialize();			
		$.ajax({
			type : 'POST',
			url  : path+'ajax/form_login.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#progress_login_teacher").removeClass('d-none');
                $("#msg-error-auth-teacher").addClass('d-none');
			},
			success :  function(response){		
				console.log('login');				
				if(response.codigo == "1"){	
                    $("#msg-error-auth-teacher").addClass('d-none');
					$("#progress_login_teacher").addClass('d-none');       
					window.location.href = path+"home";
				}
				else{						
				    $("#msg-error-auth-teacher").removeClass('d-none');
                    $("#progress_login_teacher").addClass('d-none'); 
					$notification_title = 'Não foi possível entrar';
					$notification_msg = response.mensagem;
					
					$('#modalNotification').modal('show');
					setTimeout(() => {
						$("#msg-error-auth-teacher").addClass('d-none');
					}, 5000);
                   
				}
		    }
		});
	});
	//fazer login de estudante
	$("#login_student").click(function(e){
		e.preventDefault();
		var data = $("#formLoginStudent").serialize();
			
		$.ajax({
			type : 'POST',
			url  : path+'ajax/form_login_student.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#progress_login_student").removeClass('d-none');
			},
			success :  function(response){	
				console.log('tere');					
				if(response.codigo == "1"){	
					$("#progress_login_student").addClass('d-none');       
					window.location.href = path+"home";
				}
				else{						
					$("#progress_login_student").addClass('d-none'); 
					$notification_title = 'Não foi possível entrar';
					$notification_msg = response.mensagem;
					
					$('#modalNotification').modal('show');
					
				}
			}
		});
	});
	//modal de notificação gerais de login
	$('#modalNotification').on('show.bs.modal', function (event) {
		var modal = $(this)
		modal.find('.modal-title').text($notification_title);
		modal.find('.modal-body').text($notification_msg);
	  });
	//criar novo professor
	$('#btnCreateTeacher').click(function (e) { 
		e.preventDefault();
		var data = $('#formCreateTeacher').serialize();
		$res = $('#verifyCreateTeacher').val();

		if($res==$resposta){
			$.ajax({
				type: "POST",
				url  : path+'ajax/create_teacher.php',
				data: data,
				dataType: "json",
				beforeSend: function()
				{	
					$("#progress_create_teacher").removeClass('d-none');
					$("#msg-error-create-teacher").addClass('d-none');
				},
				success: function (response) {
					$("#progress_create_teacher").addClass('d-none');
					if(response.codigo == "1"){	
						$('#modalCreateTeacher').modal('hide');	
						$("#msg-teacher-created").removeClass('d-none');
						setTimeout(() => {
							$("#msg-teacher-created").addClass('d-none');
						}, 5000);
	
					}else{	
						$("#msg-error-create-teacher").removeClass('d-none');					
						$('#formCreateTeacher').trigger("reset");
						$('#msg-error-create-teacher').find('small').text('resposta: '+response.mensagem);    
						$num1 = Math.floor(Math.random() * 100);  
						$num2 = Math.floor(Math.random() * 100); 
						$resposta = $num1 + $num2;  
						$msg = 'Responda: '+$num1+' + '+$num2+' = ';
						$('#labelVerifyCreateTeacher').text($msg);               
					}
				}
			});
		}else{
			$("#msg-error-create-teacher").removeClass('d-none');
			$('#msg-error-create-teacher').find('small').text('Resposta incorreta.'); 
			$num1 = Math.floor(Math.random() * 100);  
			$num2 = Math.floor(Math.random() * 100); 
			$resposta = $num1 + $num2;  
			$msg = 'Responda: '+$num1+' + '+$num2+' = ';
			$('#labelVerifyCreateTeacher').text($msg);
		}

	


	});  
	//modal criar novo professor
	$('#modalCreateTeacher').on('show.bs.modal', function (event) {
		$num1 = Math.floor(Math.random() * 100);  
		$num2 = Math.floor(Math.random() * 100); 
		$resposta = $num1 + $num2; 

		$msg = 'Responda: '+$num1+' + '+$num2+' = ';
		$('#labelVerifyCreateTeacher').text($msg);

	  });
	//esqueci a senha	
	$('#forgotSenha').click(function (e) { 
		e.preventDefault();
		if($('#validationTeacherEmail').val()==''){
			$("#msg-error-forgot-teacher").removeClass('d-none');
			setTimeout(() => {
				$("#msg-error-forgot-teacher").addClass('d-none');
			}, 3500);
		}else{
			var data = $("#formLoginTeacher").serialize();

			$.ajax({
				type : 'POST',
				url  : path+'ajax/email_password.php',
				data : data,
				dataType: 'json',
				beforeSend: function()
				{	
					$("#progress_login_teacher").removeClass('d-none');
					$("#msg-error-auth-teacher").addClass('d-none');
				},
				success :  function(response){						
					if(response.codigo == "1"){	
						$("#msg-error-auth-teacher").addClass('d-none');
						$("#progress_login_teacher").addClass('d-none');    
						$("#msg-error-sent-teacher").removeClass('d-none');
						setTimeout(() => {
							$("#msg-error-sent-teacher").addClass('d-none');
						}, 4000);
					}
					else{						
						$("#msg-error-not-registered-teacher").removeClass('d-none');
						setTimeout(() => {
							$("#msg-error-not-registered-teacher").addClass('d-none');
						}, 5000);
						$("#progress_login_teacher").addClass('d-none'); 
						$notification_title = 'Não foi possível enviar sua senha';
						$notification_msg = response.mensagem;
						
						$('#modalNotification').modal('show');
					   
					}
				}
			});
		};
		
	});





});

