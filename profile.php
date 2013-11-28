<!DOCTYPE html>
<?php
	if(!isset($_SESSION)) {
		session_start(); 
	}
	include_once "includes/config.php"; 
	include_once "includes/funcs.php"; 
	require_once "lib/password.php";
	if(isset($_SESSION['user'])) {
		$username = getUsername($conn, $query, $uid);
	}
?>
<html>
<?php head(); ?>
<body>
	<div id="header">
		<div id="headerInner">
		<?php 
			if(!isset($_SESSION['user'])) {
				include "includes/loginform.php"; 
			} else {
				include_once "includes/loggedIn.php";
			}
		menu($query, $conn);
		?>
		</div>
	</div>
<?php
$url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
if(!isset($_SESSION['user'])) {
	echo "You have to be logged in to view this page!";
} else {
	?>
	<div id="viewProfile">
	<div id="profileImage">
		<img src="upload/<?php echo userInfo($uid, $query, $conn, $whatToFetch = 'image') ?>" alt="user image" width="250" height="250" />
	</div>

	<div id="userInfo">
		<ul>
			<li>First name: <?php echo userInfo($uid, $query, $conn, $whatToFetch = 'fname') ?></li>
			<li>Last name: <?php echo userInfo($uid, $query, $conn, $whatToFetch = 'lname') ?></li>
			<li>Age: <?php echo userInfo($uid, $query, $conn, $whatToFetch = 'age') ?></li>
			<li>Location: <?php echo userInfo($uid, $query, $conn, $whatToFetch = 'location') ?></li>
			<li>Email: <?php echo userInfo($uid, $query, $conn, $whatToFetch = 'email') ?></li>
		<ul>
	</div>
	</div>
	<?php
	} ?>
</body>
</html>