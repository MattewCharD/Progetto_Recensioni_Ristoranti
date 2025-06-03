<?php
    session_start();
    if(isset($_SESSION["errore"])){
        $err = $_SESSION["errore"]; 

        switch ($err) {

            //Errore login username
            case 'usernameError':
                $_SESSION["errore"] = "Username errato o non esiste.";
                break;

            case 'regSucc':
                $_SESSION["errore"] = "Registrato con successo!";
                break;

            //Errore login passsword
            case 'passwordError':
                $_SESSION["errore"] = "Password Errata. ";
                break;

            case 'sessionError':
                $_SESSION["errore"] = "Non sei loggato! ";
                break;

            default:
                $_SESSION["errore"] = "ERRORE SCONOSCIUTO ";
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Login</title>
</head>

<body>
    <form action="../php/scriptlogin.php" method="POST" id="myForm">
        <div class="divform   ">
            <div class="h1">Login</div>
            <input placeholder="Username" id="user" name="username" type="text" required>
            <input placeholder="Password" id="password" name="password" type="password" pattern="^.{8,}$" required>
            <input value="Login" class="btn" type="submit">
            <span class="span">Don't have an account? <a href="./paginaregistrazione.php">Sign up</a></span>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
                if(isset($_SESSION["errore"])) {                    //funzione per alert con messaggio
                    echo "alert('".$_SESSION["errore"]."');";
                    unset($_SESSION["errore"]);
                }
            ?>
        });
    </script>
</body>

</html>