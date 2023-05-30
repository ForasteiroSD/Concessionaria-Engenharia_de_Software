<?php

    if(!(isset($_POST['marca_modelo-a']) and isset($_POST['ano-a']) and isset($_POST['placa-a'])
    and isset($_POST['quilo-a']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do funcionário a ser inserido
    $marca = explode("-", $_POST['marca_modelo-a']);
    $modelo = $marca[1];
    $marca = $marca[0];
    $ano = $_POST['ano-a'];
    $placa = $_POST['placa-a'];
    $quilo = $_POST['quilo-a'];


    if(strlen($placa) < 7){
        echo"<script>alert('A placa ".$placa." é inválida')</script>";
        echo '<script>window.location.href = "../Pages/gerente_veiculos.php"</script>';
        exit;
    }

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir o funcionário
    $sql = "INSERT INTO veiculo (marca, modelo, ano, placa, quilometragem, estado) 
    VALUES ('$marca', '$modelo', $ano, '$placa', $quilo, 'Disponível')";

    if (!($conn->query($sql))) {
        echo "Erro ao inserir veículo: " . $conn->error;
    }

    $sql = "UPDATE estoque SET quantidade = quantidade + 1 WHERE marca = '$marca' AND modelo = '$modelo'";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente_veiculos.php"</script>';

?>