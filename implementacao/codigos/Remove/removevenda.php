<?php

    if(!(isset($_POST["venda-r"]) and isset($_POST['placas-r']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $id = $_POST['venda-r'];
    $placa = $_POST['placas-r'];

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

    $sql = "DELETE FROM venda WHERE id = $id";

    if (!($conn->query($sql))) {
        echo "Erro ao remover venda: " . $conn->error;
    }

    $sql = "UPDATE veiculo SET estado = 'Disponível' WHERE placa = $placa";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    if(isset($_COOKIE['gerente'])){
        echo '<script>window.location.href = "../Pages/gerente_vendas.php"</script>';
    } else if(isset($_COOKIE['vendedor'])){
        echo '<script>window.location.href = "../Pages/vendedor_vendas.php"</script>';
    }
?>