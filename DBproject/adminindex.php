<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="box" onclick="redirectTo('display_accno.php')">
        <h2>Display Account Numbers</h2>
    </div>
    <div class="box" onclick="redirectTo('display_candidates.php')">
        <h2>Display Candidates</h2>
    </div>
    <div class="box" onclick="redirectTo('display_vote_count.php')">
        <h2>Display Vote Count</h2>
    </div>
    <div class="box" onclick="redirectTo('display_voters.php')">
        <h2>Display Voters</h2>
    </div>
    <div class="box" onclick="redirectTo('new_voter.php')">
        <h2>Add New Voters</h2>
    </div>

    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
