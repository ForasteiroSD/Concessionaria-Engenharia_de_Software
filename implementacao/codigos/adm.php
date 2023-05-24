
<?php
    if(isset($_COOKIE['adm'])){
        setcookie('adm', 'cookie adm', time()+3600);
    } else{
        echo '<script>window.location.href = "login.html";</script>';
    }

    if(isset($_POST['user'])) $user = '= "' . $_POST["user"] . '"';
    else $user = 'IN (SELECT user FROM usuario)';

    if($user == '= ""'){
        $user = 'IN (SELECT user FROM usuario)';
    }

    if(isset($_POST['cpf'])) $cpf = '= ' . $_POST["cpf"] . '';
    else $cpf = 'IN (SELECT cpf FROM usuario)';

    if($cpf == '= '){
        $cpf = 'IN (SELECT cpf FROM usuario)';
    }

    if(isset($_POST['tipo'])) {
        if($_POST['tipo'] == 'adm') $_POST['tipo'] = 'administrador';
        $tipo = '= "' . $_POST["tipo"] . '"';
    }
    else $tipo= 'IN (SELECT tipo FROM usuario)';


    if($tipo == '= "todos"' or $tipo == '= ""'){
        $tipo = 'IN (SELECT tipo FROM usuario)';
    }

    $servername = "localhost";
    $database = "concessionaria";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM usuario WHERE user $user AND cpf $cpf AND tipo $tipo ORDER BY tipo, user";

    $result = $conn->query($sql);

    $users = array();
    $cpfs = array();
    $tipos = array();
    $senhas = array();

    $j = 0;
    $i = 0;
    while($row = $result->fetch_assoc()){
        $users[$i] = $row['user'];
        $cpfs[$i] = $row['cpf'];
        $tipos[$i] = $row['tipo'];
        $senhas[$i] = $row['senha'];
        $i++;
    }

    echo "<script> let senhas = []</script>";

    for ($j=0; $j < $i; $j++){
        echo "<script>senhas.push('".$senhas[$j]."')</script>";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Fita | Administrador</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src="logout.js"></script>
</head>
<body>

        <header>
            
            <div id='image'><img src="../imgs/fita_logo.png" alt="Logo"></div>
            <h2>Usuários</h2>
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
                    <h3>Usuários</h3>
                </div>
            </div>
        </div>


        <div class='consulta'>
            <form class='campos' method="POST">
                <div>
                    <label>CPF:</label>
                    <input type="number" name="cpf" />
                </div>
                <div>
                    <label>User:</label>
                    <input type="text" name="user" />
                </div>
                <div>
                <label>Tipo:</label>
                    <select name="tipo" id="cargo">
                        <option value="todos">Todos</option>
                        <option value="vendedor">Vendedor</option>
                        <option value="gerente">Gerente</option>
                        <option value="mecanico">Mecânico</option>
                        <option value="secretario">Secretário</option>
                        <option value="adm">Administrador</option>
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
                    <h3>User</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) { 
                                echo "<p id='user-". $j . "'>". $users[$j] . "</p><br>";
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
                    <h3>Ação</h3>
                    <div class='dados'>
                        <?php
                            for ($j=0; $j < $i; $j++) {
                                echo '<img class="icons" id="data-'. $j . '" src="../imgs/edit_button.png" alt="Editar" onclick="editForm('. $j . ')">';
                                echo '<img class="icons" id="data-'. $j . '" src="../imgs/remove_button.png" alt="Remover">
                                <form action="removeuser.php" id="remove-'.$j.'" class="remove">
                                    <input type="hidden" name="cpf-r" value='.$cpfs[$j].' />
                                </form><br>';
                            }
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <button id="add_button" onclick="insertForm()">
            Adicionar novo Usuário
        </button>

        <div class="back" id="back"></div>
        <div class="screen" id="screen">
            <div class="add_new" id="add_new">
                <form action="insertuser.php" class="form_new" method='post'>
                    <h2>Inserir novo Usuário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Inserir Usuário" onclick="closeInsertForm()">
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf" requiered/>
                    </div>
                    <div>
                        <label>User:</label>
                        <input type="text" name="user" requiered/>
                    </div>
                    <div>
                        <label>Senha:</label>
                        <input type="text" name="senha" requiered/>
                    </div>
                    <div>
                    <label>Tipo:</label>
                        <select name="tipo" id="cargo-1">
                            <option value="vendedor">Vendedor</option>
                            <option value="gerente">Gerente</option>
                            <option value="mecanico">Mecânico</option>
                            <option value="secretario">Secretário</option>
                            <option value="adm">Administrador</option>
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
                <form action="edituser.php" class="form_new" method='post'>
                    <h2>Usuário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Editar Usuário" onclick="closeEditForm()">
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf" requiered readonly id="cpf"/>
                    </div>
                    <div>
                        <label>User:</label>
                        <input type="text" name="user" requiered id="user"/>
                    </div>
                    <div>
                        <label>Senha:</label>
                        <input type="text" name="senha" requiered readonly id="senha"/>
                    </div>
                    <div>
                    <label>Tipo:</label>
                        <select name="tipo" id="cargo-2">
                            <option value="vendedor">Vendedor</option>
                            <option value="gerente">Gerente</option>
                            <option value="mecanico">Mecânico</option>
                            <option value="secretario">Secretário</option>
                            <option value="adm">Administrador</option>
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
        document.getElementById("edit").style.opacity = "0"
    }

    function editForm(j){
        document.getElementById("back-1").style.display = "block"
        document.getElementById("screen-1").style.visibility = "visible"
        document.getElementById("edit").style.opacity = "1"

        var cpf = document.getElementById("cpf-"+j).innerHTML
        document.getElementById("cpf").value = cpf;

        var user = document.getElementById("user-"+j).innerHTML
        document.getElementById("user").value = user;

        document.getElementById("senha").value = senhas[j];

        var tipo = document.getElementById("tipo-"+j).innerHTML
        if(tipo == 'administrador'){
            tipo = 'adm'
        }
        document.getElementById("cargo-2").value = tipo;
    }

</script>
</html>