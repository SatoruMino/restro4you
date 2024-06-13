<?php
session_start();
include("config/pdoconfig.php");
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $role = $user['role'];
            $_SESSION['userId'] = $user['id'];
            $_SESSION['role'] = $role;
            header('Location: page/');
            exit();
        } else {
            $error = 'User entered the incorrect password';
        }
    } else {
        $error = 'User has not been registered yet';
    }
}


?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | FOOD4YOU RESTAURANT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/main.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/_showsnackbar.js"></script>
</head>

<div class="d-flex justify-content-center align-items-center min-vh-100 w-100 mx-2">
    <div class="wrapper">
        <h2>LOGIN</h2>
        <form action="index.php" method="POST" id="loginForm" name="loginForm">
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="What's your email?" required>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-box button">
                <input type="button" id="login" name="login" value="Login">
            </div>
            <div id="snackbar" name="snackbar"></div>
            <input type="hidden" id="error" name="error" value="<?php echo $error; ?>">
            <div class="text">
                <h3>Not yet having an account? <a href="register.php">Create one</a></h3>
            </div>
        </form>
    </div>
</div>
<?php require_once("partials/_scripts.php"); ?>
<script>
    var snackbar = $('#snackbar');

    function validateUserForm() {
        var email = $('#email').val();
        var password = $('#password').val();
        if (email == '' || password == '') {
            showSnackBar(snackbar, 'All field are required!');
            return false;
        }
        return true;
    }
    $(document).ready(function() {
        var error = $('#error').val();
        if (error) {
            showSnackBar(snackbar, error);
        }
        $('#login').click(function() {

            if (validateUserForm()) {
                $('#loginForm').submit();
            }
        });
    });
</script>
</body>

</html>