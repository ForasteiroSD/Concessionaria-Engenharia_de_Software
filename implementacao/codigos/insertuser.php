<?php

    if(!(isset($_POST['cpf']) and isset($_POST['user']) and isset($_POST['senha']) and isset($_POST['tipo']))){
        echo '<script>window.location.href = "login.html"</script>';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do usuário a ser inserido
    $cpf = $_POST['cpf'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    if($tipo == 'adm'){
        $tipo = 'administrador';
    }

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir o usuário
    $sql = "INSERT INTO usuario (cpf, user, senha, tipo) VALUES ($cpf, '$user', '$senha', '$tipo')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>window.location.href = "adm.php"</script>';
    } else {
        echo "Erro ao inserir usuário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

?>