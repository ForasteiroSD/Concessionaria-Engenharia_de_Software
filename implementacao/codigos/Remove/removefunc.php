<?php

    if(!(isset($_POST["cpf-r"]) or isset($_POST["cpf-a"]))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Dados do usuário a ser removido ou reativado
    if(isset($_POST["cpf-r"])){
        $cpf = $_POST["cpf-r"];
        $sql = "UPDATE funcionario SET ativo = 0 WHERE cpf = $cpf";
    } else {
        $cpf = $_POST["cpf-a"];
        $sql = "UPDATE funcionario SET ativo = 1 WHERE cpf = $cpf";
    }

    if (!($conn->query($sql))) {
        echo "Erro ao remover usuário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente.php"</script>';
?>