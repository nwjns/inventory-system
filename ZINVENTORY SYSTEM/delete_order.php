<?php

$conn = new mysqli("localhost", "root", "", "inventorysystem");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["orderID"])) {
    $orderID = $_GET["orderID"];

    $conn->query("DELETE FROM orders WHERE orderID = $orderID");


    header("Location: orders.php");
    exit();
}
