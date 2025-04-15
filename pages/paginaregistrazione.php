<?php
    session_start();
    
    if(isset($_SESSION["errore"])){
        $err = $_SESSION["errore"];
        switch ($err) {

            //Errore registrazione inserimento
            case 'insertReg':
                echo "<h3 style='color: red;'> Inserimento Fallito</h3>";
                session_unset($_SESSION["errore"]);
                break;

            //Errore registrazione username
            case 'userReg':
                echo "<h3 style='color: red;'> Username già in uso</h3>";
                session_unset($_SESSION["errore"]);
                break;

            //Errore registrazione email
            case 'emailError':
                echo "<h3 style='color: red;'> Email già in uso</h3>";
                session_unset($_SESSION["errore"]);
                break;

            default:
                echo "<h3 style='color: red;'> ERRORE SCONOSCIUTO</h3>";
                session_unset($_SESSION["errore"]);
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
            <span class="span">Already have an account? <a href="./paginalogin.html">Sign in here</a></span>
        </div>

    </form>

</body>

</html>