<?php
include("connection.php");

// Verifique a lógica de verificação de sessão aqui, se necessário

if (isset($_POST['editar'])) {
    $idUsuario = $_SESSION['id_usuario']; 
    $usuario = $_POST['username'];
    $senhaPrimaria = $_POST['password'];
    $confirmarSenha = $_POST['confirmPassword'];
    $nomeUsuario = $usuario;
    $URL_Perfil = "https://www.freeiconspng.com/uploads/am-a-19-year-old-multimedia-artist-student-from-manila--21.png";

    if ($senhaPrimaria == $confirmarSenha) {
        $senha = base64_encode($senhaPrimaria);

        // Query de atualização de usuário:
        $queryUpdate = "UPDATE Usuarios SET Usuario='$usuario', Nome='$nomeUsuario', URL_Perfil='$URL_Perfil', Senha='$senha' WHERE ID_Usuario=$idUsuario";

        // Executando a query de atualização:
        $conectar->query($queryUpdate);

        if ($conectar == true) {
            print "<script>alert('Perfil atualizado com sucesso!');</script>";
            // Redirecionar para a página de perfil após a edição
            print "<script>location.href='./index.php';</script>";
        } else {
            print "<script>alert('ERRO AO ATUALIZAR O PERFIL!');</script>";
        }
    } else {
        print "<script>alert('As senhas não correspondem!');</script>";
    }
}

// Obtenha as informações do usuário para pré-preencher o formulário
$idUsuario = $_SESSION['id_usuario'];
$querySelect = "SELECT Usuario, Nome FROM Usuarios WHERE ID_Usuario=$idUsuario";
$resultado = $conectar->query($querySelect);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $usuarioAtual = $row['Usuario'];
        $nomeAtual = $row['Nome'];
    }
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
                <input type="password" name="password" id="password" placeholder="Nova Senha">
                <img id="view_password" src="./assets/img/view_off.png" alt="Olho bloqueado de vizu senha">
            </div>

            <div class="fake-input flex-row-center">
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmar Nova Senha">
                <img id="view_confirmPassword" src="./assets/img/view_off.png" alt="Olho desbloqueado de vizu senha">
            </div>

            <input class="submit-button" type="submit" name="editar" value="Editar Perfil">
        </form>
    </main>

    <footer class="flex-row-space-between">
        <!-- -->
    </footer>

    <script>
        // 
    </script>
</body>

</html>
