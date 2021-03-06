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
        <title>EvilShark news</title>
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
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="page.php?page=1">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?w=add">Add News</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth.php?auth=exit">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
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
            <?php
                        $i=0;
                        while($i < 2)
                        {
                            ?>
                            <div class="col-lg-6">
                            <?php
                            $page = $_GET['page'];
                            $k = 4*($page-1) + 2 * $i++;
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
                                        <a class="btn btn-primary" href="#!">Read more →</a>
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
                            $cur_page = $_GET['page'];
                            while ($i++ < $total)
                            {
                                if ($i != $cur_page)
                                {
                                ?>
                                <li class="page-item" aria-current="page"><a class="page-link" href="page.php?page=<?=$i?>"><?=$i?></a></li>
                            <?php
                                }
                                else
                                {
                                    ?>
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="page.php?page=<?=$i?>"><?=$i?></a></li>
                                <?php
                                }
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
