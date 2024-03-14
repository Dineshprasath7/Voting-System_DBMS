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
        <h2>Candidate List</h2>
        
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
            
           $acc= $_POST['acc'];
           $sql = "SELECT   voters.* ,candidate.* FROM voters Inner join ward on voters.wardno=ward.wardno inner join acc on ward.accno=acc.Accno inner join candidate on candidate.Epicid=voters.Epicid  WHERE  ward.Accno = $acc";
       
       $result = $conn->query($sql);
       
       if ($result->num_rows > 0) {
       echo "<table>";
       echo "<tr><th>Epic ID</th><th>Name</th><th>Date of Birth</th><th>Mobile No</th><th>Address</th><th>Ward No</th><th>Party</th></tr>";

       while ($row = $result->fetch_assoc()) {
           echo "<tr>";
           echo "<td>" . $row["Epicid"] . "</td>";
           echo "<td>" . $row["name"] . "</td>";
           echo "<td>" . $row["dob"] . "</td>";
           echo "<td>" . $row["mobileno"] . "</td>";
           echo "<td>" . $row["address"] . "</td>";
           echo "<td>" . $row["wardno"] . "</td>";
           echo "<td>" . $row["Party"] . "</td>";
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
