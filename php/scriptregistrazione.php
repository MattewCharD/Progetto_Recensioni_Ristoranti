<?php
        include("connessione.php");
        session_start();

        if($_POST["username"]!="" && $_POST["password"]!="" && $_POST["name"]!="" && $_POST["surname"]!="" && $_POST["email"]!=""){
            $username = $_POST["username"];
            $passwordHash = hash("sha256", $_POST["password"]);             
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            
        }    else {
            header('Location: ../pages/paginaregistrazione.php');
            
        }

        $qr1 = "SELECT * FROM `utente` u WHERE u.username = '".$username."'";
        $qr2 = "SELECT * FROM `utente` u WHERE u.email = '".$email."'";
        $qr3 = "INSERT INTO `utente` ( `username`, `password`, `nome`, `cognome`, `email`, `dataregistrazione`) VALUES ( '".$username."', '".$passwordHash."', '".$name."', '".$surname."', '".$email."', current_timestamp());";
        
        //Controllo username
        $result = $conn->query($qr1);
        if(!($result->num_rows > 0)){

            //Controllo email
            $result = $conn->query($qr2);
            if(!($result->num_rows > 0)){

                //Controllo inserimento
                if($result = $conn->query($qr3)){
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $passwordHash;
                    header('Location: ../php/benvenuto.php');
                } else {
                    $_SESSION["errore"] = "insertReg";
                    header('Location: ../pages/paginaregistrazione.php');
                }
            } else {
                $_SESSION["errore"] = "emailReg";
                header('Location: ../pages/paginaregistrazione.php');
            }
        } else {
            $_SESSION["errore"] = "userReg";
            header('Location: ../pages/paginaregistrazione.php');
        }
    ?>