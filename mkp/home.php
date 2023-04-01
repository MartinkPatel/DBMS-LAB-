<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style2.css">

</head>




<body>

    <?php

    session_start();
    $email = $_SESSION['email'];
    $_SESSION['email'] = $email;
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Users";
    // Create a database connection
    $con = mysqli_connect($server, $username, $password, $dbname);

    // Check for connection success
    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }

    $first_name = "";
    $last_name = "";

    $sql = mysqli_query($con, "select * from users where email='$email'");
    $row = mysqli_fetch_row($sql);
    $first_name = $row[1];

    $last_name = $row[2];


    echo "  <div class='container'>
    
    <h1>User Details</h1>
    <br>
    <p>First Name- $first_name</p>
    <br>
    <p>Last Name - $last_name</p>
    <br>
    <p>Email - $email</p>
    <br>
</div>
";

    if (isset($_POST['button1'])) {

        header('Location:update.php');
        exit();
    }
    if (isset($_POST['delete'])) {

        $sql = "Delete from users where email='$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "<script>alert('Your Account Has Been Deleted!')</script>";
            header('Location:logout.php');
            exit();
        } else {
            echo "<script>alert('Connection To Database Failed , Try Again!')</script>";
        }
    }

    if (isset($_POST['button3'])) {
        header('Location:logout.php');
        exit();
    }
    if (isset($_POST['pass'])) {
        header('Location:passch.php');
        exit();
    }

    $con->close();
    ?>
    <div class='container'>


        <form action="home.php" method="post">


            <input type="submit" name="button1" value="Update Profile">
            <input name="delete" type="submit" value="Delete Account" onclick="return confirm('Are you sure?')">
            <input name="button3" type="submit" value="Logout" onclick="return confirm('Are you sure?')">
            <input type="submit" name="pass" value="Change Password">

        </form>

    </div>

</body>

</html>