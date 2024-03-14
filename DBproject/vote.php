<?php
// Retrieve the epicId from the cookie
$epicId = $_POST["epicId"];

// Check if the cookie is set
if (!isset($epicId)) {
    // Redirect or handle the case where the cookie is not set
    header("Location: login.php?error=Cookie not set");
    exit();
}

// Get the selected party from the form
if (isset($_POST["party"])) {
    $selectedParty = $_POST["party"];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "voting";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the 'voted' field in the voters table with the selected party
    $sql_update_vote = "UPDATE voters SET voted = '$selectedParty' WHERE epicid = '$epicId'";

    if ($conn->query($sql_update_vote) === TRUE) {
        $conn->close();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="voting.css">
            <title>Thanks for Voting</title>
        </head>
        <body>
            <h1>Thanks for Voting!</h1>
        </body>
        </html>
        <?php
        exit();
    } else {
        echo "Error updating vote: " . $conn->error;
    }
} else {
    
    header("location:voting.php?error=noparty");
    exit();

}
?>
