<?php

    mysqli_report(MYSQLI_REPORT_OFF);

    if(!(isset($_POST['user']) and isset($_POST['password']))){
        echo '<script>window.location.href = "login.html"</script>';
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

        $table = 'funcionarios';
        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        $tableExists = $result && $result->num_rows > 0;

        if(!$tableExists){

            $sql = "CREATE TABLE funcionarios(
                cpf INT UNSIGNED NOT NULL,
                data_nasc date NOT NULL,
                contratacao date NOT NULL,
                nome varchar(100) NOT NULL,
                cargo varchar(20) NOT NULL,
                salario float NOT NULL,
                PRIMARY KEY (cpf)
                ) COLLATE=utf8_unicode_ci";
    
            if (!mysqli_query ($conn, $sql)) {
                die("Error creating table: " . mysqli_connect_error());
            }

            $sql = "CREATE TABLE usuario(
                cpf INT UNSIGNED NOT NULL,
                user varchar(20) NOT NULL,
                senha varchar(20) NOT NULL,
                tipo varchar(15) NOT NULL,
                PRIMARY KEY (cpf)
                ) COLLATE=utf8_unicode_ci";
    
            if (!mysqli_query ($conn, $sql)) {
                die("Error creating table: " . mysqli_connect_error());
            }

            $stmt = $conn->prepare("INSERT INTO usuario (cpf, user, senha, tipo)
            VALUES ('1', '$user', '$passwordform', 'administrador')");
            
            if(!$stmt->execute()){
                die("Error inserting into table: " . mysqli_connect_error());
            }

            mysqli_close($conn);
            setcookie('adm', 'cookie adm', time()+3600);
            echo '<script>window.location.href = "adm.php"</script>';
            

        } else {

            $sql = "SELECT user, senha, tipo FROM usuario WHERE user = '$user' AND senha = '$passwordform'";

            $result = $conn->query($sql);

            if($result->num_rows > 0){

                $row = $result->fetch_assoc();

                if ($row['tipo'] == 'administrador') {
                    mysqli_close($conn);
                    setcookie('adm', 'cookie adm', time()+3600);
                    echo '<script>window.location.href = "adm.php"</script>';
                } 
                
                else if ($row['tipo'] == 'gerente') {
                    mysqli_close($conn);
                    setcookie('gerente', 'cookie gerente', time()+3600);
                    echo '<script>window.location.href = "gerente.php"</script>';
                }
            } else{
                mysqli_close($conn);
                echo '<script>alert("Usuário e senha inválida")</script>';
                echo '<script>window.location.href = "login.html"</script>';
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