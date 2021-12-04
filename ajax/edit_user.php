<?php

// Instancia Conexão PDO
require_once ('../config.php');
require_once ('../class/Conexao.php');

$conexao = Conexao::connect();

//setar variáveis
$usuario = User::getUser($_SESSION['id'], $_SESSION['cargo']);
$id = $usuario->id;
$nome = (isset($_POST['novo_nome'])) ? $_POST['novo_nome'] : '' ;
$sobrenome = (isset($_POST['novo_sobrenome'])) ? $_POST['novo_sobrenome'] : '' ;
$birthday = (isset($_POST['nascimento'])) ? $_POST['nascimento'] : '' ;
$check_alterar_senha = (isset($_POST['check_home_alterar_senha'])) ? $_POST['check_home_alterar_senha'] : '' ;
$senha_atual = (isset($_POST['home_senha'])) ? $_POST['home_senha'] : '' ;
$senha_nova = (isset($_POST['nova_senha'])) ? $_POST['nova_senha'] : '' ;
$senha_nova_confirma = (isset($_POST['confirma_nova_senha'])) ? $_POST['confirma_nova_senha'] : '' ;

$nome_mensagem = '';
$sobrenome_mensagem = '';   
$birthday_mensagem = '';
$senha_mensagem = '';



//setar dados usuário logado
$sql = "SELECT id, email, nome, sobrenome, senha, data_criado, data_nascimento  FROM users_teachers WHERE id = ? AND status = ? LIMIT 1";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $id);
$stm->bindValue(2, 'A');
$stm->execute();
$retorno_user = $stm->fetch(PDO::FETCH_OBJ);


if($nome!=''){
    $sql = "UPDATE users_teachers SET nome = ? WHERE id = ?";
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $nome);
    $stm->bindValue(2, $id);
    $stm->execute();
    $retorno = $stm->fetch(PDO::FETCH_OBJ);
    $nome_mensagem = 'Nome alterado com sucesso!';

   
}

if($sobrenome!=''){
    $sql = "UPDATE users_teachers SET sobrenome = ? WHERE id = ?";
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $sobrenome);
    $stm->bindValue(2, $id);
    $stm->execute();
    $retorno = $stm->fetch(PDO::FETCH_OBJ);
    $sobrenome_mensagem = 'Sobrenome alterado com sucesso!';
   
}

if($birthday!=$retorno_user->data_nascimento){
    $sql = "UPDATE users_teachers SET data_nascimento = ? WHERE id = ?";
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $birthday);
    $stm->bindValue(2, $id);
    $stm->execute();
    $retorno = $stm->fetch(PDO::FETCH_OBJ);
    $birthday_mensagem = 'Data de nascimento alterada com sucesso!';
   
}


if($check_alterar_senha=='on'){
    if (!empty($retorno_user)) {
        $hash = password_hash($retorno_user->senha, PASSWORD_DEFAULT);
    }
    if(password_verify($senha_atual, $hash)){
        if($senha_nova_confirma==$senha_nova){
            $sql = "UPDATE users_teachers SET senha = ? WHERE id = ?";
            $stm = $conexao->prepare($sql);
            $stm->bindValue(1, $senha_nova);
            $stm->bindValue(2, $id);
            $stm->execute();
            $retorno = $stm->fetch(PDO::FETCH_OBJ);

            $senha_mensagem = 'Senha alterada com sucesso!';

        }else{
            $senha_mensagem = 'Senha não alterada: novas senhas são diferentes.';
        }
    }else{
        $senha_mensagem = 'Senha não alterada: senha incorreta.'; 
    }

    
   
}

$retorno = array('codigo' => 0, 'mensagem' => 'Nome não alterado', 'nome' => $nome_mensagem, 'sobrenome' => $sobrenome_mensagem, 'birthday' => $birthday_mensagem, 'senha' => $senha_mensagem);
echo json_encode($retorno);
exit();



  






