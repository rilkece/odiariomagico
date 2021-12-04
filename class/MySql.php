<?php
class MySql{
    private static $pdo;

    public static function connect(){
        if(self::$pdo == null){
            try{
            self::$pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME,DB_USERNAME,DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);            
            }catch(Exception $e){
                echo '<script>alert("Erro ao conectar");</script>';
            }
        }

        return self::$pdo;
    }
}


?>