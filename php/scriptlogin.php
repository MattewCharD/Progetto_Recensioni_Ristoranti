<?php
        include("connessione.php");
        session_start();

        if($_POST["username"]!="" && $_POST["password"]!=""){
            $username = $_POST["username"];
            $passwordHash = hash("sha256", $_POST["password"]);  
            
         } else {
            header('Location: ../pages/paginalogin.php');
            
         }  
        $_SESSION["password"] = $passwordHash;

        $qr = "SELECT * FROM UTENTE u where u.username = '".$username."';";
        
        if($conn->query($qr)->num_rows > 0){
            $qr2 = "SELECT * from utente u where u.username = '".$username."' and u.password = '".$passwordHash."';";
            
            if($conn->query($qr2)->num_rows != 0){  
                

                $_SESSION["username"] = $username;
                
                $_SESSION["login"] = true; 
                header('Location: ./benvenuto.php');

            } else {
                $_SESSION["errore"] = "passwordError";
                header('Location: ../pages/paginalogin.php');
            }
        } else {
            $_SESSION["errore"] = "usernameError";
            header('Location: ../pages/paginalogin.php');
        }
    ?>

