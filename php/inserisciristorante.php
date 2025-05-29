<?php
        include("connessione.php");
        session_start();

        if(!(isset($_SESSION["admin"]))){  
        $_SESSION["errore"] = "noAdmin";
        header('Location: ./benvenuto.php');
        exit();
        } 

        $codice = $_POST["codice"];
        $nome = $_POST["nome"];
        $indirizzo = $_POST["indirizzo"];
        $citta = $_POST["citta"];

        $qr = "SELECT * FROM ristorante r where r.nome = $nome and r.indirizzo = $indirizzo and r.citta = $citta";
        
        if($conn->query($qr)->num_rows > 0){

            $_SESSION["errore"] = "alrdRis";
            header('Location: ./pannelloAdmin.php');

        } else {

             $qr2 = "INSERT INTO ristorante (codice, nome, indirizzo, citta) VALUES ('$codice', '$nome', '$indirizzo', '$citta');";
            
            if($conn->query($qr2)){  

                $_SESSION["errore"] = "insRisSuc";
                header('Location: ./pannelloAdmin.php');
                exit();

            } else {

                $_SESSION["errore"] = "insRisFail";
                header('Location: ./pannelloAdmin.php');
                exit();

            }
        }
    ?>