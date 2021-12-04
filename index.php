<?php 
   require_once ('config.php');
  
/* url settings */
$url = isset($_GET['url']) ? $_GET['url'] : '';

if ($url=='') { 
 header('Location: '.INCLUDE_PATH.'login');    
};
if($url=='logout'){
 $logout = Conexao::logout();
}

if($url !== 'login' && isset($_SESSION['logado']) && $_SESSION['logado']=='SIM'){
 $_SESSION['logado']=='SIM';
 $connect = Conexao::check_remember($url); 
}elseif($url !== 'login' && isset($_COOKIE['login_remember']) && $_COOKIE['login_remember']){
  $_SESSION['logado']=='SIM';
  $connect = Conexao::check_remember($url); 
}elseif($url !== 'login' && isset($_SESSION['logado']) && $_SESSION['logado'] !== 'SIM'){
 $_SESSION['logado'] = 'NAOb';     
 header('Location: '.INCLUDE_PATH.'login'); 
}elseif(!isset($_SESSION['logado'])  && $url !== 'login') {    
 $_SESSION['logado'] = 'NAOa';
 header('Location: '.INCLUDE_PATH.'login');   
}elseif(isset($_SESSION['logado']) && $_SESSION['logado']=='SIM'  && $url == 'login') {       
 header('Location: '.INCLUDE_PATH.'home');
};

if(isset($_SESSION['logado']) && $_SESSION['logado']=='SIM'){
 $user = User::getUser($_SESSION['id'], $_SESSION['cargo']);
 $basic_user = User::getBasic($_SESSION['id'], $_SESSION['cargo']);
}
/*  if(isset($_SESSION['logado'])){
  echo $_SESSION['logado'];
}else{
echo 'not logged - ';
}
if(isset($_COOKIE['login_remember'])){
echo $_COOKIE['login_remember']; 
}else{
echo ' no remember'; 
} */

      
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Diário Mágico</title>
    <!-- Styles-->
    
    <?php 
    include ('style/main_styles.php');
    ?>

    <!-- END Styles-->
  

    <!--Fontes-->
    <?php 
    include ('style/fonts.php');
    ?>
    <script src="https://kit.fontawesome.com/ad4fecfbfa.js" crossorigin="anonymous"></script>
    

    <!--END /Fontes-->
  </head>
  <body>
<!--Header-->
    <?php 
    include ('pages/header/header.php');    
    ?>
<!--END /Header-->
<!--Main-->
    <div class="container-fluid pr-0 pl-0">
    <?php     
    //echo '<script>alert("'.$url.'");</script>';
    if(file_exists('pages/'.$url.'/'.$url.'.php')){
      include 'pages/'.$url.'/'.$url.'.php';
    }else{
      include 'not_found.html';
    }   
    ?>
    </div>
<!--END Main-->
<!--Footer-->
    <?php 
    include ('pages/footer/footer.php');    
    ?>
<!--END /Footer-->

<!--Modal-->
    <?php 
    include ('pages/modal/modal_notification.php');    
    ?>
<!--END /Modal notification-->

<!--Others modal-->
    <?php 
    switch ($url) {
      case 'login':
        include ('pages/modal/modal_create_teacher.php');   
        break;
      case 'home':
        include ('pages/modal/modal_home.php');   
        break;
      case 'room':
        include ('pages/modal/modal_room.php');   
        break;
      case 'mission':
        include ('pages/modal/modal_mission.php');   
        break;
    }   
    ?>
<!--END /Others modal-->

  <!-- START SCRIPTS-->
  
  <script>
    sessionStorage.setItem("id", <?php echo $_SESSION['id']; ?>);
    sessionStorage.setItem("cargo", "<?php echo $_SESSION['cargo']; ?>");
    sessionStorage.setItem("logado", "<?php echo $_SESSION['logado']; ?>");
    sessionStorage.setItem("email", "<?php echo $_SESSION['email']; ?>");
    sessionStorage.setItem("nome", "<?php echo $_SESSION['nome']; ?>");
    sessionStorage.setItem("sobrenome", "<?php echo $_SESSION['sobrenome']; ?>");
    sessionStorage.setItem("data_criado", "<?php echo $_SESSION['data_criado']; ?>");
  </script>
  <?php 
  include 'script/main_scripts.php';
  ?>

  <!-- END SCRIPTS-->
    
  </body>
  </html>