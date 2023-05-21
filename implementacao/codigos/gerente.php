<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Fita | Gerente</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
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
                        <a href="./login.html"><img src="../imgs/logout_button.png" alt="Logo"></a>
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
                <label>Cargo:</label>
                    <select name="cargo" id="cargo">
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
                <h3>Nome</h3>
                <h3>CPF</h3>
                <h3>Cargo</h3>
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
            Adicionar novo Funcionário
        </button>

        <div id="back"></div>
        <div id="screen">
            <div id="add_new">
                <form action="" class="form_new">
                    <h2>Inserir novo Funcionário</h2>
                    <img src="../imgs/close_button.png" alt="Fechar Inserir Funcionário" onclick="closeForm()">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="name" requiered/>
                    </div>
                    <div>
                        <label>CPF:</label>
                        <input type="number" name="cpf" requiered/>
                    </div>
                    <div>
                        <label>Data de nascimento:</label>
                        <input type="date" name="data" requiered/>
                    </div>
                    <div>
                        <label>Telefone:</label>
                        <input type="text" name="telefone" placeholder="(XX) XXXXXXXXX" requiered/>
                    </div>
                    <div>
                        <label>Salário:</label>
                        <input type="number" name="salario" requiered/>
                    </div>
                    <div>
                        <label>Data de Contratação:</label>
                        <input type="date" name="salario" 
                        value="<?php
                                    $timezone = new DateTimeZone('America/Sao_Paulo');
                                    $agora = new DateTime('now', $timezone); 
                                    echo $agora->format('Y-m-d'); 
                                ?>"
                        requiered/>
                    </div>
                    <div>
                    <label>Cargo:</label>
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
        document.getElementById("add_new").style.visibility = "hidden"
        document.getElementById("add_new").style.opacity = "0"
    }

    function insert(){
        document.getElementById("back").style.display = "block"
        document.getElementById("add_new").style.visibility = "visible"
        document.getElementById("add_new").style.opacity = "1"
    }
</script>
</html>

    