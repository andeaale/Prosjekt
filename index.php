<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="index.html">
                        Raspberry Pi Server
                    </a>
                </li>
                <li>
                <a href="side1.html">Side 1</a>
                </li>
                <li>
                    <a href="side2.html">Side 2</a>
                </li>
                <li>
                    <a href="side3.html">Side 3</a>
                </li>
                  <li>
                        <a href="side4.html">Side 4</a>
                    </li>
                    <li>
                        <a href="side5.html">Side 5</a>
                    </li>
                <li>
                    <a href="index.php">Database table</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Database Tabels</h1>
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
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
