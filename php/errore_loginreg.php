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
            case 'usernameError':
                echo "<h3 class='errore'> Username errato o non esiste.</h3>";
                break;
            case 'passwordError':
                echo "<h3 style='color: red;'> password errata.</h3>";
                break;
            default:
                echo "<h3 style='color: red;'> ERRORE SCONOSCIUTO</h3>";
                break;
        }
    ?>
</body>
</html>