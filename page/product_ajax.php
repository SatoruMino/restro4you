<?php
include('config/pdoconfig.php');

if (!empty($_POST["prod_id"] && !empty($_POST['prod_qty']))) {
    $id = $_POST['prod_id'];
    $qty = $_POST['prod_qty'];
    $stmt = $pdo->prepare("SELECT recipe FROM  products WHERE id = :id");
    $stmt->execute(array(':id' => $id));

?>
<?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $recipe = json_decode($row['recipe'], true);
        $status = 'Available';
        foreach ($recipe as $rec) {
            $product_ingred_id = $rec['id'];
            $required_ingred_qty = $qty * $rec['qty'];
            $ingreStmt = $pdo->prepare('SELECT qty FROM ingredients WHERE id = :id');
            $ingreStmt->execute(array(':id' => $product_ingred_id));
            if ($ingreRow = $ingreStmt->fetch(PDO::FETCH_ASSOC)) {
                $available_ingredient_qty = $ingreRow['qty'];
                if ($available_ingredient_qty < $required_ingred_qty) {
                    $status = 'Unavailable!';
                    break;
                }
            }
        }

?>
<?php echo htmlentities($status); ?>
<?php
    }
}
