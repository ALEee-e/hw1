<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once 'connessione.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['azione'])) {
    header('Content-Type: application/json');

    if ($_GET['azione'] === 'ottieni_informazioni_utente') {
        $stmt = $conn->prepare("SELECT username, nome, cognome, email, data_di_nascita, comune FROM utenti WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["id_utente"]);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $utente = $result->fetch_assoc();
            echo json_encode($utente);
        } else {
            echo json_encode(["error" => "utente non trovato"]);
        }
        exit;
    }

    if ($_GET['azione'] === 'ottieni_preferiti' && isset($_GET['lista_id'])) {
        $stmt = $conn->prepare("
            SELECT 'libro' AS tipo, id, lista_id, book_id, titolo, autore, thumbnail 
            FROM libro 
            WHERE lista_id = ? 
            UNION 
            SELECT 'manga' AS tipo, id, lista_id, manga_id AS book_id, titolo, autore, thumbnail 
            FROM manga 
            WHERE lista_id = ?
        ");
        $stmt->bind_param("ss", $_GET['lista_id'], $_GET['lista_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $preferiti = [];
        while ($row = $result->fetch_assoc()) {
            $preferiti[] = $row;
        }
        echo json_encode($preferiti);
        exit;
    }

    if ($_GET['azione'] === 'ottieni_liste') {
        $stmt = $conn->prepare("SELECT * FROM liste WHERE user_id = ?");
        $stmt->bind_param("s", $_SESSION["id_utente"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $liste = [];
        while ($row = $result->fetch_assoc()) {
            $liste[] = $row;
        }
        echo json_encode($liste);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input['azione'] === 'rimuovi_preferito') {
        $stmt = $conn->prepare("
            DELETE FROM libro WHERE book_id = ? AND lista_id IN (SELECT id FROM liste WHERE user_id = ?)
        ");
        $stmt->bind_param("ss", $input['book_id'], $_SESSION["id_utente"]);
        if ($stmt->execute()) {
            $stmt = $conn->prepare("
                DELETE FROM manga WHERE manga_id = ? AND lista_id IN (SELECT id FROM liste WHERE user_id = ?)
            ");
            $stmt->bind_param("ss", $input['book_id'], $_SESSION["id_utente"]);
            $stmt->execute();  
            echo json_encode(['status' => 'successo']);
        } else {
            echo json_encode(['status' => 'errore', 'message' => 'Impossibile rimuovere il preferito']);
        }
        exit;
    }

    if ($input['azione'] === 'elimina_lista' && isset($input['lista_id'])) {
        $stmt = $conn->prepare("DELETE FROM libro WHERE lista_id = ?");
        $stmt->bind_param("s", $input['lista_id']);
        if ($stmt->execute()) {
            $stmt = $conn->prepare("DELETE FROM manga WHERE lista_id = ?");
            $stmt->bind_param("s", $input['lista_id']);
            $stmt->execute();  

            $stmt = $conn->prepare("DELETE FROM liste WHERE id = ?");
            $stmt->bind_param("s", $input['lista_id']);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'successo']);
            } else {
                echo json_encode(['status' => 'errore', 'message' => 'Impossibile eliminare la lista']);
            }
        } else {
            echo json_encode(['status' => 'errore', 'message' => 'Impossibile eliminare la lista']);
        }
        exit;
    }
}
?>


<!DOCTYPE html>
 <head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazioni personali</title>
    <link rel="stylesheet" href="pers.css"> 
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


    <script src="pers.js" defer></script> 
</head>
<body>
<header> 
  <div id='menu'>
            <img class='logo' src="img/239157da497dd0e7dd53d0425821b165.jpg">
            <div class='pannello'>
                <a href="http://localhost/index.php">Home</a>
                <a href="http://localhost/apigoogle.php">Ricerca Libri</a>
                <a href="http://localhost/harry.php">Harry Potter</a>
                <a href="http://localhost/good.php">Ricerca Manga</a>
                <a href="http://localhost/manu.php">Inserimento manuale</a>

            </div>
            <a href="https://localhost/logout.php">
                <button>Logout</button>
            </a>
  </div>
</header> 
<main>
    <h2>Le Tue Liste</h2>
    <div class="lists" id="favorites"></div>

    <section class="informazioni-utente hidden">
        <section>
            <p class="info">Le mie informazioni</p>
            <h2>Dati personali</h2>
            <p> <spa n class="strong"> Username: </span><span id="username"></span></p>
            <p><span  class="strong"> Nome:  </span><span id="nome"></span></p>
            <p> <span  class="strong">Cognome:</span>  <span id="cognome"></span></p>
            <p><span  class="strong"> Email:  </span><span id="email"></span></p>
            <p><span  class="strong"> Data di Nascita:</span>  <span id="data_di_nascita"></span></p>
            <p><span  class="strong"> Comune:</span>  <span id="comune"></span></p>
        </section>
        <section>
            <img src="img/7c6ac29c643b94b5ea4c661655a9b48e.jpg">
        </section>
    </section>

    <button id="toggleInformazioni">Mostra Informazioni</button>
</main>
<footer>
</footer>
</body>
</html>
