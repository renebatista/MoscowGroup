<?php
include("connection.php");
$usuId = $_GET['id'];
$usuIdDec = base64_decode($usuId);

session_start(); 

// Obtenha as informações do usuário para pré-preencher o formulário
$StringUserSql = "SELECT * FROM Usuarios WHERE id=$usuIdDec";
$exeUserSql = $conectar->query($StringUserSql);
$loadUserInfos = $exeUserSql->fetch_object();

if (isset($_POST['editar'])) {
    $nome = $_POST['nome'];
    $UrlPerfil = $_POST["URL_Foto"];
    $checkbox = $_POST["fretista"];
    $fretista = 0;

    if ($UrlPerfil == null) {
        $urlPerfil = $loadUserInfos->URL_Perfil;
    }

    if ($checkbox == 'sim') {
        $fretista = 1;
    } else {
        $fretista = 0;
    }

    $updateUserInfosSql = "UPDATE Usuarios 
                           SET Nome='$nome', URL_Perfil='$urlPerfil', fretista=$fretista
                           WHERE id=$usuIdDec";
                        
    try {
        $exeUpdate = $conectar->query($updateUserInfosSql);
        sleep(1);
        print "<script>window.location.href='./index.php?id=$usuId'</script>";
    } catch (\Throwable $th) {
        print "<script>window.location.href='./index.php?id=$usuId'</script>";        
    }

    // if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    //     $senhaAtual = $row['Senha'];

    //     //Senha atual corresponde s senha fornecida
    //     if (base64_decode($senhaAtual) == $senhaPrimaria) {
    //         //Senha atual corresponde:

    //         if ($novaSenha == $confirmarSenha) {
    //             $senha = base64_encode($novaSenha);

    //             // Query de atualização de usuário:
    //             $queryUpdate = "UPDATE Usuarios SET Usuario='$usuario', Nome='$nomeUsuario', URL_Perfil='$URL_Perfil', Senha='$senha' WHERE id=$usuIdDec";

    //             // Executando a query de atualização:
    //             $conectar->query($queryUpdate);

    //             if ($conectar == true) {
    //                 print "<script>alert('Perfil atualizado com sucesso!');</script>";
    //                 // Redirecionar para a página de perfil após a edição
    //                 print "<script>location.href='./login.php';</script>";
    //             } else {
    //                 print "<script>alert('ERRO AO ATUALIZAR O PERFIL!');</script>";
    //             }
    //         } else {
    //             print "<script>alert('As novas senhas não correspondem!');</script>";
    //         }
    //     } else {
    //         print "<script>alert('Senha atual incorreta!');</script>";
    //     }
    // } else {
    //     print "<script>alert('Usuário não encontrado!');</script>";
    // }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DerickCarvalho/DkStrap@main/DkStrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/editProfile.css">
    <link rel="icon" href="./assets/img/logo.png">
    <title>Let's Go Trip - Home</title>
</head>
<body>
    <header class="flex-row-space-between">
        <img class="logo-img" id="logo" src="./assets/img/logo.png" alt="">
        <div class="flex-row-space-between">
            <a href="./addViagem.php?id=<?php print $usuId ?>" class="header-button">+Viagem</a>
        </div>
    </header>

    <main class="flex-column-center">
        <h1>Editar Perfil</h1>
        
        <div style="padding-top: 50px;" class="profile-infos flex-row-space-between">
            <img src="<?php print $loadUserInfos->URL_Perfil ?>" alt="">
        </div>

        <form class="flex-column-center width-50" method="POST">
            <input class="default-input" type="text" name="nome" id="nome" placeholder="Novo Nome" value="<?php print $loadUserInfos->Nome; ?>">

            
            <input class="default-input" type="text" name="URL_Foto" id="URL_Foto" placeholder="Link foto perfil" value="">
            
            <?php
                if ($loadUserInfos->fretista == 1) {
                    print "<div class=\"labelDiv flex-row-center\">";
                    print "    <label for=\"fretista\">desativar função fretista?</label>";
                    print "    <input class=\"default-input\" type=\"checkbox\" name=\"fretista\" id=\"fretista\" value='não'>";
                    print "</div>";
                } else {
                    print "<div class=\"labelDiv flex-row-center\">";
                    print "    <label for=\"fretista\">ativar função fretista?</label>";
                    print "    <input class=\"default-input\" type=\"checkbox\" name=\"fretista\" id=\"fretista\" value='sim'>";
                    print "</div>";
                }
            ?>

            <input class="submit-button" type="submit" name="editar" value="Salvar Alterações">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    // Funcionalidade HomePage Button

        var elements = document.getElementById('logo').addEventListener('click', () => {
            window.location.href = './index.php?id=<?php print $usuId ?>';
        });

        // let booleanSenha = 0; // Variável booleana para verificar se a senha está ou não visível
        // let campoSenha = document.getElementById('password'); // Adiciona o input password à variável
        // let buttonPassword = document.getElementById('view_password'); // Adiciona img que servirá como botão
        // buttonPassword.addEventListener('click', () => {
        //     if (booleanSenha == 0) {
        //         buttonPassword.src = "./assets/img/view_on.png";
        //         campoSenha.type = "text";
        //         booleanSenha = 1;
        //     } else {
        //         buttonPassword.src = "./assets/img/view_off.png";
        //         campoSenha.type = "password";
        //         booleanSenha = 0;
        //     }
        // });

        // let booleanConfirmSenha = 0; // Variável booleana para verificar se a senha está ou não visível
        // let campoConfirmSenha = document.getElementById('confirmPassword'); // Adiciona o input password à variável
        // let buttonConfirmPassword = document.getElementById('view_confirmPassword'); // Adiciona img que servirá como botão
        // buttonConfirmPassword.addEventListener('click', () => {
        //     if (booleanConfirmSenha == 0) {
        //         buttonConfirmPassword.src = "./assets/img/view_on.png";
        //         campoConfirmSenha.type = "text";
        //         booleanConfirmSenha = 1;
        //     } else {
        //         buttonConfirmPassword.src = "./assets/img/view_off.png";
        //         campoConfirmSenha.type = "password";
        //         booleanConfirmSenha = 0;
        //     }
        // });

        // let booleanCurrentSenha = 0; // Variável booleana para verificar se a senha está ou não visível
        // let campoCurrentSenha = document.getElementById('currentPassword'); // Adicion
    </script>