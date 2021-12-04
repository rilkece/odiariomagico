<?php
require_once ('../config.php');

//get POSTs
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;
$student_id = (isset($_POST['id'])) ? $_POST['id'] : '' ;


// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'room?sala='.$room_id):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada! '.$_SERVER['HTTP_REFERER']);
	echo json_encode($retorno);
	exit();
endif;


// Passo 2 - Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 3 - Pegar email do professor e verificar se ele existe


$sql = 'SELECT * FROM users_students WHERE id = ? and status = ? LIMIT 1';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $student_id);
$stm->bindValue(2, 'A');
$stm->execute();
$student_info = $stm->fetch(PDO::FETCH_OBJ);

if (!empty($student_info)) {
    $retorno = array('codigo' => 1, 'mensagem' => 'Estudante encontrado!', 'id' => $student_info->id, 'nome' => $student_info->nome, 'sobrenome' => $student_info->sobrenome, 'nascimento' => $student_info->data_nascimento, 'data_criado' => $student_info->data_criado, 'data_ultimo_login' => $student_info->data_ultimo_login, 'status' => $student_info->status, 'online' => $student_info->online);
	echo json_encode($retorno);
	exit();
} else {
    $retorno = array('codigo' => 0, 'mensagem' => 'Usuário não encontrado!');
	echo json_encode($retorno);
	exit();
}


?>