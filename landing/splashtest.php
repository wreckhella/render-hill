<?php
	
	$str = file_get_contents('splashes.txt');

	$splashes = explode("\n",$str);

	$ind = rand(1, count($splashes)) -1;
	
	
	echo $splashes[$ind];

?>