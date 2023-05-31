<?php
    if(isset($_COOKIE['gerente'])){
        setcookie('gerente', 'cookie gerente', time()+3600, '/');
    } else{
        echo '<script>window.location.href = "../login.html";</script>';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $sql = "SELECT marca FROM estoque GROUP BY marca";

    $result = $conn->query($sql);
    $marcas = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $marcas[$i] = $row['marca'];
        $i++;
    }

    $sql = "SELECT nome, cpf FROM funcionario WHERE cargo = 'Vendedor'";

    $result = $conn->query($sql);
    $vendedoresNome = array();
    $vendedoresCPF = array();

    $k = 0;
    while($row = $result->fetch_assoc()){
        $vendedoresNome[$k] = $row['nome'];
        $vendedoresCPF[$k] = $row['cpf'];
        $k++;
    }

    mysqli_close($conn);
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
            <h2>Relatórios</h2>
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
                <a href="gerente.php"><h3>Funcionários</h3></a>
                <a href="gerente_clientes.php"><h3>Clientes</h3></a>
                <a href="gerente_veiculos.php"><h3>Veículos</h3></a>
                <a href="gerente_vendas.php"><h3>Vendas</h3></a>
                <a href="gerente_estoque.php"><h3>Estoque</h3></a>
                <div id='selected'>
                    <a href="gerente_relatorios.php"><h3>Relatórios</h3></a>
                </div>
            </div>
        </div>


       <div class='formsRelatorio'>
            <div class='relatorios'>
                <h3>Relatório de Total Vendido por Marca</h3>
                <form action="../Relatories/marcas.php" class="form_rel" method='post' id='form1'>
                    <div>
                        <label>Data Início:</label>
                        <input type="date" name="data-i" id='dataM1' value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                                required/>
                    </div>
                    <div>
                        <label>Data Final:</label>
                        <input type="date" name="data-f" id='dataM2' value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                                required/>
                    </div>
                    <div>
                        <label>Marca:</label>
                        <select name="marca">
                            <option value="todas">Todas</option>
                            <?php
                                for($j=0; $j < $i; $j++){
                                    echo "<option value='$marcas[$j]'>$marcas[$j]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label>Total Mínimo:</label>
                        <input type="number" name="total" value='0'/>
                    </div>
                    <div>
                        <button type="button" onclick='verificaDataMarca()'>
                            Gerar
                        </button>
                    </div>
                </form>
            </div>

            <div class='relatorios'>
                <h3>Relatório de Desempenho de Vendedores</h3>
                <form action="../Relatories/vendedores.php" class="form_rel n2" method='post' id='form2'>
                    <div>
                        <label>Data Início:</label>
                        <input type="date" name="data-i" id='dataV1' value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                                required/>
                    </div>
                    <div>
                        <label>Data Final:</label>
                        <input type="date" name="data-f" id='dataV2' value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                                required/>
                    </div>
                    <div>
                        <label>Vendedor:</label>
                        <select name="vendedor">
                            <option value="todos">Todos</option>
                            <?php
                                for($j=0; $j < $k; $j++){
                                    echo "<option value='$vendedoresCPF[$j]'>$vendedoresNome[$j] - $vendedoresCPF[$j]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <button type="button" onclick='verificaDataVenda()'>
                            Gerar
                        </button>
                    </div>
                </form>
            </div>
        </div>
     

</body>

<script>
    function verificaDataMarca(){
        var data1 = document.getElementById('dataM1').value
        var data2 = document.getElementById('dataM2').value

        if(data1>data2){
            alert("A data inicial deve ser maior que a data final");
        } else {
            document.getElementById('form1').submit()
        }
    }

    function verificaDataVenda(){
        var data1 = document.getElementById('dataV1').value
        var data2 = document.getElementById('dataV2').value

        if(data1>data2){
            alert("A data inicial deve ser maior que a data final");
        } else {
            document.getElementById('form2').submit()
        }
    }
</script>

</html>

    