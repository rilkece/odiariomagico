<?php
require_once ('../config.php');

//get POSTs
$room_id  = (isset($_POST['sala'])) ? $_POST['sala'] : '' ;
$teacher_email = (isset($_POST['email'])) ? $_POST['email'] : '' ;


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

$sql = 'SELECT * FROM users_teachers WHERE email = ? and status = ? LIMIT 1';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $teacher_email);
$stm->bindValue(2, 'A');
$stm->execute();
$teacher_info = $stm->fetch(PDO::FETCH_OBJ);

if (!empty($teacher_info)) {
    $retorno = array('codigo' => 1, 'mensagem' => 'Professor encontrado!', 'id' => $teacher_info->id, 'email' => $teacher_info->email, 'nome' => $teacher_info->nome, 'sobrenome' => $teacher_info->sobrenome, 'data_criado' => $teacher_info->data_criado, 'data_ultimo_login' => $teacher_info->data_ultimo_login, 'status' => $teacher_info->status, 'data_nascimento' => $teacher_info->data_nascimento);
	echo json_encode($retorno);
	exit();
} else {
    $retorno = array('codigo' => 0, 'mensagem' => 'Usuário não encontrado!');
	echo json_encode($retorno);
	exit();
}


?>