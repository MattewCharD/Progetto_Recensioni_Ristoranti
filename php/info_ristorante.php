<?php
    include("connessione.php");
    session_start();

    $codris = $_GET["info_nome"];
    $qr = "Select r.nome, r.indirizzo, r.citta from ristorante r where r.codice = ".$codris.";"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" >
    <title>Info</title>
</head>
<body>
    <p>Info ristorante: </p>
        <?php
            $result = $conn->query($qr);
            $row = $result->fetch_assoc();
            echo "<span>Nome: " . $row["nome"] . "</span>";
            echo "<span>Indirizzo: " . $row["indirizzo"] . "</span>";
            echo "<span>Città: " . $row["citta"] . "</span>";   
        ?>
    </table>

    <p>Recensioni: </p>
    <?php

        $qr = "Select rec.data, rec.voto from recensione rec where codiceristorante = ".$codris." ;";
        $result = $conn->query($qr);
        if ($result->num_rows > 0) {
            echo "<table>
                <tr>
                    <th>Nome Ristorante</th>
                    <th>Indirizzo</th>
                    <th>Voto</th>
                    <th>Data</th>
                </tr>";
            while ($row = $resultRistoranti->fetch_assoc()) {
                echo "<tr>
                    <td><input type='checkbox' name='select'></td>
                    <td>" . $row["idutente"] . "</td>
                    <td>" . $row["indirizzo"] . "</td>
                    <td>" . $row["voto"] . "</td>
                    <td>" . $row["data"] . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {

        }

    ?>
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