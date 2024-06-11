<?php
session_start();
include("config/pdoconfig.php");
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
      $_SESSION['adminId'] = $result->id;
    } else {
      $error = 'Incorrect Password!';
    }
  } else {
    $error = 'Admin not found';
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
  <link rel="stylesheet" href="../style/main.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/_showsnackbar.js"></script>
</head>

<div class="d-flex justify-content-center align-items-center min-vh-100">
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