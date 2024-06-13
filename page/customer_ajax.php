<?php
include('config/pdoconfig.php');

if (!empty($_POST["cust_name"])) {
    $id = $_POST['cust_name'];
    $stmt = $pdo->prepare("SELECT * FROM  customers WHERE name = :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['id']); ?>
<?php
    }
}
