<?php

define("HOST", "localhost");
define("USERNAME", "root");
define("PASSWORD","");
define("DB", "pizza_store");



function connectToDB() {
	try {
	  $conn = new PDO("mysql:host=".constant('HOST').";dbname=".constant('DB'), constant("USERNAME"), constant("PASSWORD"));  
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 
	catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	die();
	}
return $conn;
}


?>
