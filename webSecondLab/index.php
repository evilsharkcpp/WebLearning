<?php
session_start();
require("functions.php");
global $mysqli;
$mysqli = new mysqli("localhost", "root", "", "news");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mysqli_set_charset($mysqli, "utf8");
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="head">
        <a href="index.php"><h1>Новости от evilsharkcpp</h1></a>
    </header>
    <ul class="navbar">
            <li><a href="index.php">На главную</a>
            <li><a href="about.php">Об авторе</a>
            <li><a href="index.php?w=add">Добавить новость</a>
        </ul>
</body>
</html>

<?php
if (isset($_REQUEST['w']))
$w=$_REQUEST['w'];
else
$w="show_news";
switch ($w) {
case "add":
    AddNews();
break;
case "save":
    SaveNewsInDB();
break;
case "delete":
    DeleteNewsFromDB();
break;
case "fullText":
    ShowFullNews();
break;
case "edit":
    EditNews();
break;
case "save_edit":
    SaveNews();
break;
case "show_news":
default:
    ShowAllNews();
}
?>