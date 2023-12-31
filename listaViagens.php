<?php
use Vtiful\Kernel\Format;
    date_default_timezone_set('America/Sao_Paulo');
    include("connection.php");

    $usuId = $_GET['id'];
    $usuIdDec = base64_decode($usuId);
    $dataHoraAtual = date('Y-m-d H:i:s');
    $dataApenas = date('d/m/Y');
    $data30Atras = (new DateTime($dataHoraAtual))->sub(new DateInterval('P30D'))->format('Y-m-d H:i:s');
    $apenasData30Atras = (new DateTime($dataHoraAtual))->sub(new DateInterval('P30D'))->format('d/m/Y');

    // Puxar dados do usuário:
    
        $StringUserSql = "SELECT * FROM Usuarios WHERE id=$usuIdDec";
        $exeUserSql = $conectar->query($StringUserSql);
        $loadUserInfos = $exeUserSql->fetch_object();

    // Puxar dados das viagems:

        $searchMetricsQuery = "SELECT * FROM Viagens WHERE usu_id = $usuIdDec AND data_cadastro > '$data30Atras' ORDER BY data_cadastro DESC";
        $exeQuery = $conectar->query($searchMetricsQuery);
        $qntResults = $exeQuery->num_rows;

        $gastos = 0;
        $ganhos = 0;
        $viagensTotais = 0;
        $KmMes = 0;
        //$dataKm = [];
        //$dataGastos = [];
        $contador = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DerickCarvalho/DkStrap@main/DkStrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/listaViagem.css">
    <link rel="icon" href="./assets/img/logo.png">
    <title>Let's Go Trip - Home</title>
</head>
<body>
    <header class="flex-row-space-between">
        <img class="logo-img" id="logo" src="./assets/img/logo.png" alt="">
        <div class="flex-row-space-between">
            <a href="./addViagem.php?id=<?php print $usuId ?>" class="header-button">+Viagem</a>
            <div class="profile-infos flex-row-space-between">
                <p><?php print $loadUserInfos->Nome ?></p>
                <img src="<?php print $loadUserInfos->URL_Perfil ?>" alt="">
            </div>
        </div>
    </header>

    <main class="flex-column-center">
        <div class="tabela flex-column-center">

            <h1>Mostrando viagens de <?php print $apenasData30Atras ?> - <?php print $dataApenas ?></h1>

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Partida</th>
                    <th scope="col"></th>
                    <th scope="col">Destino</th>                    
                    <th scope="col">Distância</th>
                    <th scope="col">Gastos</th>
                    <?php
                        if ($loadUserInfos->fretista != 0) {
                            print "<th scope=\"col\">Ganhos</th>";
                        }
                    ?>
                    <th style="text-align: center;" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <th scope="row">01/01/2000</th>
                        <td>Mossoró</td>
                        <td>Fortaleza</td>
                        <td>400 kM</td>
                        <td>R$ 150,00</td>
                        <td>R$ 150,00</td>
                        <td>
                            <div class="flex-row-center btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary">Editar</button>
                                <button type="button" class="btn btn-danger">Excluir</button>
                            </div>
                        </td>
                    </tr> -->

                    <?php
                        if ($exeQuery->num_rows != 0) {
                            while ($loadResults = $exeQuery->fetch_object()) {

                                // Criptografando o ID da viagem:
                                
                                $viagemId = base64_encode($loadResults->id);
    
                                // Fazendo o carregamento e somando as métricas finais:
    
                                $gastos += $loadResults->gastos;
                                $KmMes += $loadResults->distancia;
                                $ganhos += $loadResults->ganhos;

                                // Convertendo data e hora:

                                $dataFormatada =  date('d/m/Y - H:i:s', strtotime($loadResults->data_cadastro) - (3 * 60 * 60));
    
                                // Montando a tabela:
    
                                if ($loadUserInfos->fretista == 0) {
                                    print "<tr>";
                                    print "    <th scope=\"row\">$dataFormatada</th>";
                                    print "    <td>$loadResults->partida</td>";
                                    print "    <td>-></td>";
                                    print "    <td>$loadResults->destino</td>";
                                    print    "<td>$loadResults->distancia kM</td>";
                                    print    "<td>R$ $loadResults->gastos</td>";
                                    print    "<td>";
                                    print        "<div class=\"flex-row-center btn-group\" role=\"group\" aria-label=\"Basic example\">";
                                    print            "<a href=\"./editViagem.php?viagemid=$viagemId&usuid=$usuId\" class=\"btn btn-primary\">Editar</a>";
                                    print            "<button type=\"button\" onclick=\"remove('$viagemId', '$usuId')\" class=\"btn btn-danger\">Excluir</button>";
                                    print        "</div>";
                                    print    "</td>";
                                    print "</tr>";
                                } else {
                                    print "<tr>";
                                    print "    <th scope=\"row\">$dataFormatada</th>";
                                    print "    <td>$loadResults->partida</td>";
                                    print "    <td>-></td>";
                                    print "    <td>$loadResults->destino</td>";
                                    print    "<td>$loadResults->distancia kM</td>";
                                    print    "<td>R$ $loadResults->gastos</td>";
                                    print    "<td>R$ $loadResults->ganhos</td>";
                                    print    "<td>";
                                    print        "<div class=\"flex-row-center btn-group\" role=\"group\" aria-label=\"Basic example\">";
                                    print            "<a href=\"./editViagem.php?viagemid=$viagemId&usuid=$usuId\" class=\"btn btn-primary\">Editar</a>";
                                    print            "<button type=\"button\" onclick=\"remove('$viagemId', '$usuId')\" class=\"btn btn-danger\">Excluir</button>";
                                    print        "</div>";
                                    print    "</td>";
                                    print "</tr>";
                                }
                            }
                        } else {
                            print "<h1>Você ainda não adicionou viagens!</h1>";
                        }
                    ?>

                     <tr class="table-success">
                        <th></th>
                        <td></td>
                        <td></td>
                        <td><strong>MÉTRICAS:</strong></td>
                        <td><strong><?php print $KmMes ?> KM</strong></td>
                        <td><strong>R$ <?php print $gastos ?></strong></td>
                        <?php
                            if ($loadUserInfos->fretista != 0) {
                                print "<td><strong>R$ $ganhos</strong></td>";
                            }
                        ?>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
            window.location.href = "./index.php?id=<?php print $usuId ?>";
        })

    // Funcionalidade redirecionamento para editar perfil
    
        document.querySelector('.profile-infos').addEventListener('click', () => {
                window.location.href = './editPerfil.php?id=<?php print $usuId ?>';
            });
    
    // Funcionalidade excluir viagem:

            function remove(viagemId, usuId) {
                let confirmacao = confirm("Deseja realmente excluir essa viagem?");

                if (confirmacao == true) {
                    window.location.href = `./excluirViagem.php?viagemid=${viagemId}&usuid=${usuId}`;
                }
            }
    
    </script>
</body>
</html>