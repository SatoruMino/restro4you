<?php
session_start();
include("configs/pdoconfig.php");
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stm = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stm->bindParam(':email', $email, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_OBJ);
    if ($result) {
        $hashedPass = $result->password;
        if (password_verify($password, $hashedPass)) {
            $role = $result->role;
            $_SESSION['userId'] = $result->id;
            if ($role == 'admin') {
                header('Location: admin/index.php');
            } else if ($role == 'cashier') {
                header('Location: cashier/index.php');
            } else {
                header('Location: customer/index.php');
            }
        } else {
            $error = 'Incorrect Password!';
        }
    } else {
        $error = 'User has not been registered';
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
        <form action="">
            <div class="input-box">
                <input type="button" id="admin" name="admin" value="Admin" onclick="window.location.href='admin/'">
            </div>
            <div class="input-box">
                <input type="button" id="admin" name="admin" value="Staff" onclick="window.location.href='cashier/'">
            </div>
            <div class="input-box">
                <input type="button" id="admin" name="admin" value="Customer" onclick="window.location.href='customer/'">
            </div>
        </form>
    </div>
</div>
<?php require_once("partial/_script.php"); ?>
</body>

</html>