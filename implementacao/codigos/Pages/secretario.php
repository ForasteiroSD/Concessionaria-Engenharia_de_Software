    
<?php
    if(isset($_COOKIE['secretario'])){
        setcookie('secretario', 'cookie secretario', time()+3600, '/');
    } else{
        echo '<script>window.location.href = "../login.html";</script>';
    }

    if(isset($_POST['name-c'])) $name = '= "' . $_POST["name-c"] . '"';
    else $name = 'IN (SELECT nome FROM cliente)';

    if($name == '= ""'){
        $name = 'IN (SELECT nome FROM cliente)';
    }

    if(isset($_POST['cpf-c'])) $cpf = '= ' . $_POST["cpf-c"] . '';
    else $cpf = 'IN (SELECT cpf FROM cliente)';

    if($cpf == '= '){
        $cpf = 'IN (SELECT cpf FROM cliente)';
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

    $sql = "SELECT * FROM cliente WHERE nome $name AND cpf $cpf $ativo ORDER BY nome";

    $result = $conn->query($sql);

    $nomes = array();
    $cpfs = array();
    $datas = array();
    $telefones = array();
    $emails = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $nomes[$i] = $row['nome'];
        $cpfs[$i] = $row['cpf'];
        $datas[$i] = $row['data_nasc'];
        $telefones[$i] = $row['telefone'];
        $emails[$i] = $row['email'];
        $i++;
    }

    echo "<script>
    let datas = []
    let telefones = []
    let emails = []
    let cpfs = []
    </script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>
        datas.push('".$datas[$j]."');
        telefones.push('".$telefones[$j]."');
        cpfs.push(".$cpfs[$j].");
        emails.push('".$emails[$j]."')
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
            <h2>Clientes</h2>
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
                    <a href="secretario.php"><h3>Clientes</h3></a>
                </div>
                <a href="secretario_veiculos.php"><h3>Veículos</h3></a>
                <h3>Vendas</h3>
                <h3>Estoque</h3>
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
                    <h3>Data de Nascimento</h3>
                    <div class='dados'>
                        <?php
                            $partes = '';

                            for ($j=0; $j < $i; $j++) { 
                                $partes = explode("-", strval($datas[$j]));
                                echo "<p id='cargo-". $j . "'>
                                $partes[2]/$partes[1]/$partes[0]
                                </p><br>";
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
                                    <form action="../Remove/removeclien.php" id="remove-'.$j.'" class="remove" method="post">
                                        <input type="number" name="cpf-a" value='.$cpfs[$j].' />
                                    </form><br>';
                                } else {
                                    echo '<img class="icons" id="data-'. $j . '" src="../../imgs/remove_button.png" alt="Remover" onclick="removeForm('. $j . ')">
                                    <form action="../Remove/removeclien.php" id="remove-'.$j.'" class="remove" method="post">
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
            Adicionar novo Cliente
        </button>

        <div class="back" id="back"></div>
        <div class="screen" id="screen">
            <div class="add_new" id="add_new">
                <form action="../Insert/insertclien.php" class="form_new" method='post'>
                    <h2>Inserir novo Cliente</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Inserir Cliente" onclick="closeInsertForm()">
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
                        <input type="text" name="telefone-a" placeholder="(XX) XXXXXXXXX"/>
                    </div>
                    <div>
                        <label>Email:</label>
                        <input type="text" name="email-a" placeholder=""/>
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
                <form action="../Edit/editclien.php" class="form_new" method='post'>
                    <h2>Cliente</h2>
                    <img src="../../imgs/close_button.png" alt="Fechar Editar Cliente" onclick="closeEditForm()">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="name-e" required id='nome'/>
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
                        <input type="text" name="telefone-e" placeholder="(XX) XXXXXXXXX" id='tel'/>
                    </div>
                    <div>
                        <label>Email:</label>
                        <input type="text" name="email-e" placeholder="" id='email'/>
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
                    <h2>Cliente</h2>
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

        document.getElementById("email").value = emails[j];
    }

    function removeForm(j){
        document.getElementById("back-2").style.display = "block"
        document.getElementById("screen-2").style.visibility = "visible"
        document.getElementById("remove").style.opacity = "1"

        var cpf = document.getElementById("cpf-"+j).innerHTML
        document.getElementById('question').innerHTML = 'Realmente deseja Desativar/Ativar o cliente de CPF: ' + cpf + '?'

    }

    function remover(){
        string = document.getElementById('question').innerHTML
        string = string.split(":")
        string = string[1].split("?")
        string = string[0].split(" ")
        pos = cpfs.indexOf(Number(string[1]))
        document.getElementById('remove-'+pos).submit()
    }

    function closeRemoveForm(){
        document.getElementById("back-2").style.display = "none"
        document.getElementById("screen-2").style.visibility = "hidden"
        document.getElementById("remove").style.opacity = "0"
    }

</script>
</html>