    
<?php
    if(isset($_COOKIE['secretario'])){
        setcookie('secretario', 'cookie secretario', time()+3600, '/');
    } else{
        echo '<script>window.location.href = "../login.html";</script>';
    }

    if(isset($_POST['cliente-c'])) $cliente = '= "' . $_POST["cliente-c"] . '"';
    else $cliente = 'IN (SELECT cliente FROM venda)';

    if($cliente == '= ""' or $cliente == '= "todos"'){
        $cliente = 'IN (SELECT cliente FROM venda)';
    }

    if(isset($_POST['vendedor-c'])) $vendedor = '= "' . $_POST["vendedor-c"] . '"';
    else $vendedor = 'IN (SELECT vendedor FROM venda)';

    if($vendedor == '= ""' or $vendedor == '= "todos"'){
        $vendedor = 'IN (SELECT vendedor FROM venda)';
    }

    if(isset($_POST['veiculo-c'])) $veiculo = '= "' . $_POST["veiculo-c"] . '"';
    else $veiculo = 'IN (SELECT veiculo FROM venda)';

    if($veiculo == '= ""' or $veiculo == '= "todos"'){
        $veiculo = 'IN (SELECT veiculo FROM venda)';
    }

    if(isset($_POST['estado-c'])) $estado = 'AND estado = "' . $_POST["estado-c"] . '"';
    else $estado = 'AND estado = "Em andamento"';

    if($estado == 'AND estado = ""'){
        $estado = 'AND estado = "Em andamento"';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM venda WHERE cliente $cliente AND vendedor $vendedor AND veiculo $veiculo $estado";

    $result = $conn->query($sql);

    $ids = array();
    $clientes = array();
    $vendedores = array();
    $placas = array();
    $estados = array();
    $precos = array();
    $datas = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $ids[$i] = $row['id'];
        $clientes[$i] = $row['cliente'];
        $vendedores[$i] = $row['vendedor'];
        $placas[$i] = $row['veiculo'];
        $estados[$i] = $row['estado'];
        $precos[$i] = $row['preco'];
        $datas[$i] = $row['data_venda'];
        $i++;
    }

    echo "<script>
    let ids = []
    let datas = []
    let precos = []
    let estados = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        ids.push(".$ids[$j].");
        precos.push('".$precos[$j]."');
        datas.push('".$datas[$j]."');
        estados.push('".$estados[$j]."');
        </script>";
    }

    $sql = "SELECT nome, cpf FROM cliente WHERE ativo = 1 ORDER BY nome";

    $result = $conn->query($sql);

    $clienteNome = array();
    $clienteCPF = array();

    $qClientes = 0;
    while($row = $result->fetch_assoc()){
        $clienteNome[$qClientes] = $row['nome'];
        $clienteCPF[$qClientes] = $row['cpf'];
        $qClientes++;
    }

    $sql = "SELECT nome, cpf FROM funcionario WHERE cargo = 'Vendedor' and ativo = 1 ORDER BY nome";

    $result = $conn->query($sql);

    $vendedorNome = array();
    $vendedorCPF = array();

    $qVendedores = 0;
    while($row = $result->fetch_assoc()){
        $vendedorNome[$qVendedores] = $row['nome'];
        $vendedorCPF[$qVendedores] = $row['cpf'];
        $qVendedores++;
    }

    $sql = "SELECT placa FROM veiculo";

    $result = $conn->query($sql);

    $veiculoPlaca = array();

    $qVeiculos = 0;
    while($row = $result->fetch_assoc()){
        $veiculoPlaca[$qVeiculos] = $row['placa'];
        $qVeiculos++;
    }

    mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Fita | Secretário</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../Style/main.css'>
    <script src="../Services/logout.js"></script>
</head>
<body>

        <header>
            
            <div id='image'><img src="../../imgs/fita_logo.png" alt="Logo"></div>
            <h2>Vendas</h2>
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
                <a href="secretario.php"><h3>Clientes</h3></a>
                <a href="secretario_veiculos.php"><h3>Veículos</h3></a>
                <div id='selected'>
                    <a href="secretario_vendas.php"></a><h3>Vendas</h3></a>
                </div>
                <a href="secretario_estoque.php"><h3>Estoque</h3></a>
            </div>
        </div>


        <div class='consulta'>
            <form class='campos' method='post'>
                <div>
                    <label>Cliente:</label>
                    <select name="cliente-c">
                        <option value="todos">Todos</option>
                        <?php
                            for($j = 0; $j<$qClientes; $j++){
                                echo "<option value='$clienteCPF[$j]'>$clienteNome[$j]-$clienteCPF[$j]</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Vendedor:</label>
                    <select name="vendedor-c">
                        <option value="todos">Todos</option>
                        <?php
                            for($j = 0; $j<$qVendedores; $j++){
                                echo "<option value='$vendedorCPF[$j]'>$vendedorNome[$j]-$vendedorCPF[$j]</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Veículo:</label>
                    <select name="veiculo-c">
                        <option value="todos">Todos</option>
                        <?php
                            for($j = 0; $j<$qVeiculos; $j++){
                                echo "<option value='$veiculoPlaca[$j]'>$veiculoPlaca[$j]</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Estado:</label>
                    <select name="estado-c" id="cargo">
                        <option value="Em andamento">Em andamento</option>
                        <option value="Concluída">Concluída</option>
                    </select>
                </div>
                <div>
                    <button type="submit">
                        Filtrar
                    </button>
                </div>
            </form>
            <hr>

            <div class="atrib_ret">

                <div class="column">
                    <h3>Cliente</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='cliente-". $j . "'>". $clientes[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Vendedor</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='vendedor-". $j . "'>". $vendedores[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Placa</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='placa-". $j . "'>". $placas[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Ação</h3>
                    <div class='dados'>
                    <?php
                            for ($j=0; $j < $i; $j++) {
                                echo '<img class="icons" id="data-'. $j . '" src="../../imgs/edit_button.png" alt="Editar" onclick="editForm('. $j . ')"><br>';
                            }
                        ?>
                    </div>
                </div>

            </div>

        </div>


        <div class="back" id="back-1"></div>
        <div class="screen" id="screen-1">
            <div class="add_new" id="edit">
                <form action="" class="form_new" method='post'>
                    <h2>Vendas</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Visualizar Vendas" onclick="closeEditForm()">
                    <div>
                        <label>Cliente:</label>
                        <input type="text" name="cliente-e" readonly id='cliente'/>
                    </div>
                    <div>
                        <label>Vendedor:</label>
                        <input type="text" name="vendedor-e" readonly id='vendedor'/>
                    </div>
                    <div>
                        <label>Data:</label>
                        <input type="date" name="data-e" readonly id='data'/>
                    </div>
                    <div>
                        <label>Veículo:</label>
                        <input type="text" name="veiculo-e" id='veiculo' readonly/>
                    </div>
                    <div>
                        <label>Preço:</label>
                        <input type="number" name="preco-e" id='preco' readonly/>
                    </div>
                    <div>
                        <label>Estado:</label>
                        <select name="estado-e" id="estado">
                            <option value="Concluída">Concluída</option>
                            <option value="Em andamento">Em andamento</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
     

</body>
<script>

    function closeEditForm(){
        document.getElementById("back-1").style.display = "none"
        document.getElementById("screen-1").style.visibility = "hidden"
        document.getElementById("add_new-1").style.opacity = "0"
    }

    function editForm(j){
        document.getElementById("back-1").style.display = "block"
        document.getElementById("screen-1").style.visibility = "visible"
        document.getElementById("edit").style.opacity = "1"

        var cliente = document.getElementById("cliente-"+j).innerHTML
        document.getElementById("cliente").value = cliente;

        var vendedor = document.getElementById("vendedor-"+j).innerHTML
        document.getElementById("vendedor").value = vendedor;

        var placa = document.getElementById("placa-"+j).innerHTML
        document.getElementById("veiculo").value = placa;

        document.getElementById("data").value = datas[j];

        document.getElementById("preco").value = precos[j];

        document.getElementById("estado").value = estados[j];
    }

</script>
</html>