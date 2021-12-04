<?php
require_once ('../config.php');

// Recebe os dados do formulário
$room_id = (isset($_POST['room_id'])) ? $_POST['room_id'] : '' ;

// Passo 1 Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();


// Passo 2 - Seleciona as missões da sala e cria uma array com os dados de cada uma
$sql = 'SELECT missions
FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);


$room_missions = unserialize($stc->missions);
$retorno = array();
if (!empty($room_missions)) {     
    foreach ($room_missions as $value) {

        $sql = 'SELECT *
        FROM missions WHERE id = ? AND status = ?';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(1, $value);
        $stm->bindValue(2, 'A');
        $stm->execute();
        $stc = $stm->fetch(PDO::FETCH_OBJ);

        $retorno[$value] = (array) $stc;        
    }
    $retorno[] = array('codigo' => 1, 'mensagem' => 'A sala possui '.count($room_missions).' missões.');
    echo json_encode($retorno);
    exit();
}else{
    $retorno = array('codigo' => 0, 'mensagem' => 'A sala não possui missões.');
    echo json_encode($retorno);
    exit();
}

?>