
<?php
    if(isset($_COOKIE['gerente'])){
        setcookie('gerente', 'cookie gerente', time()+3600);
    } else{
        echo '<script>window.location.href = "login.html";</script>';
    }

    if(isset($_POST['name-c'])) $name = '= "' . $_POST["name-c"] . '"';
    else $name = 'IN (SELECT nome FROM funcionarios)';

    if($name == '= ""'){
        $name = 'IN (SELECT nome FROM funcionarios)';
    }

    if(isset($_POST['cpf-c'])) $cpf = '= ' . $_POST["cpf-c"] . '';
    else $cpf = 'IN (SELECT cpf FROM funcionarios)';

    if($cpf == '= '){
        $cpf = 'IN (SELECT cpf FROM funcionarios)';
    }

    if(isset($_POST['cargo-c'])) $cargo = '= "' . $_POST["cargo-c"] . '"';
    else $cargo= 'IN (SELECT cargo FROM funcionarios)';


    if($cargo == '= "todos"' or $cargo == '= ""'){
        $cargo = 'IN (SELECT cargo FROM funcionarios)';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM funcionarios WHERE nome $name AND cpf $cpf AND cargo $cargo ORDER BY cargo, nome";

    $result = $conn->query($sql);

    $nomes = array();
    $cpfs = array();
    $cargos = array();
    $salarios = array();
    $datas = array();
    $contratacoes = array();
    $telefones = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $nomes[$i] = $row['nome'];
        $cpfs[$i] = $row['cpf'];
        $cargos[$i] = $row['cargo'];
        $salarios[$i] = $row['salario'];
        $datas[$i] = $row['data_nasc'];
        $contratacoes[$i] = $row['contratacao'];
        $telefones[$i] = $row['telefone'];
        $i++;
    }

    echo "<script> 
    let salarios = []
    let datas = []
    let contratacoes = []
    let telefones = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        salarios.push(".$salarios[$j].");
        datas.push('".$datas[$j]."');
        contratacoes.push('".$contratacoes[$j]."');
        telefones.push('".$telefones[$j]."');
        </script>";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Fita | Gerente</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src="logout.js"></script>
</head>
<body>

        <header>
            
            <div id='image'><img src="../imgs/fita_logo.png" alt="Logo"></div>
            <h2>Funcionários</h2>
            <?php
                $timezone = new DateTimeZone('America/Sao_Paulo');
                $agora = new DateTime('now', $timezone);
                echo '<div id="date">
                        <h3>' . $agora->format("d/m") . ' | ' . $agora->format("H:i") . '</h3>
                        <img src="../imgs/logout_button.png" alt="Logo" onclick="logout()">
                      </div>'
            ?>

        </header>

        <hr>

        <div class='options'>
            <div id='menu'>
                <div id='selected'>
                    <h3>Funcionários</h3>
                </div>
                <h3>Clientes</h3>
                <h3>Veículos</h3>
                <h3>Vendas</h3>
                <h3>Estoque</h3>
                <h3>Relatórios</h3>
            </div>
        </div>


        <div class='consulta'>
            <form class='campos' method='post'>
                <div>
                    <label>Nome:</label>
                    <input type="text" name="name-c" />
                </div>
                <div>
                    <label>CPF:</label>
                    <input type="number" name="cpf-c" />
                </div>
                <div>
                <label>Cargo:</label>
                    <select name="cargo-c" id="cargo">
                        <option value="todos">Todos</option>
                        <option value="vendedor">Vendedor</option>
                        <option value="gerente">Gerente</option>
                        <option value="faxineiro">Faxineiro</option>
                        <option value="mecanico">Mecânico</option>
                        <option value="secretario">Secretário</option>
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
                    <h3>Nome</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='nome-". $j . "'>". $nomes[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>CPF</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='cpf-". $j . "'>". $cpfs[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Cargo</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='cargo-". $j . "'>". $cargos[$j] . "</p><br>";
                            }
                        ?>
                    </div>
                </div>

                <div class="column">
                    <h3>Ação</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) {
                                echo '<img class="icons" id="data-'. $j . '" src="../imgs/edit_button.png" alt="Editar" onclick="editForm('. $j . ')">';
                                echo '<img class="icons" id="data-'. $j . '" src="../imgs/remove_button.png" alt="Remover"><br>';
                            }
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <button id="add_button" onclick="insertForm()">
            Adicionar novo Funcionário
        </button>

        <div class="back" id="back"></div>
        <div class="screen" id="screen">
            <div class="add_new" id="add_new">
                <form action="" class="form_new" method='post'>
                    <h2>Inserir novo Funcionário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Inserir Funcionário" onclick="closeInsertForm()">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="name-a" requiered/>
                    </div>
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf-a" requiered/>
                    </div>
                    <div>
                        <label>Data de nascimento:</label>
                        <input type="date" name="data-a" requiered/>
                    </div>
                    <div>
                        <label>Telefone:</label>
                        <input type="text" name="telefone-a" placeholder="(XX) XXXXXXXXX" requiered/>
                    </div>
                    <div>
                        <label>Salário:</label>
                        <input type="number" name="salario-a" requiered/>
                    </div>
                    <div>
                        <label>Data de Contratação:</label>
                        <input type="date" name="contratacao-a" 
                        value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                        requiered/>
                    </div>
                    <div>
                    <label>Cargo:</label>
                        <select name="cargo-a" id="cargo">
                            <option value="vendedor">Vendedor</option>
                            <option value="gerente">Gerente</option>
                            <option value="faxineiro">Faxineiro</option>
                            <option value="mecanico">Mecânico</option>
                            <option value="secretario">Secretário</option>
                        </select>
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
                <form action="editfunc.php" class="form_new" method='post'>
                    <h2>Funcionário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Editar Usuário" onclick="closeEditForm()">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="name-e" requiered id='nome'/>
                    </div>
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf-e" readonly id='cpf'/>
                    </div>
                    <div>
                        <label>Data de nascimento:</label>
                        <input type="date" name="data-e" readonly id='nasc'/>
                    </div>
                    <div>
                        <label>Telefone:</label>
                        <input type="text" name="telefone-e" placeholder="(XX) XXXXXXXXX" requiered id='tel'/>
                    </div>
                    <div>
                        <label>Salário:</label>
                        <input type="number" name="salario-e" requiered id='sal'/>
                    </div>
                    <div>
                        <label>Data de Contratação:</label>
                        <input type="date" name="contratacao-e" readonly id='contr'/>
                    </div>
                    <div>
                    <label>Cargo:</label>
                        <select name="cargo-e" id="func-edit">
                            <option value="vendedor">Vendedor</option>
                            <option value="gerente">Gerente</option>
                            <option value="faxineiro">Faxineiro</option>
                            <option value="mecanico">Mecânico</option>
                            <option value="secretario">Secretário</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit">
                            Editar
                        </button>
                    </div>
                </form>
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

        var nome = document.getElementById("nome-"+j).innerHTML
        document.getElementById("nome").value = nome;

        var cpf = document.getElementById("cpf-"+j).innerHTML
        document.getElementById("cpf").value = cpf;

        document.getElementById("nasc").value = datas[j];

        document.getElementById("tel").value = telefones[j];

        document.getElementById("sal").value = salarios[j];

        document.getElementById("contr").value = contratacoes[j];

        var tipo = document.getElementById("cargo-"+j).innerHTML
        document.getElementById("func-edit").value = tipo;
    }
</script>
</html>

    