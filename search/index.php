<?php
	include("../core/config.php");
	include("../core/header.php");
	
	if (isset($_GET['search'])) {
		echo '<head><title>\'' . $_GET['search'] . '\' Search - TDBDNH</title></head>';}
	else {
		echo '<head><title>Search - TDBDNH</title></head>';}
	
	if(isset($_GET['page'])) {$page = mysqli_real_escape_string($conn,intval($_GET['page']));} else {$page = 0;}
	$page = max($page,1);
?>

<!DOCTYPE html>
	<body>
		<div id="body">
			<div id="box" style="text-align:center;">
				<div id="subsect">
					<form action="" method="GET" style="margin:15px;">
						<input style="width:500px; height:20px;" type="text" name="search" placeholder="I'm looking for...">
						<input style="height:24px;" type="submit" value="Submit">
					</form>
				</div>
				<?php
				if (isset($_GET['search'])) {
					$query = mysqli_real_escape_string($conn,strtolower($_GET['search']));
					
					$sqlCount = "SELECT * FROM `beta_users` WHERE  `usernameL` LIKE '%$query%' ORDER BY `username`";
					$countQ = $conn->query($sqlCount);
					$count = $countQ->num_rows;
					
					$page = min($page,max((int)($count/20),1));
	
					$limit = ($page-1)*20;
					
					$sqlSearch = "SELECT * FROM `beta_users` WHERE  `usernameL` LIKE '%$query%' ORDER BY `username` LIMIT $limit,20";
					$result = $conn->query($sqlSearch);
					echo '<table width="100%"cellspacing="0"cellpadding="4"border="0"><tbody>';
					while($searchRow=$result->fetch_assoc()){ 
						$lastonline = strtotime($curDate)-strtotime($searchRow['last_online']);
						echo '<tr class="searchColumn" style="color:#c3cdd2;"><td><img style="vertical-align:middle; width:50px;" src="/images/avatars/'?><?php echo $searchRow["id"]; ?><?php echo '.png?c='?><?php echo $searchRow['avatar_id']; ?><?php echo '">';
						echo '<a style="color:#c3cdd2;" href="/user?id=' . $searchRow['id'] . '">' . $searchRow['username'] . '</a></td>';
						echo '<td style="text-align:center;"><p>'; if($searchRow['description'] > null) {echo substr(htmlentities($searchRow['description']),0,50) , str_repeat("...",(strlen($searchRow['description']) >= 50)); } echo'</p></td>';
						if ($lastonline >= 300) {
							$timedif = $lastonline . " seconds";
							if ($lastonline >= 300) {$timedif = (int)gmdate('i',$lastonline) . " minutes";}
							if ($lastonline >= 3600) {$timedif = (int)gmdate('H',$lastonline) . " hours";}
							if ($lastonline >= 86400) {$timedif = (int)gmdate('d',$lastonline) . " days";}
							if ($lastonline >= 2592000) {$timedif = (int)gmdate('m',$lastonline) . " months";}
							if ($lastonline >= 31536000) {$timedif = (int)gmdate('Y',$lastonline) . " years";}
							echo '<td style="text-align:center;"><span style="color:#c3cdd2; font-weight: bold;">' . $timedif . ' ago</span></td>';}
						else {
							}
						if ($lastonline <= 300) {echo '';}
						else {echo '<td style="text-align:center;"><i style="color:#c3cdd2;font-size:15px;" class="fa fa-circle"></i></td>';}
					}
				} echo '</tbody></table>';
				?>
				<span>
				
				<?php
				if(isset($_GET['search'])) {
					echo '<div class="numButtonsHolder" style="margin-left:auto;margin-right:auto;margin-top:10px;">';
					if($page-2 > 0) {
					    echo '<a style="color:#c3cdd2;" href="?search='.$query.'&page=0">1</a> ... ';
					}
					if($count/20 > 1) {
				          for($i = max($page-2,0); $i < min($count/20,$page+2); $i++)
				          {
				            echo '<a style="color:#c3cdd2;" href="?search='.$query.'&page='.($i+1).'">'.($i+1).'</a> ';
				          }
				        }
				        if($count/20 > 4) {
				            echo '... <a style="color:#c3cdd2;" href="?search='.$query.'&page='.round($count/20).'">'.round($count/20).'</a> ';
				        }
					
					echo '</div>';
				}
				?>
				
					<a href="/search/online" style="color: #09bd00;font-size: 12px;float: right;margin-right: 20px;padding-top: 3px;">Online Users</a>
				</span>
				</dv>
			</div>
		</div>
		<?php 
		include("../core/footer.php");
		?>
	</body>
</html>