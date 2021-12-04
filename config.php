<?php
// Initialize the session
if (session_status() !== PHP_SESSION_ACTIVE) {
   session_start();
}


//constants
//! ODIARIOMAGICO.COM.BR 🛑
 //define('INCLUDE_PATH', 'https://odiariomagico.com.br/'); 

//! LOCALHOST  🟢
 define('INCLUDE_PATH', 'http://localhost/odiariomagico/');

//load class dynamically
$autoload = function($class){
   if($class == 'Email'){   
       require '../class/PHPMailer/src/Exception.php';
       require '../class/PHPMailer/src/PHPMailer.php';
       require '../class/PHPMailer/src/SMTP.php';
   }
   include('class/'.$class.'.php');
};

spl_autoload_register($autoload);

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

//! ODIARIOMAGICO.COM.BR 🛑
/* define('DB_SERVER', 'odiariomagico.com.br');
define('DB_USERNAME', 'odiari97_erickle');
define('DB_PASSWORD', 'jB@.=kwjh[fd');
define('DB_NAME', 'odiari97_magico');
define('DB_CHARSET', 'utf8'); */ 

//! LOCALHOST  🟢
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_CHARSET', 'utf8'); 
define('DB_PASSWORD', '');
define('DB_NAME', 'o_diario_magico');
 


/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Impossível conectar no banco de dados.");
}




?>