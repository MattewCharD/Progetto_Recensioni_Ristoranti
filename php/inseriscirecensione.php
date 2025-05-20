<?php
    session_start();
    include("connessione.php");

    if(isset($_SESSION["login"])){  
        $_SESSION["errore"] = "alrdlog";
        header('Location: ./benvenuto.php');
        exit();
    } 

    $id = $_SESSION['id']; 

    $id_ristorante = $_POST['ristorante'];
    $voto = intval($_POST['voto']);
    $qr = "SELECT * FROM recensione re WHERE re.idutente = '$id' AND re.codiceristorante = '$id_ristorante'";
    $result = $conn->query($qr);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        $_SESSION["errore"] = 'insRecen';
    } else {
        $qr = "INSERT INTO recensione (voto, idutente, codiceristorante) VALUES (".$voto.",". $id.",'".$id_ristorante."')";
        echo $qr;
        $result = $conn->query($qr);
        if ($result) {
            $_SESSION["errore"] = 'success';
            $_SESSION['esito_recensione'] === true;
        } else {
            $_SESSION["errore"] = 'insRecErr';
        }
    }
    header("Location: ./benvenuto.php");
    exit;
?>