<?php 
/*
 ___ _ __   _____      ____      _____| |__   ©
/ __| '_ \ / _ \ \ /\ / /\ \ /\ / / _ \ '_ \
\__ \ | | | (_) \ V  V /  \ V  V /  __/ |_) |
|___/_| |_|\___/ \_/\_/    \_/\_/ \___|_.__/

*/

/**
* This is a simple php script to 
* insert records and pull records 
* from the database using PDO
*/
class Quotes{
	/**
	* This function initiates a connection
	* to the database
	* @return $db
	*/
	public function connectToDB(){
		//Declare the database variables $dbhost,$dbpass,$dbuser,$dbname	
		$dbhost = "localhost";
        $dbpass = "qwertyuiop)(*&^%$#@!";
        $dbuser = "root";
        $dbname = "Quotes";
        $dsn 	= "mysql:host=$dbhost; dbname=$dbname";
        try{
		$pdo = new PDO($dsn,$dbuser,$dbpass);
		// set the PDO error mode to exception
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	    return $pdo;
		}catch(PDOException $e){
			echo "Sorry there is no opensource connection, try again latter";
		}
	}

	/**
	* This function pulls records from the database
	*/
	public function pullQuotes(){
		$pdo = $this->connectToDB();  //Connect to DB
		try{
			$query	= $pdo->prepare("SELECT * FROM quote"); 
		    $query->execute();
	    $result = $query->fetchAll();						//Pull every record from the table
		    return $result;									//return Result
		}catch(PDOException $e){
			echo "The pull request was not successful \n".$e->getMessage();
		}  
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>HNG Internship: Stage 1</title>
	</head>
	<body>
		<h3>Recent Activities:</h3>
		<ul>
		<!-- Pull the records from the quotes table-->
		<?php 
			$quotes = new Quotes; 
			$records = $quotes->pullQuotes();
			
			if(!empty($records)){
				for($i = 0; $i < count($records); $i++){
					echo "<li>";
					echo $records[$i]["username"]." posted <b>".$records[$i]["quote"]."</b> at ".date('F j ,g:ia',mktime($records[i]['time_posted']));
					echo "</li>";
				}			
			}else{
				echo "The record is empty";	
			}
		?>			
		</ul>
	</body>
</html>
