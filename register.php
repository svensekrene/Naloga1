<?php
include_once 'databaseconn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="register.php" method="POST">
        <div class="container">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Username" name="username" id="username" required>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <hr>
            <button type="submit" class="registerbtn" name="submit">Register</button>
        </div>
    </form>
    <?php

    if (isset($_POST['submit'])) {

        $username = mysqli_real_escape_string($database, $_POST['username']);
        $email = mysqli_real_escape_string($database, $_POST['email']);
        $password = mysqli_real_escape_string($database, $_POST['psw']);

        $user_check = "SELECT * FROM uporabniki WHERE username='$username' OR mail='$email' LIMIT 1;";
        $result = mysqli_query($database, $user_check);
        $user = mysqli_fetch_assoc($result);

        if ($user) {

            if ($user['username'] === $username) {
                $username_err = "Username ze obstaja";
                echo $username_err;
            }

            if ($user['mail'] === $email) {
                $mail_err = "Email ze obstaja";
                echo $mail_err;
            }
        }
        if (!$user) {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO uporabniki (username,mail,password) VALUES ('$username','$email','$pass');";
            $result2 = mysqli_query($database, $sql);
            header('location: login.php');
        }
    }

    ?>
</body>

</html>