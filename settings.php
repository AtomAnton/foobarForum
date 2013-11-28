<!DOCTYPE html>
<?php
	include_once "includes/funcs.php"; 
	include_once "includes/config.php"; 
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

	<div class="container">
		<?php if(!isset($_SESSION['user'])) {
			echo "You have to be logged in to see this page!";
		} elseif(isset($_SESSION['user'])) { ?>
			<form method="post">
				<fieldset class="registerFieldset">
					<legend>Change user information</legend>
					First name <br />
					<input type="text" name="fname" value="<?php echo userInfo($uid, $query, $conn, $whatToFetch = 'fname'); ?>"> <br />
					Last name <br />
					<input type="text" name="lname" value="<?php echo userInfo($uid, $query, $conn, $whatToFetch = 'lname'); ?>"><br />
					Age <br />
					<input type="text" name="age" value="<?php echo userInfo($uid, $query, $conn, $whatToFetch = 'age'); ?>"><br />
					Location <br />
					<input type="text" name="location" value="<?php echo userInfo($uid, $query, $conn, $whatToFetch = 'location'); ?>"><br />
					Email <br />
					<input type="text" name="email" value="<?php echo userInfo($uid, $query, $conn, $whatToFetch = 'email'); ?>"><br />
				</fieldset>
				<input type="submit" value="Change settings" name="changesettings"> <br />
			<?php
				if(isset($_POST['changesettings'])) {
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$age = $_POST['age'];
					$location = $_POST['location'];
					$email = $_POST['email'];

					$query = mysqli_query($conn, "UPDATE user SET firstname = '$fname', lastname = '$lname', age = '$age', location = '$location', email = '$email' WHERE user_id = $uid ") or die(mysqli_error($conn));
				}
			?>
			</form>
			<form>
				<br /><fieldset class="registerFieldset">
					<legend>Change password</legend>
					Current password <br />
					<input type="password" name="pw" value="password"><br />
					new password <br />
					<input type="password" name="newpw" value=""><br />
					Confirm new password <br />
					<input type="password" name="confirmnewpw" value=""><br />
				</fieldset>
				<input type="submit" value="change password" name="changepassword">
			<?php
				if(isset($_POST['changepassword'])) {
					$query = mysqli_query($conn, "SELECT password FROM user WHERE user_id = '$uid'");
					$row = mysqli_fetch_array($query);
					$currentPassword = $_POST['pw'];
					$currentHashedPassword = $row['password'];
					$newPassword = $_POST['newpw'];
					$confirmedPassword = $_POST['confirmnewpw'];
					if(!empty($newPassword) && !empty($confirmedPassword) && $newPassword == $confirmedPassword) {
						if (password_verify($currentPassword, $currentHashedPassword) == true) {
							$newlyHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
							$query = mysqli_query($conn, "UPDATE user SET password = '$newlyHashedPassword' WHERE user_id = $uid ") or die(mysqli_error($conn));
							echo "Sucess!";
						} else {
							echo "Wrong password";
						}
					} else {
						echo "Empty or the passwords do not match!";
					}
				}
			?>
			</form>
			<br /><br />
				<fieldset class="registerFieldset">
					<legend>Change profile picture</legend>
					<form method="post" enctype="multipart/form-data">
						Select picture:
					    <!-- MAX_FILE_SIZE must precede the file input field -->
					    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
					    <!-- Name of input element determines name in $_FILES array -->
					    <input name="userfile" type="file" />
					</fieldset>	
						<input type="submit" value="Change picture" name="changepic">
					<?php
					if(isset($_POST['changepic'])) {
						$uploaddir = '/var/www/forum/upload/';
						$file = $_FILES['userfile']['name'];
						$file = md5($uid);
						$uploadfile = $uploaddir . basename($file);

						echo '<pre>';
						if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
						    echo "File is valid, and was successfully uploaded.\n";
						} else {
						    echo "Possible file upload attack!\n";
						}

						//echo 'Here is some more debugging info:';
						//print_r($_FILES);

						mysqli_query($conn, "UPDATE user SET profile_picture = '$file' WHERE user_id = '$uid' ") or die(mysqli_error($conn));			
					} 
					?>
					</form>
 		<?php } ?>
	</div>
</body>
</html>