<?php

    if(!(isset($_POST['id-e']) and isset($_POST['marca-e']) and isset($_POST['modelo-e']) and isset($_POST['tipo-e'])
    and isset($_POST['preco-e']) and isset($_POST['quant-e']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $id = $_POST['id-e'];
    $preco = $_POST['preco-e'];

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE estoque SET preco = $preco WHERE id = $id";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    echo '<script>window.location.href = "../Pages/gerente_estoque.php"</script>';

?>