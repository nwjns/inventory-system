<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outside the HAUS</title>
    <link rel="icon" type="image/png" href="Add a heading.png">
    <style>
        
        body {
            font-family: Segoe UI, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f6f6f7;
            animation: fadeInAnimation ease 2s;
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
        .container {
            text-align: center;
        }

        .logo {
            max-width: 40%;
            height: auto;
        }

        .buttons {
            margin-top: 20px;
        }

        .buttons a:hover {
            background-color: #222121;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }

        .admin {
            background-color: #040304;
        }

        .employee {
            background-color: #040304;
        }
    </style>
</head>
<body>

<div class="container">
    <img class="logo" src="inventory-logo.png">
    <p></p>
    <div class="buttons">
        <a href="login2.php" class="button admin">Admin</a>
        <a href="login.php" class="button employee">Employee</a>
    </div>
</div>

</body>
</html>