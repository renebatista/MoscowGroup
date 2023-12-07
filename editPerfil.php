<?php
include("connection.php");
$usuId = $_GET['id'];
$usuIdDec = base64_decode($usuId);

session_start(); 

if (isset($_POST['editar'])) {
    $usuario = $_POST['username'];
    $senhaPrimaria = $_POST['currentPassword']; 
    $novaSenha = $_POST['password'];
    $confirmarSenha = $_POST['confirmPassword'];
    $nomeUsuario = $usuario;
    $URL_Perfil = "https://www.freeiconspng.com/uploads/am-a-19-year-old-multimedia-artist-student-from-manila--21.png";

    // Informações do usuário
    $querySelect = "SELECT Senha FROM Usuarios WHERE id=$usuIdDec";
    $result = $conectar->query($querySelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $senhaAtual = $row['Senha'];

        //Senha atual corresponde s senha fornecida
        if (base64_decode($senhaAtual) == $senhaPrimaria) {
            //Senha atual corresponde:

            if ($novaSenha == $confirmarSenha) {
                $senha = base64_encode($novaSenha);

                // Query de atualização de usuário:
                $queryUpdate = "UPDATE Usuarios SET Usuario='$usuario', Nome='$nomeUsuario', URL_Perfil='$URL_Perfil', Senha='$senha' WHERE id=$usuIdDec";

                // Executando a query de atualização:
                $conectar->query($queryUpdate);

                if ($conectar == true) {
                    print "<script>alert('Perfil atualizado com sucesso!');</script>";
                    // Redirecionar para a página de perfil após a edição
                    print "<script>location.href='./login.php';</script>";
                } else {
                    print "<script>alert('ERRO AO ATUALIZAR O PERFIL!');</script>";
                }
            } else {
                print "<script>alert('As novas senhas não correspondem!');</script>";
            }
        } else {
            print "<script>alert('Senha atual incorreta!');</script>";
        }
    } else {
        print "<script>alert('Usuário não encontrado!');</script>";
    }
}

// Obtenha as informações do usuário para pré-preencher o formulário
$StringUserSql = "SELECT * FROM Usuarios WHERE id=$usuIdDec";
$exeUserSql = $conectar->query($StringUserSql);

if ($exeUserSql->num_rows > 0) {
    $loadUserInfos = $exeUserSql->fetch_object();
    $usuarioAtual = $loadUserInfos->Usuario;
    // $nomeAtual = $loadUserInfos->Nome; // 
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <!--  -->
    <link rel="icon" href="./assets/img/logo.png">
    <title>GoTrip - Editar Perfil</title>
</head>

<body>
    <header class="flex-row-space-between">
        <!-- -->
    </header>

    <main class="flex-column-center">
        <h1>Editar Perfil</h1>

        <form class="flex-column-center width-50" method="POST">
            <input class="default-input" type="text" name="username" id="username" placeholder="Usuário" value="<?php echo $usuarioAtual; ?>">

            <div class="fake-input flex-row-center">
                <input type="password" name="currentPassword" id="currentPassword" placeholder="Senha Atual">
                <!--<img id="view_currentPassword" src="./assets/img/view_off.png" alt="Olho bloqueado de vizu senha">-->
            </div>

            <div class="fake-input flex-row-center">
                <input type="password" name="password" id="password" placeholder="Nova Senha">
                <!--<img id="view_currentPassword" src="./assets/img/view_off.png" alt="Olho bloqueado de vizu senha">-->
            </div>

            <div class="fake-input flex-row-center">
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmar Nova Senha">
                <!--<img id="view_currentPassword" src="./assets/img/view_off.png" alt="Olho bloqueado de vizu senha">-->
            </div>

            <input class="submit-button" type="submit" name="editar" value="Salvar Alterações">
        </form>
    </main>

    <footer class="flex-row-space-between">
        <!-- -->
    </footer>

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

        let booleanCurrentSenha = 0; // Variável booleana para verificar se a senha está ou não visível
        let campoCurrentSenha = document.getElementById('currentPassword'); // Adicion
