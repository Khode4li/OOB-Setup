<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello my friend :)</title>
</head>
<body>
<h1>Hello my friend :)</h1>
</body>
</html>
<?php
require_once 'vendor/autoload.php';
require_once 'config/bootstrap.php';
blockBots();
$handler = new config\handler();
$handler->notify();
?>
