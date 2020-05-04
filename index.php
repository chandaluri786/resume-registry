<?php
session_start();
?>

<html>
<head>
<title>Chandaluri Jahnavi S S L</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<h1>Resume registry</h1>

<?php
$mysql_host = 'localhost';
$mysql_username = 'jahnavi';
$mysql_password = 'chandaluri';
$conn = new PDO("mysql:host=$mysql_host;dbname=resume", $mysql_username, $mysql_password);
if (isset($_POST['login'])) {
    $username = htmlentities($_POST['username']);
    $password = hash('md5',$salt.htmlentities($_POST['password']));
    //echo $password;

    $user = $conn->prepare('select * from users where email = :username and password = :password');
    $user->bindValue(':username', $username, PDO::PARAM_STR);
    $user->bindValue(':password', $password, PDO::PARAM_STR);
    $user->execute();
    $res = $user->fetch(PDO::FETCH_OBJ);
    if ($res != null) {
        $_SESSION['user_id'] = $res->user_id;
        $_SESSION['name'] = $res->first_name . $res->last_name;
        
    }
    else{
        $_SESSION['error'] = "Incorrect Password";
        header("Location: login.php");
    }
}
?>

<?php
//inserting values
if (isset($_POST['add'])) {
   // echo 'inside profile add fn';
   // print_r($_SESSION);
   // echo $_SESSION['user_id'] . '<br>';
    $stmt = $conn->prepare('insert into Profile (user_id, first_name, last_name, email, headline,summary)values(:ui,:fn,:ln,:e,:h,:s)');
    $stmt->execute(array(':ui' => $_SESSION['user_id'], ':fn' => htmlentities($_POST['first_name']), ':ln' => htmlentities($_POST['last_name']), ':e' => htmlentities($_POST['email']), ':h' => htmlentities($_POST['headline']), ':s' => htmlentities($_POST['summary'])));
   // $stmt->debugDumpParams();
    echo '<h6>Profile added</h6>';
    //header('Location: ' . $_SERVER['REQUEST_URI']);
}

?>
<?php
//deleting records
if (isset($_POST['delete'])) {
    
    $post = $conn->prepare('delete from Profile where profile_id = :pid');
    $post->execute([':pid' => $_SESSION['profile_id']]);
    echo '<h6>Profile deleted</h6>';
    //header('Location: ' . $_SERVER['REQUEST_URI']);
    
}

?>
<?php
//editing records
if (isset($_POST['edit'])) {
   
    $post = $conn->prepare('update Profile set first_name = :fn, last_name = :ln, email = :e, headline = :h,summary = :s where profile_id = :pid');
    $post->execute(array(':fn' => htmlentities($_POST['first_name']), ':ln' => htmlentities($_POST['last_name']), ':e' => htmlentities($_POST['email']), ':h' => htmlentities($_POST['headline']), ':s' => htmlentities($_POST['summary']),':pid' => htmlentities($_SESSION['profile_id'])));
    //$post->debugDumpParams();
    echo '<h6>Profile edited</h6>';
    //header('Location: ' . $_SERVER['REQUEST_URI']);
}
?>
<?php
if ($_SESSION['user_id'] != null) {
    echo '
<a href="logout.php">Logout</a><br>
<a href = "add.php">Add a New Entry</a> ';

    $post = $conn->prepare('select * from Profile');
    $post->execute();
    $posts = $post->fetchAll(PDO::FETCH_OBJ);

    echo '
<table class="table table-bordered">
<th>Name</th>
<th>Hedline</th>
<th>Action</th>
';
    foreach ($posts as $p) {
        echo "<tr>" .
        "<td>" . 
        "<a href= \"view.php?profile_id=" . $p->profile_id . "\">" . 
        $p->first_name . $p->last_name . "</a>" . 
        
        "</td>" .
        "<td>" . $p->headline . "</td>" .
        "<td><div><a href= \"delete.php?profile_id=" . $p->profile_id . "\">DELETE</a></div>
             <div><a href= \"edit.php?profile_id=" . $p->profile_id . "\">EDIT</a></div></td>" .
            "</tr>";
    }
} else {
    echo '<a href="login.php">Sign in</a>';

    $post = $conn->prepare('select * from Profile');
    $post->execute();
    
    $posts = $post->fetchAll(PDO::FETCH_OBJ);
    

    echo '
<table class="table table-bordered">
<th>Name</th>
<th>Hedline</th>

';
    foreach ($posts as $p) {
        echo "<tr>" .
        "<td>" . "<a href= \"view.php?profile_id= ". $p->profile_id ." \" >" . $p->first_name . $p->last_name . "</a>" . "</td>" .
        "<td>" . $p->headline . "</td>" . "</tr>";
    }
}

?>


</body>
</html>