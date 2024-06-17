<?php
session_start();
include("config/config.php");
include("config/code-generator.php");
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = 'user_' . $uniqueId;
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
    // Prepared statement to check if email exists
    $stmt = $mysqli->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    // Check the number of rows returned
    if ($stmt->num_rows > 0) {
        $error =  "User is already existed!";
    } else {
        $postQuery = "INSERT INTO users (id, email, password, role) VALUES (?,?,?,'customer')";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sss', $code, $email, $password);
        if ($postStmt->execute()) {
            $cust_code = 'cust_' . $uniqueId;
            $custmt = $mysqli->prepare('INSERT INTO customers(id, name, u_id) VALUE (?,?,?)');
            $custmt->bind_param('sss', $cust_code, $name, $code);
            if ($custmt->execute()) {
                $_SESSION['userId'] = $code;
                $_SESSION['role'] = 'customer';
                header('Location: page/');
                exit();
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
    }
}
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER | FOOD4YOU RESTAURANT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/main.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/_showsnackbar.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100 w-100 mx-2">
        <div class="wrapper">
            <h2>Registration</h2>
            <form action="register.php" method="POST" id="registrationForm" name="registrationForm">
                <div class="input-box">
                    <input type="text" placeholder="Username" id="name" name="name" required>
                </div>
                <div class="input-box">
                    <input type="email" placeholder="Enter your email" id="email" name="email" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Create password" id="password" name="password" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Confirm password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="input-box button">
                    <input type="button" value="Register" name="register" id="register">
                </div>
                <div id="snackbar" name="snackbar"></div>
                <input type="hidden" id="error" name="error" value="<?php echo $error; ?>">
                <div class="text">
                    <h3>Already have an account? <a href="index.php">Login now</a></h3>
                </div>
            </form>
        </div>
    </div>
    <?php require_once("partials/_scripts.php"); ?>
    <script>
        var snackbar = $('#snackbar');

        function validateForm() {
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();
            if (name == '' || email == '' || password == '' || confirmPassword == '') {
                showSnackBar(snackbar, 'All field are required!');
                return false;
            }
            if (password != confirmPassword) {
                showSnackBar(snackbar, "Password doesn't match each other!");
                return false;
            }
            return true;
        }
        $(document).ready(function() {
            var error = $('#error').val();
            if (error) {
                showSnackBar(snackbar, error);
            }
            $('#register').click(function() {
                if (validateForm()) {
                    $('#registrationForm').submit();
                }
            });
        });
    </script>
</body>

</html>