<?php

    if(!(isset($_POST['cpf']) and isset($_POST['user']) and isset($_POST['senha']) and isset($_POST['tipo']))){
        echo '<script>window.location.href = "login.php"</script>';
    }

    $cpf = $_POST['cpf'];
    $user = $_POST['user'];
    $passwordform = $_POST['senha'];
    $tipo = $_POST['tipo'];

    if($tipo == 'adm'){
        $tipo = 'administrador';
    }
    

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE usuario SET user = '$user', tipo = '$tipo' WHERE cpf = $cpf";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    echo '<script>window.location.href = "adm.php"</script>';


?>