<?php

    if(!(isset($_POST["placa-r"]))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $placa = $_POST['placa-r'];

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

    $sql = "SELECT marca, modelo FROM veiculo WHERE placa = '$placa'";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    $marca = $row['marca'];
    $modelo = $row['modelo'];

    $sql = "UPDATE estoque SET quantidade = quantidade - 1 WHERE marca = '$marca' AND modelo = '$modelo'";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $sql = "DELETE FROM veiculo WHERE placa = '$placa'";

    if (!($conn->query($sql))) {
        echo "Erro ao remover veiculo: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente_veiculos.php"</script>';
?>