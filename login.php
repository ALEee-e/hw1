<?php
session_start();
require_once "connessione.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

 
    $query = "SELECT id, username FROM utenti WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["loggedin"] = true;
        $_SESSION["id_utente"] = $row["id"];
        $_SESSION["username"] = $row["username"];
 
        header("Location: index.php");
        exit;
    } else {
        $error = "Username o password non validi.";
    }
}
?>

<!DOCTYPE html>
<head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Accedi</button>
        </form>
        <p>Non hai un account? <a href="register.php">Registrati qui</a>.</p>
    </div>
</body>
</html>