<?php
    include("connection.php");

    if(isset($_POST['login'])) {
        $usuario = $_POST['username'];
        $senha = base64_decode($_POST['senha']);

        // Query de cadastro de usuario:
        $queryBusca = "SELECT * FROM Usuarios WHERE Usuario=$usuario AND Senha=$senha";

        // Executando a query:
        $conectar->query($queryBusca);

        if ($conectar==true) {
            print "<script>location.href='./index.php';</script>";
        } else {
            print "<script>alert('ERRO AO LOGAR USUÁRIO!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DerickCarvalho/DkStrap@documentacao/DkStrap.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="icon" href="./assets/img/logo.png">
    <title>Página Inicial</title>
</head>
<body>
    <header class="flex-row-space-between">
        <img class="logo-img" src="./assets/img/logo.png" alt="">
        <a class="header-button" href="./register.php">Registrar-se</a>
    </header>

    <main class="flex-column-center">
        <h1>Login</h1>

        <form class="flex-column-center width-50" action="" method="POST">            
            <input class="default-input" type="text" name="username" id="username" placeholder="Usuário">

            <div class="fake-input flex-row-center">
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <img id="view_password" src="./assets/img/view_off.png" alt="Olho bloqueado de vizu senha">
            </div>

            <input class="submit-button" type="submit" name="login" value="Login">
        </form>
    </main>

    <footer class="flex-row-space-between">
        <section class="flex-column-center">
            <div class=" flex-row-space-between">
                <div class="social-media flex-column-center">
                    <img src="./assets/img/linkedin.png" alt="">
                    <div class="links flex-column-center">
                        <p><a href="https://www.linkedin.com/in/derick-carvalho-3a0ba9216/">Derick Carvalho</a></p>
                        <p><a href="https://www.linkedin.com/in/antônio-renê-367084130?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app">Antônio Renê</a></p>
                        <p><a href="https://br.linkedin.com/in/thawan-kadson-6357aa245">Thawan Kadson</a></p>
                    </div>
                </div>
    
                <div style="border-right: 1px solid #000000;" class="social-media flex-column-center">
                    <img src="./assets/img/git.png" alt="">
                    <div class="links flex-column-center">
                        <p><a href="https://github.com/DerickCarvalho">Derick Carvalho</a></p>
                        <p><a href="https://github.com/renebatista">Antônio Renê</a></p>
                        <p><a href="https://github.com/thawankadson">Thawan Kadson</a></p>
                    </div>
                </div>
            </div>
            <p class="copy">Developed By - MoscowGroup 2023.2 - &copy;MoscowGroup</p>
        </section>

        <section class="fut-logo flex-column-center">
            <img src="./assets/img/logo.png" alt="">
            <p>2023.2 - Let's Go TRIP</p>
        </section>
    </footer>
</body>

<script>
        let booleanSenha = 0; // Variável booleana para verificar se a senha está ou não visível
        let campoSenha = document.getElementById('senha'); // Adiciona o input password à variável
        let buttonPassword = document.getElementById('view_password'); // Adiciona img que servirá como botão
        buttonPassword.addEventListener('click', () => {
            if (booleanSenha == 0) {
                buttonPassword.src = "./assets/img/view_on.png";
                campoSenha.type = "text";
                booleanSenha = 1;
            } else {
                buttonPassword.src = "./assets/img/view_off.png";
                campoSenha.type = "password";
                booleanSenha = 0;
            }
        });
</script>

</html>