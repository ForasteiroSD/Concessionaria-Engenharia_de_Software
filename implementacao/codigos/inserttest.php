<?php

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

    $i = 0;
    // Preparar e executar a consulta SQL para inserir o usuário
    for($i = 5; $i<20; $i++){
        $sql = "INSERT INTO usuario (cpf, user, senha, tipo) VALUES (".$i.", 'abc', '123', 'gerente')";

        if ($conn->query($sql) === TRUE) {
            // echo '<script>window.location.href = "adm.php"</script>';
        } else {
            echo "Erro ao inserir usuário: " . $conn->error;
        }
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

?>