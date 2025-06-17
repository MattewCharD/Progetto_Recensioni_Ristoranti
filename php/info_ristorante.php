<?php
    include("connessione.php");
    session_start();

    $codris = $_GET["info_nome"];
     
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" >
    <title>Info</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <link rel="stylesheet" type="text/css" href="../css/cssinfo.css">
</head>
<body>
    <p>Info ristorante: </p>
        <?php
            $qr = "Select r.nome, r.indirizzo, r.citta from ristorante r where r.codice = '".$codris."';";
            $result = $conn->query($qr);
            $row = $result->fetch_assoc();
            echo "<span> Nome: " . $row["nome"] . "</span>";
            echo "<span> Indirizzo: " . $row["indirizzo"] . "</span>";
            echo "<span> Città: " . $row["citta"] . "</span>";   
        ?>
    </table>

    <p>Recensioni: </p>
    <?php

        $qr = "Select rec.data, rec.voto, u.username, ris.indirizzo, u.nome from recensione rec join utente u on u.id_utente = rec.idutente join ristorante ris on ris.codice = rec.codiceristorante where rec.codiceristorante = '".$codris."' ;";
        $result = $conn->query($qr);
        if ($result->num_rows > 0) {
            echo "<table>
                <tr>
                    <th>Username</th>
                    <th>Voto</th>
                    <th>Data</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nome"] . "</td>
                    <td>" . $row["voto"] . "</td>
                    <td>" . $row["data"] . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "nessuna recensione presente";
        }

    ?>


<!-- Mappa -->
        
<div id="map" style="height: 550px; border: 1px solid #ccc;"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const defaultLat = 41.8719;
            const defaultLng = 12.5674;
            const map = L.map('map').setView([defaultLat, defaultLng], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            let marker = null;
            map.on('click', function (e) {
                const lat = e.latlng.lat.toFixed(6);
                const lng = e.latlng.lng.toFixed(6);
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup("Posizione selezionata: " + lat + ", " + lng)
                    .openPopup();
                document.getElementById('latitudine').value = lat;
                document.getElementById('longitudine').value = lng;
            });
        });
    </script>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
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
    <br><br>
    <a href="./benvenuto.php"><button>Torna Indietro</button></a>
</body>

</html>