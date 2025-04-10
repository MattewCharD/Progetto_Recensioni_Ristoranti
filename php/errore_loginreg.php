<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Errore</title>
</head>
<body>
    <?php
    
        $err = $_SESSION["errore"];
        
        switch ($err) {

            //Errore login username
            case 'usernameError':
                echo "<h3 class='errore'> Username errato o non esiste.</h3>";
                break;

            //Errore login passsword
            case 'passwordError':
                echo "<h3 style='color: red;'> Password Errata.</h3>";
                break;

            //Errore registrazione inserimento
            case 'insertReg':
                echo "<h3 style='color: red;'> Inserimento Fallito</h3>";
                break;

            //Errore registrazione username
            case 'userReg':
                echo "<h3 style='color: red;'> Username già in uso</h3>";
                break;

            //Errore registrazione email
            case 'emailError':
                echo "<h3 style='color: red;'> Email già in uso</h3>";
                break;

            default:
                echo "<h3 style='color: red;'> ERRORE SCONOSCIUTO</h3>";
                break;
        }
        echo "<a href='../pages/paginalogin.html'>Torna indietro</a>";
    ?>
</body>
</html>