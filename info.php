<?php
echo "hello world";
?>
 <?php
$servername = "localhost";
$username = "jahnavi";
$password = "chandaluri";

try {
    $conn = new PDO("mysql:host=$servername;dbname=cms", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?> 
<?php
 $complaint=$conn->prepare('select * from complaint');
$complaint->execute([]);
 $complaints = $complaint -> fetchAll(PDO::FETCH_OBJ);
//var_dump($complaints);
foreach($complaints as $c){
echo $c -> name . "<br>";
}
?>
