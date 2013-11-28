<!DOCTYPE html>
<?php
	session_start(); 
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
	<div class="container">
		<?php if(isset($_SESSION['user'])) {
			$query = mysqli_query($conn, "SELECT * FROM subcategory WHERE category_id = '$f'");
			$row = mysqli_fetch_array($query);
		?>
		<div id="newThread">
			<a href="newthread.php?n=<?php echo $row['category_id'] ?>">Create a new thread</a>
		</div>
		<?php } ?>
	<table class="forum">
		<tbody>	
			<tr>
				<th class="headerRow">Forums</th>
				<th class="headerRow">Replies</th>
				<th class="headerRow">Latest Post</th>
			</tr>
				<?php
					$query = mysqli_query($conn, "SELECT subcategory_id, subcategory_name FROM subcategory WHERE category_id = '$f'");
					while($row = mysqli_fetch_array($query)) {
						echo "<tr>";
							echo "<td width=\"55%\"><a href=\"post.php?p={$row['subcategory_id']}\">{$row['subcategory_name']}</a></td>";
							echo "<td width=\"15%\">N/A</td>";
							echo "<td width=\"15%\">N/A</td>";
							//echo "<td width=\"15%\">Today 08:00 <br/> by <a href=\"#\">Admin</a></td>";
						echo "</tr>";
					}
				?>
		</tbody>
	</table>
	</div>
</body>
</html>