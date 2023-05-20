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
            <h2>Usuários</h2>
            <?php
                $timezone = new DateTimeZone('America/Sao_Paulo');
                $agora = new DateTime('now', $timezone);
                echo '<div id="date">
                        <h3>' . $agora->format("d/m") . ' | ' . $agora->format("H:i") . '</h3>
                        <img src="../imgs/logout_button.png" alt="Logo">
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
                <label>Cargo:</label>
                    <select name="cargo" id="cargo">
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

            <div class="resultados">

            </div>
        </div>

        <button id="add_button">
            Adicionar novo Usuário
        </button>
        
     

</body>
<script>
    
</script>
</html>

    