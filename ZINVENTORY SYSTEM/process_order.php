<?php
$conn = new mysqli("localhost", "root", "", "inventorysystem");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];
    $quantity = $_POST["quantity"];
    $customerName = $_POST["customerName"];
    $customerAddress = $_POST["customerAddress"];
    $customerTelNum = $_POST["customerTelNum"];

    $result = $conn->query("SELECT price FROM pcmtable WHERE productName = '$productName'");
    $row = $result->fetch_assoc();
    $price = $row['price'];

    $totalPrice = $price * $quantity;

    $conn->query("INSERT INTO orders (productName, price, quantity, customerName, customerAddress, customerTelNum, totalPrice, orderStatus, dateTimeOrderPlaced)
                  VALUES ('$productName', $price, $quantity, '$customerName', '$customerAddress', '$customerTelNum', $totalPrice, 'on production', NOW())");

    header("Location: orders.php");
    exit();
}
