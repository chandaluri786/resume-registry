<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['user_id']);
unset($_SESSION['error']);
header('Location: index.php');
?>
<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
</head>
</html>
