<?php
$conn = mysqli_connect("localhost", "root", "", "iscritti");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>