<?php

    if(!(isset($_POST["cpf-r"]))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do usuário a ser removido
    $cpf = $_POST["cpf-r"];

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "SELECT tipo FROM usuario WHERE cpf = $cpf";
    $result = $conn->query($sql);
    $tipo = $result->fetch_assoc();

    if($tipo['tipo'] == "Administrador"){
        $sql = "SELECT count(tipo) AS quant FROM usuario WHERE tipo = 'Administrador'";
        $result = $conn->query($sql);
        $tipo = $result->fetch_assoc();

        if($tipo['quant'] <= 1){
            echo '<script>alert("Você não pode deixar o sistema sem um administrador")</script>';
            $conn->close();
            echo '<script>window.location.href = "../Pages/adm.php"</script>';
            exit;
        }
    }

    // Preparar e executar a consulta SQL para inserir o usuário
    $sql = "DELETE FROM usuario WHERE cpf = $cpf";

    if (!($conn->query($sql))) {
        echo "Erro ao remover usuário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/adm.php"</script>';

?>