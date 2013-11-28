<?php
require_once "config.php";
if(!isset($_SESSION)) {
	session_start(); 
}
// Report all errors except E_NOTICE
//error_reporting(E_ALL ^ E_NOTICE);
if(isset($_SESSION['user'])) {
	$uid =  (int)$_SESSION['user']; 
} else {
	$uid = null;
}
$query = null;

function userInfo($uid, $query, $conn, $whatToFetch) {
	$query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$uid'");
	$row = mysqli_fetch_array($query);
	if($whatToFetch === 'fname') {
		return $row['firstname'];
	} elseif($whatToFetch === 'lname') {
		return $row['lastname'];
	} elseif($whatToFetch === 'age') {
		return $row['age'];
	} elseif($whatToFetch === 'location') {
		return $row['location'];
	} elseif($whatToFetch === 'email') {
		return $row['email'];
	} elseif($whatToFetch === 'image') {
		return $row['profile_picture'];
	}
}

function currentDirectory($url) {

	$url = $_SERVER['REQUEST_URI']; //returns the current URL
	$parts = explode('/', $url);
	$dir = $_SERVER['SERVER_NAME'];
	for ($i = 0; $i < count($parts) - 1; $i++) {
	 $dir = $dir . $parts[$i] . "/";
	}
	$dir = "http://" . $dir;
	return $dir;
}
function clean($conn, $var) {
	$var = trim($var);
	if(is_int($var)) {
		return $var = (int)$var;
	} else {
		return $var = mysqli_real_escape_string($conn, $var);
	}
}

function clean_print($var) {
	define('charset', 'UTF-8');
	$charset = charset;
	$var = htmlentities($var, ENT_QUOTES, $charset);
	return $var;
}

function newThread($conn, $query) {
	$query = mysqli_query($conn, "SELECT * FROM subcategory WHERE category_id = '$f' LIMIT 1");
	$row = mysqli_fetch_array($query);
	$catid = $row['category_id'];
	
	$query2 = mysqli_query($conn, "INSERT INTO subcategory('category_id', 'subcategory_name', 'content', 'postBy') VALUES('$catid', '', '', '')");
	
}

function getUsername($conn, $query, $uid) {
	$query = mysqli_query($conn, "SELECT username FROM user WHERE user_id = '$uid'");
	$row = mysqli_fetch_array($query);
	return $row['username'];
}

function menu($query, $conn) {
	if(isset($_SESSION['user'])) {
		$query = mysqli_query($conn, "SELECT * FROM menu");
		while($row = mysqli_fetch_array($query)) {
			echo "<li class='menu'><a href=\"{$row['file_name']}\">{$row['menu_name']}</a></li>";
		}
	} else {
		$query = mysqli_query($conn, "SELECT * FROM menu WHERE type = 0");
		while($row = mysqli_fetch_array($query)) {
			echo "<li class='menu'><a href=\"{$row['file_name']}\">{$row['menu_name']}</a></li>";
		}
	}
}

function navbar($query, $conn) {
	$query = mysqli_query($conn, "SELECT * FROM menu WHERE menu_id = 1");
	$row = mysqli_fetch_array($query);
	echo "<a href=\"{$row['file_name']}\">{$row['menu_name']}</a>";
	//echo $row['menu_name'];
}

function navbar2($query, $conn) {
	$query = mysqli_query($conn, "SELECT * FROM category");
	$row = mysqli_fetch_array($query);
	$f = $row['category_id'];
	$url = "forum.php?f=$f";
	echo "<a href=\"{$url}\">{$row['category_name']}</a>";
}
function navbar3($query, $conn) {
	$query = mysqli_query($conn, "SELECT * FROM subcategory");
	$row = mysqli_fetch_array($query);
	$p = $row['subcategory_id'];
	$url = "post.php?p=$p";
	echo "<a href=\"{$url}\">{$row['subcategory_name']}</a>";
}


function head() {
?><head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head> <?php
}

function logout() {
	session_start();
	session_destroy();
	header("location: index.php");
}

@$p = clean($conn, $_GET['p']);
@$f = clean($conn, $_GET['f']);
@$n = clean($conn, $_GET['n']);
