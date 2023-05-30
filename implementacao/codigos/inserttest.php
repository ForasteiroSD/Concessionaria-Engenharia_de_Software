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
    // for($i = 5; $i<20; $i++){
    //     $sql = "INSERT INTO usuario (cpf, user, senha, tipo) VALUES (".$i.", 'abc', '123', 'gerente')";

    //     if ($conn->query($sql) === TRUE) {
    //         // echo '<script>window.location.href = "adm.php"</script>';
    //     } else {
    //         echo "Erro ao inserir usuário: " . $conn->error;
    //     }
    // }

    // Preparar e executar a consulta SQL para inserir o usuário
    // for($i = 5; $i<20; $i++){
    //     $sql = "INSERT INTO cliente (nome, cpf, data_nasc, telefone, email, ativo) VALUES ('thiago', $i, '2010-05-10', 123, 'aaa', 1)";

    //     if ($conn->query($sql) === TRUE) {
    //         // echo '<script>window.location.href = "adm.php"</script>';
    //     } else {
    //         echo "Erro ao inserir usuário: " . $conn->error;
    //     }
    // }

    // // Preparar e executar a consulta SQL para inserir o usuário
    // for($i = 5; $i<20; $i++){
    //     $sql = "INSERT INTO estoque (marca, modelo, tipo, preco, quantidade) VALUES ('Fiat', 'abc', 'Carro SUV', 1250.05, 0)";

    //     if ($conn->query($sql) === TRUE) {
    //         // echo '<script>window.location.href = "adm.php"</script>';
    //     } else {
    //         echo "Erro ao inserir usuário: " . $conn->error;
    //     }
    // }

    // for($i = 5; $i<20; $i++){
    //     $sql = "INSERT INTO veiculo (marca, modelo, ano, placa, quilometragem, estado)
    //     VALUES ('Fiat', 'abc', 2010, $i, 10, 'Disponível')";

    //     if ($conn->query($sql) === TRUE) {
    //         // echo '<script>window.location.href = "adm.php"</script>';
    //     } else {
    //         echo "Erro ao inserir usuário: " . $conn->error;
    //     }
    // }


    // for($i = 5; $i<20; $i++){
    //     $sql = "INSERT INTO funcionario (nome, cpf, data_nasc, telefone, contratacao, cargo, salario, ativo) VALUES ('thiago', $i, '2010-05-10', '123', '2010-05-11', 'Vendedor', 1000, 1)";

    //     if ($conn->query($sql) === TRUE) {
    //         // echo '<script>window.location.href = "adm.php"</script>';
    //     } else {
    //         echo "Erro ao inserir usuário: " . $conn->error;
    //     }
    // }

    // $sql = "INSERT INTO funcionario (nome, cpf, data_nasc, telefone, contratacao, cargo, salario, ativo) VALUES ('thiago', 1, '2010-05-10', '123', '2010-05-11', 'Secretário', 1000, 1)";

    // if ($conn->query($sql) === TRUE) {
    //     // echo '<script>window.location.href = "adm.php"</script>';
    // } else {
    //     echo "Erro ao inserir usuário: " . $conn->error;
    // }

    // Fechar a conexão com o banco de dados
    $conn->close();

?>