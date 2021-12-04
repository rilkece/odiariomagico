<?php 

//require_once ('../config.php');

 class Conexao {  

   /*  
    * Atributo estático para instância do PDO  
    */  
   private static $pdo;
   

   /*  
    * Escondendo o construtor da classe  
    */ 
   private function __construct() {  
     //  
   } 
 
   /*  
    * Método estático para retornar uma conexão válida  
    * Verifica se já existe uma instância da conexão, caso não, configura uma nova conexão  
    */  
   public static function connect() {  
     if (!isset(self::$pdo)) {  
       try {  
         $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_PERSISTENT => TRUE);  
         self::$pdo = new PDO("mysql:host=" .DB_SERVER. "; dbname=" .DB_NAME. "; charset=" .DB_CHARSET. ";", DB_USERNAME, DB_PASSWORD, $opcoes);  
       } catch (PDOException $e) {  
         print "Erro: " . $e->getMessage();  
       }  
     }  
     return self::$pdo;  
   }  

   public static function logout(){        
    setcookie('login_remember','true',time()-1,'/');
    setcookie('email','true',time()-1,'/');
    setcookie('senha','true',time()-1,'/');
    $_SESSION['logado'] = 'NAO';
    $_SESSION['email'] = '';
    $_SESSION['senha'] = '';
    $_SESSION['id'] = '';
    $_SESSION['nome'] = '';
    $_SESSION['sobrenome'] = ''; 
    $_SESSION['data_criado'] = ''; 
    $_SESSION['cargo'] = '';   
    session_destroy();
    header('Location: '.INCLUDE_PATH.'login');
  }

  public static function check_remember($url){
    if(isset($_COOKIE['login_remember']) && $_COOKIE['login_remember']){       
        $email = $_COOKIE['email'];
        $senha = $_COOKIE['senha'];
        $sql = MySql::connect()->prepare("SELECT * FROM `users_teachers` WHERE email = ? AND senha = ?");
        $sql->execute(array($email,$senha));
        if($sql->rowCount() == 1){
                $info = $sql->fetch();
                $_SESSION['logado'] = 'SIM';
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha;
                $_SESSION['id'] = $info['id'];
                $_SESSION['nome'] = $info['nome'];
                $_SESSION['sobrenome'] = $info['sobrenome']; 
                $_SESSION['data_criado'] = $info['data_criado']; 
                $_SESSION['cargo'] = 'professor';                               
                //header('Location: '.INCLUDE_PATH.$url);                
                //die();
        }
    }else{
      
       
    }
}
 }

