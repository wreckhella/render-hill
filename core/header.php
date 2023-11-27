<?php
include('config.php');
   $building = false;  //maintenance status, true equals it's in maintenance, false - the opposite


    if($_SESSION["canAccess"] != "true"){
        if(!isset($_SESSION["canAccess"])){
            if($building == "true"){
                die("<script>window.location = '/information/maintenance/'</script>");
            }
        }   
    }

$membershipPower = -1;
if (isset($_SESSION['id'])) {
  
  $currentUserID = $_SESSION['id'];
  $findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$currentUserID'";
  $findUser = $conn->query($findUserSQL);
  
  if ($findUser->num_rows > 0) {
    $userRow = (object) $findUser->fetch_assoc();
  } else {
    unset($_SESSION['id']);
    //header('Location: /landing/');
  }
  
  $power = $userRow->{'power'};
  $UID = $userRow->{'id'};
  $currentID = $userRow->{'id'};
  $curDate = date('d/m/Y H:i');
  $sqlRead = "UPDATE `beta_users` SET `last_online` = '$curDate' WHERE `id` = '$currentUserID'";
  $result = $conn->query($sqlRead);
  
//ez

  $loggedIn = true;
} else {
  $loggedIn = false;
  
  $URI = $_SERVER['REQUEST_URI'];
  if ($URI != '/login/' && $URI != '/register/') {
    //header('Location: /login/');
  }
}

$shopUnapprovedAssetsSQL = "SELECT * FROM `shop_items` WHERE `approved`='no' ORDER BY `date` DESC LIMIT 0,10";
$shopUnapprovedAssets = $conn->query($shopUnapprovedAssetsSQL);
$unapprovedNum = $shopUnapprovedAssets->num_rows;
?>
<!DOCTYPE html>
  <head>
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="/javascript/security.js?r=<?php echo rand(10000,1000000) ?>"></script>
  <?php 
  if($loggedIn) {
    $theme = $userRow->{'theme'};
  } else {
    $theme = 0;
  }
  ?>
    <link rel="icon" href="/assets/BH_favicon.png">
    <link rel="stylesheet" href="/style.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div id="header">
      <div id="banner">
  <?php if($loggedIn) {echo '<div id="welcome"><a class="nav" style="margin-top: 7px;" href="/" >Logged as: '. $userRow->{'username'}.'</a></div>';} ?>
        <div id="info" <?php if(!$loggedIn) {echo 'style="visibility:hidden;"';} ?> >
          <span style="display:inline-block;float: left;margin-left: -5px; margin-top: 5px;">
            
              <a class="nav" href="/messages/"><i class="fa fa-envelope"></i>
                <?php 
                if($loggedIn) {
                  $mID = $userRow->{'id'};
                  $sqlSearch = "SELECT * FROM `messages` WHERE  `recipient_id` = '$mID' AND `read` = 0";
                  $result = $conn->query($sqlSearch);
                  
                  $messages = 0;
                  while($searchRow=$result->fetch_assoc()) {$messages++;}
                  echo number_format($messages); 
                }
                ?>
              </a>
              <a class="nav" href="/friends/"><i class="fa fa-users"></i> 
              <?php
              if($loggedIn) {
                $requestsQuery = mysqli_query($conn,"SELECT * FROM `friends` WHERE `to_id`='$mID' AND `status`='pending'");
                $requests = mysqli_num_rows($requestsQuery);
                echo number_format($requests);
              }
              ?>
              </a>
            
          </span>
            </ul>
          </span>
        </div>
      </div>
      <div id="navbar">
        <span>
          <span>
            <a class="nav" href="/shop/">Shop</a>
          </span>
          <span>  </span>
          <span>
            <a class="nav" href="/customize/">Customize Avatar</a>
          </span>
          <span></span>
		   <span>
            <a class="nav" href="/search/">Users</a>
          </span>
<span style="float:right; margin-top: -3px;">
          <?php
          if($loggedIn) {
            echo '<a class="nav" href="/login/logout">Logout</a>';
          } else {
            echo '<a class="nav" href="/login/">Login</a>    <a class="nav" href="/register/">Register</a>';
          }
          
          ?>
</div>
         
          
          </span>
        </span>
</span>
      </div>
    </div>
<?php
  if($_SERVER['REMOTE_ADDR'] != '82.21.246.202') { //for working on the site
    //exit;
  }
  ////
  if($loggedIn) {
    $bannedSQL = "SELECT * FROM `moderation` WHERE `active`='yes' AND `user_id`='$currentID'";
    $banned = $conn->query($bannedSQL);
    if($banned->num_rows != 0) {//they are banned
      $URI = $_SERVER['REQUEST_URI'];
      if ($URI != '/banned/') {
      header('Location: /banned/');
    
      $bannedRow = $banned->fetch_assoc();
      $banID = $bannedRow['id'];
      $currentDate = strtotime($curDate);
      $banEnd = strtotime($bannedRow['issued'])+($bannedRow['length']*60);
      if($bannedRow['length'] <= 0) {$title = "You have been warned";}
      elseif($bannedRow['length'] < 60) {$title = "You have been banned for ".$bannedRow['length']." minutes";}
      elseif($bannedRow['length'] >= 60) {$title = "You have been banned for ".round($bannedRow['length']/60)." hours";}
      elseif($bannedRow['length'] >= 1440) {$title = "You have been banned for ".round($bannedRow['length']/1440)." days";}
      elseif($bannedRow['length'] >= 43200) {$title = "You have been banned for ".round($bannedRow['length']/43200)." months";}
      elseif($bannedRow['length'] >= 525600) {$title = "You have been banned for ".round($bannedRow['length']/525600)." years";}
      elseif($bannedRow['length'] >= 36792000) {$title = "You have been terminated";}
      echo '<head>
          <title>Banned - Render Hill</title>
        </head>
        <body>
          <div id="body">
            <div id="box">
              <h3>'.$title.'</h3>
              <div style="margin:10px">
                Reviewed: ' . gmdate('m/d/Y',strtotime($bannedRow['issued'])) . '<br>
                Moderator Note:<br>
                <div style="border:1px solid;width:400px;height:150px;background-color:#F9FBFF">
                  ' . $bannedRow['admin_note'] . '
                </div>';
      
      if($currentDate >= $banEnd) {
        if(isset($_POST['unban'])) {
          $unbanSQL = "UPDATE `moderation` SET `active`='no' WHERE `id`='$banID'";
          $unban = $conn->query($unbanSQL);
          header("Refresh:0");
        }
        echo 'You can now reactivate your account<br>
        <form action="" method="POST">
          <input type="submit" name="unban" value="Reactivate my account">
        </form>';
      } else {
        echo 'Your account will be unbanned on ' . date('d-m-Y H:i:s',$banEnd);
      }
      echo '
              </div>
            </div>
          </div>
        </body>';
      exit;
    }
  }
}
?>