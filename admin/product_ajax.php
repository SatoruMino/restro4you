<?php
include('config/pdoconfig.php');

if (!empty($_POST["prod_qty"] && !empty($_POST['prod_name']))) {
    $id = $_POST['prod_name'];
    $qty = $_POST['prod_qty'];
    $stmt = $pdo->prepare("SELECT * FROM  products WHERE name = :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['cate_id']); ?>
<?php
    }
}
