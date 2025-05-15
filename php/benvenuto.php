<?php
    session_start();
    include("connessione.php");

    if(!(isset( $_SESSION["username"]) and isset($_SESSION["password"]) and isset($_SESSION["login"]))){
          
        header('Location: ../pages/paginalogin.php');
        
    } 
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
        echo "<p class='text-danger'>Utente non trovato.</p>";
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
        
        
        <p>Numero recensioni effetuate:</p>
         <?php
            $sql = "SELECT COUNT(*) as numRecensioni FROM `recensione` WHERE idutente = $id;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $numRecensioni = $row["numRecensioni"];
            echo $numRecensioni;
        ?><br><br>
        <div>
            <?php
                if ($numRecensioni > 0) {
                    $sql = "SELECT ris.nome, ris.indirizzo, rec.voto, rec.data FROM `recensione` rec JOIN ristorante ris ON rec.codiceristorante = ris.codice JOIN utente u ON rec.idutente = u.id WHERE u.id = $id;";
                        $result = $conn->query($sql);
                        echo "<table class='table table-bordered border-primary'>
                            <thead>
                                <tr>
                                    <th scope='col'>Nome Ristorante</th>
                                    <th scope='col'>Indirizzo</th>
                                    <th scope='col'>Voto</th>
                                    <th scope='col'>Data</th>
                                </tr>
                            </thead>
                            <tbody>";
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["indirizzo"] . "</td>";
                                echo "<td>" . $row["voto"] . "</td>";
                                echo "<td>" . $row["data"] . "</td>";
                                echo "</tr>";
                            }
                        echo "</tbody></table>";
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
        <!-- INSERIMENTO RECENSIONE -->
        <div>
            <h2>Inserisci una nuova recensione</h2>
            <br><br>
            <form action="inseriscirecensione.php" method="POST" class="form-recensione">
                <label for="ristorante" class="form-label">Seleziona un ristorante:</label>
                <select id="ristorante" name="ristorante"  required>
                    <?php
                    $sqlRistoranti = "SELECT codice, nome FROM ristorante WHERE codice NOT IN (SELECT codiceristorante  FROM recensione WHERE idutente = $idUtente)";
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
                        <label for="voto<?= $i ?>"> <?php echo$i ?> <i class="bi bi-star"></i></label>
                    <?php endfor; ?>
                </div>
                <button type="submit">Invia Recensione</button>
            </form>
        </div>
<br><br>
        <p>Effettua il logout:</p>
        <main>
            <a href="./scriptlogout.php" class="btn">Log-Out</a>
        </main><br><br>

        <footer>
            <p>&copy; 2025  - Tutti i diritti riservati</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>