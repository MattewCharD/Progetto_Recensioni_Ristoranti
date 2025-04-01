<?php

    session_start();
    session_unset();

    echo "Logout Effettuato <br>";
    echo "<a href='../pages/paginalogin.html'>Torna indietro</a>";
?>