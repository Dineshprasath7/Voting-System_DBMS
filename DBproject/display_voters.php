<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="voting.css">
        <title></title>
    </head>
    <body>
        <h2>Voters List</h2>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Accno:
        <select name="acc" id="acc">
        <?php
        
        $sql1="SELECT * from acc";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()){
                $accno = $row1["Accno"];
                $accname= $row1["Details"];
                echo "<option value='$accno'>$accno $accname</option>";
            }
        }
        
        ?>
        </select>
        
        <button type="submit">submit</button>
        
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset( $_POST['acc'])) {
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            wardno:
        <select name="ward" id="ward">
            <?php
           $acc = $_POST['acc'];
            $sql2="SELECT * from ward where accno=$acc";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()){
                
                    $wardno= $row2["wardno"];
                 echo "<option value='$wardno'>$wardno</option>";
             }
            }
        
    
    ?>
    </select>
        
    <button type="submit">submit</button>
        
    </form>
    <?php
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset( $_POST['ward'])) {
            
           $ward= $_POST['ward'];
           $sql = "SELECT * FROM voters WHERE   wardno = $ward";
       
       $result = $conn->query($sql);
       
       if ($result->num_rows > 0) {
       echo "<table>";
       echo "<tr><th>Epic ID</th><th>Name</th><th>Date of Birth</th><th>Mobile No</th><th>Address</th><th>Ward No</th><th>Voted</th></tr>";

       while ($row = $result->fetch_assoc()) {
           echo "<tr>";
           echo "<td>" . $row["Epicid"] . "</td>";
           echo "<td>" . $row["name"] . "</td>";
           echo "<td>" . $row["dob"] . "</td>";
           echo "<td>" . $row["mobileno"] . "</td>";
           echo "<td>" . $row["address"] . "</td>";
           echo "<td>" . $row["wardno"] . "</td>";
           echo "<td>" . ($row["Voted"] ? "Yes" : "No") . "</td>";
           echo "</tr>";
       }
       
       echo "</table>";
       } else {
       echo "No results found.";
       }
        }
    ?>
    <input type="button" value="back" onclick= "redirectTo('adminindex.php')" class="back">
    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>
    </body>
    </html>
    <?php




$conn->close();
?>
