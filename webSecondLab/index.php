<?php
session_start();
require("functions.php");
global $mysqli;
$mysqli = new mysqli("localhost", "root", "", "news");
$users = new mysqli("localhost","root","","users");
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
        <a href="index.php?w=show_news"><h1>Новости от evilsharkcpp</h1></a>
    </header>
    <ul class="navbar">
            <?php
            if(!isset($_SESSION["id"]))
            {
                ?>
                <li><a href="index.php?w=auth">Авторизация</a>
                <li><a href="about.php">Об авторе</a>
                <?php
            }
            else
            {
                ?>
                <li><a href="index.php?w=show_news">На главную</a>
                <li><a href="index.php?w=add">Добавить новость</a>
                <li><a href="index.php?w=exit">Выйти</a>
                <?php
            }
            ?>
        </ul>
</body>
</html>

<?php
if (isset($_REQUEST['w']))
$w=$_REQUEST['w'];
else
$w="check";
switch ($w)
{
case "auth":
    Auth();
break;
case "add":
    Check();
    AddNews();
break;
case "save":
    Check();
    SaveNewsInDB();
break;
case "delete":
    Check();
    DeleteNewsFromDB();
break;
case "fullText":
    Check();
    ShowFullNews();
break;
case "edit":
    Check();
    EditNews();
break;
case "save_edit":
    Check();
    SaveNews();
break;
case "login":
    Login();
break;
case "show_news":
    Check();
    ShowAllNews();
    break;
case "exit":
    Logout();
break;
default:
    Auth();
    //ShowAllNews();
}
?>