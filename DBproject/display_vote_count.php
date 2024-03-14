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
    <h2>Voting Count</h2>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Accno:
    <select name="acc" id="acc">
    <?php
    
    $sql1 = "SELECT * FROM acc";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        while ($row1 = $result1->fetch_assoc()) {
            $accno = $row1["Accno"];
            $accname = $row1["Details"];
            echo "<option value='$accno'>$accno $accname</option>";
        }
    }
    
    ?>
    </select>
    
    <button type="submit">submit</button>
    
    </form>
    
<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acc'])) {
        
        $acc = $_POST['acc'];
        $sql = "SELECT voters.*, candidate.* FROM voters
                INNER JOIN ward ON voters.wardno = ward.wardno
                INNER JOIN acc ON ward.accno = acc.Accno
                INNER JOIN candidate ON candidate.Epicid = voters.Epicid
                WHERE ward.Accno = $acc";
       
        $result = $conn->query($sql);
       
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Epic ID</th><th>Name</th><th>Party</th><th>count</th></tr>";
            $c = array(array(0, ""), array(0, ""), array(0, ""), array(0, ""));
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Epicid"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["Party"] . "</td>";
                $sql3 = "SELECT COUNT(voters.Epicid) as a FROM voters
                         INNER JOIN ward ON voters.wardno = ward.wardno
                         INNER JOIN acc ON ward.accno = acc.Accno
                         WHERE voters.voted = '".$row["Party"]."' AND acc.Accno = $acc";
                $result3 = $conn->query($sql3);
                $count = $result3->fetch_assoc();
                $c[$i][0] = $count["a"];
                $c[$i][1] = $row["Epicid"];
                $i += 1;
                echo "<td>" . $count["a"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            $ma = max($c[0][0], $c[1][0], $c[2][0], $c[3][0]);
    
            for ($x = 0; $x <= 3; $x++) {
                if ($c[$x][0] == $ma && $c[$x][0] != 0) {
                    $sql4 = "SELECT voters.name, candidate.Party FROM voters
                                INNER JOIN ward ON voters.wardno = ward.wardno
                             INNER JOIN acc ON ward.accno = acc.Accno
                             INNER JOIN candidate ON candidate.Epicid =voters.Epicid
                             where  candidate.Epicid='" . $c[$x][1] . "'";
                    $result4 = $conn->query($sql4);

                    $ca = $result4->fetch_assoc();
                    echo "<h3> Winner name : ".$ca["name"]."  party : ".$ca["Party"]."</h3>";
                }
            }
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
