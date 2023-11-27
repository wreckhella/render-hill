<?php 
	$conn = mysqli_connect( "localhost" , "root", "!(tdbdnh123)" , "brickhill");  //host, user, dbpassword, db
	
	/* if(!$conn) {
		include("information/maintenance.php");   //was used for enabling maintenance (just do the funny with connection)
		die();
	} */
	
	//sorry, but every page should require a session -lukey
	if(session_status() == PHP_SESSION_NONE) {
		session_name("BRICK-SESSION");
		session_start();
	}


?>