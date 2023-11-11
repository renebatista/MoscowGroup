<?php
    // Criação da string de conecão com DB:
    $servername = "31.170.162.21";
    $username = "timagcom_user_moscowgroup";
    $password = "l]j49A]KR3&l";
    $dbname = "timagcom_moscowgroup";

    // Conecanto-se ao banco
    $conectar = new mysqli($servername, $username, $password, $dbname);

    /*
    if ($conn->connect_error) {
        die("Flaha na conexão: " . $conn->connect_error);
    } else {
        echo "Conectado ao banco";
    }
    */
?>