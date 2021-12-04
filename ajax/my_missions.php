<?php
require_once ('../config.php');

// Recebe os dados do formulário
$author = (isset($_POST['author'])) ? $_POST['author'] : '' ;

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'mission'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;

// Passo 1.1 Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();


// Passo 2 - Seleciona as missões do professor e cria uma array com os dados de cada uma
$sql = 'SELECT missions_created
FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $author);
$stm->execute();
$stc = $stm->fetch(PDO::FETCH_OBJ);


$teacher_missions = unserialize($stc->missions_created);
$retorno = array();


if (!empty($teacher_missions)) { 

    foreach ($teacher_missions as $value) {
        $sql = 'SELECT *
        FROM missions WHERE id = ? AND status = ?';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(1, $value);
        $stm->bindValue(2, 'A');
        $stm->execute();
        $stc = $stm->fetch(PDO::FETCH_OBJ);

        $retorno[$value] = (array) $stc;        
    }
    $retorno[] = array('codigo' => 1, 'mensagem' => 'O professor possui  missões.');
    echo json_encode($retorno);
    exit();
}else{
    $retorno = array('codigo' => 0, 'mensagem' => 'O professor não possui missões.');
    echo json_encode($retorno);
    exit();
}

?>