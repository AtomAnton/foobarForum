<?php
require_once "config.php";
$query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '{$_SESSION['user']}'");
$row = mysqli_fetch_array($query);
echo "<div class='displayUsername'>";
echo "Welcome {$row['username']}<br>";
echo "<a href='logout.php'>click here to logout!</a>";
echo "</div>";