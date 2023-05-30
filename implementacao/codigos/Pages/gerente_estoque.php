
<?php
    if(isset($_COOKIE['gerente'])){
        setcookie('gerente', 'cookie gerente', time()+3600, '/');
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
    $marca_modelo = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $ids[$i] = $row['id'];
        $marcas[$i] = $row['marca'];
        $modelos[$i] = $row['modelo'];
        $tipos[$i] = $row['tipo'];
        $precos[$i] = $row['preco'];
        $quantidades[$i] = $row['quantidade'];
        $marca_modelo[$i] = "$marcas[$i]-$modelos[$i]";
        $i++;
    }

    echo "<script>
    let ids = []
    let precos = []
    let quantidades = []
    let marca_modelo = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        ids.push(".$ids[$j].");
        precos.push('".$precos[$j]."');
        quantidades.push(".$quantidades[$j].");
        marca_modelo.push('".$marca_modelo[$j]."');
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
                <a href="gerente.php"><h3>Funcionários</h3></a>
                <a href="gerente_clientes.php"><h3>Clientes</h3></a>
                <a href="gerente_veiculos.php"><h3>Veículos</h3></a>
                <a href="gerente_vendas.php"><h3>Vendas</h3></a>
                <div id='selected'>
                    <a href="gerente_estoque.php"><h3>Estoque</h3></a>
                </div>
                <h3>Relatórios</h3>
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
                    <input type="text" name="modelo-c" />
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
                                echo '<img class="icons" id="data-'. $j . '" src="../../imgs/edit_button.png" alt="Editar" onclick="editForm('. $j . ')">';
                                echo '<img class="icons" id="data-'. $j . '" src="../../imgs/remove_button.png" alt="Remover" onclick="removeForm('. $j . ')">
                                <form action="../Remove/removeestoque.php" id="remove-'.$j.'" class="remove" method="post">
                                    <input type="number" name="id-r" value='.$ids[$j].' />
                                </form><br>';
                            }
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <button id="add_button" onclick="insertForm()">
            Adicionar ao Estoque
        </button>

        <div class="back" id="back"></div>
        <div class="screen" id="screen">
            <div class="add_new" id="add_new">
                <form action="../Insert/insertestoque.php" class="form_new" method='post' id='form_add'>
                    <h2>Inserir no Estoque</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Inserir no Estoque" onclick="closeInsertForm()">
                    <div>
                        <label>Marca:</label>
                        <input type="text" name="marca-a" required id='marca-a'/>
                    </div>
                    <div>
                        <label>Modelo:</label>
                        <input type="text" name="modelo-a" id='modelo-a' required/>
                    </div>
                    <div>
                        <label>Preço:</label>
                        <input type="number" name="preco-a" required/>
                    </div>
                    <div>
                        <label>Tipo:</label>
                        <select name="tipo-a" id='tipo-a'>
                            <option value="Carro SUV">Carro SUV</option>
                            <option value="Moto">Moto</option>
                            <option value="Picape">Picape</option>
                            <option value="Carro Hatch">Carro Hatch</option>
                            <option value="Carro Sedan">Carro Sedan</option>
                        </select>
                    </div>
                    <div>
                        <button type="button" onclick='verificaInsercao()'>
                            Inserir
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="back" id="back-1"></div>
        <div class="screen" id="screen-1">
            <div class="add_new" id="edit">
                <form action="../Edit/editestoque.php" class="form_new" method='post'>
                    <h2>Estoque</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Editar Estoque" onclick="closeEditForm()">
                    <div>
                        <label>ID:</label>
                        <input type="number" name="id-e" id='id' readonly/>
                    </div>
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
                        <input type="number" name="preco-e" id='preco'/>
                    </div>
                    <div>
                        <label>Tipo:</label>
                        <input type="text" name="tipo-e" id='tipo' readonly/>
                    </div>
                    <div>
                        <label>Quantidade:</label>
                        <input type="number" name="quant-e" id='quant' readonly/>
                    </div>
                    <div>
                        <button type="submit">
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
                    <h2>Estoque</h2>
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

    function verificaInsercao(){
        marca = document.getElementById("marca-a").value
        modelo = document.getElementById("modelo-a").value
        marca = marca + '-' + modelo
        if (marca_modelo.indexOf(marca) > -1) {
            alert("Você não pode inserir algo com mesma marca e modelo já existente!")
        } else {
            document.getElementById('form_add').submit()
        }
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

        document.getElementById("id").value = ids[j]

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

    function removeForm(j){

        if(quantidades[j]>0){
            alert('Você não pode remover algo do estoque que tenha a quantidade maior do que 0.')
        }
        
        else {
            document.getElementById("back-2").style.display = "block"
            document.getElementById("screen-2").style.visibility = "visible"
            document.getElementById("remove").style.opacity = "1"

            var id = ids[j]
            document.getElementById('question').innerHTML = 'Realmente deseja remover o estoque de id: ' + id + '?'
        }

    }

    function remover(){
        string = document.getElementById('question').innerHTML
        string = string.split(":")
        string = string[1].split("?")
        string = string[0].split(" ")
        pos = ids.indexOf(Number(string[1]))
        document.getElementById('remove-'+pos).submit()
    }

    function closeRemoveForm(){
        document.getElementById("back-2").style.display = "none"
        document.getElementById("screen-2").style.visibility = "hidden"
        document.getElementById("remove").style.opacity = "0"
    }

</script>
</html>

    