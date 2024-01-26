<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAUS LABS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">

    <style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f6f6f7;
    background-image: url('BACKGROUND.png'); 
    background-size: cover;
    background-position: center;
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
    padding: 7px;
    position: fixed;
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

section {
    display: flex;
    justify-content: space-around; 
    padding: 10% 5%; 
}

.container {
    display: flex;
    max-width: 1000px; 
    width: 100%;
    color: whitesmoke;
    font-size: 24px;
    padding: 20px;
    border-radius: 10px;
    margin-top:100px;
}

.left-container {
    flex: 2;
    padding: 30px;
    border-radius: 10px;
    text-align: left;
    margin-left: 0;
    margin-right: 50px; 
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    white-space: nowrap;
}

.left-container a{
    color: white;
    text-decoration: none;
    margin-top: 10px;
    display: block;
}

.left-container a:hover {
    text-decoration: underline;
    }

.left-container h1 {
    margin-top: 15px;
    margin-bottom: 0;
    font-size: 28px;
    line-height: 1.2; 
}

.right-container {
    flex: 3;
    padding: 30px;
    text-align: left;
    border-radius: 10px;
    margin-left: 50px; 
    margin-right: 0;
    margin-top: 20px;
}

.right-container h1 {
    font-size: 28px;
    margin-bottom: 15px;
}

.right-container p {
    margin: 15px 0;
}
    </style>
</head>

<body>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventorysystem";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    session_start();
    ?>

    <header>
        <img src="menu.png" alt="HAUSLABS">
        <nav>
            <?php
            if (isset($_SESSION['user_id'])) {

                if ($_SESSION['position'] == 'Admin') {
                    echo '<a href="index2.php">Home</a>';
                    echo '<a href="admin-pcm-page.php">Product, Category and Materials</a>';
                    echo '<a href="admin-orders.php">Stock Orders</a>';
                } elseif ($_SESSION['position'] == 'Inventory Officer' || 'Inventory Associate' || 'Production Clerk' || 'Inventory Controller') {
                    echo '<a href="index.php">Home</a>';
                    echo '<a href="employee-pcm-page.php">Product, Category and Materials</a>';
                    echo '<a href="orders.php">Stock Orders</a>';
                }
                echo '<a href="logout2.php">Logout</a>';
            } else {

                header('Location: login2.php');
            }
            ?>
        </nav>
    </header>

    <section>
        
    <?php
    if (isset($_SESSION['user_id'])) {
        // PAG NAKA LOGIN SI USER, WELCOME
        echo '<div class="container">';
        echo '<div class="left-container">';
        echo '<b>' . "Welcome to the HAUS, " . '</b>';
        echo '<h1>' . $_SESSION['name'] . "<br>" . '</h1>';
        echo "{$_SESSION['username']}<br>";
        echo "<i>{$_SESSION['position']}</i><br>";
        echo '<a href="logout.php">Logout</a>';
        echo '</div>';

        echo '<div class="right-container">';
        echo '<h1>STATS</h1>';

        $completedOrdersQuery = "SELECT COUNT(*) as totalCompletedOrders FROM orders WHERE orderStatus = 'delivered'";
        $completedOrdersResult = $conn->query($completedOrdersQuery);
        $rowCompletedOrders = $completedOrdersResult->fetch_assoc();
        $totalCompletedOrders = $rowCompletedOrders['totalCompletedOrders'];

        $pendingOrdersQuery = "SELECT COUNT(*) as totalPendingOrders FROM orders WHERE orderStatus IN ('on production', 'shipped')";
        $pendingOrdersResult = $conn->query($pendingOrdersQuery);
        $rowPendingOrders = $pendingOrdersResult->fetch_assoc();
        $totalPendingOrders = $rowPendingOrders['totalPendingOrders'];

        $totalProductsQuery = "SELECT COUNT(DISTINCT productName) as totalProducts FROM pcmtable";
        $totalProductsResult = $conn->query($totalProductsQuery);
        $rowTotalProducts = $totalProductsResult->fetch_assoc();
        $totalProducts = $rowTotalProducts['totalProducts'];

        echo '<p>Completed Orders ' . '<b>' . $totalCompletedOrders . '</b>' . '</p>';
        echo '<p>Pending Orders ' . '<b>' . $totalPendingOrders . '</b>' . '</p>';
        echo '<p>Products ' . '<b>' . $totalProducts . '</b>' . '</p>';

        echo '</div>';
        echo '</div>';
    } else {
        // PAG HINDI, redirect to login page
        header('Location: login.php');
    }
    ?>
    </section>
        <?php
    $conn->close();
    ?>
</body>

</html>