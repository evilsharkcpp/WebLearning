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
		<div class="container"
		<h2>Выполнил Асаулюк Валентин ПМ-95</h2>
	</div>
</body>
</html>