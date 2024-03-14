<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
</head>
<body>
<Div class="head">
        <h1 >Voting System </h1>
        
    </Div>
    <div class="top">
        <a href="login.php">Login</a>
    </div>
    <div class="form">
        <h2>Welcome Admin</h2>
        <php>
        
        <form action="adminindex.php" method="post" onsubmit="return validateForm()" >
        
            <input type="text" name="Username" id="Username" placeholder="Username" required>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" required >
            <br>
            <input type="submit" value="Submit" class="button">
            <?php
                 if (isset($_GET['error'])) {
                    $errorMessage = $_GET['error'];
                    echo '<p class="error-message">' . $errorMessage . '</p>';
                }
            ?>
        </form>
        <script>
        function validateForm() {
            // Get the values of the username and password fields
            var username = document.getElementById("Username").value;
            var password = document.getElementById("password").value;

            // Check if the username and password are correct (e.g., "admin" for both)
            if (username === "admin" && password === "admin") {
                return true; // Allow the form to be submitted
            } else {
                // Display an error message and prevent form submission
                alert("Invalid username or password.");
                return false;
            }
        }
    </script>
</body>
