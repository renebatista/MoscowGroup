<?php
use Vtiful\Kernel\Format;
    date_default_timezone_set('America/Sao_Paulo');
    include("connection.php");

    $usuId = $_GET['id'];
    $usuIdDec = base64_decode($usuId);
    $dataHoraAtual = date('Y-m-d H:i:s');
    $data30Atras = (new DateTime($dataHoraAtual))->sub(new DateInterval('P30D'))->format('Y-m-d H:i:s');

    // $SqlData = "SELECT DATE_SUB(data_cadastro , INTERVAL 30 DAY) AS data_30_dias_passado FROM Viagens;";
    // $exeQueryData = $conectar->query($SqlData);
    // $resQueryData = $exeQueryData->fetch_object();
    // $dataLimite = $resQueryData->data_30_dias_passado;

    // Puxar dados do usuário:
    
        $StringUserSql = "SELECT * FROM Usuarios WHERE id=$usuIdDec";
        $exeUserSql = $conectar->query($StringUserSql);
        $loadUserInfos = $exeUserSql->fetch_object();

    // Puxar dados das viagems:

        $searchMetricsQuery = "SELECT * FROM Viagens WHERE usu_id = $usuIdDec AND data_cadastro > '$data30Atras'";
        $exeQuery = $conectar->query($searchMetricsQuery);
        $qntResults = $exeQuery->num_rows;
        //$loadQueryRes = $exeQuery->fetch_object();
        $gastos = 0;
        $ganhos = 0;
        $viagensTotais = 0;
        $KmMes = 0;
        $dataKm = [];
        $dataGastos = [];
        $contador = 0;

        while ($loadResults = $exeQuery->fetch_object()) {
            $gastos += $loadResults->gastos;
            $KmMes += $loadResults->distancia;
            $ganhos += $loadResults->ganhos;
            $dataKm[$contador] = $loadResults->distancia;
            $dataGastos[$contador] = $loadResults->gastos;
            $contador++;
        }

        $arrayKmLength = count($dataKm);
        $arrayGastosLength = count($dataGastos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DerickCarvalho/DkStrap@main/DkStrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/home.css">
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

    <main>
        <section class="metrics-section flex-row-center">
            <div class="flex-column-center">
                <div class="metric flex-column-center">
                    <h1>Viagens do Mês</h1>
                    <h1><strong><?php print $qntResults ?></strong></h1>
                </div>
    
                <div class="metric flex-column-center">
                    <h1>KM Rodados no Mês</h1>
                    <h1><strong><?php print "$KmMes KMs" ?></strong></h1>
                </div>
            </div>

            <div class="flex-column-center">
                <div class="metric flex-column-center">
                    <h1>Gastos Totais</h1>
                    <h1><strong><?php print "R$ $gastos"; ?></strong></h1>
                </div>
    
                <?php
                    if ($loadUserInfos->fretista != 0) {
                        print "<div class=\"metric flex-column-center\">";
                        print "    <h1>Ganho Total</h1>";
                        print "    <h1><strong><?php print \"R$ $ganhos\" ?></strong></h1>";
                        print "</div>";
                    }
                ?>
            </div>
        </section>

        <section class="flex-column-center">
            <h1>Métricas</h1>
            <div class="metrics-graph flex-row-center">
                <div>
                    <canvas id="KmRodado"></canvas>
                </div>
    
                <div>
                    <canvas id="Gastos"></canvas>
                </div>
            </div>            
        </section>
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

        var elements = document.getElementById('logo');

    // Funcionalidade das divs de metricas

        var elements = document.querySelectorAll('.metric');
        elements.forEach(function(element){
            element.addEventListener('click', () => {
            window.location.href = './listaViagens.php?id=<?php print $usuId ?>';
            })        
        });

    // Funcionalidade redirecionamento para editar perfil
    
    document.querySelector('.profile-infos').addEventListener('click', () => {
            window.location.href = './editPerfil.php?id=<?php print $usuId ?>';
        });

    // Funcionalidade Graficos
    
        var limiteMeses = <?php print $qntResults ?>;

        var meses = [];

        for (let i = 0; i < limiteMeses; i++) {
            meses[i] = i+1;
        }   

        var dataKm = [];
        
        // Seguir a mesma lógica para gastos

        <?php
            for ($index = 0; $index < $arrayKmLength; $index++) {
                $TempKm = $dataKm[$index];
                print "dataKm[$index] = $TempKm;";
            }
        ?>;

        // KM RODADO

        var graphic1 = document.getElementById('KmRodado').getContext('2d');
        var myGraphic1 = new Chart(graphic1, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                label: 'KMs Rodados',
                data: dataKm,
                borderColor: '#52dcff',
                backgroundColor: '#0000FF',
                borderWidth: 8
                }]
            },
            options: {
                scales: {
                x: {
                    display: true,
                    title: {
                    display: true,
                    text: 'Viagens'
                    }
                },
                y: {
                    display: true,
                    title: {
                    display: true,
                    text: 'KM Rodado'
                    }
                }
                }
            }
        });

        // GASTOS
        
        // Seguir a mesma lógica para gastos

        var dataGastos = [];

        <?php
            for ($index = 0; $index < $arrayGastosLength; $index++) {
                $TempGastos = $dataGastos[$index];
                print "dataGastos[$index] = $TempGastos;";
            }
        ?>;

        

        var graphic2 = document.getElementById('Gastos').getContext('2d');
        var myGraphic2 = new Chart(graphic2, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                label: 'Valor Gasto',
                data: dataGastos,
                borderColor: '#81ff7d',
                backgroundColor: '#048500',
                borderWidth: 8
                }]
            },
            options: {
                scales: {
                x: {
                    display: true,
                    title: {
                    display: true,
                    text: 'Viagens'
                    }
                },
                y: {
                    display: true,
                    title: {
                    display: true,
                    text: 'Valor Gasto'
                    }
                }
                }
            }
        });
    </script>
</body>
</html>