<!DOCTYPE html>
<?php 
	session_start(); 
	include_once "includes/config.php"; 
	include_once "includes/funcs.php"; 
	require_once "lib/password.php";
?>
<html>
<?php head(); ?>
<body>
	<div id="header">
		<div id="headerInner">
		<?php
			if(!isset($_SESSION['user'])) {
				include_once "login.php"; 
			} else {
				include_once "includes/loggedIn.php";
			}
			menu($query, $conn);
		?>
		</div>
	</div>
	
	<form class="register" method="post">
	<?php
	if(isset($_SESSION['user'])) {
		echo "You are already registered, you'll be redirected to your profile in five seconds...";
		header("Refresh: 5; url=profile.php");
		die();
	}
		if(isset($_POST['register'])) {
			if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirmPassword']) || empty($_POST['confirmEmail']) || empty($_POST['email'])) {
				echo "<fieldset class=\"registerFieldset\">";
					echo "<legend>Error!</legend>";
					echo "All the required fields are not specified.";
					echo "<ul>Required Fields:
							<li>Username</li>
							<li>Password</li>
							<li>E-mail</li>
						</ul>";
				echo "</fieldset>";
				die();
			}
		}	
		if(isset($_POST['register']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_POST['confirmEmail']) && isset($_POST['email'])) {
			if($_POST['password'] == $_POST['confirmPassword'] && $_POST['email'] == $_POST['confirmEmail']) {
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$age = $_POST['age'];
				$location = $_POST['location'];
				$password = $_POST['password'];
				$confirmPassword = $_POST['confirmPassword'];
				$email = $_POST['email'];
				$confirmEmail = $_POST['confirmEmail'];
				$username = $_POST['username'];
				$query = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'") or die(mysqli_error($conn));
				if (mysqli_num_rows($query)){
				echo "<fieldset class=\"registerFieldset\">";
					echo "<legend>Username already exists!</legend>";
					echo "The username you specified already exists in our database, please choose another username and try again!";
				echo "</fieldset>";
				
				} else {
					$hash = password_hash($password, PASSWORD_BCRYPT);	//Hash password with BCRYPT, using third party library (password_compat) since I'm not on php 5.5+
					if (password_verify($password, $hash)) {
						//If the hashing went well, we'll insert it into the database
						$query = mysqli_query($conn, "INSERT INTO user(firstname, lastname, age, location, password, email, username) VALUE ('$fname','$lname','$age','$location','$hash','$email', '$username')");
					} else {
						//If the hashing failed, we'll spit out a mysqli error
						mysqli_error($conn);
						die();
					}
				}
			}
		}
	?>
	<fieldset class="registerFieldset">
		<legend>User Information</legend>
		Username: *<br/><input type="text" name="username" placeholder="Username..."><br />
		First name:<br/><input type="text" name="fname" placeholder="First name..."><br/>
		Last name:<br/><input type="text" name="lname" placeholder="Last name..."><br/>
		Age:<br/><input type="text" name="age" placeholder="Age"><br/>
		Location:<br/><input type="text" name="location" placeholder="location..."><br/>
	</fieldset>
		<fieldset class="registerFieldset">
		<legend>Password</legend>
		Password: *<br/><input type="password" name="password" placeholder="password..."><br />
		Confirm password: *<br/><input type="password" name="confirmPassword" placeholder="Password..."><br/>
	</fieldset>
		<fieldset class="registerFieldset">
		<legend>Email</legend>
		Email: *<br/><input type="text" name="email" placeholder="E-mail..."><br />
		Confirm Email: *<br/><input type="email" name="confirmEmail" placeholder="Confirm E-mail..."><br/>
	</fieldset>
		<input type="submit" value="register" name="register">
	</form>

</body>
</html>