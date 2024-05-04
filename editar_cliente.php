<?php

include('conexao.php');
$id = intval($_GET['id']);
// $id = intval($_GET['id']);
// $sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
// $query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
// $cliente = $query_cliente->fetch_assoc();



function limpar_texto($str){
 return preg_replace("/[^0-9]/","",$str);
 }

// $erro = false;

if(count($_POST) > 0){

  
    $erro = false;
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $nascimento = $_POST["nascimento"];

    if(empty($nome)){
        $erro = "Preencha o nome";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Preencha o e-mail";
    }

    if(!empty($nascimento)){
        $pedacos = explode('/', $nascimento);
        if(count($pedacos) == 3) {
            $nascimento = implode ('-', array_reverse($pedacos));
        }else{
         $erro = "A data de nascimento deve seguir o padrão dia/mes/ano";
        }
    
    }
     if(!empty($telefone)){
        $telefone = limpar_texto($telefone);
      if(strlen($telefone) != 11)        
     
        $erro = "O telefone deve seguir o padrão (21)0000-0000 "; 
      } 
       
   

    if($erro){
        echo "<p><b>ERRO:$erro</b></p>";
    }else{
     $sql_code = "UPDATE clientes
     SET nome = '$nome',
     email = '$email',
     telefone = '$telefone',
     nascimento = '$nascimento' 
     WHERE id = '$id' ";   
     
    //   clientes (nome, email, telefone, nascimento, data)
    //   VALUES('$nome','$email','$telefone','$nascimento', NOW())"; 
     $deu_certo = $mysqli->query($sql_code) or die($mysqli->error); 
     if($deu_certo){
        echo "<p><b>Cliente atualizado com sucesso !!!</b></p>";
         unset($_POST);
     }

    }
}
// $id = intval($_GET['id']);
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editar_cliente</title>
</head>

<body>
    <a href="/projetos/editar_clientes.php?id"></a>

    <a href="/projetos/cadastrar_cliente.php">Cadastrar cliente</a>
    <form method="POST" action="">
        <p>
            <label>Nome:</label>
            <input value="<?php echo $cliente['nome']; ?>" name="nome" type="text">
        </p>

        <p>
            <label>E-mail:</label>
            <input value="<?php echo $cliente['email']; ?>" name="email" type="text">
        </p>

        <p>
            <label>Telefone:</label>
            <input value="<?php if(!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>"
                placeholder="(21)0000-0000" name="telefone" type="text">
        </p>

        <p>
            <label>Data de Nascimento:</label>
            <input value="<?php if(!empty($cliente['nascimento'])) echo formatar_data($cliente['nascimento']); ?>"
                name="nascimento" type="text">
        </p>

        <button type="submit">Salvar Cliente</button>

    </form>

</body>

</html>