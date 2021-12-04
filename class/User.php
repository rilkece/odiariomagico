<?php

class User{

     private static $connect;


     public static function  getUser($id, $userType){
        $connect = Conexao::connect();
      
        if($userType=='professor'){
            $sql = "SELECT  *  FROM teachers_info WHERE id = ? AND cargo = ?";
        }else{
            $sql = "SELECT  *  FROM students_info WHERE id = ? AND cargo = ?";
        }

      
        $stm = $connect->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->bindValue(2, $userType);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_OBJ);

    
        return $user;
         
       
     }
     public static function  getBasic($id, $userType){
        $connect = Conexao::connect();
        
        if($userType=='professor'){
            $sql = "SELECT  *  FROM users_teachers WHERE id = ?";
        }else{
            $sql = "SELECT  *  FROM users_students WHERE id = ?";
        }

        
        $stm = $connect->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->execute();
        $user_basic = $stm->fetch(PDO::FETCH_OBJ);
     
        return $user_basic;
    }

    public static function getTeacher($id){
        $connect = Conexao::connect();
        $sql = "SELECT  *  FROM users_teachers WHERE id = ? AND status = ?";
         
        $stm = $connect->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->bindValue(2, 'A');
        $stm->execute();
        $user_teacher = $stm->fetch(PDO::FETCH_OBJ);

        return $user_teacher;
        
    }

    public static function getStudent($id){
        $connect = Conexao::connect();
        $sql = "SELECT  *  FROM users_students WHERE id = ? AND status = ?";
         
        $stm = $connect->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->bindValue(2, 'A');
        $stm->execute();
        $user_student = $stm->fetch(PDO::FETCH_OBJ);

        return $user_student;
        
    }




}

?>