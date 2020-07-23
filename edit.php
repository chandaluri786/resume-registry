<?php
session_start();
require_once 'util.php';
//print_r($_SESSION);
if (isset($_SESSION['edit_error'])) {

    echo $_SESSION['edit_error'];
}
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
$stmt = $conn->prepare('select * from Position where profile_id  = :pid order by rank');
$stmt->execute([':pid' => $_GET['profile_id']]);
$res1 = $stmt->fetchAll(PDO::FETCH_OBJ);

function displayPos($res1)
{

    $count = 1;
    foreach ($res1 as $value) {

        echo '<div id="Position' .
        $count .
        '">Year:<input type="textbox" name="year'
        . $count .
        '" value="' . $value->year . '" ><input type="button" value="-" onclick="$(\'#Position'
        . $count .
        '\').remove();return false;"><br><textarea  name="desc'
        . $count .
        '" row="8" cols="80" >' . $value->description . '</textarea></div>';
        $count++;

    }
}

if ($res->user_id == $_SESSION['user_id']) {
    echo '<h1>Editing Profile</h1>';
    echo '<form id="f3"  class="form-group" action="index.php" method="POST" onsubmit="return validateForm()">
   <lable>First Name</lable>
   <input type="textbox" id="first_name" name="first_name" value="' . $res->first_name . '">
   <br>
   <lable>Last Name</lable>
   <input type="textbox" id="last_name" name="last_name" value="' . $res->last_name . '" >
   <br>
   <lable>Email</lable>
   <input type="textbox" id="email" name="email" value="' . $res->email . '">
   <br>
   <lable>Headline</lable>
   <input type="textbox" id="headline" name="headline" value="' . $res->headline . '">
   <br>
   <lable>Summary</lable><br>
   <textarea id="summary" name="summary" >' . $res->summary . '</textarea>
   <br>

   <p>Position:<input type="submit" id="addPos" value="+">';
   displayPos($res1);
    echo '
<div id="position"></div>
    </p>

   <input type="submit" name="edit" value="Save">
   <button><a href="index.php">Cancel</a>
   </form>';

} else {
    echo "You cannot edit this record" . "<br>";
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
<script>
$(document).ready( function(){
  var  count = <?php echo sizeof($res1);?> ;
  $('#addPos').click(function(event){
    console.log('enterd the function');
   event.preventDefault();

if( count==9 ){
  alert('Maximum of nine position entries exceeded');
}
count++;
//console.log('adding position'+count);
 var long_str =
 '<div id="Position'
 + count +
 '">Year:<input type="textbox" name="year'
 + count +
 '" ><input type="button" value="-" onclick="$(\'#Position'
 + count +
 '\').remove();return false;"><br><textarea  name="desc'
 + count +
 '" row="8" cols="80"></textarea></div>';
 console.log(long_str);
  $('#position').append(long_str)
     });

});
</script>

</body>

</html>