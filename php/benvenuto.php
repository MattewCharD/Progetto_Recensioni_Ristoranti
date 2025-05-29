<?php
    session_start();
    include("connessione.php");

    // per mappa 2 input text item nascosti
    if(!(isset( $_SESSION["username"]) and isset($_SESSION["password"]) and isset($_SESSION["login"]))){  
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

            case 'noAdmin' : 
                $_SESSION["errore"] = "Non sei admin!";
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
    <link rel="stylesheet" type="text/css" href="../css/styleHome.css">
    </head>

<body>
    <div class="container">
        <header>
            <?php
            echo "<h1>Benvenuto " .$_SESSION["username"] ."</h1><br>";
            ?>
        </header>
        <ul>
            <li> <?php echo $nome ?></li>
            <li> <?php echo $cognome ?></li>
            <li> <?php echo $email ?></li>
        </ul><br>
        
        <span>Numero recensioni effetuate: </span>
        <?php
            $sql = "SELECT COUNT(*) as numRecensioni FROM `recensione` WHERE idutente = $id;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $numRecensioni = $row["numRecensioni"];
            echo $numRecensioni;
        ?>
        <br><br>

        <!-- ------------------------------------------ Stampo recensioni -------------------------------------------- -->
        <div>
            <?php
                if ($numRecensioni > 0) {
                    $sql = "SELECT ris.nome, ris.indirizzo, rec.voto, rec.data FROM `recensione` rec JOIN ristorante ris ON rec.codiceristorante = ris.codice JOIN utente u ON rec.idutente = u.id_utente WHERE u.id_utente = $id;";
                        $result = $conn->query($sql);
                        echo "<table class='table table-bordered border-primary'>
                            
                                <tr>
                                    <th>Nome Ristorante</th>
                                    <th>Indirizzo</th>
                                    <th>Voto</th>
                                    <th>Data</th>
                                </tr>";
                            
                            
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["indirizzo"] . "</td>";
                                echo "<td>" . $row["voto"] . "</td>";
                                echo "<td>" . $row["data"] . "</td>";
                                echo "</tr>";
                            }
                        echo "</table>";
                } else {
                    echo "<p class='text-warning'>Nessuna recensione effettuata.</p>";
                }

                if (isset($_SESSION['esito_recensione'])) {
                    if ($_SESSION['esito_recensione'] === true) {
                        echo "<p class='alert alert-success'>Recensione inserita con successo</p>";
                    } else {
                        echo "<p class='alert alert-danger'>Impossibile aggiungere la recensione</p>";
                    }
                    unset($_SESSION['esito_recensione']);
                }
            ?>
        </div>
        <br><br>

        <!-- ---------------------------------------- Vedi info ristoranti --------------------------------------- -->
        <div>
            <h2>Info ristoranti</h2>
            <br><br>
            <form action="info_ristorante.php" method="GET">
                <select id="ristorante" name="ristorante" required>
                    <?php
                    $sqlRistoranti = "SELECT r.codice, r.nome FROM ristorante r";
                    $resultRistoranti = $conn->query($sqlRistoranti);
                    if ($resultRistoranti->num_rows > 0) {
                        while ($row = $resultRistoranti->fetch_assoc()) {
                            echo "<option value='" .$row['codice'] . "'>" . $row['nome'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>Nessun ristorante disponibile</option>";
                    }
                    ?>
                </select>
                
                <button type="submit">Vedi</button>
            </form>
        </div>
<br><br>
        <!-- ---------------------------------------- Inserimento Recensione --------------------------------------- -->
        <div>
            <h2>Inserisci una nuova recensione</h2>
            <br><br>
            <form action="inseriscirecensione.php" method="POST">
                <label for="ristorante" class="form-label">Seleziona un ristorante:</label>
                <select id="ristorante" name="ristorante" required>
                    <?php
                    $sqlRistoranti = "SELECT r.codice, r.nome FROM ristorante r WHERE r.codice NOT IN (SELECT re.codiceristorante  FROM recensione re WHERE idutente = $id)";
                    $resultRistoranti = $conn->query($sqlRistoranti);
                    if ($resultRistoranti->num_rows > 0) {
                        while ($rowRistorante = $resultRistoranti->fetch_assoc()) {
                            echo "<option value='" .$rowRistorante['codice'] . "'>" . $rowRistorante['nome'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>Nessun ristorante disponibile</option>";
                    }
                    ?>
                </select>
                <br>
                <label>Seleziona il voto:</label>
                <div>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" id="voto<?= $i ?>" name="voto" value="<?= $i ?>" required>
                        <label for="voto<?= $i ?>"> <?php echo$i ?> <i class=" bi-star"></i></label>
                    <?php endfor; ?>
                </div>
                <button type="submit">Invia Recensione</button>
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