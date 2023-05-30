
<?php
    if(isset($_COOKIE['gerente'])){
        setcookie('gerente', 'cookie gerente', time()+3600, '/');
    } else{
        echo '<script>window.location.href = "../login.html";</script>';
    }

    if(isset($_POST['name-c'])) $name = '= "' . $_POST["name-c"] . '"';
    else $name = 'IN (SELECT nome FROM funcionario)';

    if($name == '= ""'){
        $name = 'IN (SELECT nome FROM funcionario)';
    }

    if(isset($_POST['cpf-c'])) $cpf = '= "' . $_POST["cpf-c"] . '"';
    else $cpf = 'IN (SELECT cpf FROM funcionario)';

    if($cpf == '= ""'){
        $cpf = 'IN (SELECT cpf FROM funcionario)';
    }

    if(isset($_POST['cargo-c'])) $cargo = '= "' . $_POST["cargo-c"] . '"';
    else $cargo= 'IN (SELECT cargo FROM funcionario)';


    if($cargo == '= "todos"' or $cargo == '= ""'){
        $cargo = 'IN (SELECT cargo FROM funcionario)';
    }

    if(isset($_POST['ativo'])) $ativo = 'AND ativo = 0';
    else $ativo= 'AND ativo = 1';

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM funcionario WHERE nome $name AND cpf $cpf AND cargo $cargo $ativo ORDER BY cargo, nome";

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
    let cpfs = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        salarios.push(".$salarios[$j].");
        datas.push('".$datas[$j]."');
        contratacoes.push('".$contratacoes[$j]."');
        telefones.push('".$telefones[$j]."');
        cpfs.push('".$cpfs[$j]."')
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
            <h2>Funcionários</h2>
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
                <div id='selected'>
                    <a href="gerente.php"><h3>Funcionários</h3></a>
                </div>
                <a href="gerente_clientes.php"><h3>Clientes</h3></a>
                <a href="gerente_veiculos.php"><h3>Veículos</h3></a>
                <a href="gerente_vendas.php"><h3>Vendas</h3></a>
                <a href="gerente_estoque.php"><h3>Estoque</h3></a>
                <a href="gerente_relatorios.php"><h3>Relatórios</h3></a>
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
                        <option value="Vendedor">Vendedor</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Faxineiro">Faxineiro</option>
                        <option value="Mecânico">Mecânico</option>
                        <option value="Secretário">Secretário</option>
                    </select>
                </div>
                <div>
                    <label>Des.:</label>
                    <input type="checkbox" id="check" name="ativo" value="1">
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
                                echo '<img class="icons" id="data-'. $j . '" src="../../imgs/edit_button.png" alt="Editar" onclick="editForm('. $j . ')">';
                                if(isset($_POST['ativo'])){
                                    echo '<img class="icons" id="data-'. $j . '" src="../../imgs/add_button.png" alt="Adicionar" onclick="removeForm('. $j . ')">
                                    <form action="../Remove/removefunc.php" id="remove-'.$j.'" class="remove" method="post">
                                        <input type="number" name="cpf-a" value='.$cpfs[$j].' />
                                    </form><br>';
                                } else {
                                    echo '<img class="icons" id="data-'. $j . '" src="../../imgs/remove_button.png" alt="Remover" onclick="removeForm('. $j . ')">
                                    <form action="../Remove/removefunc.php" id="remove-'.$j.'" class="remove" method="post">
                                        <input type="number" name="cpf-r" value='.$cpfs[$j].' />
                                    </form><br>';
                                }
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
                <form action="../Insert/insertfunc.php" class="form_new" method='post'>
                    <h2>Inserir novo Funcionário</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Inserir Funcionário" onclick="closeInsertForm()">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="name-a" required/>
                    </div>
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf-a" required/>
                    </div>
                    <div>
                        <label>Data de nascimento:</label>
                        <input type="date" name="data-a" required/>
                    </div>
                    <div>
                        <label>Telefone:</label>
                        <input type="text" name="telefone-a" placeholder="(XX) XXXXXXXXX" required/>
                    </div>
                    <div>
                        <label>Salário:</label>
                        <input type="number" name="salario-a" required/>
                    </div>
                    <div>
                        <label>Data de Contratação:</label>
                        <input type="date" name="contratacao-a" 
                        value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                        required/>
                    </div>
                    <div>
                    <label>Cargo:</label>
                        <select name="cargo-a" id="cargo">
                            <option value="Vendedor">Vendedor</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Faxineiro">Faxineiro</option>
                            <option value="Mecânico">Mecânico</option>
                            <option value="Secretário">Secretário</option>
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
                <form action="../Edit/editfunc.php" class="form_new" method='post'>
                    <h2>Funcionário</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Editar Usuário" onclick="closeEditForm()">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="name-e" required id='nome'/>
                    </div>
                    <div>
                        <label>CPF:</label>
                        <input type="text" name="cpf-e" readonly id='cpf'/>
                    </div>
                    <div>
                        <label>Data de nascimento:</label>
                        <input type="date" name="data-e" readonly id='nasc'/>
                    </div>
                    <div>
                        <label>Telefone:</label>
                        <input type="text" name="telefone-e" placeholder="(XX) XXXXXXXXX" required id='tel'/>
                    </div>
                    <div>
                        <label>Salário:</label>
                        <input type="number" name="salario-e" required id='sal'/>
                    </div>
                    <div>
                        <label>Data de Contratação:</label>
                        <input type="date" name="contratacao-e" readonly id='contr'/>
                    </div>
                    <div>
                    <label>Cargo:</label>
                        <select name="cargo-e" id="func-edit">
                            <option value="Vendedor">Vendedor</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Faxineiro">Faxineiro</option>
                            <option value="Mecânico">Mecânico</option>
                            <option value="Secretário">Secretário</option>
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

        <div class="back" id="back-2"></div>
        <div class="screen" id="screen-2">
            <div class="add_new" id="remove">
                <div class='form_new'>
                    <h2>Funcionário</h2>
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

    function removeForm(j){
        document.getElementById("back-2").style.display = "block"
        document.getElementById("screen-2").style.visibility = "visible"
        document.getElementById("remove").style.opacity = "1"

        var cpf = document.getElementById("cpf-"+j).innerHTML
        document.getElementById('question').innerHTML = 'Realmente deseja Desativar/Ativar o funcionário de CPF: ' + cpf + '?'

    }

    function remover(){
        string = document.getElementById('question').innerHTML
        string = string.split(":")
        string = string[1].split("?")
        string = string[0].split(" ")
        pos = cpfs.indexOf(string[1])
        document.getElementById('remove-'+pos).submit()
    }

    function closeRemoveForm(){
        document.getElementById("back-2").style.display = "none"
        document.getElementById("screen-2").style.visibility = "hidden"
        document.getElementById("remove").style.opacity = "0"
    }

</script>
</html>

    