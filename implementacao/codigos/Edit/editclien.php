<?php

    if(!(isset($_POST['cpf-e']) and isset($_POST['name-e']) and isset($_POST['data-e'])
    and isset($_POST['telefone-e']) and isset($_POST['email-e']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $cpf = $_POST['cpf-e'];
    $name = $_POST['name-e'];
    $telefone = $_POST['telefone-e'];
    $email = $_POST['email-e'];

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE cliente SET nome = '$name', telefone = '$telefone', email = '$email' WHERE cpf = '$cpf'";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    if (isset($_COOKIE['secretario'])) {
        echo '<script>window.location.href = "../Pages/secretario.php"</script>';
    } else if(isset($_COOKIE['gerente'])){
        echo '<script>window.location.href = "../Pages/gerente_clientes.php"</script>';
    } else if(isset($_COOKIE['vendedor'])){
        echo '<script>window.location.href = "../Pages/vendedor.php"</script>';
    }


?>