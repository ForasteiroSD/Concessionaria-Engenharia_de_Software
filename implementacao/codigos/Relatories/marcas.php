<?php

    if(!(isset($_POST['data-i']) and isset($_POST['data-f'])
    and isset($_POST['marca']) and isset($_POST['total']))){
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

    $sql = "SELECT veiculo, preco FROM venda WHERE estado = 'Concluída' AND data_venda >= '$data_i' AND data_venda <= '$data_f'";

    $result = $conn->query($sql);

    $veiculos = array();
    $precos = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $veiculos[$i] = $row['veiculo'];
        $precos[$i] = $row['preco'];
        $i++;
    }

    $marca = '= "'.$_POST['marca'].'"';
    $total = array();
    $marcas = array();

    if($marca == '= "todas"'){
        $marca = 'IN (SELECT marca FROM veiculo)';
    }

    $sql = "SELECT marca, placa FROM veiculo WHERE marca $marca";
    $result = $conn->query($sql);
    
    $i = 0;
    while($row = $result->fetch_assoc()){
        $marca = $row['marca'];
        $pos = array_search($row['placa'], $veiculos);
        if($pos !== false) {
            $marca = array_search($row['marca'], $marcas);
            if($marca !== false) {
                $total[$marca] = $total[$marca] + $precos[$pos];
            } else {
                $marcas[$i] = $row['marca'];
                $total[$i] = $precos[$pos];
                $i++;
            }
        }
    }

    $minimo = $_POST['total'];

    $somatorio = 0;
    
    foreach ($total as $key => $valor) {
        if($valor < $minimo){
            $total[$key] = -1;
        } else {
            $somatorio = $somatorio + $valor;
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
            <h2>Relatório de Marcas</h2>
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
                    <h3>Marca</h3>
                    <div class='dados'>
                        <?php
                            foreach ($marcas as $key => $marca) {
                                if($total[$key] != -1){
                                    echo "
                                        <p>". $key+1 ." - $marca</p>
                                    <hr><br>";
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="atrib_rel">
                    <h3>Total</h3>
                    <div class='dados'>
                        <?php
                            foreach ($marcas as $key => $marca) {
                                if($total[$key] != -1){
                                    echo "
                                        <p>R$ $total[$key]</p>
                                    <hr><br>";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php
                echo "<div id='somatorio'>
                        <p>Somatório: R$ $somatorio</p>
                </div>";
            ?>
        </div>

</body>
</html>