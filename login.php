<?php
require_once "includes/config.php";
require_once "lib/password.php";
?>

<form method='post'>
	<input type="text" name="username" placeholder="username"> <br />
	<input type="password" name="password" placeholder="password"> <br />
	<input type="submit" value="login" name="submit"> 
</form>
<div id="help">
	<a href="#">Forgot your password?</a><br />
	<a href="register.php" class="register">Don't have an account?</a>
</div>

<?php
if(isset($_POST['submit'])) {
	$uname = $_POST['username'];
	$uname = clean($conn, $uname);
	$pword = $_POST['password'];

	$query = mysqli_query($conn, "SELECT username FROM user WHERE username = '$uname' ") or die(mysqli_error($conn));
	if (mysqli_num_rows($query) == true) {
		$query = mysqli_query($conn, "SELECT user_id, username, password FROM user WHERE username = '$uname'");
		$row = mysqli_fetch_array($query);
		$hash = $row['password'];
		$user_id = $row['user_id'];
		if (password_verify($pword, $hash) == true) {
			$_SESSION['user'] = $user_id;
			header("location: index.php");
		} else {
		?>  <script>
				window.alert("Wrong username/password");
			</script> 
		<?php
		}
	} else { 
	?> 
		<script>
			window.alert("Wrong username/password");
		</script>
	<?php
	}
}