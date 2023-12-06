<?php
    include("connection.php");

    if(isset($_POST['cadastrar'])) {
        $usuario = $_POST['username'];
        $senhaPrimaria = $_POST['password'];
        $confirmarSenha = $_POST['confirmPassword'];
        $nomeUsuario = $usuario;
        $URL_Perfil = "https://www.freeiconspng.com/uploads/am-a-19-year-old-multimedia-artist-student-from-manila--21.png";

        if ($senhaPrimaria == $confirmarSenha) {
            $senha = base64_encode($senhaPrimaria);

            // Query de cadastro de usuario:
            $queryCadastro = "INSERT INTO Usuarios (Usuario, Nome, URL_Perfil, Senha, fretista) 
            VALUES ('$usuario','$nomeUsuario','$URL_Perfil','$senha',0)";

            // Executando a query:
            $conectar->query($queryCadastro);

            if ($conectar==true) {
                print "<script>alert('Usuário cadastrado com sucesso!');</script>";
                print "<script>location.href='./login.php';</script>";
            } else {
                print "<script>alert('ERRO AO CADASTRAR USUÁRIO!');</script>";
            }
        } else {
            print "<script>alert('As senhas não correspondem!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DerickCarvalho/DkStrap@main/DkStrap.css">
    <link rel="stylesheet" href="./assets/css/register.css">
    <link rel="icon" href="./assets/img/logo.png">
    <title>GoTrip - Registrar-se</title>
</head>
<body>
    <header class="flex-row-space-between">
        <img class="logo-img" src="./assets/img/logo.png" alt="">
        <a class="header-button" href="./login.php">Login</a>
    </header>

    <main class="flex-column-center">
        <h1>Registrar-se</h1>

        <form class="flex-column-center width-50" method="POST">
            <input class="default-input" type="text" name="username" id="username" placeholder="Usuário">

            <div class="fake-input flex-row-center">                
                <input type="password" name="password" id="password" placeholder="Senha">
                <img id="view_password" src="./assets/img/view_off.png" alt="Olho bloqueado de vizu senha">
            </div>

            <div class="fake-input flex-row-center">                
                <input  type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmar Senha">
                <img id="view_confirmPassword" src="./assets/img/view_off.png" alt="Olho desbloqueado de vizu senha">
            </div>

            <input class="submit-button" type="submit" name="cadastrar" value="Registrar-se">
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
        let campoSenha = document.getElementById('password'); // Adiciona o input password à variável
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

        let booleanConfirmSenha = 0; // Variável booleana para verificar se a senha está ou não visível
        let campoConfirmSenha = document.getElementById('confirmPassword'); // Adiciona o input password à variável
        let buttonConfirmPassword = document.getElementById('view_confirmPassword'); // Adiciona img que servirá como botão
        buttonConfirmPassword.addEventListener('click', () => {
            if (booleanConfirmSenha == 0) {
                buttonConfirmPassword.src = "./assets/img/view_on.png";
                campoConfirmSenha.type = "text";
                booleanConfirmSenha = 1;
            } else {
                buttonConfirmPassword.src = "./assets/img/view_off.png";
                campoConfirmSenha.type = "password";
                booleanConfirmSenha = 0;
            }
        });
</script>

</html>