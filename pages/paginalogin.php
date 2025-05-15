<?php
    session_start();
    if(isset($_SESSION["errore"])){
        $err = $_SESSION["errore"];
        
        switch ($err) {

            //Errore login username
            case 'usernameError':
                echo "<h3 class='errore'> Username errato o non esiste.</h3>";
                unset($_SESSION["errore"]);
                break;

            //Errore login passsword
            case 'passwordError':
                echo "<h3 style='color: red;'> Password Errata.</h3>";
                unset($_SESSION["errore"]);
                break;

            default:
                echo "<h3 style='color: red;'> ERRORE SCONOSCIUTO</h3>";
                unset($_SESSION["errore"]);
                break;
        }
        $ee=$_SESSION["password"];
        var_dump($err);
        var_dump($ee);
        
    }
        
        // sistema utenti sul db non ashati --> password: cognome1234
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
    <form action="../php/scriptlogin.php" method="post" id="myForm">
        <div class="divform   ">
            <div class="h1">Login</div>
            <input placeholder="Username" id="user" name="username" type="text" required>
            <input placeholder="Password" id="password" name="password" type="password" pattern="^.{8,}$" required>
            <input value="Login" class="btn" type="submit">
            <span class="span">Don't have an account? <a href="./paginaregistrazione.php">Sign up</a></span>
        </div>

    </form>



    

</body>

</html>