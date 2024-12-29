<?php

	$servername = 'localhost';
	$user 		= 'root';
	$pass 		= '';
	$db 		= 'nbspi_community_portal';
	$conn 		= mysqli_connect($servername, $user, $pass, $db);
	
	if(!$conn){
		die("").'<br>';
	}
?>