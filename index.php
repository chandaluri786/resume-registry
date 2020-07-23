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
    $username = htmlentities($_POST['email']);
    $password = hash('md5', $salt . htmlentities($_POST['pass']));
 //  echo $password;

    $user = $conn->prepare('select * from users where email = :username and password = :password');
    $user->bindValue(':username', $username, PDO::PARAM_STR);
    $user->bindValue(':password', $password, PDO::PARAM_STR);
    $user->execute();
    $res = $user->fetch(PDO::FETCH_OBJ);
    if ($res != null) {
        $_SESSION['user_id'] = $res->user_id;
        $_SESSION['name'] = $res->first_name . $res->last_name;

    } else {
        $_SESSION['error'] = "Incorrect Password";
        header("Location: login.php");
    }
}
?>

<?php
//inserting values
if (isset($_POST['add'])) {
    echo 'inside profile add fn';
    // print_r($_SESSION);
    // echo $_SESSION['user_id'] . '<br>';
    $stmt = $conn->prepare('insert into Profile (user_id, first_name, last_name, email, headline,summary)values(:ui,:fn,:ln,:e,:h,:s)');
    $stmt->execute(array(':ui' => $_SESSION['user_id'], ':fn' => htmlentities($_POST['first_name']), ':ln' => htmlentities($_POST['last_name']), ':e' => htmlentities($_POST['email']), ':h' => htmlentities($_POST['headline']), ':s' => htmlentities($_POST['summary'])));
    // $stmt->debugDumpParams();
    $pid = $conn->lastInsertId();

    function validatePos()
    {
                for ($i = 1; $i <= 9; $i++) {
            if (!isset($_POST['year' . $i])) {
                continue;
            }

            if (!isset($_POST['desc' . $i])) {
                continue;
            }

            $year = $_POST['year' . $i];
            $desc = $_POST['desc' . $i];
            //echo $year . '' . $desc;

            if (strlen($year) == 0 || strlen($desc) == 0) {

                return "All fields are required";
            }

            if (!is_numeric($year)) {

                return "Position year must be numeric";

            }
        }
        return true;
    }
    // echo validatePos();
    if (validatePos() != 1) {

        $_SESSION['add_error'] = validatePos();
        header('Location: add.php');
    } else {
        unset($_SESSION['add_error']);
        echo '<h6>Profile added</h6>';
        //header('Location: ' . $_SERVER['REQUEST_URI']);
        $rank = 1;
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($_POST['year' . $i])) {
                continue;
            }

            if (!isset($_POST['desc' . $i])) {
                continue;
            }

            $year = $_POST['year' . $i];
            $desc = $_POST['desc' . $i];
            $stmt2 = $conn->prepare('insert into Position (profile_id, rank, year, description)  values ( :pid, :rank, :year, :desc)');

            $stmt2->execute(array(
                ':pid' => $pid,
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc)
            );
//$stmt2->debugDumpParams();

            $rank++;

        }
    }
}

?>
<?php
//deleting records
if (isset($_POST['delete'])) {

    $post = $conn->prepare('delete from Profile where profile_id = :pid');
    $post->execute([':pid' => $_SESSION['profile_id']]);
    echo '<h6>Profile deleted</h6>';
    //header('Location: ' . $_SERVER['REQUEST_URI']);
    $stmt1 = $conn->prepare('DELETE FROM Position WHERE profile_id=:pid');
    $stmt1->execute(array(':pid' => $_SESSION['profile_id']));

}

?>
<?php
//editing records
if (isset($_POST['edit'])) {

    $post = $conn->prepare('update Profile set first_name = :fn, last_name = :ln, email = :e, headline = :h,summary = :s where profile_id = :pid');
    $post->execute(array(':fn' => htmlentities($_POST['first_name']), ':ln' => htmlentities($_POST['last_name']), ':e' => htmlentities($_POST['email']), ':h' => htmlentities($_POST['headline']), ':s' => htmlentities($_POST['summary']), ':pid' => htmlentities($_SESSION['profile_id'])));
    //$post->debugDumpParams();
    echo '<h6>Profile edited</h6>';
    //header('Location: ' . $_SERVER['REQUEST_URI']);
    function validatePos()
    {
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($_POST['year' . $i])) {
                continue;
            }

            if (!isset($_POST['desc' . $i])) {
                continue;
            }

            $year = $_POST['year' . $i];
            $desc = $_POST['desc' . $i];
           // echo $year . '' . $desc;

            if (strlen($year) == 0 || strlen($desc) == 0) {

                return "All values are required";
            }

            if (!is_numeric($year)) {

                return "Year must be numeric";

            }
        }
        return true;
    }
    //echo validatePos();
    if (validatePos() != 1) {

        $_SESSION['edit_error'] = validatePos();
        header('Location: edit.php?profile_id=' . $_SESSION['profile_id']);
    } else {
        unset($_SESSION['edit_error']);
        $stmt1 = $conn->prepare('DELETE FROM Position WHERE profile_id=:pid');
        $stmt1->execute(array(':pid' => $_SESSION['profile_id']));
        $rank = 1;
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($_POST['year' . $i])) {
                continue;
            }

            if (!isset($_POST['desc' . $i])) {
                continue;
            }

            $year = $_POST['year' . $i];
            $desc = $_POST['desc' . $i];
            $stmt2 = $conn->prepare('insert into Position (profile_id, rank, year, description)  values ( :pid, :rank, :year, :desc)');

            $stmt2->execute(array(
                ':pid' => $_SESSION['profile_id'],
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc)
            );
            //$stmt2->debugDumpParams();

            $rank++;

        }

    }
}
?>
<?php
if ($_SESSION['user_id'] != null) {
    echo '
<a href="logout.php">Logout</a><br>
<a href = "add.php">Add New Entry</a> ';

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
    echo '<a href="login.php">Please log in</a>';

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
        "<td>" . "<a href= \"view.php?profile_id= " . $p->profile_id . " \" >" . $p->first_name . $p->last_name . "</a>" . "</td>" .
        "<td>" . $p->headline . "</td>" . "</tr>";
    }
}

?>


</body>
</html>