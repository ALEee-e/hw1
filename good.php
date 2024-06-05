<?php
 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require_once 'connessione.php';

$clientId = '18887';
$clientSecret = 'zOwuqWPcD8M2ZuxOYPVPlcq8dhKcUEUNHOztPwfF';
$redirectUri = 'http://localhost/good.php';

function fetchMangaData($query, $accessToken) {
    $apiUrl = "https://graphql.anilist.co";
    $queryData = [
        'query' => '
        query ($search: String) {
            Page {
                media (search: $search, type: MANGA) {
                    id
                    title {
                        romaji
                        english
                    }
                    description
                    coverImage {
                        large
                    }
                }
            }
        }
        ',
        'variables' => ['search' => $query],
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\nAuthorization: Bearer $accessToken\r\n",
            'method'  => 'POST',
            'content' => json_encode($queryData),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);
    return json_decode($result, true);
}

function returnJsonResponse($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

try {
    if (isset($_GET['query'])) {
        if (!isset($_SESSION['access_token'])) {
            returnJsonResponse(['error' => 'Non autenticato']);
        }
        $data = fetchMangaData($_GET['query'], $_SESSION['access_token']);
        returnJsonResponse($data);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if ($input['azione'] === 'aggiungi_a_lista') {
            $stmt = $conn->prepare("SELECT * FROM manga WHERE lista_id = ? AND manga_id = ?");
            $stmt->bind_param("ss", $input['lista_id'], $input['manga_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                returnJsonResponse(['status' => 'errore', 'message' => 'Il manga è già presente nella lista']);
            } else {
                $stmt = $conn->prepare("INSERT INTO manga (lista_id, manga_id, titolo, autore, thumbnail) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $input['lista_id'], $input['manga_id'], $input['titolo'], $input['autore'], $input['thumbnail']);
                if ($stmt->execute()) {
                    returnJsonResponse(['status' => 'successo']);
                } else {
                    returnJsonResponse(['status' => 'errore', 'message' => 'Impossibile aggiungere il manga alla lista']);
                }
            }
        } elseif ($input['azione'] === 'crea_lista') {
            $stmt = $conn->prepare("SELECT * FROM liste WHERE user_id = ? AND nome = ?");
            $stmt->bind_param("ss", $_SESSION["id_utente"], $input['nome']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                returnJsonResponse(['status' => 'errore', 'message' => 'Una lista con questo nome esiste già']);
            } else {
                $stmt = $conn->prepare("INSERT INTO liste (user_id, nome) VALUES (?, ?)");
                $stmt->bind_param("ss", $_SESSION["id_utente"], $input['nome']);
                if ($stmt->execute()) {
                    returnJsonResponse(['status' => 'successo', 'lista_id' => $conn->insert_id]);
                } else {
                    returnJsonResponse(['status' => 'errore', 'message' => 'Impossibile creare la lista']);
                }
            }
        }  
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['azione']) && $_GET['azione'] === 'ottieni_liste') {
            $stmt = $conn->prepare("SELECT * FROM liste WHERE user_id = ?");
            $stmt->bind_param("s", $_SESSION["id_utente"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $liste = [];
            while ($row = $result->fetch_assoc()) {
                $liste[] = $row;
            }
            returnJsonResponse($liste);
        }

        if (isset($_GET['azione']) && $_GET['azione'] === 'verifica_manga' && isset($_GET['lista_id']) && isset($_GET['manga_id'])) {
            $stmt = $conn->prepare("SELECT * FROM manga WHERE lista_id = ? AND manga_id = ?");
            $stmt->bind_param("ss", $_GET['lista_id'], $_GET['manga_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $presente = $result->num_rows > 0 ? true : false;
            returnJsonResponse(['presente' => $presente]);
        }
    }

    if (!isset($_GET['code']) && !isset($_SESSION['access_token'])) {
        $authUrl = "https://anilist.co/api/v2/oauth/authorize?response_type=code&client_id=$clientId&redirect_uri=" . urlencode($redirectUri);
        header('Location: ' . $authUrl);
        exit;
    } elseif (isset($_GET['code'])) {
        $code = $_GET['code'];

        $tokenUrl = 'https://anilist.co/api/v2/oauth/token';
        $data = [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($tokenUrl, false, $context);
        $response = json_decode($result, true);

        if (isset($response['access_token'])) {
            $_SESSION['access_token'] = $response['access_token'];
            header('Location: good.php');
            exit;
        } else {
            echo 'Errore nella richiesta del token di accesso.';
            exit;
        }
    }
} catch (Exception $e) {
    returnJsonResponse(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
}
?>



<!DOCTYPE html>
 <head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricerca Manga  </title>
    <link rel="stylesheet" href="good.css">
    <script src="good.js" defer></script>
</head>
<body>
<header> 
  <div id='menu'>
        <img class='logo' src="img/239157da497dd0e7dd53d0425821b165.jpg">
        <div class='pannello'>
           <a href="http://localhost/index.php">Home</a>
                <a href="http://localhost/harry.php">Harry Potter</a>
                 <a href="http://localhost/apigoogle.php">Ricerca Libri</a>
                    <a href="http://localhost/pers.php">Pagina personale</a>
     <a href="http://localhost/manu.php">Inserimento manuale</a>
            
                   </div>
        <a href="https://localhost/logout.php">
            <button>Logout</button>
        </a>
    </div>
</header> 
<section class="head">
    <h1>Cerca Manga su AniList</h1>
    <input type="text" id="searchQuery" placeholder="Cerca manga...">
    <button id="searchButton">Cerca</button>

</section> 
<div id="searchResults"></div>

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

<footer> 
</footer> 
</body>
</html>
