<?php
// Retrieve the epicId from the cookie
$epicId = $_COOKIE["epicCookie"];

// Check if the cookie is set
if (!isset($epicId)) {
    // Redirect or handle the case where the cookie is not set
    header("Location: login.php?error=Cookie not set");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch voter details
$sql_voter = "SELECT epicid, name, mobileno,voted FROM voters WHERE epicid = '$epicId'";
$result_voter = $conn->query($sql_voter);
$row_voter = $result_voter->fetch_assoc();
if($row_voter['voted']==null){
    if ($result_voter->num_rows == 1) {
       
        $voter_name = $row_voter['name'];

        // Fetch accno for the voter
        $sql_accno = "SELECT acc.accno FROM acc INNER JOIN ward ON acc.accno = ward.accno WHERE ward.wardno IN (SELECT wardno FROM voters WHERE epicid = '$epicId')";
        $result_accno = $conn->query($sql_accno);

        if ($result_accno->num_rows == 1) {
            $row_accno = $result_accno->fetch_assoc();
            $accno = $row_accno['accno'];

            // Fetch candidates for the accno
            $sql_candidates = "SELECT candidate.Party, candidate.Epicid FROM candidate WHERE candidate.accno = '$accno'";
            $result_candidates = $conn->query($sql_candidates);
        } else {
            // Handle the case where accno is not found
            echo "Account number not found.";
        }
    } else {
        // Handle the case where voter details are not found
        echo "Voter details not found.";
    }


    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Voting Page</title>
        <link rel="stylesheet" href="voting.css">
    </head>
    <body>
        <h1>Welcome, <?php echo $voter_name; ?>!</h1>
        <h2>Select a Party to Vote For:</h2>
        <div class="form">
        <form action="vote.php" method="post" onclick="checkvote()">
            <?php
            if ($result_candidates->num_rows > 0) {
                while ($row_candidate = $result_candidates->fetch_assoc()) {
                    $party = $row_candidate['Party'];
                    $epicId_candidate = $row_candidate['Epicid'];
                    $sql_voter1 = "SELECT name FROM voters WHERE epicid = '$epicId_candidate'";
                    $result_voter1 = $conn->query($sql_voter1);
                    $row_voter1 = $result_voter1->fetch_assoc();
                    $voter_name1 = $row_voter1['name'];
                    $flag_path = "img/" . $party . ".png"; 
                ?>
                    <label class ="block">

                    <img src="<?php echo $flag_path; ?>" alt="<?php echo $party; ?>" >
                    <br>
                    <h4><?php echo $voter_name1; ?></h4>
                    <br>
                    <input type="radio" name="party" value="<?php echo $party; ?>" required>
                    </label>
                    <?php
                }
                ?>
                <input type="hidden" name="epicId" value="<?php echo $epicId; ?>">
                <br>
                <input type="submit" value="Vote" class="vote">

                <?php
            } else {
                echo "No candidates found for this account number.";
            }
            ?>
        </form>
        </div>
    </body>
    </html>
    <?php
    $conn->close();
    
}
else{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Voting Page</title>
        <link rel="stylesheet" href="voting.css">
    </head>
    <body>
    <h2><?php echo "Already Voted"; ?></h2>
    </body>
<?php
}

?>