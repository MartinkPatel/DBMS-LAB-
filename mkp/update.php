<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <?php
    session_start();
    $email = $_SESSION['email'];

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


    $sql = mysqli_query($con, "select * from users where email='$email'");
    $row = mysqli_fetch_row($sql);
    // echo "<script>alert('Profile ')</script>";
    $first_name = $row[1];

    $last_name = $row[2];

    //echo $first_name;

    if (isset($_POST['update'])) {


        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $sql = "update users set first_name='$first_name', last_name='$last_name' where email='$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {

            echo "<script>alert('Profile Updated')</script>";

            header('Location:home.php');
            exit();
        } else {
            echo "<script>alert('Error Occured While Updating Profile')</script>";
        }
    }


    ?>


    <div class="container">

        <h1>Update Profile</h1>
        <br>
        <form method="post">
            <label for="email" text-align:left>Email:</label>
            <input type="email" name="email" id="email" value=<?php echo $email; ?> readonly>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value=<?php echo "$first_name"; ?>>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value=<?php echo "$last_name"; ?>>
            <input name="update" type="submit" value="Update" onclick="return confirm('Are you sure?')">



        </form>



    </div>





</body>

</html>