<?php
    include("../core/config.php");
    include("../core/header.php");
   
?>
<!DOCTYPE html>
<html>
<head>
<style>
@font-face {
	font-family: "idk";
	src: url('../assets/W95FA.ttf');
}

.button {
    padding: 5px;
    /* margin: 50px; */
    font-size: 1.5rem;
    background-color: #08ca08;
    border-bottom: 5px solid #008600;
    text-align: center;
}
.button:hover {
	position: center;
	cursor: pointer;
}
.button:active {
	position: center;
    border-bottom: 0px solid transparent;
    margin-top: 15px;
}
.red-button {
	position: center;
	background-color: #FF5747;
	border-bottom: 5px solid #CB4538;
}
.green-button {
	position: center;
	background-color: #2BDC32;
	border-bottom: 5px solid #22B229;
}
  .blue-button {
	position: center;
    background-color: #15BFFF;
    border-bottom: 5px solid #109ACD;
    color: white;
    text-align: center;
  
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
</style>
	<style>
	#landing {

	   height: 400px;

	}
	</style>
	<title>Main Page - TDBDNH: Revived</title>
</head>
<body>
	<div id="body">
		<div id="box">
		<div id="landing" style="padding: 10px;">
		<center><img src="/landing/lol.png"></img></center>
				<div style="display: inline-table;padding-top: 5%;padding-left: 5%;">
          
          <div>
            
          <div class="button pixel-text blue-button" style="display:inline-block; onClick="/register/"">
					<a href="/register/" style="color:white;">Sign Up today!</a>
          </div></div>
<div class="button pixel-text blue-button" style="display:inline-block; onClick="/login/"">
					<a href="/login/" style="color:white">Have an Account? Login.</a> </div>
				</div>
			</div><?php 
    include("about-us.php");
    ?>
    </div></div>
	<?php
	        include("../core/footer.php");
	    ?>
</body>
</html>