<?php
session_start();
 
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once 'connessione.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input['azione'] === 'aggiungi_a_lista') {
        $stmt = $conn->prepare("SELECT * FROM libro WHERE lista_id = ? AND book_id = ?");
        $stmt->bind_param("ss", $input['lista_id'], $input['book_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(['status' => 'errore', 'message' => 'Il libro è già presente nella lista']);
        } else {
            $stmt = $conn->prepare("INSERT INTO libro (lista_id, book_id, titolo, autore, thumbnail) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $input['lista_id'], $input['book_id'], $input['titolo'], $input['autore'], $input['thumbnail']);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'successo']);
            } else {
                echo json_encode(['status' => 'errore', 'message' => 'Impossibile aggiungere il libro alla lista']);
            }
        }
        exit;
    } 
    
    elseif ($input['azione'] === 'crea_lista') {
        $stmt = $conn->prepare("SELECT * FROM liste WHERE user_id = ? AND nome = ?");
        $stmt->bind_param("ss", $_SESSION["id_utente"], $input['nome']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(['status' => 'errore', 'message' => 'Una lista con questo nome esiste già']);
        } else {
            $stmt = $conn->prepare("INSERT INTO liste (user_id, nome) VALUES (?, ?)");
            $stmt->bind_param("ss", $_SESSION["id_utente"], $input['nome']);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'successo', 'lista_id' => $conn->insert_id]);
            } else {
                echo json_encode(['status' => 'errore', 'message' => 'Impossibile creare la lista']);
            }
        }
        exit;
    }  
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
if (isset($_GET['azione']) && $_GET['azione'] === 'ottieni_liste') {
header('Content-Type: application/json');
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


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['azione']) && $_GET['azione'] === 'verifica_libro' && isset($_GET['lista_id']) && isset($_GET['book_id'])) {
        header('Content-Type: application/json');
        $stmt = $conn->prepare("SELECT * FROM libro WHERE lista_id = ? AND book_id = ?");
        $stmt->bind_param("ss", $_GET['lista_id'], $_GET['book_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $presente = $result->num_rows > 0 ? true : false;
        echo json_encode(['presente' => $presente]);
        exit;
    }
}

 

?>


<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ricerca libri</title>
    <link rel="stylesheet" href="api.css">
     <script src="api.js" defer></script>
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


</head>
<body>
<header> 
  <div id='menu'>
            <img class='logo' src="img/239157da497dd0e7dd53d0425821b165.jpg">
            <div class='pannello'>
                
                <a href="http://localhost/index.php">Home</a>
                <a href="http://localhost/harry.php">Harry Potter</a>
                <a href="http://localhost/good.php">Ricerca Manga</a>
                    <a href="http://localhost/pers.php">Pagina personale</a>
                    <a href="http://localhost/manu.php"> Inserimento manuale</a>
                    
            </div>
<a href="https://localhost/logout.php">
        <button>Logout</button>
    </a>

</header> 
    <section class="head">
        <h1>Ricerca Libri</h1>
        <input type="text" id="searchQuery" placeholder="Cerca libri...">
        <button id="searchButton">Cerca</button>
    </section>
    <main>
        <div class="results" id="results"></div>
        
        </div>
    </main>

 <!-- Modale -->
<div class="modal" id="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Scegli una lista</h2>
        <div id="liste"></div>
        <input type="text" id="nomeNuovaLista" placeholder="Nome nuova lista">
        <button id="creaLista">Crea nuova lista</button>
        <button id="annulla">Annulla</button>
    </div>
</div>


   <p class='benvenuto'>Benvenuto, <?php echo $_SESSION["username"]; ?>!</p>
   
       <footer>

    </footer>

</body>
</html>
