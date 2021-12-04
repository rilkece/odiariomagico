<?php

class Classroom{

     private static $connect;


     public static function  getClassroom($id){
        $connect = Conexao::connect();
     
            $sql = "SELECT  *  FROM rooms WHERE id = ?";

      
        $stm = $connect->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->execute();
        $classroom = $stm->fetch(PDO::FETCH_OBJ);

        if (empty($classroom)) {  
            return false;           
          
        }else{
            return $classroom;
        }    
       
     }

}

?>