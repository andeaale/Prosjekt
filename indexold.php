<!--  Industriell IKT 
 Lab 4 (PHP) 
 2014.11.18

 Group members: 
 1. Andrii Petrychak
 2. Christian Marås
 3. Svanhild Thomsen
 4. Petter Svellingen -->

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>

<?php

echo "<table style='border: solid 1px black;'>";
class TableRows extends RecursiveIteratorIterator { 
	function __construct($it) { 
		parent::__construct($it, self::LEAVES_ONLY); 
	}

	function current() {
		return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
	}

	function beginChildren() { 
		echo "<tr>"; 
	} 

	function endChildren() { 
		echo "</tr>" . "\n";
	} 
} 

$servername = "localhost";
$username = "root";
$password = 'Brilliant31%';

$database = null;
$table = null;

if(isset($_GET['myDatabase'])){
	$database = $_GET['myDatabase'];
}

if(isset($_GET['myTable'])){
	$table = $_GET['myTable'];
}

if(!$database && !$table){

	$conn = new mysqli($servername, $username, $password); 
	if ($conn->connect_error) { 
		die("Connection failed: ".$conn->connect_error); 
	} 

	$sql = "SHOW DATABASES"; 
	$result = $conn->query($sql); 
	if ($result->num_rows > 0) {

    echo "Databases (";
    echo "<a href='/'>localhost).</a><br /><br />";

	while($row = $result->fetch_assoc()) { 

		echo "<a href='/index.php?myDatabase=".$row["Database"]."'>".$row["Database"]."</a>";
		echo "<br />"; 
	} 
}

}

if($database && !$table){
	echo "Database ".$database;
	echo "<br />";

   echo "Goto ";
   echo "<a href='/index.php?myDatabase='.$database'>database menu</a><br /><br />";

   $conn = new mysqli($servername, $username, $password); 
	if ($conn->connect_error) { 
		die("Connection failed: ".$conn->connect_error); 
	} 
	$sql = "SHOW TABLES FROM ".$database; 
	$result = $conn->query($sql); 

	if ($result->num_rows > 0) { 
	 // output data of each row 


		while($row = $result->fetch_assoc()) { 
			$column_name = "Tables_in_".$database;
			echo "<a href='/index.php?myDatabase=".$database."&myTable=".$row[$column_name]."'>".$row[$column_name]."</a>";
			echo "<br />"; 
		} 

	}

}

if($database && $table){

	echo "Table ".$table." Database ".$database;
	echo "<br />"; 

	echo "<a href='/index.php?myDatabase='.$database'>Goto database menu</a>";
	echo "<br />";

	try {
    $conn = new PDO("mysql:host=$servername;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM ".$database.".".$table." LIMIT 100"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
    $dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
echo "</table>";
}

?>
</body>
</html>
