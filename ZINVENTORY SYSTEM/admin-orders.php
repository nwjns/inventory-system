<?php
$conn = new mysqli("localhost", "root", "", "inventorysystem");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System | HAUS LABS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">
    <style>
        body {
            font-family: Segoe UI, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f7;
            color: #030304;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
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

        .container {
            max-width: 1345px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 0px;

        }

        h3 {
            color: #030304;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        select,
        input {
            margin-bottom: 3px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
        }

        input[type="submit"] {
            margin-bottom: 3px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            background-color: #030304;
            color: #fff;
        }

        .form-container {
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #030304;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #030304;
            color: #fff;
        }

        .table-container {
            width: 100%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            border-radius: 5px;
        }

        input[type="text"] {
            margin-bottom: 3px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            margin-right: 5px;
        }

        input[type="submit"] {
            margin-bottom: 3px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            font-style: Segoe UI;
            background-color: #030304;
            color: #fff;
        }

        h1 {
            margin-top: 100px;
            margin-bottom: 6px;
        }

        form label {
            display: block;
            margin-bottom: 0;
            margin-right: 10px;
            margin-left: 10px;
            font-size: 12px;
        }

        form label[for=productName] {
            display: block;
            margin-bottom: 0;
            margin-right: 10px;
        }


        form input,
        form select {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            width: 100%;
            box-sizing: border-box;
        }


        .table-scroll {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        #search-order {
            margin-left: 20px;
            margin-bottom: 0;
        }

        .search-form {
            padding: 10px;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 0;
        }

        .search-form label {
            display: block;
            margin-bottom: 5px;
            margin-bottom: 0;
        }

        .search-form input {
            margin-bottom: 5px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            width: 25%;
            box-sizing: border-box;
            margin-left: 10px;
        }

        #ordersTable {
            margin-top: 5px;
            margin-left: 15px;
            margin-right: 15px;
        }

        table {
            width: 99%;
        }
    </style>
</head>

<body>
    <header>
        <img src="menu.png" alt="HAUSLABS">
        <nav>
            <a href="index2.php">Home</a>
            <a href="admin-pcm-page.php">Product, Category and Materials</a>
            <a href="admin-orders.php">Stock Orders</a>
            <a href="logout2.php">Logout</a>
        </nav>
    </header>
    <h1>Orders</h1>
    <div class="container">

        <div class="table-container">
            <h3 id="search-order">Search Orders</h3>
            <form action="#" method="post" class="search-form">
                Search by Customer Name <input type="text" name="search" id="search" oninput="filterTable()" />
            </form>

            <div class="table-scroll">
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Customer Name</th>
                            <th>Customer Address</th>
                            <th>Customer Telephone Number</th>
                            <th>Total Price</th>
                            <th>Order Status</th>
                            <th>Order Placed Date</th>
                            <th>Delete or Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM orders");
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['orderID'] . "</td>";
                            echo "<td>" . $row['productName'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['customerName'] . "</td>";
                            echo "<td>" . $row['customerAddress'] . "</td>";
                            echo "<td>" . $row['customerTelNum'] . "</td>";
                            echo "<td>" . $row['totalPrice'] . "</td>";
                            echo "<td>" . $row['orderStatus'] . "</td>";
                            echo "<td>" . $row['dateTimeOrderPlaced'] . "</td>";
                            echo "<td><a href='admin-delete-order.php?orderID=" . $row['orderID'] . "' style='text-decoration: none; color: red;'>Delete</a> or <a href='admin-update-status.php?orderID=" . $row['orderID'] . "' style='text-decoration: none; color: green;'>Update Status</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('productNameSelect').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var priceInput = document.getElementById('price');
            priceInput.value = selectedOption.getAttribute('data-price');
        });

        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("ordersTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>

</html>


