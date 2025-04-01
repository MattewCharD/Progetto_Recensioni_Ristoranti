<?php
        include("connessione.php");

        $_SESSION["username"] = $_POST["username"];


        if($_POST["username"]!="" && $_POST["password"]!=""){
            $username = $_POST["username"];
            $password = $_POST["password"];
            
        }    else {
            header('Location: ../pages/paginalogin.html');
            
        }

        $qr = "SELECT * FROM UTENTI u where"









        // // Calcolo del numero massimo degli attori
        // $sql= "SELECT COUNT(*) AS totalAttori from attori";
        // $result = $conn->query($sql);
        // $row = $result->fetch_assoc();
        // $numMaxAttori = $row["totalAttori"];

        // // Controlli
        // $numAttori = $_GET["num"];      //risultato della form
        // if (!(isset($numAttori))) {
        //     echo "errore";
        // } elseif ($numAttori < 1) {
        //     echo "Nessun attore selezionato";
        // } elseif ($numAttori > $numMaxAttori) {
        //     echo  "Il numero fornito è maggiore rispetto al numero totale degli attori. Saranno mostrati solo {$numMaxAttori} attori";
        //     $numAttori = $numMaxAttori;
        
        // //Query attore
        // } else {
        //     $query = "SELECT * FROM attori a ORDER BY a.Nome LIMIT $numAttori";
        //     $result = $conn->query($query);
        //     $i=1;
        //     while($row = $result->fetch_assoc()){
        //         echo "<h3>Attore ".$i."</h3>";
        //         echo "CodAttore: ".$row["CodAttore"].", Nome: ".$row["Nome"]."<br>";
        //         $i++;
            
        //         $CodAttore = $row["CodAttore"];

        //         //query numero film in cui ha recitato
            
        //         $sql2 = "SELECT Count(*) FROM recita 
        //                 JOIN attori ON attori.CodAttore = recita.CodAttore
        //                 JOIN film ON film.CodFilm = recita.CodFilm
        //                 WHERE attori.CodAttore = $CodAttore";
        //         $result2 = $conn->query($sql2);

        //         while ($row2 = $result2->fetch_assoc()) {
        //             echo "L'attore ha recitato in " . $row2["Count(*)"] . " film.<br>"; 
        //             //query film in cui ha recitato
        //             $sql3 = "SELECT f.* FROM film f
        //                     JOIN recita r 
        //                     ON r.CodFilm = f.CodFilm
        //                     JOIN attori a 
        //                     on a.CodAttore = r.CodAttore
        //                     WHERE a.CodAttore = $CodAttore;";                          
        //             $result3 = $conn->query($sql3);
        //             while ($row3 = $result3->fetch_assoc()) {
        //                 echo "CodFilm: " . $row3["CodFilm"] . ", Titolo: " . $row3["Titolo"] . ", AnnoProduzione: " . $row3["AnnoProduzione"] . "<br>"; 
        //             }
        //         }

                
        //     }
    
        // }
    ?>