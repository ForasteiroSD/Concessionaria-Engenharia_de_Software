
<?php
    if(isset($_COOKIE['adm'])){
        setcookie('adm', 'cookie adm', time()+3600);
    } else{
        echo '<script>window.location.href = "login.html";</script>';
    }
?>

<?php
    // Código de inserção entra aqui
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Fita | Administrador</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
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
                        <a href="./login.html"><img src="../imgs/logout_button.png" alt="Logo"></a>
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
            <form class='campos'>
                <div>
                    <label>Nome:</label>
                    <input type="text" name="name" />
                </div>
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
                    <h3>Nome</h3>
                </div>

                <div class="column">
                    <h3>CPF</h3>
                </div>

                <div class="column">
                    <h3>User</h3>
                </div>

                <div class="column">
                    <h3>Tipo</h3>
                </div>

            </div>

        </div>

        <button id="add_button" onclick="insertForm()">
            Adicionar novo Usuário
        </button>

        <div class="back" id="back"></div>
        <div class="screen" id="screen">
            <div class="add_new" id="add_new">
                <form action="" class="form_new">
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
                        <select name="tipo" id="cargo">
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
            <div class="add_new" id="add_new-1">
                <form action="" class="form_new">
                    <h2>Usuário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Editar Usuário" onclick="closeEditForm()">
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf" requiered readonly/>
                    </div>
                    <div>
                        <label>User:</label>
                        <input type="text" name="user" requiered/>
                    </div>
                    <div>
                        <label>Senha:</label>
                        <input type="text" name="senha" requiered readonly/>
                    </div>
                    <div>
                    <label>Tipo:</label>
                        <select name="tipo" id="cargo">
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
        document.getElementById("add_new-1").style.opacity = "0"
    }

    function editForm(){
        document.getElementById("back-1").style.display = "block"
        document.getElementById("screen-1").style.visibility = "visible"
        document.getElementById("add_new-1").style.opacity = "1"
    }

</script>
</html>

    