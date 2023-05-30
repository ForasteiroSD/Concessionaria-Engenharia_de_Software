<?php

    if(!(isset($_POST['cpf-a']) and isset($_POST['name-a']) and isset($_POST['data-a']) and isset($_POST['telefone-a'])
    and isset($_POST['email-a']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do funcionário a ser inserido
    $cpf = $_POST['cpf-a'];
    $nome = $_POST['name-a'];
    $nasc = $_POST['data-a'];
    $tel = $_POST['telefone-a'];
    $email = $_POST['email-a'];

    

    if(strlen($cpf) != 11){
        echo"<script>alert('O cpf ".$cpf." é inválido')</script>";
        if (isset($_COOKIE['secretario'])) {
            echo '<script>window.location.href = "../Pages/secretario.php"</script>';
        } else if(isset($_COOKIE['gerente'])){
            echo '<script>window.location.href = "../Pages/gerente_clientes.php"</script>';
        } else if(isset($_COOKIE['vendedor'])){
            echo '<script>window.location.href = "../Pages/vendedor.php"</script>';
        }
        exit;
    }

    //Verifica idade do cliente
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $agora = new DateTime('now', $timezone);
    $data1 = new DateTime($nasc);
    $intervalo = $data1->diff($agora);
    $idade = (int)($intervalo->format('%Y'));

    if($idade < 18){
        echo"<script>alert('A idade do cliente deve ser no mínimo 18 anos')</script>";
        if (isset($_COOKIE['secretario'])) {
            echo '<script>window.location.href = "../Pages/secretario.php"</script>';
        } else if(isset($_COOKIE['gerente'])){
            echo '<script>window.location.href = "../Pages/gerente_clientes.php"</script>';
        } else if(isset($_COOKIE['vendedor'])){
            echo '<script>window.location.href = "../Pages/vendedor.php"</script>';
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
    $sql = "INSERT INTO cliente (cpf, data_nasc, nome, email, telefone, ativo) 
    VALUES ('$cpf', '$nasc', '$nome', '$email', '$tel', 1)";

    if (!($conn->query($sql))) {
        echo "Erro ao inserir cliente: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    if (isset($_COOKIE['secretario'])) {
        echo '<script>window.location.href = "../Pages/secretario.php"</script>';
    } else if(isset($_COOKIE['gerente'])){
        echo '<script>window.location.href = "../Pages/gerente_clientes.php"</script>';
    } else if(isset($_COOKIE['vendedor'])){
        echo '<script>window.location.href = "../Pages/vendedor.php"</script>';
    }


?>