<?php
session_start();
if(isset( $_SESSION['error']))
{
?>
    <tr>
    <td id="error"><?php echo $_SESSION['error']; ?></td>
    </tr>
    <?php
}
//echo $_POST['password'];
//$password = hash('md5',$salt.htmlentities($_POST['password']));
  //  echo $password;
?>
<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<form id="f1" class="form-group" action="index.php" method="POST" onsubmit="return validateForm()">
<lable>email</lable>
<input type="textbox" id="email" name="email" >
<br>
<lable>pass</lable>
<input type="password" id="pass" name="pass" >
<br>
<input type="submit" name="login" value="Log In">
<button><a href="index.php">Cancel</a></button>
</form>
<script>
function validateForm(){
    var x = document.forms["f1"]["username"].value;
    var y = document.forms["f1"]["password"].value;
  
  if(!(validateEmptyField(x)&&validateEmptyField(y))){
      alert('All fields are required');
  }
  
    return  validateEmptyField(x)&&validateEmptyField(y)&&validateEmail(x) ;
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if(!re.test(email)){
     alert('Incorrect email id');
  }
  return re.test(email);
}
function validateEmptyField(x){
    
  if (x == "") {
  
    return false;
  }
  return true;
}
</script>
</body>
</html>
