
var missionID = '';

$(document).ready(function () {   
    //get missions 
    myMissions();

        //set modal create mission range
        const
        range = document.getElementById('missionXP-form-modalCreateMission'),
        rangeV = document.getElementById('rangeV'),
        setValue = ()=>{
            const
            newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) ),
            newPosition = 10 - (newValue * 0.2);
            rangeV.innerHTML = `<span>${range.value}</span>`;
            rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;
        };
        document.addEventListener("DOMContentLoaded", setValue);
        range.addEventListener('input', setValue);
    $('#modalCreateMission').on('show.bs.modal', function (e) {
        //set modal create mission range
        
            const
            newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) ),
            newPosition = 10 - (newValue * 0.2);
            rangeV.innerHTML = `<span>${range.value}</span>`;
            rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;
      
      });

        const
        rangeEdit = document.getElementById('missionXP-form-modalEditMission'),
        rangeVEdit = document.getElementById('rangeV-edit'),
        setValueEdit = ()=>{
            const
            newValueEdit = Number( (rangeEdit.value - rangeEdit.min) * 100 / (rangeEdit.max - rangeEdit.min) ),
            newPositionEdit = 10 - (newValueEdit * 0.2);
            rangeVEdit.innerHTML = `<span>${rangeEdit.value}</span>`;
            rangeVEdit.style.left = `calc(${newValueEdit}% + (${newPositionEdit}px))`;
        };
        document.addEventListener("DOMContentLoaded", setValueEdit);
        rangeEdit.addEventListener('input', setValueEdit);
    $('#modalEditMission').on('show.bs.modal', function (e) {
        //set modal create mission range
        
            const
            newValueEdit = Number( (rangeEdit.value - rangeEdit.min) * 100 / (rangeEdit.max - rangeEdit.min) ),
            newPositionEdit = 10 - (newValueEdit * 0.2);
            rangeVEdit.innerHTML = `<span>${rangeEdit.value}</span>`;
            rangeVEdit.style.left = `calc(${newValueEdit}% + (${newPositionEdit}px))`;
      
      });
  

    //create mission
    $('#missionFile-form-modalCreateMission').change(function (e) { 
        e.preventDefault();
        validateFileType('create');
        
    });
    $('#btn-form-modalCreateMission').click(function (e) { 
        e.preventDefault();
        var mission_name = $('#missionName-form-modalCreateMission').val();
        var mission_type = $('#missionTipo-form-modalCreateMission').val();
        var mission_xp = $('#missionXP-form-modalCreateMission').val();
        var mission_desc = $('#missionDescription-form-modalCreateMission').val();

        if (mission_name=='') {
            alert('Preencha o nome da missão.');
        } else if (mission_type==''){
            alert('Escolha o tipo da missão.');
        } else if (mission_desc==''){
            alert('Preencha a descrição da missão.');
        }else{
            getImgBlob('create');
        }

     
        
    });

    //edit mission
    $('#missionFile-form-modalEditMission').change(function (e) { 
        e.preventDefault();
        validateFileType('edit');
        
    });
    $('#save-modalEditMission').click(function (e) {         
        e.preventDefault();
        var mission_name = $('#missionName-form-modalCreateMission').val();
        var mission_type = $('#missionTipo-form-modalCreateMission').val();
        var mission_xp = $('#missionXP-form-modalCreateMission').val();
        var mission_desc = $('#missionDescription-form-modalCreateMission').val();
        getImgBlob('edit');
        
    });

    //delete mission
    $('#modalDeleteMission').on('show.bs.modal', function (e) {
        $('#save-modalDeleteMission').click(function (e) { 
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: path+'ajax/delete_mission.php',
                data: {'mission_id': missionID},
                dataType: "json",
                success: function (response) {
                    alert(response.mensagem);
                    $('#modalDeleteMission').modal('hide');
                    myMissions();
                    
                }
            });
            
        });
        
      });


});



function validateFileType(action){
    if (action=='create') {
        var file = document.getElementById("missionFile-form-modalCreateMission");        
    } else {    
        var file = document.getElementById("missionFile-form-modalEditMission");        
    }
  var fileName = file.value,
  idxDot = fileName.lastIndexOf(".") + 1,
  extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
  if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){    
    return true;  
    
  }else{
    alert("Apenas imagens jpg/jpeg e png são permitidas!");
    file.value = "";  // Reset the input so no files are uploaded
    return false;
  }
}

function getImgBlob(action) {
    if (action=='create') {
        const reader = new FileReader();
        var imagem = $("#missionFile-form-modalCreateMission")[0].files[0];    
        if (imagem) {  
            reader.readAsDataURL(imagem);
            reader.onloadend = function (e) {
                postMission(reader.result, action);        
            }
        }else{
            postMission('');
        }
    } else {
        const reader = new FileReader();
        var imagem = $("#missionFile-form-modalEditMission")[0].files[0];    
        if (imagem) {  
            reader.readAsDataURL(imagem);
            reader.onloadend = function (e) {
                postMission(reader.result, action);        
            }
        }else{
            postMission('');
        }
    }
    
}

function postMission(image, action) {
    if (action=='create') {
        var mission_name = $('#missionName-form-modalCreateMission').val();
        var mission_type = $('#missionTipo-form-modalCreateMission').val();
        var mission_xp = $('#missionXP-form-modalCreateMission').val();
        var mission_desc = $('#missionDescription-form-modalCreateMission').val();
        var mission_img = image;
    
        $.ajax({
            type: "POST",
            url: path+'ajax/create_mission.php',
            data: {'author': sessionStorage.getItem('id'), 'mission_name': mission_name, 'mission_type': mission_type, 'mission_xp': mission_xp, 'mission_desc': mission_desc, 'mission_img': mission_img},
            dataType: "json",
            success: function (response) {
                alert(response.mensagem); 
                $("#form-modalCreateMission").trigger("reset");   
                $('#modalCreateMission').modal('hide');        
            }
        });  
    } else {
        var mission_name = $('#inputName-modalEditMission').val();
        console.log(mission_name);
        var mission_type = $('#inputType-modalEditMission').val();
        var mission_xp = $('#missionXP-form-modalEditMission').val();
        var mission_desc = $('#inputDesc-modalEditMission').val();
        var mission_img = image;

        $.ajax({
            type: "POST",
            url: path+'ajax/edit_mission.php',
            data: {'author': sessionStorage.getItem('id'), 'mission_id': missionID, 'mission_name': mission_name, 'mission_type': mission_type, 'mission_xp': mission_xp, 'mission_desc': mission_desc, 'mission_img': mission_img},
            dataType: "json",
            success: function (response) {
                alert(response.mensagem); 
                $("#form-modalEditMission").trigger("reset");   
                $('#modalEditMission').modal('hide');  
                myMissions();      
            }
        }); 
    }
       
}

function myMissions() {

    $.ajax({
        type: "POST",
        url: path+'ajax/my_missions.php',
        data: {'author': sessionStorage.getItem('id')},
        dataType: "json",
        success: function (response) {
            if (response.codigo==0) {
                //console.log(Object.values(response).slice(-1)[0].mensagem);  /        
            } else {
                //console.log(Object.values(response)); 
                $('#myMissionsContainer').empty();
                Object.values(response).forEach(element => {
                    if (typeof element.id !== 'undefined') { 
                        if(element.cover==''){
                            element.cover = path+'imgs/no-image.png';
                        }
                        $('#myMissionsContainer').append('<div class="card mt-5"><div class="card-body"><div class="row"><div class="col-3"><img class="img-card-mission"  src="'+element.cover+'" alt=""></div><div class="col-7"><h4 class="card-title">'+element.name+'<small>('+element.type+')</small></h4><p class="card-text">'+element.description+'</p><small class="text-muted"><em>criado em: '+element.created+'. XP: '+element.xp+'. ID: '+element.id+'</em></small></div><div class="col-2"><a name="" id="" class="btn btn-green mission-edit" href="#" role="button" mission-id="'+element.id+'"><i class="fas fa-edit    "></i></a><a name="" id="" class="btn btn-danger mission-delete" href="#" role="button" mission-id="'+element.id+'"><i class="fas fa-trash"></i></a></div></div></div></div>');
                    }
                });
                setMissionsBtns();
            }
            
        }
    });
    
}

function setMissionsBtns() {
    $('.mission-edit').click(function (e) { 
        e.preventDefault();
        missionID = $(this).attr('mission-id');
        $.ajax({
            type: "POST",
            url: path+'/ajax/get_mission.php',
            data: {author: sessionStorage.getItem('id'), 'missionID': missionID},
            dataType: "json",
            success: function (response) {
                if (response.codigo==0) {
                    alert('Missão não encontrada"');                    
                } else {
                    $('#inputName-modalEditMission').attr('placeholder', response.name);
                    $('#inputDesc-modalEditMission').attr('placeholder', response.description);
                    $('#missionXP-form-modalEditMission').attr('value', response.xp);
                    $('#modalEditMission').modal('show');
                    
                }                
            }
        });             
    });
    $('.mission-delete').click(function (e) { 
        e.preventDefault();
        missionID = $(this).attr('mission-id');
         $('#modalDeleteMission').modal('show');

    });
    
}