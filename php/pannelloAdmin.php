<?php
    session_start();
    include("connessione.php");

    // per mappa 2 input text item nascosti
    if(!(isset( $_SESSION["username"]) and isset($_SESSION["password"]) and isset($_SESSION["login"]) and isset($_SESSION["admin"]))){  
        $_SESSION["errore"] = "sessionError";
        header('Location: ../pages/paginalogin.php');
        exit();
    } 

    // --------------------------------------- Errori ----------------------------------------

    if(isset($_SESSION["errore"])){
        $err = $_SESSION["errore"];
        switch ($err) {

            //Errore registrazione inserimento
            case 'sessionError':
                $_SESSION["errore"] = "Errore, sessione scaduta, riprova";
                break;
            //Errore registrazione username
            case 'insRecen':
                $_SESSION["errore"] = "Hai già fatto una recensione per questo ristorante!";
                break;

            //Inserimento recensione con successo
            case 'success':
                $_SESSION["errore"] = "Recensione inserita con successo!";
                break;

            case 'insRecErr':
                $_SESSION["errore"] = "Errore in inserimento";
                break;

            case 'alrdlog':
                $_SESSION["errore"] = "Sei già loggato! Devi prima disconnetterti.";
                break;

            default:
                $_SESSION["errore"] = "ERRORE SCONOSCIUTO";
                break;
        }
    }
    // -------------------------------- Dati Utente Loggato ----------------------------------

    $sql = "SELECT * FROM utente WHERE username = '".$_SESSION["username"]."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
         
        $nome = $row["nome"];
        $cognome = $row["cognome"];
        $email = $row["email"];
        $_SESSION["id"] = $row["id_utente"];
        $id = $_SESSION["id"];
    } else {
        $_SESSION["errore"] = "sessionError";
        header('Location: ../pages/paginalogin.php');
        exit();
    } 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    </head>

<body>
    <div class="container">
        <header>
            <?php
            echo "<h1>Benvenuto Nel pannello Admin, " .$_SESSION["username"] ."</h1><br>";
            ?>
        </header>
        <ul>
            <li> <?php echo $nome ?></li>
            <li> <?php echo $cognome ?></li>
            <li> <?php echo $email ?></li>
        </ul><br>
        <br><br>

        <!-- ------------------------------------------ Stampo ristoranti-------------------------------------------- -->
        <div>
            <?php
                $sql = "SELECT ris.nome , ris.codice, ris.indirizzo, ris.citta, COUNT(rec.id_recensione)  as numRecRis  
                        FROM `recensione`rec RIGHT join ristorante ris on rec.codiceristorante = ris.codice 
                        group by ris.nome , ris.codice, ris.indirizzo, ris.citta;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){

                    echo "<table class='table table-bordered border-primary'>
                        <tr>
                            <th>Codice</th>
                            <th>Nome Ristorante</th>
                            <th>Indirizzo</th>
                            <th>Città</th>
                            <th>Numero Recensioni</th>
                        </tr>";                      
                                
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["codice"] . "</td>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . $row["indirizzo"] . "</td>";
                        echo "<td>" . $row["citta"] . "</td>";
                        echo "<td>" . $row["numRecRis"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {

                    echo "Nessun Ristorante inserito;";
                }
            ?>
        </div>
        <br><br>
        <!-- ---------------------------------------- Inserimento Ristorante --------------------------------------- -->
        <div>
            <h2>Inserisci un nuovo ristorante</h2>
            <br><br>
            <form action="inserisciristorante.php" method="POST">

                <label>Inserisci il codice:</label>
                <input type="text" required>

                <label>Inserisci il nome:</label>
                <input type="text" required>

                <label>Inserisci l'indirizzo:</label> 
                <input type="text" required>

                <label for="ristorante" class="form-label">Seleziona la città:</label>
                <select id="ristorante" name="ristorante" required>
                    <option value="Firenze">Firenze</option>
                    <option value="Prato">Prato</option>
                    <option value="Pistoia">Pistoia</option>
                    <option value="Pisa">Pisa</option>
                    <option value="Lucca">Lucca</option>
                    <option value="Lastra a Signa">Lastra a Signa</option>
                    <option value="Livorno">Livorno</option>
                </select>
                <br>                
                <button type="submit">Conferma</button>
            </form>
        </div>

        <p id="logout_p">Effettua il logout:</p>
        <main>
            <a href="./scriptlogout.php" class="btn">Log-Out</a>
        </main><br>

        <footer>
            <p>&copy; 2025  - Tutti i diritti riservati</p>
        </footer>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>