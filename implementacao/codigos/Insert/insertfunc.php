<?php

    if(!(isset($_POST['cpf-a']) and isset($_POST['name-a']) and isset($_POST['data-a']) and isset($_POST['telefone-a'])
    and isset($_POST['salario-a']) and isset($_POST['contratacao-a']) and isset($_POST['cargo-a']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do funcionário a ser inserido
    $cpf = $_POST['cpf-a'];
    $nome = $_POST['name-a'];
    $nasc = $_POST['data-a'];
    $tel = $_POST['telefone-a'];
    $sal = $_POST['salario-a'];
    $cont = $_POST['contratacao-a'];
    $cargo = $_POST['cargo-a'];

    if(strlen($cpf) != 11){
        echo"<script>alert('O cpf ".$cpf." é inválido')</script>";
        echo '<script>window.location.href = "../Pages/gerente.php"</script>';
        exit;
    }

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir o funcionário
    $sql = "INSERT INTO funcionario (cpf, data_nasc, contratacao, nome, cargo, salario, telefone, ativo) 
    VALUES ('$cpf', '$nasc', '$cont', '$nome', '$cargo', $sal, '$tel', 1)";

    if (!($conn->query($sql))) {
        echo "Erro ao inserir funcionário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente.php"</script>';


?>