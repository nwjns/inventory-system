<?php
$conn = new mysqli("localhost", "root", "", "inventorysystem");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderID"])) {
    $orderID = $_POST["orderID"];
    $newStatus = $_POST["newStatus"];

    $conn->query("UPDATE orders SET orderStatus = '$newStatus' WHERE orderID = $orderID");

    header("Location: orders.php");
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["orderID"])) {
    $orderID = $_GET["orderID"];

    $result = $conn->query("SELECT orderStatus FROM orders WHERE orderID = $orderID");
    $row = $result->fetch_assoc();
    $currentStatus = $row['orderStatus'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status | HAUS LABS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">
    <style>
        body {
            background-color: #f6f6f7;
            font-family: Segoe UI, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            animation: fadeInAnimation ease 0.5s;
            animation-iteration-count: 1;
            animation-fill-mode: forwards;
            }

        @keyframes fadeInAnimation {
            0% {
            opacity: 0;
            }
            100% {
            opacity: 1;
            }
            }

        header {
            background-color: #030304;
            padding: 7px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        header img {
            width: 10%;
            height: auto;
            margin-left: 20px;
        }

        nav {
            display: flex;
            color: #ffffff;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #ffffff;
            padding: 8px;
            margin: 0 20px;
            font-size: 15px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: none;
            background-color: #222121;
        }

        .content-container {
            width: 40%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }

        img {
            height: 70px;
            width: 280px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #040304;
            font-size: 13px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #040304;
            border-radius: 3px;
            display: block;
        }

        input[type="submit"] {
            background-color: #040304;
            color: #ffffff;
            cursor: pointer;
            width: 20%;
            align-items: center;
            margin: auto;
            display: block;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #222121;
        }

        h3 {
            margin-bottom: 6px;
            text-align: left;
        }

        h1 {
            margin-top: 100px;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    <header>
        <img src="menu.png" alt="HAUSLABS">
        <nav>
            <a href="index.php">Home</a>
            <a href="employee-pcm-page.php">Product, Category and Materials</a>
            <a href="orders.php">Stock Orders</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <h1>Orders</h1>
    <div class="content-container">
        <h3>Update Order Status</h3>
        <form action="update_status.php" method="post">
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
            Current Status: <strong><?php echo $currentStatus; ?></strong><br>
            New Status:
            <select name="newStatus">
                <option value="on production">On Production</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
            <input type="submit" value="Update Status">
        </form>
    </div>

</body>

</html>