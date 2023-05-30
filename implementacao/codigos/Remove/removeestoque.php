<?php

    if(!(isset($_POST["id-r"]))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $id = $_POST["id-r"];

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

    $sql = "DELETE FROM estoque WHERE id = $id";

    if (!($conn->query($sql))) {
        echo "Erro ao remover estoque: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente_estoque.php"</script>';

?>