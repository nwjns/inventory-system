<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    require('config.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, username, position FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // login succedsfful
        $stmt->bind_result($id, $name, $username, $position);
        $stmt->fetch();

        if ($position === "Admin"){
            $invaliduserpass = "Access denied. " . '<b><a href = "login2.php">Go here instead.</a></b>';
        } else {
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['position'] = $position;

        header("Location: index.php");            
        }

    } else {
        // failed, invalid user and pass
        $invaliduserpass = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>HAUS LABS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">
    <style>
        body {
            background-color: #f6f6f7;
            font-family: Segoe UI, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
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

        #login-container {
            width: 20%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        img {
            height: 70px;
            width: 280px;

        }

        #sign-in-text-sa-form {
            text-align: left
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

        #text2 {
            font-size: 10px;
        }

        #sign-up-link {
            text-decoration: none;
            font-size: 10px;
            color: black;
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

        #invaliduserpass {
            font-size: 10px;
            color: red;
            margin-top: 0px;
            height: 15px;
            display: block;
        }

        #invaliduserpass a {
            font-size: 10px;
            color: red;
            margin-top: 0px;
            height: 15px;
            display: inline;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="login-container">
        <img src="HEADER.png">
        <h2 id="sign-in-text-sa-form">Sign In</h2>

        <!--login form-->
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <div id="invaliduserpass"><?php echo isset($invaliduserpass) ? $invaliduserpass : ''; ?></div>
            <br>
            <input type="submit" name="login" value="Login">

        </form>
        <p id="text2">Don't have an account? <b><a href="register.php" id="sign-up-link">Sign up.</a></b></p>
    </div>

    <footer>
        <p>© Dasalla, Keith Gabriell F. BSCS 2-3</p>
        <p><b>January 2024</b></p>
    </footer>

</body>

</html>