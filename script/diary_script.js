

$(document).ready(function () {
  $(".hexagon-item").click(function (e) {
    e.preventDefault();

    $("#loader-wrapper").removeClass("d-none");

    $(".hexagon-item").removeClass("active");
    $(this).addClass("active");
    $("#navbarToggleExternalContent").collapse("toggle");
    
    var menuID =  $(this).attr('id').replace('hexagon-item-link-', '');
    //console.log('menu: '+menuID);
    //console.log('MENU ID=>'+menuID);


    $.ajax({
        type: "POST",
        url: path+'/ajax/diary_page.php',
        data: {'menuID': menuID, 'userID': sessionStorage.getItem('id'), 'context': 'student'},
        dataType: "html",
        success: function (response) {  
          $("#loader-wrapper").addClass("d-none");       
          if (menuID<5) {
            $('.tagDiv').addClass('d-none');  
          } else {
            $('.tagDiv').removeClass('d-none'); 
          }   
          $('#diary-filter-btn').removeClass('d-none');      
          $('#diary-content-div').empty();
          $('#diary-content-div').append(response);    
        }
    });
  });

  $('#btn-add-data').click(function (e) { 
    e.preventDefault();
    $.ajax({
      type: "method",
      url: "url",
      data: "data",
      dataType: "dataType",
      success: function (response) {
        alert('dados adicionados')
        
      }
    });
    
  });

});
