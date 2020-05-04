<?php
session_start();
?>
<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<?php
$mysql_host = 'localhost';
$mysql_username = 'jahnavi';
$mysql_password = 'chandaluri';
$conn = new PDO("mysql:host=$mysql_host;dbname=resume", $mysql_username, $mysql_password);
$_SESSION['profile_id'] = $_GET['profile_id'];
$post = $conn->prepare('select * from Profile where profile_id = :pid');
$post->execute([':pid' => $_GET['profile_id']]);
$res = $post->fetch(PDO::FETCH_OBJ);

?>

<?php

if ($res->user_id == $_SESSION['user_id']) {
    echo '<h1>Editing Profile</h1>'; 
    echo   '<form id="f3"  class="form-group" action="index.php" method="POST" onsubmit="return validateForm()">
   <lable>First Name</lable>
   <input type="textbox" id="first_name" name="first_name" value="'. $res->first_name .'">
   <br>
   <lable>Last Name</lable>
   <input type="textbox" id="last_name" name="last_name" value="'. $res->last_name .'" >
   <br>
   <lable>Email</lable>
   <input type="textbox" id="email" name="email" value="'. $res->email .'">
   <br>
   <lable>Headline</lable>
   <input type="textbox" id="headline" name="headline" value="'. $res->headline .'">
   <br>
   <lable>Summary</lable>
   <input type="textbox" id="summary" name="summary" value="'. $res->summary . '" >
   <br>
   <form action="index.php" method="POST">
   <input type="submit" name="edit" value="Save">
   <button><a href="index.php">Cancel</a>
   </form>';

    

} else {
    echo "You cannot edit this record"."<br>";
    echo "<button><a href=\"index.php\">Cancel</a>";

}
?>
<script>
function validateForm(){
   
    var e = document.forms["f3"]["email"].value;
    return  validateEmail(e) ;
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if(!re.test(email)){
     alert('Incorrect email id');
  }
  return re.test(email);
}

</script>

</body>

</html>