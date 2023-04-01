<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

</head>



<body>
    <?php

    session_start();
    if (isset($_POST['button2'])) {
        header("Location: index.php");
        exit();
    }



    if (isset($_POST['button1'])) {
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
        $email = "";
        $password = "";
        $emailErr = "";
        $passErr = "";
        $insert = true;
        if (empty($_POST["email"])) {
            $emailErr = "Email field is required";
            //echo $emailErr;
            $insert = false;
        } else {
            $email = ($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                //  echo $emailErr;
                $insert = false;
            }
        }


        if (empty($_POST["password"])) {
            $passErr = "Password Cant be Empty!";
            $insert = false;
        } else {
            $password = $_POST['password'];
        }
        if ($insert) {
            $sql = mysqli_query($con, "SELECT * from users where email='$email'");
            if (mysqli_num_rows($sql) < 1) {
                $emailErr = "No Account exists with this email!";
                $insert = false;
            }
        }
        if ($insert) {
            $sql = mysqli_query($con, "select * from users where email='$email' and password='$password'");
            if (mysqli_num_rows($sql) < 1) {
                $passErr = "Incorrect Password!";
                $insert = false;
            }
        }
        $con->close();
        if ($insert) {
            $_SESSION['email'] = $email;
            header("Location: home.php");
            exit();
        } else {

            if (!empty($emailErr)) {
                echo "<script>alert('$emailErr')</script>";
            } else if (!empty($passErr)) {
                echo "<script>alert('$passErr')</script>";
            }
        }
    }


    ?>
    <div class="container">
        <h1>User Login</h3>
            <p>Enter your details and submit this form to Login </p>
            <form action="login.php" method="post">

                <input type="email" name="email" id="email" placeholder="Enter your email">
                <input type="password" name="password" id="password" placeholder="Enter your Password">
                <input type="submit" name="button1" value="Login">
                <input type="submit" name="button2" value="Register">

            </form>
    </div>




</body>

</html>