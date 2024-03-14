<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="voting.css">
        <title></title>
    </head>
    <body >
        <h2>Assembly Constituency</h2>
        <table>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM acc";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    echo "<tr><th>Acc No</th><th>Name</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["Accno"]."</td><td>".$row["Details"]."</td></tr>";
    }
    
} else {
    echo "No results found.";
}

$conn->close();
?>
</table>
<input type="button" value="back" onclick= "redirectTo('adminindex.php')" class="back">
    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>
</body>