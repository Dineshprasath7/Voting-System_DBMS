
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="head">
        <h1>Voting System</h1>
    </div>
    <div class="top">
        <a href="admin.php">Admin</a>
    </div>
    
    <div class="form">
        <h2>Welcome to Voting</h2>
        <php>
        
        <form action="connect.php" method="post" >
            <input type="text" name="epic_id" id="epic_id" placeholder="Epic id" pattern="^(?=(?:[^A-Z]*[A-Z]){3})(?=(?:\D*\d){7}).{10,}$" title="Must contain Three uppercase letters and seven numbers" required>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" required pattern="^(?=(?:[^A-Z]*[A-Z]){4})(?=(?:\D*\d){4})[A-Za-z\d]{8}$" title="Must contain First four characters of your name and last four digits of your number">
            <br>
            <input type="submit" value="Submit" class="button">
            <?php
                 if (isset($_GET['error'])) {
                    $errorMessage = $_GET['error'];
                    echo '<p class="error-message">' . $errorMessage . '</p>';
                }
            ?>
        </form>
    </div>
    
    
</body>
</html>
