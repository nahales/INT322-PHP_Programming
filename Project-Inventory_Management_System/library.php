<?php
	function title($title){
			echo "<img src=\"logo.jpg\" alt=\"Nahal Mobile Store\">";
			echo "<p class='menu' style='text-align: left;'>$title
				 <span style='float: right;'><a href = 'add.php'>Add</a> &nbsp&nbsp&nbsp <a href = 'view.php'>View All</a></span></p>";
			echo "<hr/>";	
		}

		function cleanInput($var){
			 $var = trim($var);
			 $var = stripslashes($var);
			 $var = htmlspecialchars($var);
		  return $var;
		}

		function connectionDB(){
			include "../../secret/topsecret.php";
			$dbConnect = mysqli_connect($serverDB, $userName, $userPwd, $nameDB);
			return $dbConnect;
		}
?>