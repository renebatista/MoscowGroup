<?php
    include("connection.php");

    // ID Usuário:

    $usuId = $_GET["usuid"];
    $usuIdDec = base64_decode($usuId);

    // ID Viagem:

    $tripId = $_GET["viagemid"];
    $tripIdDecode = base64_decode($tripId);

    // Excluindo Viagem:
    
        $deletSql = "DELETE FROM Viagens WHERE id=$tripIdDecode";
         try {
            $exeDelet = $conectar->query($deletSql);
            sleep(1);
            print "<script>window.location.href = './listaViagens.php?id=$usuId'</script>";
         } catch (\Throwable $th) {
            print "<script>";
            print "    alert('Erro ao excluir viagem, tente novamente mais tarde!');";
            print "    window.location.href = './listaViagens.php?id=$usuId'";
            print "</script>";
         }
?>