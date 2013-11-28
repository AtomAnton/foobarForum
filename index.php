<!DOCTYPE html>
<?php
	include "includes/config.php"; 
	include "includes/funcs.php";
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
	<table class="forum">
		<tbody>	
			<tr>
				<th class="headerRow">Forums</th>
				<th class="headerRow">Threads</th>
				<th class="headerRow">Posts</th>
				<th class="headerRow">Latest post</th>
			</tr>
			<?php 
				$query = mysqli_query($conn, "SELECT category_name,category_id FROM category");
				while($row = mysqli_fetch_array($query)) {
					echo "<tr>";
						echo "<td width=\"55%\"><a href=\"forum.php?f={$row['category_id']}\">{$row['category_name']}</a></td>";
						echo "<td width=\"15%\">N/A</td>";
						echo "<td width=\"15%\">N/A</td>";
						echo "<td width=\"15%\" class=\"latestPost\">N/A</td>";
						//echo "<td width=\"15%\" class=\"latestPost\">" . "<a href=\"#\">Random post</a> Today 08:00 <br/> by admin" . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
	</div>
</body>
</html>