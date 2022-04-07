<?php
session_start();
require("functions.php");
require("navigation.php");
global $mysqli;
$mysqli = new mysqli("localhost", "root", "", "news");
$users = new mysqli("localhost","root","","users");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mysqli_set_charset($mysqli, "utf8");
if(array_key_exists("auth", $_GET))
        {
            $w = $_GET["auth"];
            if ($w == "check")
            {
                Login();
            }
            if ($w == "exit")
            {
                Logout();
            }
            else
            {
                if(!isset($_SESSION["id"]) and $w!="")
                header('Location: ./auth.php');
            }
        }
        else
        {
            if(!isset($_SESSION["id"]))
                header('Location: ./auth.php');
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Home - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="css/slider.css">
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Evilshark news</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?w=add">Add News</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth.php?auth=exit">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                    <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
                </div>
            </div>
        </header>
        <?php
        if(array_key_exists("w", $_GET))
        {
            $w = $_GET["w"];
            switch($w)
            {
                case "save":
                    SaveNewsInDB();
                    break;
                case "add":
                    AddNews();
                    exit();
                    break;
                case "edit":
                    EditNews();
                    exit();
                    break;
                case "delete":
                    DeleteNewsFromDB();
                    break;
            }
        }
        ?>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <div id="block-for-slider">
                    <div id="viewport">
                    <ul id="slidewrapper">
                                <?php 
                                $result = GetNews(0,3);
                                $i = 0;
                                
                                while($row = $result->fetch_assoc())
                                {
                                    $i++;
                                ?>
                        <li class="slide">
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="<?=$row["image"]?>" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?=$row["data"]?></div>
                                    <h2 class="card-title"><?=$row["title"]?></h2>
                                    <p class="card-text"><?=$row["preview"]?></p>
                                    
                                </div>
                            <a class="btn btn-primary" href="news.php?id=<?=$row["id"]?>"> Read more →</a> 
                            <form action="index.php?w=edit" method="post">
                                <input type="hidden" name="title" value="<?=$row["title"] ?>">
                                <input type="hidden" name="image" value="<?=$row["image"] ?>">
                                <input type="hidden" name="preview" value="<?=$row["preview"] ?>">
                                <input type="hidden" name="text" value="<?=$row["text"] ?>">
                                <input type="hidden" name="edit" value="<?=$row["id"] ?>">
                                <input class="btn btn-primary" type="submit" value="Редактировать">
                            </form>
                            <form action="index.php?w=delete" method="post">
                                <input type="hidden" name="delete" value="<?=$row["id"] ?>">
                                <input class="btn btn-primary" type="submit" value="Удалить">
                            </form> 
                            </div>
                           
                        </li>
                        
                        <?php
                                }?>
                    </ul>
                    
                        <ul id="nav-btns">
                            <?php
                            $j=0;
                            while($j++ < $i)
                            {
                                ?>
                            <li class="slide-nav-btn"></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    </div>
                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <?php
                        $i=0;
                        while($i < 2)
                        {
                            ?>
                            <div class="col-lg-6">
                            <?php
                            $k = 3 + 2 * $i++;
                            $result = GetNews($k, 2);
                            while($row = $result->fetch_assoc())
                            {
                                ?>
                                <div class="card mb-4">
                                    <a href="#!"><img class="card-img-top" src="<?=$row["image"]?>" alt="..." /></a>
                                    <div class="card-body">
                                        <div class="small text-muted"><?=$row["data"]?></div>
                                        <h2 class="card-title h4"><?=$row["title"]?></h2>
                                        <p class="card-text"><?=$row["preview"]?></p>
                                        <a class="btn btn-primary" href="news.php?id=<?=$row["id"]?>"> Read more →</a>
                                        <form action="index.php?w=edit" method="post">
                                        <input type="hidden" name="title" value="<?=$row["title"] ?>">
                                        <input type="hidden" name="image" value="<?=$row["image"] ?>">
                                        <input type="hidden" name="preview" value="<?=$row["preview"] ?>">
                                        <input type="hidden" name="text" value="<?=$row["text"] ?>">
                                        <input type="hidden" name="edit" value="<?=$row["id"] ?>">
                                        <input class="btn btn-primary" type="submit" value="Редактировать">
                                        </form>
                                        <form action="index.php?w=delete" method="post">
                                            <input type="hidden" name="delete" value="<?=$row["id"] ?>">
                                            <input class="btn btn-primary" type="submit" value="Удалить">
                                        </form> 
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <!-- Pagination-->
                    <nav aria-label="Pagination">
                        <hr class="my-0" />
                        <ul class="pagination justify-content-center my-4">
                            <?php
                            $res = $GLOBALS["mysqli"]->query("SELECT count(*) FROM news");
                            $row = $res->fetch_row();
                            $total = $row[0]/4;
                            $i=0;
                            while ($i++ < $total)
                            {
                                ?>
                                <li class="page-item" aria-current="page"><a class="page-link" href="page.php?page=<?=$i?>"><?=$i?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
