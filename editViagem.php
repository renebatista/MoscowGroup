<?php
use Vtiful\Kernel\Format;
    include("connection.php");
    date_default_timezone_set('America/Sao_Paulo');

    // ID Usuário:

    $usuId = $_GET["usuid"];
    $usuIdDec = base64_decode($usuId);

    // ID Viagem:

    $tripId = $_GET["viagemid"];
    $tripIdDecode = base64_decode($tripId);

    $dataHoraAtual = date('Y-m-d H:i:s');
    $data30Atras = (new DateTime($dataHoraAtual))->sub(new DateInterval('P30D'))->format('Y-m-d H:i:s');

    // Puxar dados do usuário:

        $StringUserSql = "SELECT * FROM Usuarios WHERE id=$usuIdDec";
        $exeUserSql = $conectar->query($StringUserSql);
        $loadUserInfos = $exeUserSql->fetch_object();

    // Puxar dados das viagems:

        $searchMetricsQuery = "SELECT * FROM Viagens WHERE id = $tripIdDecode AND data_cadastro > '$data30Atras'";
        $exeQuery = $conectar->query($searchMetricsQuery);
        $qntResults = $exeQuery->num_rows;
        $loadTripResults = $exeQuery->fetch_object();

    // Adicionar viagem:

        if (isset($_POST["editViagem"])) {
            $partida = $_POST["partida"];
            $destino = $_POST["destino"];
            $distancia = floatval($_POST["distancia"]);
            $gastos = floatval($_POST["gastos"]);
            $ganhos = floatval($_POST["ganhos"]);
            $dataAntiga = $loadResults->data_cadastro;

            $sqlQuery = "UPDATE Viagens SET partida='$partida',destino='$destino',distancia=$distancia,gastos=$gastos,ganhos=$ganhos,data_cadastro=$dataAntiga
                         WHERE id=$tripIdDecode AND usu_id=$usuIdDec";

            $conectar->query($sqlQuery);

            if ($conectar == true) {
                sleep(1);
                base64_encode($usuId);
                print "<script>window.location.href = './listaViagens.php?id=$usuId'</script>";
            } else {
                print "<script>alert('Erro ao cadastrar essa viagem');</script>";
            }
        }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DerickCarvalho/DkStrap@main/DkStrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/editViagem.css">
    <link rel="icon" href="./assets/img/logo.png">
    <title>Let's Go Trip - Home</title>
</head>
<body>
    <header class="flex-row-space-between">
        <img class="logo-img" id="logo" src="./assets/img/logo.png" alt="">
        <div class="flex-row-space-between">
            <div class="profile-infos flex-row-space-between">
                <p><?php print $loadUserInfos->Nome ?></p>
                <img src="<?php print $loadUserInfos->URL_Perfil ?>" alt="">
            </div>
        </div>
    </header>

    <main class="flex-row-center">
        <form action="" class="formulario flex-column-center" method="POST">
            <div class="flex-row-space-between">
                <section style="border-right: 1px solid #000;" class="flex-column-center">
                    <h3>Dados da trajetória</h3>
                    <input type="text" name="partida" id="partida" placeholder="Partida" value="<?php print $loadTripResults->partida ?>">
                    <input type="text" name="destino" id="destino" placeholder="Destino" value="<?php print $loadTripResults->destino ?>">
                    <div style="padding: 0;" class="money-input flex-row-center">
                        <input type="number" name="distancia" id="distancia" placeholder="Distancia" min="1" step="any" value="<?php print $loadTripResults->distancia ?>">
                        <p>Km</p>
                    </div>
                </section>
    
                <section class="flex-column-center">
                    <h3>Dados financeiros</h3>
                    <div style="padding: 0;" class="money-input flex-row-center">
                        <p>R$</p>
                        <input type="number" name="gastos" id="gastos" placeholder="Gastos" step="any" value="<?php print $loadTripResults->gastos ?>">
                    </div>

                    <?php
                        if ($loadUserInfos->fretista != 0) {
                            print "<div style=\"padding: 0;\" class=\"money-input flex-row-center\">";
                            print "    <p>R$</p>";
                            print "    <input type=\"number\" name=\"ganhos\" id=\"ganhos\" placeholder=\"Ganhos\" step=\"any\" value=\"<?php print $loadTripResults->ganhos ?>\">";
                            print "</div>";
                        }
                    ?>
                </section>
            </div>
            <div class="flex-row-center">                
                <a style="color: #000; margin-right: 10px; text-decoration: none;" class="submit-button" href="./listaViagens.php?id=<?php print $usuId ?>">Voltar</a>
                <input class="submit-button" type="submit" name="editViagem" value="Salvar">
            </div>
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
        document.querySelector('.profile-infos').addEventListener('click', () => {
            window.location.href = './editPerfil.php?id=<?php print $usuId ?>';
        });

        document.getElementById('logo').addEventListener('click', () => {
            window.location.href = './index.php?id=<?php print $usuId ?>';
        });
    </script>