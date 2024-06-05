<?php
session_start();
require_once "connessione.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $data_di_nascita = $_POST["data_di_nascita"];
    $comune = $_POST["comune"];

     if (strlen($password) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error = "La password deve avere almeno 8 caratteri, un segno speciale e almeno un numero.";
    } else {
         $query_check = "SELECT id FROM utenti WHERE username = ? OR email = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 0) {
 
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);

             $query_insert_user = "INSERT INTO utenti (username, password, nome, cognome, email, data_di_nascita, comune) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($query_insert_user);
            $stmt_insert->bind_param("sssssss", $username, $password_hashed, $nome, $cognome, $email, $data_di_nascita, $comune);

            if ($stmt_insert->execute() === TRUE) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id_utente"] = $conn->insert_id;
                $_SESSION["username"] = $username;

                header("Location: index.php");
                exit;
            } else {
                $error = "Errore durante la registrazione.";
            }

            $stmt_insert->close();
        } else {
            $error = "Username o email già in uso.";
        }

        $stmt_check->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="style.css">
    <script src="register.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Registrazione</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form name="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="cognome" placeholder="Cognome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date" name="data_di_nascita" placeholder="Data di nascita" required>
            <input type="text" name="comune" placeholder="Comune" required>
            <button type="submit">Registrati</button>
        </form>
    </div>
</body>
</html>
