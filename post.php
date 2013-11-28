<!DOCTYPE html>
<?php 
	include_once "includes/config.php"; 
	include_once "includes/funcs.php"; 
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
	<div class='container'>
	<?php
		$query = mysqli_query($conn, "SELECT * FROM subcategory WHERE subcategory_id = '$p'"); 
		while($row = mysqli_fetch_array($query)) {
			$content = $row['content'];
			echo "<p class='topicTitle'><a href=\"{$_SERVER['REQUEST_URI']}\">{$row['subcategory_name']}</a></p>";
			echo "<p class='userProfile'>{$row['postBy']}<br>";
			?> 
			<img src="upload/<?php echo userInfo($uid, $query, $conn, $whatToFetch = "image") ?>" alt='Profile Picture' width='150' height='150' /> 
			<?php
			echo "</p>";
			echo "<p class='topicContent'>$content</p>";	
		}

		$query = mysqli_query($conn, "SELECT postBy, post_id, post FROM post WHERE blaaa = '$p'");
		while($row = mysqli_fetch_array($query)) {
			global $username;
			@$i++;
			echo "<p class='topicTitle'>Reply $i</p>";
			echo "<p class='userProfile'>";
			echo "{$row['postBy']} <br />";
			?>
			
			<img src="upload/<?php echo userInfo($uid, $query, $conn, $whatToFetch = "image") ?>" alt='Profile Picture' width='150' height='150' />
			<?php
			echo "</p>";
			echo "<p class='topicContent'>{$row['post']} </p>";
		}


		if(isset($_SESSION['user'])) {
			?>
			<div id="newPost">
				<form method="post">
					<textarea placeholder="Write a new post!" name="content"></textarea>
					<input type="submit" value="send" name="submit">
				</form>
			</div>
			<?php
			if(isset($_POST['submit'])) {
				$currUsername = getUsername($conn, $query, $uid);
				$today = date("Y-m-d");
				$content = $_POST['content'];
				
				$query = mysqli_query($conn, "INSERT INTO post(postBy, post, date, blaaa) 
					VALUES('$currUsername', '$content', '$today', '$p') ") or die(mysqli_error($conn));
			}
		} ?>
	</div>
</body>
</html>