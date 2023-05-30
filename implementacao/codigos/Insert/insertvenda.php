<?php

    if(!(isset($_POST['cliente-a']) and isset($_POST['vendedor-a']) and isset($_POST['data-a']) 
    and isset($_POST['veiculo-a']) and isset($_POST['preco-a']) and isset($_POST['estado-a']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do funcionário a ser inserido
    $cliente = $_POST['cliente-a'];
    $vendedor = $_POST['vendedor-a'];
    $veiculo = $_POST['veiculo-a'];
    $data = $_POST['data-a'];
    $preco= $_POST['preco-a'];
    $estado = $_POST['estado-a'];

    if($preco < 0){
        echo"<script>alert('O preço ".$preco." é inválido. Deve ser maior que 0')</script>";

        if (isset($_COOKIE['vendedor'])) {
            echo '<script>window.location.href = "../Pages/vendedor_vendas.php"</script>';
        } else if(isset($_COOKIE['gerente'])){
            echo '<script>window.location.href = "../Pages/gerente_vendas.php"</script>';
        }

        exit;
    }
    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir o funcionário
    $sql = "INSERT INTO venda (cliente, vendedor, data_venda, veiculo, preco, estado) 
    VALUES ($cliente, $vendedor, '$data', $veiculo, $preco, '$estado')";

    if (!($conn->query($sql))) {
        echo "Erro ao inserir venda: " . $conn->error;
    }

    if($estado == 'Concluída'){
        $sql = "UPDATE veiculo SET estado = 'Vendido' WHERE placa = $veiculo";

        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $sql = "SELECT marca, modelo FROM veiculo WHERE placa = $veiculo";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $marca = $row['marca'];
        $modelo = $row['modelo'];

        $sql = "UPDATE estoque SET quantidade = quantidade - 1 WHERE marca = $marca, modelo = $modelo";

        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    } else {
        $sql = "UPDATE veiculo SET estado = 'Em processo de Venda' WHERE placa = $veiculo";

        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    if(isset($_COOKIE['gerente'])){
        echo '<script>window.location.href = "../Pages/gerente_vendas.php"</script>';
    } else if(isset($_COOKIE['vendedor'])){
        echo '<script>window.location.href = "../Pages/vendedor_vendas.php"</script>';
    }

?>