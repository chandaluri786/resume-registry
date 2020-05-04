<?php
session_start();
//print_r($_SESSION);

?>
<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>



<body>
<script>
function validateForm(){
    var fn = document.forms["f2"]["first_name"].value;
    var ln = document.forms["f2"]["last_name"].value;
    var e = document.forms["f2"]["email"].value;
    var h = document.forms["f2"]["headline"].value;
    var s = document.forms["f2"]["summary"].value;

  
  if(!(validateEmptyField(fn)&&validateEmptyField(ln)&&validateEmptyField(e)&&validateEmptyField(h)&&validateEmptyField(s))){
      alert('All fields are required');
  }
  
    return  validateEmptyField(fn)&&validateEmptyField(ln)&&validateEmptyField(e)&&validateEmptyField(h)&&validateEmptyField(s)&&validateEmail(e) ;
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
<?php
echo "<h1>Adding profile for" . $_SESSION['name'] . "</h1>";
?>
<form id="f2"  class="form-group" action="index.php" method="POST" onsubmit="return validateForm()">
<lable class="col-form-label">First Name</lable>
<input type="textbox" id="first_name" name="first_name"   >
<br>
<lable class="col-sm-2 col-form-label" >Last Name</lable>
<input type="textbox" id="last_name" name="last_name"   >
<br>
<lable class="col-sm-2 col-form-label ">Email</lable>
<input type="textbox" id="email" name="email"   >
<br>
<lable class="col-sm-2 col-form-label ">Headline</lable>
<input type="textbox" id="headline" name="headline"  >
<br>
<lable class="col-sm-10 col-form-label ">Summary</lable>
<input type="textbox" id="summary" name="summary" >
<br>
<input type="submit" name="add" value="Add">
<button><a href="index.php">Cancel</a></button>
</form>

</body>
</html>
