<?php

    if(!(isset( $_SESSION["username"]) and isset($_SESSION["password"]))){
          
        header('Location: ../pages/paginalogin.php');
        
    } 

    session_start();
    session_unset();
    session_destroy();

    header('Location: ../pages/paginalogin.php');
?>