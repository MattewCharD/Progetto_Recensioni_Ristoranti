<?php
        include("connessione.php");
        session_start();

        if($_POST["username"]!="" && $_POST["password"]!=""){
            $username = $_POST["username"];
            $passwordHash = hash("sha256", $_POST["password"]);    
            
        }    else {
            header('Location: ../pages/paginalogin.php');
            
        }  
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $passwordHash;

        $qr = "SELECT * FROM UTENTE u where u.username = '". $_SESSION["username"]."';";
        $result = $conn->query($qr);
        if($result->num_rows > 0){
            $qr2 = "select * from utente u where u.username = '".$_SESSION["username"]."' and u.password = '". $_SESSION["password"] ."';";
            $result = $conn->query($qr2);
            if($result->num_rows > 0){
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