<!DOCTYPE html>
<?php
	include_once "includes/funcs.php";
	include_once "includes/config.php"; 
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
	<div class="container">
		<fieldset>
		<legend>Write a potatis</legend>
			<form class="newThreadForm" method="post">
				Title:<br/> <input type="text" name="title" placeholder="Title"> <br/>
				Post:<br/> <textarea name="post" placeholder="Write a new post"></textarea><br/>
				<input type="submit" value="submit" name="submit">
			</form>
		</fieldset>
		<?php
			$catid = $n;
			$uid = $_SESSION['user'];
			$username = getUsername($conn, $query, $uid);
			@$catname = $_POST['title'];
			@$content = $_POST['post'];
			if(isset($_POST['submit'])) {
				mysqli_query($conn, "INSERT INTO subcategory (category_id, subcategory_name, content, postBy) VALUES ('$catid', '$catname', '$content', '$username') ");
			}
		?>
	</div>
</body>
</html>