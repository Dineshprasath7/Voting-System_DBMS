<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form data
$name = $epicid = $mobileno = $wardno = "";
$epicidErr = $mobilenoErr = $wardnoErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $epicid = $_POST["epicid"];
    $mobileno = $_POST["mobileno"];
    $wardno = $_POST["wardno"];

    // Validate Epic ID (First 3 characters and 7 digits)
    if (!preg_match("/^[A-Z]{3}\d{7}$/", $epicid)) {
        $epicidErr = "Invalid Epic ID format";
    }

    // Validate Mobile No (10 digits)
    if (!preg_match("/^\d{10}$/", $mobileno)) {
        $mobilenoErr = "Invalid Mobile No format";
    }

    // Validate Ward No (1-100)
    if (!is_numeric($wardno) || $wardno < 1 || $wardno > 100) {
        $wardnoErr = "Invalid Ward No (1-100)";
    }

    // Check if the Epic ID already exists
    $existingEpicId = "SELECT epicid FROM voters WHERE epicid = '$epicid'";
    $result = $conn->query($existingEpicId);
    if ($result->num_rows > 0) {
        $epicidErr = "Epic ID already exists";
    }

    // If all inputs are valid and the Epic ID doesn't exist, insert the new voter into the database
    if (empty($epicidErr) && empty($mobilenoErr) && empty($wardnoErr)) {
        // Insert a new voter into the database
        $sql = "INSERT INTO voters (epicid, name, mobileno, wardno) VALUES ('$epicid', '$name', '$mobileno', '$wardno')";

        if ($conn->query($sql) === TRUE) {
            echo "New voter added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Voter</title>
    <link rel="stylesheet" href="voting.css">
</head>
<body>
    <h2>Add New Voter</h2>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="epicid">Epic ID:</label>
        <input type="text" name="epicid" required>
        <span class="error"><?php echo $epicidErr; ?></span><br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="mobileno">Mobile No:</label>
        <input type="text" name="mobileno" required>
        <span class="error"><?php echo $mobilenoErr; ?></span><br><br>

        <label for="wardno">Ward No:</label>
        <input type="text" name="wardno" required>
        <span class="error"><?php echo $wardnoErr; ?></span><br><br>

        <input type="submit" value="Add Voter">
    </form>
    <input type="button" value="back" onclick= "redirectTo('adminindex.php')" class="back">
    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
