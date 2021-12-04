<?php
require_once ('../config.php');

//get POSTs
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$room_id):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.5 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 2 - Verifica os estudantes e retorna seus nomes
$sql = 'SELECT students FROM rooms WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $room_id);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);

$students_in_room = unserialize($stc->students);

if (!empty($students_in_room)){ 
    $retorno = array();   
    foreach ($students_in_room as $value) {  
        $sql = 'SELECT nome, sobrenome FROM users_students WHERE id = ?';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(1, $value);
        $stm->execute();
        $stc = $stm->fetch(PDO::FETCH_OBJ);

        $student_name = $stc->nome.' '.$stc->sobrenome;

        $retorno[$value] = $student_name;
    }
    echo json_encode($retorno);
    exit();
}else{
    $retorno = array('codigo' => 0, 'mensagem' => 'A sala não possui estudantes.');
    echo json_encode($retorno);
    exit();
}

?>