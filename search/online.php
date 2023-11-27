<?php
	include("../core/config.php");
	include("../core/header.php");
	
	if (isset($_GET['search'])) {
		echo '<head><title>\'' . $_GET['search'] . '\' Search - TDBDNH</title></head>';}
	else {
		echo '<head><title>Search - TDBDNH</title></head>';}
?>

<!DOCTYPE html>
	<body>
		<div id="body">
			<div id="box" style="text-align:center;">
				<div id="subsect">
					<form action="index" method="GET" style="margin:15px;">
						<input style="width:500px; height:20px;" type="text" name="search" placeholder="I'm looking for...">
						<input style="height:24px;" type="submit" value="Submit">
					</form>
				</div>
				<?php
					if(isset($_GET['search'])) {$query = mysqli_real_escape_string($conn,strtolower($_GET['search']));} else {$query = '';}
					
					$sqlSearch = "SELECT * FROM `beta_users` WHERE  `usernameL` LIKE '%$query%'";
					$result = $conn->query($sqlSearch);
					echo '<table width="100%"cellspacing="0"cellpadding="4"border="0"style="background-color:#000;"><tbody>';
					while($searchRow=$result->fetch_assoc()){ 
						$lastonline = strtotime($curDate)-strtotime($searchRow['last_online']);
						if ($lastonline <= 300) {
						echo '<tr class="searchColumn" style="color:#c3cdd2;"><td><img style="vertical-align:middle; width:50px;" src="/images/avatars/'?><?php echo $searchRow["id"];
						echo '.png?c=';
						echo $searchRow['avatar_id']; 
						echo '">';
						echo '<a style="color:#c3cdd2;" href="/user?id=' . $searchRow['id'] . '">' . $searchRow['username'] . '</a></td>';
						echo '<td style="text-align:center; color:#c3cdd2;"><p>'; if($searchRow['description'] > null) {echo substr(htmlentities($searchRow['description']),0,75) , str_repeat("...",(strlen($searchRow['description']) >= 75)); }
						echo'</p></td>';
						if ($lastonline <= 300) {echo '</tbody>';}
						else {echo '</tbody>';}
					}
				}echo '</table>';
				?>
				<span>
					<a href="/search/online" style="color: #09bd00;font-size: 12px;float: right;margin-right: 20px;padding-top:5px;">Online Users</a>
				</div>
				</span>
			</div>
		</div>
		<?php 
		include("../core/footer.php");
		?>
	</body>
</html>