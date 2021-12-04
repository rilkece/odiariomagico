<?php


require_once ('../config.php');

// Passo 1 - Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != INCLUDE_PATH.'login'):
	$retorno = array('codigo' => 0, 'mensagem' => 'Origem da requisição não autorizada!');
	echo json_encode($retorno);
	exit();
endif;


// Instancia Conexão PDO
require_once ('../class/Conexao.php');
$conexao = Conexao::connect();



// Recebe os dados do formulário
$email = (isset($_POST['email'])) ? $_POST['email'] : '' ;


// Passo 2 - Verifica se o formato do e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
    $retorno = array('codigo' => 0, 'mensagem' => 'Formato de e-mail inválido!');
	echo json_encode($retorno);
	exit();
endif;


// Passo 3 - Procura se o email já existe no banco de dados
$sql = "SELECT  email, nome, senha  FROM users_teachers WHERE email = ? LIMIT 1";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $email);
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);

if(empty($retorno->email)){
    $retorno = array('codigo' => 0, 'mensagem' => 'Esse email não está cadastrado');
	echo json_encode($retorno);
	exit();
}else{
	$back = $retorno;
	$retorno = array('codigo' => 1, 'mensagem' => 'Email enviado.');
	echo json_encode($retorno);
    $recipient = $back->nome;
    $msg = 'Olá, '.$recipient.'<br>Você está recendo esse email pois solicitou sua senha no site odiariomagico.com.br, abaixo está o seu login e senha:<br><br><strong>Login: </strong>'.$email.';<br><strong>Senha: </strong>'.$back->senha.'<br><br>Caso você não tenha solicitado, pode responder esse email pedindo a exclusão da sua conta<br><br>Obrigado pelo apoio, equipe Diário Mágico.';
    $msgAlt = 'Olá, '.$recipient.'Você está recendo esse email pois solicitou sua senha no site odiariomagico.com.br, esses são os seus login e senha:Login:'.$email.' - Senha: '.$back->senha.'. Caso você não tenha solicitado, pode responder esse email pedindo a exclusão da sua conta. Obrigado pelo apoio, equipe Diário Mágico.';
	$emailSenha =  Mymail::sentMail($email, $recipient,'Login O Diario Magico', $msg, $msgAlt);    
	exit();
}



   