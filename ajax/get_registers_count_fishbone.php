<?php
//setar timezone
date_default_timezone_set('America/Fortaleza');

require_once ('../config.php');


// Recebe os dados do formulário
$cargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '' ;
$id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
$type = (isset($_POST['type'])) ? $_POST['type'] : '' ;
$day= (isset($_POST['day'])) ? $_POST['day'] : '' ;
$month= (isset($_POST['month'])) ? $_POST['month'] : '' ;
$year= (isset($_POST['year'])) ? $_POST['year'] : '' ;
$tag= (isset($_POST['tag']))&&$_POST['tag']!='' ? '#'.$_POST['tag'] : '' ;



// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'diary'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 2 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 3 - Verifica se vai ser a função ANO, MÊS ou DIA
$myDate = "year";
$yearNow = date("Y");
$monthNow = date("n");
$dayNow = date("j");

if ($year==$yearNow) {
 if ($month>$monthNow) {
    $retorno = array( 'codigo' => 0);
    echo json_encode($retorno);
    exit();
 } else if ($month==$monthNow && $day > $dayNow){
    $retorno = array( 'codigo' => 0);
    echo json_encode($retorno);
    exit();
 }
 if ($month==$monthNow) {
     $myDate="day";
 } else {
     $myDate="month";
 } 
    
} 

if ($myDate=="year") {
    
}

// Passo 4 - Pesquisa os registros que há no intervalo de tempo  e retorna a quantidade
$retorno = array();
switch ($myDate) {
    case 'year':
       for ($i= $year; $i <= $yearNow; $i++) { 
            $sql = 'SELECT COUNT(*) AS count FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ?';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(1, $type);
            $stm->bindValue(2, "%".$i."%");
            $stm->bindValue(3, "%".$tag."%");
            $stm->execute();
            $register_count = $stm->fetch(PDO::FETCH_OBJ);

            $retorno[$i] = $register_count->count;

       }
        echo json_encode($retorno);
        exit();
       
        break;
    case 'month':
        for ($i= $month; $i <= $monthNow; $i++) { 
            $zero = "";
            if($i<10){
                $zero = 0;
            }
            $sql = 'SELECT COUNT(*) AS count FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ?';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(1, $type);
            $stm->bindValue(2, "%".$yearNow."-".$zero.$i."%");
            $stm->bindValue(3, "%".$tag."%");
            $stm->execute();
            $register_count = $stm->fetch(PDO::FETCH_OBJ);
            switch ($i) {
                case 1:
                    $monthName = "Janeiro";
                    break;
                case 2:
                    $monthName = "Fevereiro";
                    break;
                case 3:
                    $monthName = "Março";
                    break;
                case 4:
                    $monthName = "Abril";
                    break;
                case 5:
                    $monthName = "Maio";
                    break;
                case 6:
                    $monthName = "Junho";
                    break;
                case 7:
                    $monthName = "Julho";
                    break;
                case 8:
                    $monthName = "Agosto";
                    break;
                case 9:
                    $monthName = "Setembro";
                    break;
                case 10:
                    $monthName = "Outubro";
                    break;
                case 11:
                    $monthName = "Novembro";
                    break;
                case 12:
                    $monthName = "Dezembro";
                    break;
                
                default:
                    $monthName = "Mês: ".$i;
                    break;
            }
    
            $retorno[$monthName] = $register_count->count;
    
           }
        echo json_encode($retorno);
        exit();
        break;
    case 'day':
        for ($i= $day; $i <= $dayNow; $i++) { 
            $zero = "";
            if($i<10){
                $zero = 0;
            }
            $monthFormatted = $monthNow;
            if ($monthNow<10) {
                $monthFormatted = "0".$monthNow;
            }
            $sql = 'SELECT COUNT(*) AS count FROM '.$cargo.'_registers_'.$id.' WHERE type = ? AND date_ini LIKE ? AND description LIKE ?';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(1, $type);
            $stm->bindValue(2, "%".$yearNow."-".$monthFormatted."-".$zero.$i."%");
            $stm->bindValue(3, "%".$tag."%");
            $stm->execute();
            $register_count = $stm->fetch(PDO::FETCH_OBJ);
    
            $retorno[$i.'/'.$monthNow] = $register_count->count;
    
           }
        echo json_encode($retorno);
        exit();
        break;
}






?>