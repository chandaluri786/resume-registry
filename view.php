<?php
session_start();
$mysql_host = 'localhost';
$mysql_username = 'jahnavi';
$mysql_password = 'chandaluri';
$conn = new PDO("mysql:host=$mysql_host;dbname=resume", $mysql_username, $mysql_password);
$post = $conn->prepare('select * from Profile where profile_id = :pid');
$post->execute([':pid' => $_GET['profile_id']]);
$res = $post->fetch(PDO::FETCH_OBJ);
echo 'Profile Id: ' . $res->profile_id . "<br>" . 'First Name: ' . $res->first_name . "<br>" . 'Last Name: ' . $res->last_name . "<br>" . 'Email: ' . $res->email . "<br>" . 'Headline: ' . $res->headline . "<br>" . 'Summary: ' . $res->summary . "<br>";

?>
<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
</head>
<button><a href="index.php">Cancel</a>
</html>
