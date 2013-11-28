<?php
define("db_hostname", 'localhost');
define("db_username", "root");
define("db_password", "");
define("db_database", "forum");
define("charset", "utf8");

$conn = mysqli_connect(db_hostname, db_username, db_password, db_database) or die(mysqli_error($conn)); 
mysqli_set_charset($conn, charset);

?>