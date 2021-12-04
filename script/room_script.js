$(document).ready(function () {

    //ajax to get classroom info
    var sala = getUrlParameter('sala');
    $.ajax({
        type: "POST",
        url: path+"ajax/room_users.php",
        data: {'sala':sala},
        dataType: "json",
        success: function (response) {
            if(response.belong){
               
            }else{
                window.location.href = path+"login";     
            }         
        }
        
    });

    fillTeachers();
    fillStudents();
    fillMissions(sala);

    //show/hide div when click icons in small screens
    $('#small_link_diarioClasse').click(function (e) { 
        e.preventDefault();
        if($(window).width()<768){
            $('#divIn-diarioClasse').toggleClass('d-none');
            $('#divIn-professores').addClass('d-none');
            $('#divIn-estudantes').addClass('d-none');
            $('#divIn-missoes').addClass('d-none');
            
               }
    });
    $('#small_link_professores').click(function (e) { 
        e.preventDefault();
        if($(window).width()<768){
            $('#divIn-professores').toggleClass('d-none');
            $('#divIn-diarioClasse').addClass('d-none');
            $('#divIn-estudantes').addClass('d-none');
            $('#divIn-missoes').addClass('d-none');
            
               }
    });
    $('#small_link_estudantes').click(function (e) { 
        e.preventDefault();
        if($(window).width()<768){
            $('#divIn-estudantes').toggleClass('d-none');
            $('#divIn-diarioClasse').addClass('d-none');
            $('#divIn-professores').addClass('d-none');
            $('#divIn-missoes').addClass('d-none');
            
               }
    });
    $('#small_link_missoes').click(function (e) { 
        e.preventDefault();
        if($(window).width()<768){
            $('#divIn-missoes').toggleClass('d-none');
            $('#divIn-diarioClasse').addClass('d-none');
            $('#divIn-professores').addClass('d-none');
            $('#divIn-estudantes').addClass('d-none');
            
               }
    });

    //MODALS
    //modal add teacher
    $('#modal-body-btnVerifyTeacher').click(function (e) { 
        e.preventDefault();        
        $('#verifyTeacherResultsDiv').empty();
        $('#modal-body-btnAddTeacher').addClass('d-none');
        var teacherEmail = $('#emailTeacherSearch').val();
        if (teacherEmail == '') {
            alert('Preencha o email.');
        } else {
            $.ajax({
                type: "POST",
                url: path+"ajax/get_teacher.php",
                data: {'email':teacherEmail, 'sala':sala},
                dataType: "json",
                success: function (response) {
                    if (response.codigo == 0) {
                        alert(response.mensagem);
                    } else {
                        //console.log('Professor encontrado: '+response.nome+' '+response.sobrenome);
                        $('#verifyTeacherResultsDiv').append('<p id="modal-body-p-teacherName" teacher-id="'+response.id+'" class="h5 mt-2">Professor: '+response.nome+' '+response.sobrenome+'</p>');
                        $('#modal-body-btnAddTeacher').removeClass('d-none');
                    }                    
                }
            });
        }
       
    });

    $('#modal-body-btnAddTeacher').click(function (e) { 
        e.preventDefault();
        var teacherID = $('#modal-body-p-teacherName').attr('teacher-id');
        $.ajax({
            type: "POST",
            url: path+"ajax/teacher_to_room.php",
            data: {'teacherID': teacherID, 'sala':sala},
            dataType: "json",
            success: function (response) {
                alert(response.mensagem);
                $('#emailTeacherSearch').val('');
                $('#verifyTeacherResultsDiv').empty();
                $('#modalAddTeacher').modal('hide');
                $('#modal-body-btnAddTeacher').addClass('d-none');
                fillTeachers();
                
            }
        });
    });

    //modal add student
    $('#modal-body-btnVerifyStudent').click(function (e) { 
        e.preventDefault();        
        $('#verifyStudentResultsDiv').empty();
        $('#modal-body-btnAddStudent').addClass('d-none');
        var studentID = $('#registerStudentSearch').val();
        if (studentID == '') {
            alert('Preencha a matrícula.');
        } else {
            $.ajax({
                type: "POST",
                url: path+"ajax/get_student.php",
                data: {'id':studentID, 'sala':sala},
                dataType: "json",
                success: function (response) {
                    if (response.codigo == 0) {
                        alert(response.mensagem);
                    } else {
                        console.log('Estudante encontrado: '+response.nome+' '+response.sobrenome);
                        $('#verifyStudentResultsDiv').append('<p id="modal-body-p-studentName" student-id="'+response.id+'" class="h5 mt-2">Estudante: '+response.nome+' '+response.sobrenome+'</p>');
                        $('#modal-body-btnAddStudent').removeClass('d-none');
                    }                    
                }
            });
        }
       
    });
    $('#modal-body-btnAddStudent').click(function (e) { 
        e.preventDefault();
        var studentID = $('#modal-body-p-studentName').attr('student-id');
        $.ajax({
            type: "POST",
            url: path+"ajax/student_to_room.php",
            data: {'id': studentID, 'sala':sala},
            dataType: "json",
            success: function (response) {
                alert(response.mensagem);
                $('#registerStudentSearch').val('');
                $('#verifyStudentResultsDiv').empty();
                $('#modalAddStudent').modal('hide');
                $('#modal-body-btnAddStudent').addClass('d-none');
                fillStudents();
                
            }
        });
    });

    //modal add mission
    var missionID = '';
    $('#modal-body-btnVerifyMission').click(function (e) { 
        e.preventDefault();
        missionID = $('#idMissionSearch').val();
        //console.log(missionID);
        if (missionID=='') {
            alert('Preencha o ID da missão.');            
        } else {
            $.ajax({
                type: "POST",
                url: path+'ajax/get_mission.php',
                data: {'author': sessionStorage.getItem('id'), 'missionID': missionID},
                dataType: "json",
                success: function (response) {
                    if (response.codigo==0) {
                        alert(response.mensagem);
                    } else {
                       $('#verifyMissionResultsDiv').append('<p class="w-100 text-center h4">Missão: '+response.name+'</p>'); 
                       $('#btnAdd-modalAddMissionToRoom').removeClass('d-none');
                    }                    
                }
            });
            
        }
        
    });
    $('#btnAdd-modalAddMissionToRoom').click(function (e) { 
        e.preventDefault();
        console.log('sala: '+sala);
        console.log('id da missão: '+missionID);
        console.log('author: '+sessionStorage.getItem('id'));
        $.ajax({
            type: "POST",
            url: path+'ajax/mission_to_room.php',
            data: {'sala': sala, 'missionID': missionID, 'author': sessionStorage.getItem('id')},
            dataType: "json",
            success: function (response) {
                if (response.codigo==0) {
                    alert(response.mensagem);
                    $('#modalAddMissionToRoom').modal('hide');
                    fillMissions(sala);
                } else {
                    alert(response.mensagem);
                    $('#modalAddMissionToRoom').modal('hide');
                    fillMissions(sala);
                }
               
            }
        });
    });
    $('#modalAddMissionToRoom').on('hidden.bs.modal', function (e) {
        $('#verifyMissionResultsDiv').empty();
        $('#btnAdd-modalAddMissionToRoom').addClass('d-none');
      });

    //modal add room register
    $('#modalAddRoomRegister').on('show.bs.modal', function (e) {        
        addRoomRegister();

        
            
      
      })
   
});
function fillTeachers() {
    $('#teachersDiv').empty();
    //ajax to get classroom info
    var sala = getUrlParameter('sala');
    $.ajax({
        type: "POST",
        url: path+"ajax/teachers_in_room.php",
        data: {'sala':sala},
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if(response.codigo!=0){
                $.each(response, function (indexInArray, valueOfElement) { 
                   
                  if (indexInArray!='author') {
                    if (sessionStorage.getItem("id")==response.author) {                       
                        $('#teachersDiv').append('<p class="h5 text-white" register="'+indexInArray+'">'+valueOfElement+'&nbsp;&nbsp;<a class="remove-teacher"  register="'+indexInArray+'" data-toggle="modal" data-target="#modalRemoveUser"><i class="fas fa-user-minus"></i></a></p>'); 
                        setRemoves();                
                        } else {
                            $('#teachersDiv').append('<p class="h5 text-white remove-teacher" register="'+indexInArray+'">'+valueOfElement+'&nbsp;&nbsp;</p>');   
                            
                        }  
                    }
                });
            
            }
             
        }
        
    });

}
function fillStudents() {
    $('#feedEstudantes').empty();
    //ajax to get classroom info
    var sala = getUrlParameter('sala');
    $.ajax({
        type: "POST",
        url: path+"ajax/students_in_room.php",
        data: {'sala':sala},
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if(response.codigo!=0){
               $.each(response, function (indexInArray, valueOfElement) { 
                
                if (sessionStorage.getItem("cargo")=="professor") {                        
                    $('#feedEstudantes').append('<p class="h5 text-white" register="'+indexInArray+'">'+valueOfElement+'&nbsp;&nbsp;<a class="remove-student" register="'+indexInArray+'" data-toggle="modal" data-target="#modalRemoveUser"><i class="fas fa-user-minus"></i></a></p>');  
                    setRemoves();  
                    } else {
                        $('#feedEstudantes').append('<p class="h5 text-white remove-student" register="'+indexInArray+'">'+valueOfElement+'&nbsp;&nbsp;</p>');  
                        
                    }  
               });
            }
             
        }
        
    });
    
}
function fillMissions(sala) {    
    $.ajax({
        type: "POST",
        url: path+'ajax/room_missions.php',
        data: {'room_id': sala},
        dataType: "json",
        success: function (response) {
            if (response.codigo==0) {
                console.log(response.mensagem);                
            } else {
                console.log(Object.values(response)); 
                $('#feedMissions').empty();
                Object.values(response).forEach(element => {
                    if (typeof element.id !== 'undefined') { 
                        if (sessionStorage.getItem("cargo")=="professor") {                        
                            $('#feedMissions').append('<p class="h5 text-white" register="'+element.id+'">'+element.name+'&nbsp;&nbsp;<a class="complete-mission" register="'+element.id+'" data-toggle="modal" data-target="#modalRemoveMissionFromRoom"><i class="fas fa-trash"></i></a></p>');  
                            setRemoves();  
                        } else {
                            $('#feedMissions').append('<p class="h5 text-white remove-student" register="'+element.id+'">'+element.name+'&nbsp;&nbsp;<a class="complete-mission" register="'+element.id+'" data-toggle="modal" data-target="#modalCompleteMission"><i class="fas fa-play"></i></a></p>');  
                            setRuns();    
                        }  
                    }
                });
            }
        }
    });
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}
function setRemoves() {
    //REMOVE USER  
      
   $('.remove-teacher').off().on('click', function (e) {
        e.preventDefault();  
        var teacher_id = $(this).attr('register'); 
        var teacher_name = $(this).parent();
        console.log(teacher_name[0]['innerText']); 
        $('#modal-body-modalRemoveUser').empty();   
        $('#modal-body-modalRemoveUser').append('<p class="h5">Remover '+teacher_name[0]['innerText']+' da sala?');

        $('#btnRemoveUser-modalRemoveUser').off().click(function (e) { 
            e.preventDefault();
            removeUser(teacher_id, 'professor');        
        });    
    });
    
   $('.remove-student').off().on('click', function (e) {
        e.preventDefault();
        var student_id = $(this).attr('register'); 
        var student_name = $(this).parent();
        console.log(student_name[0]['innerText']); 
        $('#modal-body-modalRemoveUser').empty();   
        $('#modal-body-modalRemoveUser').append('<p class="h5">Remover '+student_name[0]['innerText']+' da sala?');

        $('#btnRemoveUser-modalRemoveUser').off().click(function (e) { 
            e.preventDefault();
            removeUser(student_id, 'estudante');        
        });
    }); 
   $('.remove-mission').off().on('click', function (e) {
        e.preventDefault();
        var mission_id = $(this).attr('register'); 
        $('#btn-modalRemoveMissionFromRoom').off().click(function (e) { 
            e.preventDefault();
            removeUser(mission_id, 'mission');        
        });
    }); 
  
      
}
function setRuns() {
    $('.complete-mission').off().on('click', function (e) {
        var complete_missionID = $(this).attr('register'); 
           $.ajax({
               type: "POST",
               url: path+'ajax/get_mission.php',
               data: {'missionID': complete_missionID},
               dataType: "json",
               success: function (response) {
                   if (response.codigo==0) {
                    $('#modalCompleteMission').modal('hide');
                    alert(response.mensagem);
                   }else{
                       //fill instruction
                    $('#title-modalCompleteMission').empty();
                    $('#title-modalCompleteMission').append(response.name);
                    $('#desc-rowInstruction-modal-body-modalCompleteMission').empty();
                    $('#desc-rowInstruction-modal-body-modalCompleteMission').append(response.description);
                    $('#footer-rowInstruction-modal-body-modalCompleteMission').empty();
                    $('#footer-rowInstruction-modal-body-modalCompleteMission').append('Tipo: '+response.type+'. XP: '+response.xp+'.');
                    if (response.cover!='') {
                        $('#img-rowInstruction-modal-body-modalCompleteMission').attr('src', response.cover);
                    }else{
                        $('#img-rowInstruction-modal-body-modalCompleteMission').attr('src', path+imgs/no-image.png);
                    }
                    $('#btnSeeMission-modalCompleteMission').click(function (e) { 
                        e.preventDefault();
                        $('#rowInstruction-modal-body-modalCompleteMission').addClass('d-none');   
                        $('#rowMission-modal-body-modalCompleteMission').removeClass('d-none');                     
                    });

                    //fill mission
                    $('#label-missionName-form-modalCompleteMission').empty();
                    $('#label-missionName-form-modalCompleteMission').append('Título '+response.type);
                    $('#btnSeeDescription-modalCompleteMission').click(function (e) { 
                        e.preventDefault();
                        $('#rowInstruction-modal-body-modalCompleteMission').removeClass('d-none');   
                        $('#rowMission-modal-body-modalCompleteMission').addClass('d-none');                     
                    });
                    $('#btnCompleteMission-modalCompleteMission').click(function (e) { 
                        e.preventDefault();
                        const reader = new FileReader();
                        var imagem = $("#missionFile-form-modalCompleteMission")[0].files[0];    
                        if (imagem) {  
                            reader.readAsDataURL(imagem);
                            reader.onloadend = function (e) {
                                
                                completeMission(reader.result, response.id, response.type);        
                            }
                        }else{
                            completeMission('', response.id, response.type);
                        }
                        
                    });
                   }
                   
               }
           });
          });
}
function removeUser(id, cargo) {
    var sala = getUrlParameter('sala');
      if (cargo == 'professor') {
          var path_cargo = 'remove_teacher.php';
      } else if(cargo == 'estudante') {
        var path_cargo = 'remove_student.php';
      }  else if(cargo == 'mission'){
        var path_cargo = 'remove_mission.php';
      } 

      $.ajax({
          type: "POST",
          url: path+"ajax/"+path_cargo,
          data: {'id': id, 'sala': sala},
          dataType: "json",
          success: function (response) {
              alert('Retorno: '+response.mensagem);
              $('#modal-body-modalRemoveUser').empty(); 
              $('#modalRemoveUser').modal('hide');  
              $('#modalRemoveMissionFromRoom').modal('hide');  
              fillTeachers(); 
              fillStudents();           
              fillMissions(sala);           
          }
      }); 
}
function completeMission(image, mission, type) {
    //variables
    var sala = getUrlParameter('sala');    
    var student = sessionStorage.getItem('id'); 
    var mission_name = $('#missionName-form-modalCompleteMission').val();
    var mission_desc = $('#missionDescription-form-modalCompleteMission').val();
    var mission_dateIni = $('#missionDateIni-form-modalCompleteMission').val();
    var mission_dateEnd = $('#missionDateEnd-form-modalCompleteMission').val();

    if (mission_name=='') {
        alert('Preencha o título da missão');
    } else if(mission_desc=='') {
        alert('Preencha a descrição da missão');
    } else if(mission_dateIni=='') {
        alert('Escolha uma data inicial');
    }else{
        $.ajax({
            type: "POST",
            url: path+'ajax/complete_mission.php',
            data: {'sala': sala, 'missionID': mission, 'missionName': mission_name, 'missionDesc': mission_desc, 'missionType': type, 'missionDateIni': mission_dateIni, 'missionDateEnd': mission_dateEnd, 'student': student, 'image': image},
            dataType: "json",
            success: function (response) {
                alert(response.mensagem);
                $('#form-modalCompleteMission').trigger('reset');
                $('#modalCompleteMission').modal('hide');
                location.reload(true);
               
            }
        });
    }

}
function addRoomRegister() {
    $('#btnAddRoomRegister-modalAddRoomRegister').click(function (e) { 
        e.preventDefault();
        var name_room_register = $('#missionName-form-modalAddRoomRegister').val();
        var type_room_register = $('#missionTipo-form-modalAddRoomRegister').val();
        var desc_room_register = $('#missionDescription-form-modalAddRoomRegister').val();
        var dateIni_room_register = $('#missionDateIni-form-modalAddRoomRegister').val();
        //console.log('type=> '+type_room_register);
        if (name_room_register=='') {
            alert('Preencha o título do registro.');
        } else if (desc_room_register=='') {
            alert('Preencha a descrição do registro.');
        } else if (type_room_register==null) {
            alert('Escolha o tipo do registro.')
        } else if (dateIni_room_register=='') {
            alert('Escolha a data inicial do registro.')
        } else {
            const reader = new FileReader();
            var imagem = $("#missionFile-form-modalAddRoomRegister")[0].files[0];    
            if (imagem) {  
                reader.readAsDataURL(imagem);
                reader.onloadend = function (e) {
                postRegister(reader.result);        
                }
            }else{
                postRegister('');
            }
        }
    });    
}
function postRegister(image) {
    var sala = getUrlParameter('sala');
    var name_room_register = $('#missionName-form-modalAddRoomRegister').val();
    var type_room_register = $('#missionTipo-form-modalAddRoomRegister').val();
    var desc_room_register = $('#missionDescription-form-modalAddRoomRegister').val();
    var dateIni_room_register = $('#missionDateIni-form-modalAddRoomRegister').val();
    var dateEnd_room_register = $('#missionDateEnd-form-modalAddRoomRegister').val();
    
    $.ajax({
        type: "POST",
        url: path+'ajax/register_to_room.php',
        data: {'sala': sala, 'author': sessionStorage.getItem('id'), 'missionName': name_room_register, 'missionDesc': desc_room_register, 'missionType': type_room_register, 'missionDateIni': dateIni_room_register, 'missionDateEnd': dateEnd_room_register, 'image': image},
        dataType: "json",
        success: function (response) {
            alert(response.mensagem);   
            $('#form-modalAddRoomRegister').trigger('reset');
            $('#modalAddRoomRegister').modal('hide');  
            location.reload(true);       
        }
    });
}