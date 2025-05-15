<?php
    session_start();

    if(!(isset( $_SESSION["username"]) and isset($_SESSION["password"]) and isset($_SESSION["login"]))){
          
        header('Location: ../pages/paginalogin.php');
        
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <?php

    echo "Benvenuto " .$_SESSION["username"] ."<br>";

    echo "Effettua il logout: <a href ='./scriptlogout.php'>Logout</a>";


    ?>
</body>

</html>