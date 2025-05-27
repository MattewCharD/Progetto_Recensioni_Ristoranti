<?php
        include("connessione.php");
        session_start();

        if(isset($_SESSION["login"])){  
        $_SESSION["errore"] = "alrdlog";
        header('Location: ./benvenuto.php');
        exit();
        } 

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
            
            if($conn->query($qr2)->num_rows > 0){  

            /*---------------Controllo admin-------------*/ 


                $_SESSION["username"] = $username;
                $_SESSION["login"] = true; 

                $sql = "SELECT u.admin FROM `utente` u WHERE u.username = '$username';";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $admin = $row["admin"];

                if ($admin== 1) {

                    
                    $_SESSION["admin"] = true;
                    header('Location: ./pannelloAdmin.php');
                    exit();

                } else {

                    $_SESSION["username"] = $username;
                    $_SESSION["login"] = true; 
                    header('Location: ./benvenuto.php');
                    exit();
                }

            } else {
                $_SESSION["errore"] = "passwordError";
                header('Location: ../pages/paginalogin.php');
            }
        } else {
            $_SESSION["errore"] = "usernameError";
            header('Location: ../pages/paginalogin.php');
        }
    ?>

