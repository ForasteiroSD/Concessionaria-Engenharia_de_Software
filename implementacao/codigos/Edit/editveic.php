<?php

    if(!(isset($_POST['marca-e']) and isset($_POST['modelo-e']) and isset($_POST['ano-e'])
    and isset($_POST['placa-e']) and isset($_POST['quilo-e']) and isset($_POST['estado-e']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $placa = $_POST['placa-e'];
    $quilo = $_POST['quilo-e'];

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE veiculo SET quilometragem = $quilo WHERE placa = '$placa'";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    echo '<script>window.location.href = "../Pages/gerente_veiculos.php"</script>';

?>