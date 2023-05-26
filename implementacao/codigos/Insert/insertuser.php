<?php

    if(!(isset($_POST['cpf']) and isset($_POST['user']) and isset($_POST['senha']) and isset($_POST['tipo']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

    //Variáveis para conexão com BD
    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    // Dados do usuário a ser inserido
    $cpf = $_POST['cpf'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    //Verificação básica de cpf
    if($cpf < 10000000000){
        echo"<script>alert('O cpf ".$cpf." é inválido')</script>";
        echo '<script>window.location.href = "../Pages/adm.php"</script>';
        exit;
    }

    //Verifica se tamanho do campo user é valido
    if(strlen($user) < 8){
        echo"<script>alert('O user deve ter pelo menos 8 caracteres')</script>";
        echo '<script>window.location.href = "../Pages/adm.php"</script>';
        exit;
    }

    //Verifica se tamanho do campo user é valido
    if(strlen($senha) < 10){
        echo"<script>alert('A senha deve ter pelo menos 10 caracteres')</script>";
        echo '<script>window.location.href = "../Pages/adm.php"</script>';
        exit;
    }

    //Transforma tipo retornado pelo formulário em tipo correto
    if($tipo == 'adm'){
        $tipo = 'Administrador';
    }


    //Verifica se senha é valida para o sistema
    $carSenha = count_chars($senha,3);
    $number = FALSE;
    $minuscula = FALSE;
    $maiuscula = FALSE;

    if(!(str_contains($carSenha, '@') or str_contains($carSenha, '#') or str_contains($carSenha, '$') 
    or str_contains($carSenha, '%') or str_contains($carSenha, '&') or str_contains($carSenha, '*') 
    or str_contains($carSenha, '(') or str_contains($carSenha, ')') or str_contains($carSenha, '-')
    or str_contains($carSenha, '+') or str_contains($carSenha, '=')or str_contains($carSenha, '?'))){
        echo"<script>alert('A senha deve ter um símbolo especial')</script>";
        echo '<script>window.location.href = "../Pages/adm.php"</script>';
        exit;
    }

    for ($i=0; $i < strlen($carSenha); $i++) {
        
        if(is_numeric($carSenha[$i])){
            $number = TRUE;
        } else if(ctype_alpha($carSenha[$i])){
            if(strtoupper($carSenha[$i]) == $carSenha[$i]) {
                $maiuscula = TRUE;
            } else {
                $minuscula = TRUE;
            }
        }
    }

    if(!($number and $maiuscula and $minuscula)){
        echo"<script>alert('A senha não tem os tipos necessários de caracteres')</script>";
        echo '<script>window.location.href = "../Pages/adm.php"</script>';
        exit;
    }

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se já existe usuário com mesmo user
    $sql = "SELECT COUNT(cpf) AS quant FROM usuario WHERE user = '$user'";
    $result = $conn->query($sql);
    $total = $result->fetch_assoc();

    if ($total['quant']>0) {
        echo "<script>alert('Já existe um usuário com mesmo nome.')</script>";
    } else {

        // Preparar e executar a consulta SQL para inserir o usuário
        $sql = "INSERT INTO usuario (cpf, user, senha, tipo) VALUES ($cpf, '$user', '$senha', '$tipo')";

        if (!($conn->query($sql))) {
            echo "Erro ao inserir usuário: " . $conn->error;
        }

    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    echo '<script>window.location.href = "../Pages/adm.php"</script>';

?>