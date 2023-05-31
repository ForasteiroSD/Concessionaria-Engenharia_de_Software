<?php

    if(!(isset($_POST['data-i']) and isset($_POST['data-f'])
    and isset($_POST['vendedor']))){
        echo '<script>window.location.href = "../login.html"</script>';
        exit;
    }

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

    $data_i = $_POST['data-i'];
    $data_f = $_POST['data-f'];

    
    $vendedor = '= "'.$_POST['vendedor'].'"';
    if($vendedor == '= "todos"'){
        $vendedor = 'IN (SELECT vendedor FROM venda)';
    }

    $sql = "SELECT vendedor, preco FROM venda WHERE vendedor $vendedor AND estado = 'Concluída' AND data_venda >= '$data_i' AND data_venda <= '$data_f'";

    $result = $conn->query($sql);

    $vendedores = array();
    $totais = array();
    $qVendida = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $pos = array_search($row['vendedor'], $vendedores);
        if($pos !== false) {
            $qVendida[$pos]++;
            $totais[$pos] += $row['preco'];
        } else {
            $vendedores[$i] = $row['vendedor'];
            $qVendida[$i] = 1;
            $totais[$i] = $row['preco'];
            $i++;
        }
    }

    $sql = "SELECT nome, cpf FROM funcionario WHERE cargo = 'Vendedor' AND ativo = 1";

    $result = $conn->query($sql);

    $vendedoresNome = array();

    $i = 0;
    while($row = $result->fetch_assoc()){
        $pos = array_search($row['cpf'], $vendedores);
        if($pos !== false) {
            $nome = explode(" ", $row['nome']);
            $vendedoresNome[$pos] = $nome[0];
        }
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Fita | Gerente</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../Style/main.css'>
    <script src="../Services/logout.js"></script>
</head>
<body>

        <header>
            
            <div id='image'><img src="../../imgs/fita_logo.png" alt="Logo"></div>
            <h2>Relatório de Vendedores</h2>
            <?php
                $timezone = new DateTimeZone('America/Sao_Paulo');
                $agora = new DateTime('now', $timezone);
                echo '<div id="date">
                        <h3>' . $agora->format("d/m") . ' | ' . $agora->format("H:i") . '</h3>
                        <img src="../../imgs/logout_button.png" alt="Logo" onclick="logout()">
                      </div>'
            ?>

        </header>

        <hr>

        <div class='options'>
            <div id='menu'>
                <a href="../Pages/gerente.php"><h3>Funcionários</h3></a>
                <a href="../Pages/gerente_clientes.php"><h3>Clientes</h3></a>
                <a href="../Pages/gerente_veiculos.php"><h3>Veículos</h3></a>
                <a href="../Pages/gerente_vendas.php"><h3>Vendas</h3></a>
                <a href="../Pages/gerente_estoque.php"><h3>Estoque</h3></a>
                <div id='selected'>
                    <a href="../Pages/gerente_relatorios.php"><h3>Relatórios</h3></a>
                </div>
            </div>
        </div>


        <div class='consulta'>
            <div id="retornos">

                <div class="atrib_rel">
                    <h3>Vendedor</h3>
                    <div class='dados'>
                        <?php
                            foreach ($vendedores as $key => $vendedor) {
                                echo "
                                    <p>". $vendedoresNome[$key] ." - $vendedor</p>
                                <hr><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="atrib_rel">
                    <h3>Nº Veículos Vendidos</h3>
                    <div class='dados'>
                        <?php
                            foreach ($vendedores as $key => $vendedor) {
                                echo "
                                    <p>$qVendida[$key]</p>
                                <hr><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="atrib_rel">
                    <h3>Valor Total Vendido</h3>
                    <div class='dados'>
                        <?php
                            foreach ($vendedores as $key => $vendedor) {
                                echo "
                                    <p>R$ $totais[$key]</p>
                                <hr><br>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

</body>
</html>