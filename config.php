<?php 

	//Adatok a kapcsolódáshoz
	$conn = new mysqli("localhost", "team05", "DYJlbCv0KCTN537", "team05");
	//ez kell a Zolis adatbázishoz ide meg a function.php ba 
	//$conn = new mysqli("localhost", "team05", "DYJlbCv0KCTN537", "team05");
	
	//Ellenőrizzük, hogy létrejön-e a kapcsolat, ha nem, kiírjuk a hibaüzenetet.
	if($conn->connect_error){
		die("Connection Failed! ".$conn->connect_error);
	}

?>