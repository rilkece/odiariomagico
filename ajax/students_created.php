<?php
require_once ('../config.php');

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'home'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;


// Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();

// Passo 2 - pegar array de estudantes

$sql = 'SELECT students_created FROM teachers_info WHERE id = ?';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $_SESSION['id']);
$stm->execute();
$std_crt = $stm->fetch(PDO::FETCH_OBJ);
$students_created = unserialize($std_crt->students_created);

$students_info = array();

for ($i=0; $i < count($students_created); $i++) { 
	$sql = 'SELECT * FROM users_students WHERE id = ?';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $students_created[$i]);
	$stm->execute();
	$std_info = $stm->fetch(PDO::FETCH_OBJ);

	$std_array = array('id' => $std_info->id, 'nome' => $std_info->nome, 'sobrenome' => $std_info->sobrenome, 'nascimento' => $std_info->data_nascimento, 'data_criado' => $std_info->data_criado, 'data_ultimo_login' => $std_info->data_ultimo_login, 'senha' => $std_info->senha, 'status' => $std_info->status, 'online' => $std_info->online);
	$students_info[] = $std_array;

}



//$retorno = array('codigo' => 1, 'mensagem' => $students_created[0]);
echo json_encode($students_info);
exit();

?>