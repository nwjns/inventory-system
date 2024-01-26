<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    require('config.php');

    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $position = $_POST['position'];

    $stmt = $conn->prepare("INSERT INTO users (name, username, password, position) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $password, $position);

    if ($stmt->execute()) {
        $registrationsuccessgobacktologin = "Registration successful!" . "<a href='login.php' id='back2login'> Click here to go back to login.</a>";
    } else {
        $registrationsuccessgobacktologin = "Error! Register again.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register to the HAUS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">
    <style>
        body {
            font-family: Segoe UI, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f7;
            color: #040304;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        .reg-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 20%;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #040304;
            font-size: 13px;
            text-align: left;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #040304;
            color: #ffffff;
            cursor: pointer;
            width: 25%;
        }

        input[type="submit"]:hover {
            background-color: #222121;
        }

        a {
            color: #040304;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        #back2login {
            font-size: 10px;
            margin-top: 0px;
            color: green;
            height: 15px;
            display: inline;
            font-weight: bold;
            text-decoration: none;
        }

        #reg-text-sa-form {
            text-align: left;
        }

        #reg-succ-cont {
            font-size: 10px;
            color: green;
            margin-top: 0px;
            height: 15px;
            margin-bottom: 12px;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px;
            background-color: #f6f6f7;
            color: #040304;
            line-height: 80%
        }
    </style>
</head>

<body>
    <Div class="reg-container">
        <h2 id="reg-text-sa-form">Register</h2>
        <form method="post" action="">
            <label for="name">Full Name</label>
            <input type="text" name="name" placeholder="Full Name" required>
            <br>
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <label for="position">Position</label>
            <select name="position" required>
                <option>Inventory Officer</option>
                <option>Inventory Associate</option>
                <option>Production Clerk</option>
                <option>Inventory Controller</option>
            </select>
            <br>
            <input type="submit" name="register" value="Register">
        </form>
    </div>

    <footer>
        <?php
        if (!empty($registrationsuccessgobacktologin)) {
            echo '<div id="reg-succ-cont">' . $registrationsuccessgobacktologin . '</div>';
        }
        ?>
    </footer>
</body>

</html>