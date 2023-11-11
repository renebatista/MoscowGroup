<?php
    // String de conexão DataBase:
    $defaultStringConnection = "31.107.162.21,timagcom_user_moscowgroup,l]j49A]KR3&l,timagcom_moscowgroup";

    // Conectando-se ao banco:
    $connect = mysqli_connect($defaultStringConnection);

    if ($connect = mysqli_connect($defaultStringConnection)) {
        print "Conexão realizada com sucesso!";
    }
?>