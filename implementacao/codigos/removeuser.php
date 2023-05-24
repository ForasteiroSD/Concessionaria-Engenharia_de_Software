<?php

    if(!(isset($_POST["cpf-r"]))){
        echo '<script>window.location.href = "login.html"</script>';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do usuário a ser inserido
    $cpf = $_POST["cpf-r"];

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir o usuário
    $sql = "DELETE FROM usuario WHERE cpf = $cpf";

    if ($conn->query($sql) === TRUE) {
        echo '<script>window.location.href = "adm.php"</script>';
    } else {
        echo "Erro ao remover usuário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

?>