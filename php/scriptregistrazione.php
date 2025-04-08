<?php
        include("connessione.php");
        session_start();

        if($_POST["username"]!="" && $_POST["password"]!="" && $_POST["name"]!="" && $_POST["surname"]!="" && $_POST["email"]!=""){
            $username = $_POST["username"];
            $passwordHash = hash("sha256", $_POST["password"];);             
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            
        }    else {
            header('Location: ../pages/paginaregistrazione.html');
            
        }

        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];

        
    

        

        // $qr = "INSERT INTO `utente` ( `username`, `password`, `nome`, `cognome`, `email`, `dataregistrazione`) VALUES ( '".$username."', '".."', '".."', '".."', '".."', current_timestamp());";
        // $result = $conn->query($qr);
        // if($result->num_rows > 0){
        //     $qr2 = "select * from utente u where u.username = '".$_SESSION["username"]."' and u.password = '". $_SESSION["password"] ."';";
        //     $result = $conn->query($qr2);
        //     if($result->num_rows > 0){
        //         $_SESSION["login"] = true; 
        //         header('Location: ./benvenuto.php');
        //     } else {
        //         $_SESSION["errore"] = "passwordError";
        //         header('Location: ./errore_loginreg.php');
        //     }
        // } else {
        //     $_SESSION["errore"] = "usernameError";
        //     header('Location: ./errore_loginreg.php');
        // }
    ?>