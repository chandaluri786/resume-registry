<?php
session_start();
?>
<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
</head>
<body>
<h1>Deleting Profile</h1>
<?php
$mysql_host = 'localhost';
$mysql_username = 'jahnavi';
$mysql_password = 'chandaluri';
$conn = new PDO("mysql:host=$mysql_host;dbname=resume", $mysql_username, $mysql_password);
$_SESSION['profile_id'] = $_GET['profile_id'];
$post = $conn->prepare('select * from Profile where profile_id = :pid');
$post->execute([':pid' => $_GET['profile_id']]);
$res = $post->fetch(PDO::FETCH_OBJ);
echo "<p>First Name: " . $res->first_name . "</p><br>";
echo "<p>Last Name: " . $res->last_name . "</p><br>";
if ($res->user_id == $_SESSION['user_id']) {
    echo "<form action=\"index.php\" method=\"POST\">
<input type=\"submit\" name=\"delete\" value=\"Delete\">
<button><a href=\"index.php\">Cancel</a>
</form>";

} else {
    echo "You cannot delete this record" . "<br>";
    echo "<form action=\"index.php\" method=\"POST\">
<input type=\"submit\" name=\"delete\" value=\"Delete\">
<button><a href=\"index.php\">Cancel</a>
</form>";

}
?>

</body>

</html>