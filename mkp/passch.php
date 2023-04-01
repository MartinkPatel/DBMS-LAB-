<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Change</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_POST['update'])) {
        $email = $_SESSION['email'];
        $old0 = "";

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

        $sql = "Select password from users where email='$email'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_row($result);
        $old0 = $row[0];
        $old1 = $_POST['old'];

        $insert = true;
        $passErr = "";
        $oldErr = "";
        if ($old0 != $old1) {
            $insert = false;
            $oldErr = "Old Password Doesnt Match!";
        }

        $new1 = $_POST['new1'];
        $new2 = $_POST['new2'];

        if (empty($new1)) {
            $passErr = "Password Cant be Empty!";
            $insert = false;
        } else {

            $uppercase = preg_match('@[A-Z]@', $new1);
            $lowercase = preg_match('@[a-z]@', $new1);
            $number    = preg_match('@[0-9]@', $new1);
            $specialChars = preg_match('@[^\w]@', $new1);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($new1) < 8) {
                $passErr = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
                // echo $passErr;
                $insert = false;
            } else {
            }
        }

        if ($new1 != $new2 && $insert) {
            $insert = false;
            $passErr = "Confirm Password Doesnt Match!";
        }

        if ($insert) {

            $sql = "update users set password='$new1' where email='$email'";
            $result = mysqli_query($con, $sql);

            if ($result) {
                echo "<script>alert('Password Updated!')</script>";
                header('Location:home.php');
                exit();
            } else {
                echo "<script>alert('Connection Failed!')</script>";
            }
        } else {

            if (!empty($oldErr)) {
                echo "<script>alert('$oldErr')</script>";
            } else if (!empty($passErr)) {
                echo "<script>alert('$passErr')</script>";
            }
        }
    }
    ?>

    <div class="container">

        <h1>Change Password</h1>
        <br>
        <form method="post">

            <input type="password" name="old" id="old" placeholder="Old Password">

            <input type="password" name="new1" id="new1" placeholder="New Password">
            <input type="password" name="new2" id="new2" placeholder="Confirm New Password">
            <input name="update" type="submit" value="Update" onclick="return confirm('Are you sure?')">



        </form>




    </div>



</body>

</html>