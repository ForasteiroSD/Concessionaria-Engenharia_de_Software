    
<?php
    if(isset($_COOKIE['secretario'])){
        setcookie('secretario', 'cookie secretario', time()+3600, '/');
    } else{
        echo '<script>window.location.href = "../login.html";</script>';
    }

    if(isset($_POST['marca-c'])) $marca = '= "' . $_POST["marca-c"] . '"';
    else $marca = 'IN (SELECT marca FROM estoque)';

    if($marca == '= ""'){
        $marca = 'IN (SELECT marca FROM estoque)';
    }

    if(isset($_POST['modelo-c'])) $modelo = '= "' . $_POST["modelo-c"] . '"';
    else $modelo = 'IN (SELECT modelo FROM estoque)';

    if($modelo == '= ""'){
        $modelo = 'IN (SELECT modelo FROM estoque)';
    }

    if(isset($_POST['tipo-c'])) $tipo = '= "' . $_POST["tipo-c"] . '"';
    else $tipo = 'IN (SELECT tipo FROM estoque)';

    if($tipo == '= ""' or $tipo == '= "todos"'){
        $tipo = 'IN (SELECT tipo FROM estoque)';
    }

    if(isset($_POST['quantidade-c'])) $quantidade = 'AND quantidade >= ' . $_POST["quantidade-c"] . '';
    else $quantidade = '';

    if($quantidade == 'AND quantidade >= '){
        $quantidade = '';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM estoque WHERE marca $marca AND modelo $modelo AND tipo $tipo $quantidade ORDER BY quantidade DESC, marca";

    $result = $conn->query($sql);

    $ids = array();
    $marcas = array();
    $modelos = array();
    $tipos = array();
    $precos = array();
    $quantidades = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $ids[$i] = $row['id'];
        $marcas[$i] = $row['marca'];
        $modelos[$i] = $row['modelo'];
        $tipos[$i] = $row['tipo'];
        $precos[$i] = $row['preco'];
        $quantidades[$i] = $row['quantidade'];
        $i++;
    }

    echo "<script>
    let ids = []
    let precos = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        ids.push('".$ids[$j]."');
        precos.push('".$precos[$j]."');
        </script>";
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
            <h2>Estoque</h2>
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
                <h3>Vendas</h3>
                <div id='selected'>
                    <a href="secretario_estoque.php"><h3>Estoque</h3></a>
                </div>
            </div>
        </div>


        <div class='consulta'>
            <form class='campos' method='post'>
                <div>
                    <label>Marca:</label>
                    <input type="text" name="marca-c" />
                </div>
                <div>
                    <label>Modelo:</label>
                    <input type="number" name="modelo-c" />
                </div>
                <div>
                    <label>Tipo:</label>
                    <select name="tipo-c" id="cargo">
                        <option value="todos">Todos</option>
                        <option value="Carro SUV">Carro SUV</option>
                        <option value="Moto">Moto</option>
                        <option value="Picape">Picape</option>
                        <option value="Carro Hatch">Carro Hatch</option>
                        <option value="Carro Sedan">Carro Sedan</option>
                    </select>
                </div>
                <div>
                    <label>Quantidade:</label>
                    <input type="number" name="quantidade-c" />
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
                    <h3>Tipo</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='tipo-". $j . "'>". $tipos[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Quantidade</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='quantidade-". $j . "'>". $quantidades[$j] . "</p><br>";
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
                    <h2>Estoque</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Visualizar Estoque" onclick="closeEditForm()">
                    <div>
                        <label>Marca:</label>
                        <input type="text" name="marca-e" readonly id='marca'/>
                    </div>
                    <div>
                        <label>Modelo:</label>
                        <input type="text" name="modelo-e" readonly id='modelo'/>
                    </div>
                    <div>
                        <label>Preço:</label>
                        <input type="number" name="data-e" readonly id='preco'/>
                    </div>
                    <div>
                        <label>Tipo:</label>
                        <input type="text" name="tipo-e" id='tipo' readonly/>
                    </div>
                    <div>
                        <label>Quantidade:</label>
                        <input type="number" name="quant-e" id='quant' readonly/>
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

        var marca = document.getElementById("marca-"+j).innerHTML
        document.getElementById("marca").value = marca;

        var modelo = document.getElementById("modelo-"+j).innerHTML
        document.getElementById("modelo").value = modelo;

        var tipo = document.getElementById("tipo-"+j).innerHTML
        document.getElementById("tipo").value = tipo;

        var quant = document.getElementById("quantidade-"+j).innerHTML
        document.getElementById("quant").value = quant;

        document.getElementById("preco").value = precos[j];
    }

</script>
</html>