<?php

session_start();

include("function.php");

$index_user = new users();

$index_user->check_login();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Project</title>
</head>

<body>

    <h2>Index Page</h2>

    <a href="Logout.php">Log Out</a>

    <br>
</body>
</html>