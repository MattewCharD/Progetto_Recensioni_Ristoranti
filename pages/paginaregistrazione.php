<?php
    session_start();
    
    if(isset($_SESSION["errore"])){
        $err = $_SESSION["errore"];
        switch ($err) {

            //Errore registrazione inserimento
            case 'insertReg':
                $_SESSION["errore"] = "Inserimento Fallito";
                break;

            case 'missingFields':
                $_SESSION["errore"] = "Inserisci i campi!";
                break;
                
            //Errore registrazione username
            case 'userReg':
                $_SESSION["errore"] = "Username già in uso";
                break;

            //Errore registrazione email
            case 'emailError':
                $_SESSION["errore"] = "Email già in uso";
                break;

            default:
                $_SESSION["errore"] = "ERRORE SCONOSCIUTO";
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
    <title>Registrazione</title>
</head>

<body>

    <form action="../php/scriptregistrazione.php" method="post" id="myForm">
        <div class="divform">
            <div class="h1">Registrazione</div>
            <p class="paragrafo">Inserisci i dati richiesti: </p>
            <input placeholder="Nome" id="name" name="name" type="text" required>
            <input placeholder="Cognome" id="surname" name="surname" type="text" required>
            <input placeholder="Email" id="email" name="email" type="text"
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>
            <input placeholder="Username" id="username" name="username" type="text" required>
            <input placeholder="Password" id="password" name="password" type="password" pattern="^.{8,}$" required>
            <input value="Sign Up" class="btn" type="submit">
            <span class="span">Already have an account? <a href="./paginalogin.php">Sign in here</a></span>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
                if(isset($_SESSION["errore"])) {                    
                    echo "alert('".$_SESSION["errore"]."');";
                    unset($_SESSION["errore"]);
                }
            ?>
        });
    </script>
</body>

</html>