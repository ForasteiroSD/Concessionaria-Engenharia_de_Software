<?php

    if(!(isset($_POST['cpf-e']) and isset($_POST['name-e']) and isset($_POST['data-e'])
    and isset($_POST['telefone-e']) and isset($_POST['salario-e']) and isset($_POST['contratacao-e'])
    and isset($_POST['cargo-e']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $cpf = $_POST['cpf-e'];
    $name = $_POST['name-e'];
    $telefone = $_POST['telefone-e'];
    $salario = $_POST['salario-e'];
    $cargo = $_POST['cargo-e'];

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE funcionario SET nome = '$name', telefone = '$telefone', salario = $salario, cargo = '$cargo'
    WHERE cpf = '$cpf'";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    echo '<script>window.location.href = "../Pages/gerente.php"</script>';


?>