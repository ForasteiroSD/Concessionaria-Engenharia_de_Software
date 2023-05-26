<?php

    setcookie("adm", '', time() - 1, '/');
    setcookie("gerente", '', time() - 1, '/');
    setcookie("vendedor", '', time() - 1, '/');
    setcookie("secretario", '', time() - 1, '/');
    setcookie("mecanico", '', time() - 1, '/');


    echo "<script>
        window.open('../login.html', '_self');
    </script>";

?>