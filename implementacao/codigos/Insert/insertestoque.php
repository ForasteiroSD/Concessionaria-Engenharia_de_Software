<?php
     if(!(isset($_POST['marca-a']) and isset($_POST['modelo-a']) and isset($_POST['preco-a']) and isset($_POST['tipo-a']))){
         echo '<script>window.location.href = ""../Pages/gerente_estoque.php"</script>';
         exit;
     }
    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do funcionário a ser inserido
    $marca = $_POST['marca-a'];
    $modelo = $_POST['modelo-a'];
    $preco = $_POST['preco-a'];
    $tipo = $_POST['tipo-a'];

    if($preco < 0){
        echo"<script>alert('O preço ".$preco." é inválido. Deve ser maior que 0')</script>";
        echo '<script>window.location.href = "../Pages/gerente_estoque.php"</script>';
        exit;
    }

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir o funcionário
    $sql = "INSERT INTO estoque (marca, modelo, preco, tipo	,quantidade) 
    VALUES ('$marca' , '$modelo', '$preco', '$tipo', 0)";

    if (!($conn->query($sql))) {
        echo "Erro ao inserir estoque: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/gerente_estoque.php"</script>';


?>
