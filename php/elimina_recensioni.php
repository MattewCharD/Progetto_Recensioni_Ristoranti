<?php
        include("connessione.php");
        session_start();

        if(!(isset( $_SESSION["username"]) and isset($_SESSION["password"]) and isset($_SESSION["login"]))){  
        $_SESSION["errore"] = "sessionError";
        header('Location: ../pages/paginalogin.php');
        exit();
        } 

        $codice = $_POST["codice"];
        

        $qr = "Delete";
        
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