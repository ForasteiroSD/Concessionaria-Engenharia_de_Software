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
                <h3>Nome</h3>
                <h3>CPF</h3>
                <h3>User</h3>
                <h3>Tipo</h3>
            </div>

            <div>
                <div class='borders'></div>
                <div class='borders'></div>
                <div class='borders'></div>
            </div>

            <div class="resultados">

            </div>
        </div>

        <button id="add_button" onclick="insert()">
            Adicionar novo Usuário
        </button>

        <div id="back"></div>
        <div id="screen">
            <div id="add_new">
                <form action="" class="form_new">
                    <h2>Inserir novo Usuário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Inserir Usuário" onclick="closeForm()">
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
     

</body>
<script>
    function closeForm(){
        document.getElementById("back").style.display = "none"
        document.getElementById("screen").style.visibility = "hidden"
        document.getElementById("add_new").style.opacity = "0"
    }

    function insert(){
        document.getElementById("back").style.display = "block"
        document.getElementById("screen").style.visibility = "visible"
        document.getElementById("add_new").style.opacity = "1"
    }
</script>
</html>

    