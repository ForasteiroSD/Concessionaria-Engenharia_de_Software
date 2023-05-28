<?php

    mysqli_report(MYSQLI_REPORT_OFF);

    if(!(isset($_POST['user']) and isset($_POST['password']))){
        echo '<script>window.location.href = "../login.html"</script>';
    }

    $user = $_POST['user'];
    $passwordform = $_POST['password'];
    

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($servername, $username, $password);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    if($selected = mysqli_select_db($conn, $database)){

        $table = 'funcionario';
        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        $tableExists = $result && $result->num_rows > 0;

        if(!$tableExists){

            $sql = "CREATE TABLE funcionario(
                cpf BIGINT UNSIGNED NOT NULL,
                data_nasc date NOT NULL,
                contratacao date NOT NULL,
                nome varchar(100) NOT NULL,
                cargo varchar(20) NOT NULL,
                salario float NOT NULL,
                telefone varchar(25),
                ativo BOOLEAN NOT NULL,
                PRIMARY KEY (cpf)
                ) COLLATE=utf8_unicode_ci";
    
            if (!mysqli_query ($conn, $sql)) {
                die("Error creating table: " . mysqli_connect_error());
            }

            $sql = "CREATE TABLE usuario(
                cpf BIGINT UNSIGNED NOT NULL,
                user varchar(20) NOT NULL,
                senha varchar(20) NOT NULL,
                tipo varchar(15) NOT NULL,
                PRIMARY KEY (cpf)
                ) COLLATE=utf8_unicode_ci";
    
            if (!mysqli_query ($conn, $sql)) {
                die("Error creating table: " . mysqli_connect_error());
            }

            $sql = "CREATE TABLE cliente(
                nome varchar(100) NOT NULL,
                cpf BIGINT UNSIGNED NOT NULL,
                data_nasc date NOT NULL,
                telefone varchar(25),
                email varchar(100),
                ativo BOOLEAN NOT NULL,
                PRIMARY KEY (cpf)
                ) COLLATE=utf8_unicode_ci";
    
            if (!mysqli_query ($conn, $sql)) {
                die("Error creating table: " . mysqli_connect_error());
            }

            $sql = "CREATE TABLE estoque(
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                marca varchar(100) NOT NULL,
                modelo varchar(100) NOT NULL,
                preco INT NOT NULL,
                tipo varchar(20) NOT NULL,
                quantidade INT NOT NULL,
                PRIMARY KEY (id)
                ) COLLATE=utf8_unicode_ci";
    
            if (!mysqli_query ($conn, $sql)) {
                die("Error creating table: " . mysqli_connect_error());
            }

            $stmt = $conn->prepare("INSERT INTO usuario (cpf, user, senha, tipo)
            VALUES (1, '$user', '$passwordform', 'Administrador')");
            
            if(!$stmt->execute()){
                die("Error inserting into table: " . mysqli_connect_error());
            }

            mysqli_close($conn);
            setcookie('adm', 'cookie adm', time()+3600, '/');
            echo '<script>window.location.href = "../Pages/adm.php"</script>';
            exit;
            

        } else {

            $sql = "SELECT user, senha, tipo FROM usuario WHERE user = '$user' AND senha = '$passwordform'";

            $result = $conn->query($sql);

            if($result->num_rows > 0){

                $row = $result->fetch_assoc();

                if ($row['tipo'] == 'Administrador') {
                    mysqli_close($conn);
                    setcookie('adm', 'cookie adm', time()+3600, '/');
                    echo '<script>window.location.href = "../Pages/adm.php"</script>';
                    exit;
                } 
                
                else if ($row['tipo'] == 'Gerente') {
                    mysqli_close($conn);
                    setcookie('gerente', 'cookie gerente', time()+3600, '/');
                    echo '<script>window.location.href = "../Pages/gerente.php"</script>';
                    exit;
                }

                else if ($row['tipo'] == 'Secretário') {
                    mysqli_close($conn);
                    setcookie('secretario', 'cookie secretario', time()+3600, '/');
                    echo '<script>window.location.href = "../Pages/secretario.php"</script>';
                    exit;
                }

                else if ($row['tipo'] == 'Vendedor') {
                    mysqli_close($conn);
                    setcookie('vendedor', 'cookie vendedor', time()+3600, '/');
                    echo '<script>window.location.href = "../Pages/vendedor.php"</script>';
                    exit;
                }
                
            } else{
                mysqli_close($conn);
                echo '<script>alert("Usuário e senha inválida")</script>';
                echo '<script>window.location.href = "../login.html"</script>';
            }


        }
        

    } else {
        $sql = 'CREATE DATABASE concessionaria';
        if (!mysqli_query($conn, $sql)) {
            echo 'Error creating database: ' . mysql_error() . "\n";
        }

        mysqli_close($conn);
        echo '<script> location.reload(); </script>';
    }


    ?>