<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$epicId = $_POST['epic_id'];
$password = $_POST['password'];

$sql = "SELECT epicid, name, mobileno FROM voters WHERE epicid = '$epicId' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedEpicId = $row['epicid'];
    $name = strtoupper($row['name']);
    $mobileno = $row['mobileno'];

    if ($storedEpicId === $epicId && substr($name, 0, 4) === substr($password, 0, 4) && substr($mobileno, -4) === substr($password, -4)) {
        setcookie("epicCookie", $epicId, time() + 3600, "/");
        header("Location: voting.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid Password");
        exit();
    }
} else {
    header("Location: login.php?error=Invalid Epic ID");
    exit();
}

$conn->close();
?>
