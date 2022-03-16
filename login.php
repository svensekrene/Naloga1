<?php
include_once 'databaseconn.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="login.php" method="POST">
        <div class="container">
            <label>Username : </label>
            <input type="text" placeholder="Enter Username" name="username" required>
            <label>Password : </label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <button type="submit" name="submit">Login</button>
        </div>
    </form>
</body>
<?php
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($database, $_POST['username']);
    $password = mysqli_real_escape_string($database, $_POST['password']);

    $sql1 = "SELECT * FROM uporabniki WHERE username='$username';";
    $result1 = mysqli_query($database, $sql1);
    $rows = mysqli_num_rows($result1);

    if ($rows == 1) {
        $sql2 = "SELECT id,password FROM uporabniki WHERE username='$username';";
        $result3 = mysqli_query($database, $sql2);
        $geslo = mysqli_fetch_row($result3);
        $geslo1 = $geslo[1];
        $id_session = $geslo[0];

        if (password_verify($password, $geslo1)) {
            $_SESSION["user"] = $_POST['username'];
            $_SESSION["id"] = $id_session;
            header("Location: main.php");
        } else {
            $user_err = 'Napacno geslo';
            echo $user_err;
        }
    } else {
        $login_error = 'Uporabnik ne obstaja';
        echo $login_error;
    }
}
?>

</html>