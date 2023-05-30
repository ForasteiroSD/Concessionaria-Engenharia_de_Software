<?php

    if(!(isset($_POST['marca']) and isset($_POST['modelo']) and isset($_POST['preco']) and isset($_POST['tipo']) and isset($_POST['quantidade']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do funcionário a ser inserido
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $tipo = $_POST['tipo'];
    $qtd = $_POST['quantidade'];
    $preco= $_POST['preco'];

    if($qtd < 1){
        echo"<script>alert('A quantidade ".$qtd." é inválida. Deve ser maior que 0')</script>";
        echo '<script>window.location.href = "../Pages/gerente.php"</script>';
        exit;
    }

    if($preco < 1){
        echo"<script>alert('O preço ".$preco." é inválido. Deve ser maior que 0')</script>";
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
    $sql = "INSERT INTO estoque (marca, modelo, preco, tipo, quantidade) 
    VALUES ($marca, '$modelo',  '$preco', '$tipo', $qtd')";

    if (!($conn->query($sql))) {
        echo "Erro ao inserir funcionário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente_estoque.php"</script>';


?>