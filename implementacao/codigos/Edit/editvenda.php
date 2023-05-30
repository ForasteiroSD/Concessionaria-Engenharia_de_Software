<?php

    if(!(isset($_POST['id-e']) and isset($_POST['cliente-e']) and isset($_POST['vendedor-e']) and isset($_POST['data-e'])
    and isset($_POST['veiculo-e']) and isset($_POST['preco-e']) and isset($_POST['estado-e']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $id = $_POST['id-e'];
    $veiculo = $_POST['veiculo-e'];

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE venda SET estado = 'Concluída' WHERE id = $id";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

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

    mysqli_close($conn);

    if (isset($_COOKIE['vendedor'])) {
        echo '<script>window.location.href = "../Pages/vendedor_vendas.php"</script>';
    } else if(isset($_COOKIE['gerente'])){
        echo '<script>window.location.href = "../Pages/gerente_vendas.php"</script>';
    }

?>