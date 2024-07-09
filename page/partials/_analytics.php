<?php
$userId = $_SESSION['userId'];
//1. Customers
$query = "SELECT COUNT(*) FROM `customers` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($customers);
$stmt->fetch();
$stmt->close();

//2. Orders
$query = "SELECT COUNT(*) FROM `orders` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();




//3. Orders
$query = "SELECT COUNT(*) FROM `products` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

//4.Sales
$query = "SELECT SUM(amount) FROM `payments` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();

//5.Import Expense
$query = "SELECT SUM(total) FROM `imports`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($importExpense);
$stmt->fetch();
$stmt->close();

//6.Ingrdients
$query = "SELECT COUNT(*) FROM `ingredients`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($ingredients);
$stmt->fetch();
$stmt->close();

//6.Imports
$query = "SELECT COUNT(*) FROM `imports`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($imports);
$stmt->fetch();
$stmt->close();

//7.Supplier
$query = "SELECT COUNT(*) FROM `suppliers`";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($suppliers);
$stmt->fetch();
$stmt->close();

//8. Individual Customer Orders
$query = "SELECT COUNT(*)
          FROM orders o
          INNER JOIN customers c ON o.cust_id = c.id
          WHERE c.u_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $userId);  // Bind user ID as integer
$stmt->execute();
$stmt->bind_result($custOrder);
$stmt->fetch();
$stmt->close();
