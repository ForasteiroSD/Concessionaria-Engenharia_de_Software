    
<?php
    if(isset($_COOKIE['gerente'])){
        setcookie('gerente', 'cookie gerente', time()+3600, '/');
    } else{
        echo '<script>window.location.href = "../login.html";</script>';
    }

    if(isset($_POST['marca_modelo-c'])){
        $marca_modelo = explode("-", $_POST['marca_modelo-c']);
        if(count($marca_modelo) == 2){
            $marca = '= "' . $marca_modelo[0] . '"';
            $modelo = '= "' . $marca_modelo[1] . '"';
        } else {
            $marca = 'IN (SELECT marca FROM veiculo)';
            $modelo = 'IN (SELECT modelo FROM veiculo)';
        }
    } else {
        $marca = 'IN (SELECT marca FROM veiculo)';
        $modelo = 'IN (SELECT modelo FROM veiculo)';
    }

    if(isset($_POST['placa-c'])) $placa = '= "' . $_POST["placa-c"] . '"';
    else $placa = 'IN (SELECT placa FROM veiculo)';

    if($placa == '= ""'){
        $placa = 'IN (SELECT placa FROM veiculo)';
    }

    if(isset($_POST['estado-c'])) $estado = 'AND estado = "' . $_POST["estado-c"] . '"';
    else $estado = 'AND estado = "Disponível"';

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM veiculo WHERE marca $marca AND modelo $modelo AND placa $placa $estado ORDER BY ano DESC, marca";

    $result = $conn->query($sql);

    $marcas = array();
    $modelos = array();
    $anos = array();
    $placas = array();
    $quilometragens = array();
    $estados = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $marcas[$i] = $row['marca'];
        $modelos[$i] = $row['modelo'];
        $anos[$i] = $row['ano'];
        $placas[$i] = $row['placa'];
        $quilometragens[$i] = $row['quilometragem'];
        $estados[$i] = $row['estado'];
        $i++;
    }

    $sql = "SELECT marca, modelo FROM estoque ORDER BY marca, modelo";

    $result = $conn->query($sql);

    $marcaE = array();
    $modeloE = array();

    $k = 0;
    while($row = $result->fetch_assoc()){
        $marcaE[$k] = $row['marca'];
        $modeloE[$k] = $row['modelo'];
        $k++;
    }

    echo "<script>
    let placas = []
    let estados = []
    let quilometragens = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        estados.push('".$estados[$j]."');
        quilometragens.push('".$quilometragens[$j]."');
        placas.push('".$placas[$j]."');
        </script>";
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
            <h2>Veículos</h2>
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
                <div id='selected'>
                    <a href="gerente_veiculos.php"><h3>Veículos</h3></a>
                </div>
                <a href="gerente_vendas.php"><h3>Vendas</h3></a>
                <a href="gerente_estoque.php"><h3>Estoque</h3></a>
                <h3>Relatórios</h3>
            </div>
        </div>


        <div class='consulta'>
            <form class='campos' method='post'>
                <div>
                    <label>Marca e Modelo:</label>
                    <select name="marca_modelo-c">
                        <option value="todos">Todos</option>
                        <?php
                            for($j = 0; $j<$k; $j++){
                                echo "<option value='$marcaE[$j]-$modeloE[$j]'>$marcaE[$j]-$modeloE[$j]</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Placa:</label>
                    <input type="text" name="placa-c" />
                </div>
                <div>
                    <label>Estado:</label>
                    <select name="estado-c" id="cargo">
                        <option value="Em processo de Venda">Em processo de Venda</option>
                        <option value="Vendido">Vendido</option>
                        <option value="Disponível" selected>Disponível</option>
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
                    <h3>Marca</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='marca-". $j . "'>". $marcas[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Modelo</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='modelo-". $j . "'>". $modelos[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Ano</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='ano-". $j . "'>". $anos[$j] . "</p><br>";
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
                                echo '<img class="icons" id="data-'. $j . '" src="../../imgs/edit_button.png" alt="Editar" onclick="editForm('. $j . ')">';
                                echo '<img class="icons" id="data-'. $j . '" src="../../imgs/remove_button.png" alt="Remover" onclick="removeForm('. $j . ')">
                                <form action="../Remove/removeveic.php" id="remove-'.$j.'" class="remove" method="post">
                                    <input type="text" name="placa-r" value='.$placas[$j].' />
                                </form><br>';
                            }
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <button id="add_button" onclick="insertForm()">
            Adicionar novo Veículo
        </button>

        <div class="back" id="back"></div>
        <div class="screen" id="screen">
            <div class="add_new" id="add_new">
                <form action="../Insert/insertveic.php" class="form_new" method='post'>
                <h2>Inserir novo Veículo</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Inserir Veículo" onclick="closeInsertForm()">
                    <div>
                        <label>Marca e Modelo:</label>
                        <select name="marca_modelo-a" id="marcaModelo" required>
                            <?php
                                for($j = 0; $j<$k; $j++){
                                    echo "<option value='$marcaE[$j]-$modeloE[$j]'>$marcaE[$j]-$modeloE[$j]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label>Ano:</label>
                        <input type="number" name="ano-a" required/>
                    </div>
                    <div>
                        <label>Placa:</label>
                        <input type="text" name="placa-a" required/>
                    </div>
                    <div>
                        <label>Quilometragem:</label>
                        <input type="number" name="quilo-a" required/>
                    </div>
                    <div>
                        <button type="submit">
                            Inserir
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="back" id="back-1"></div>
        <div class="screen" id="screen-1">
            <div class="add_new" id="edit">
                <form action="../Edit/editveic.php" class="form_new" method='post' id="form_edit">
                    <h2>Veículo</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Visualizar Veículo" onclick="closeEditForm()">
                    <div>
                        <label>Marca:</label>
                        <input type="text" name="marca-e" readonly id='marca'/>
                    </div>
                    <div>
                        <label>Modelo:</label>
                        <input type="text" name="modelo-e" readonly id='modelo'/>
                    </div>
                    <div>
                        <label>Ano:</label>
                        <input type="number" name="ano-e" readonly id='ano'/>
                    </div>
                    <div>
                        <label>Placa:</label>
                        <input type="text" name="placa-e" id='placa' readonly/>
                    </div>
                    <div>
                        <label>Quilometragem:</label>
                        <input type="number" name="quilo-e" id='quilo'/>
                    </div>
                    <div>
                        <label>Estado:</label>
                        <input type="text" name="estado-e" id='estado' readonly/>
                    </div>
                    <div>
                        <button type="button" onclick='verificaEdicao()'>
                            Editar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="back" id="back-2"></div>
        <div class="screen" id="screen-2">
            <div class="add_new" id="remove">
                <div class='form_new'>
                    <h2>Veículo</h2>
                    <h4 id='question'></h4>
                </div>
                <div class="remover_cancelar">
                    <button onclick="remover()">
                        Sim
                    </button>
                    <button onclick="closeRemoveForm()">
                        Cancelar
                    </button>
                </div>  
            </div>
        </div>
             

</body>
<script>

    function closeInsertForm(){
        document.getElementById("back").style.display = "none"
        document.getElementById("screen").style.visibility = "hidden"
        document.getElementById("add_new").style.opacity = "0"
    }

    function insertForm(){
        document.getElementById("back").style.display = "block"
        document.getElementById("screen").style.visibility = "visible"
        document.getElementById("add_new").style.opacity = "1"
    }


    function closeEditForm(){
        document.getElementById("back-1").style.display = "none"
        document.getElementById("screen-1").style.visibility = "hidden"
        document.getElementById("add_new-1").style.opacity = "0"
    }

    function editForm(j){
        document.getElementById("back-1").style.display = "block"
        document.getElementById("screen-1").style.visibility = "visible"
        document.getElementById("edit").style.opacity = "1"

        var marca = document.getElementById("marca-"+j).innerHTML
        document.getElementById("marca").value = marca;

        var modelo = document.getElementById("modelo-"+j).innerHTML
        document.getElementById("modelo").value = modelo;

        var ano = document.getElementById("ano-"+j).innerHTML
        document.getElementById("ano").value = ano;

        var placa = document.getElementById("placa-"+j).innerHTML
        document.getElementById("placa").value = placa;

        document.getElementById("quilo").value = quilometragens[j];

        document.getElementById("estado").value = estados[j];
    }

    function verificaEdicao(){
        var placa = document.getElementById("placa").value
        pos = placas.indexOf(placa)
        
        estado = estados[pos]

        if(estado == 'Vendido') {
            alert("Você não pode alterar um veículo que já foi vendido.")
        } else {
            document.getElementById("form_edit").submit()
        }

    }

    function removeForm(j){

        if(estados[j] != "Disponível"){
            alert('Você só pode remover veículos que estejam Disponíveis.')
        }
        
        else {
            document.getElementById("back-2").style.display = "block"
            document.getElementById("screen-2").style.visibility = "visible"
            document.getElementById("remove").style.opacity = "1"

            var placa = document.getElementById("placa-"+j).innerHTML
            document.getElementById('question').innerHTML = 'Realmente deseja remover o veículo com placa: ' + placa + '?'
        }

    }

    function remover(){
        string = document.getElementById('question').innerHTML
        string = string.split(":")
        string = string[1].split("?")
        string = string[0].split(" ")
        pos = placas.indexOf(string[1])
        document.getElementById('remove-'+pos).submit()
    }

    function closeRemoveForm(){
        document.getElementById("back-2").style.display = "none"
        document.getElementById("screen-2").style.visibility = "hidden"
        document.getElementById("remove").style.opacity = "0"
    }

</script>
</html>