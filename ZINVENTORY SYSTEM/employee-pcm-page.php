<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'inventorysystem');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function searchProducts($conn, $searchTerm)
{
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

    $sql = "SELECT * FROM pcmtable
                WHERE productName LIKE '%$searchTerm%'
                OR productCategory LIKE '%$searchTerm%'
                OR productStatus LIKE '%$searchTerm%'
                OR productMaterial LIKE '%$searchTerm%'";

    $result = $conn->query($sql);

    $searchResults = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }

    return $searchResults;
}

function getProducts($conn)
{
    $sql = "SELECT * FROM pcmtable";
    $result = $conn->query($sql);

    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List | HAUS LABS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">
    <style>
        body {
            margin: 0;
            font-family: Segoe UI, sans-serif;
            background-color: #f6f6f7;
            color: #030304;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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

        h1 {
            margin-top: 100px;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 5px;
        }

        .single-column-container {
            box-sizing: border-box;
            padding: 20px;
            width: 70%;
            overflow-y: auto;
            max-height: 500px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .single-column-container form {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .single-column-container label {
            margin-bottom: 5px;
        }

        .single-column-container input,
        .single-column-container select,
        .single-column-container button {
            margin-bottom: 3px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
        }

        .right-column button {
            background-color: #030304;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            font-size: 16px;
        }

        .popup-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            align-items: center;
            justify-content: center;
        }

        .popup-container form {
            box-sizing: border-box;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
        }

        .popup-container .close {
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 3px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #030304;
            color: #fff;
        }

        h3 {
            margin-bottom: 3px;
        }

        .single-column-container input[type="text"] {
            margin-bottom: 3px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            margin-right: 5px;
            font-style: Segoe UI;
        }

        .single-column-container input[type="submit"] {
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
    <h1>Products, Category and Materials</h1>
    <div class="main-container">
        <div class="single-column-container">
            <h3>Search Products</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                <input type="text" name="searchTerm" placeholder="name, category, material, or status" required>
                <input type="submit" name="search" value="Search">
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateStatus'])) {
                $productID = $_POST['productID'];
                $newStatus = $_POST['newStatus'];

                $updateSql = "UPDATE pcmtable SET productStatus = '$newStatus' WHERE productID = $productID";

                if ($conn->query($updateSql) === TRUE) {
                    echo "<span style='color:green'>Product status updated successfully</span>";
                } else {
                    echo "Error. Try updating it properly" . $conn->error;
                }
            }
            ?>
            <?php
            echo "<h3>Product List</h3>";
            echo "<table border='1'>";
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
                $searchTerm = $_GET['searchTerm'];
                $searchResults = searchProducts($conn, $searchTerm);

                if (!empty($searchResults)) {
                    echo "<p>Showing results for: '$searchTerm'</p>";
                }
            }

            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Product ID</th>";
            echo "<th>Product Name</th>";
            echo "<th>Product Category</th>";
            echo "<th>Product Material</th>";
            echo "<th>Product Status</th>";
            echo "<th>Price</th>";
            echo "<th>Date Added</th>";
            echo "<th>Update</th>";
            echo "</tr>";

            $productsList = isset($searchResults) ? $searchResults : getProducts($conn);

            foreach ($productsList as $product) {
                echo "<tr>";
                echo "<td>{$product['productID']}</td>";
                echo "<td>{$product['productName']}</td>";
                echo "<td>{$product['productCategory']}</td>";
                echo "<td>{$product['productMaterial']}</td>";
                echo "<td>{$product['productStatus']}</td>";
                echo "<td>{$product['price']}</td>";
                echo "<td>" . date('Y-m-d H:i:s', strtotime($product['dateAdded'])) . "</td>";
                echo "<td>";
                echo "<form action='{$_SERVER['PHP_SELF']}' method='post'>";
                echo "<input type='hidden' name='productID' value='{$product['productID']}'>";
                echo "<select name='newStatus'>";
                echo "<option value='available'>Available</option>";
                echo "<option value='phased out'>Phased Out</option>";
                echo "</select>";
                echo "<input type='submit' name='updateStatus' value='Update'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

    </div>
    <script>
        document.getElementById("openFormBtn").addEventListener("click", openPopup);

        function openPopup() {
            document.getElementById("formPopup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("formPopup").style.display = "none";
        }
    </script>


    </section>

</body>

</html>