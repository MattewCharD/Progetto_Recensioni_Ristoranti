<?php
    session_start();
    include("connessione.php");

    if(!(isset($_SESSION["login"]))){  
        $_SESSION["errore"] = "sessionError";
        header('Location: ../pages/paginalogin.php');
        exit();
    } 

    $nome_ristorante = $_POST['nome_ristorante'];

    $voto = intval($_POST['voto']);
    $id = intval($_SESSION['id']); 
    $query = "SELECT codice FROM ristorante WHERE nome = '$nome_ristorante'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $ristorante_id = $row['codice'];
    $query = "SELECT * FROM recensione WHERE idutente = '$id' AND codiceristorante = '$ristorante_id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        $_SESSION["errMessage"] = 'Recensione su questo ristorante già effettuata';
    } else {
        $query = "INSERT INTO recensione (voto, idutente, codiceristorante) VALUES ($voto, $id, '$ristorante_id')";
        if ($conn->query($query) === TRUE) {
            $_SESSION["errMessage"] = 'Recensione inserita con successo';
        } else {
            $_SESSION["errMessage"] = 'errore';
        }
    }
    header("Location: benvenuto.php");
    exit;
?>