<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости</title>
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="slider.css">
</head>
<?php

function quote($var){
    return trim($var);
}
function Auth()
{
    if(isset($_SESSION["id"])) header('Location: ./index.php?w=show_news');
    ?>
    <div class="container">
    <form action="index.php?w=login" method="post">
    <p>login: <input type="text" name="login"></p>
    <p>password: <input type="password" name="password"></p>
    <input type="submit" value="Войти">
    </form>
    </div>
    <?php
}
function Login()
{
    $login = quote($_REQUEST["login"]);
    $passwd = MD5(quote($_REQUEST["password"]));
    $query = $GLOBALS["users"]->prepare("SELECT * FROM users WHERE `login`='$login' AND `passwd`='$passwd'");
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION["id"]=$row["id"];
        header('Location:./index.php?w=show_news');
    }
    else 
    {
        $_SESSION['message'] = "Неверный логин или пароль";
    }
}
function Logout()
{
    session_destroy();
    header('Location:./index.php?w=auth');
}
function Check()
{
    ?>
    <?php
    if(!isset($_SESSION["id"]))
    {
       header('Location:./index.php?w=auth');
    }
    ?>
    <?php
}
function ShowAllNews()
{
    $query = $GLOBALS["mysqli"]->prepare("SELECT * FROM news ORDER BY data DESC LIMIT 10");
    $query->execute();

    $result = $query->get_result();  // запрос на выборку
    ?>
    <div class="container">

        <div id="block-for-slider">
            <div id="viewport">
            <ul id="slidewrapper">
                <?php
                $i=0;
                while ($i < 3 and $row = $result->fetch_assoc())
                {
                    $i++;
                    ?>
                    <li class="slide" id="<?=$row["id"]?>">
                        <img src="<?=$row["image"]?>" alt="<?=$i?>" class="slide-img">
                        <form action="index.php?w=fullText" method="post">
                            <input type="hidden" name="fullText" value="<?=$row['id'] ?>">
                            <a href="#" onclick="parentNode.submit();"><?=$row["title"] ?></a>
                        </form>
                        <div class="slider-preview">
                            <p><?=$row["preview"] ?></p>
                        </div>
                        <form action="index.php?w=edit" method="post">
                            <input type="hidden" name="title" value="<?=$row["title"] ?>">
                            <input type="hidden" name="image" value="<?=$row["image"] ?>">
                            <input type="hidden" name="preview" value="<?=$row["preview"] ?>">
                            <input type="hidden" name="text" value="<?=$row["text"] ?>">
                            <input type="hidden" name="edit" value="<?=$row["id"] ?>">
                            <input class="edit" type="submit" value="Редактировать">
                        </form>
                        <form action="index.php?w=delete" method="post">
                            <input type="hidden" name="delete" value="<?=$row["id"] ?>">
                            <input class="delete" type="submit" value="Удалить">
                        </form>
                    </li>
                <?php
                }
                ?>
                </ul>
                <div class="nav-btns">
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
        </div>
        <ul class="news">
        <?php
    while($row = $result->fetch_assoc())// получаем все строки в цикле по одной
    {
        ?>
        <li>
        <div class="image">
                        <img src="<?=$row["image"]?>">
                    </div>
                    <time datetime="<?=$row["data"]?>" title="<?=$row["data"]?>">Время публикации: <?=$row["data"]?></time>
                    <div class="preview">
                    <form action="index.php?w=fullText" method="post">
                            <input type="hidden" name="fullText" value="<?=$row['id'] ?>">
                            <a href="#" onclick="parentNode.submit();"><?=$row["title"] ?></a>
                        </form>
                        <p>
                        <?=$row["preview"] ?>
                        </p>
                       
                        <form action="index.php?w=edit" method="post">
                            <input type="hidden" name="title" value="<?=$row["title"] ?>">
                            <input type="hidden" name="image" value="<?=$row["image"] ?>">
                            <input type="hidden" name="preview" value="<?=$row["preview"] ?>">
                            <input type="hidden" name="text" value="<?=$row["text"] ?>">
                            <input type="hidden" name="edit" value="<?=$row["id"] ?>">
                            <input class="edit" type="submit" value="Редактировать">
                        </form>
                        <form action="index.php?w=delete" method="post">
                            <input type="hidden" name="delete" value="<?=$row["id"] ?>">
                            <input class="delete" type="submit" value="Удалить">
                        </form>
                    </div>
    </li>
        <?php
    }
    ?>
    </ul>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./script.js"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
}
?>

<?php
function SaveFile()
{
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
    {
        
        //// get details of the uploaded file
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // sanitize file-name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        // check if file has one of the following extensions
        $allowedfileExtensions = array('jpg', 'gif', 'png');
        
        if (in_array($fileExtension, $allowedfileExtensions))
        {
          // directory in which the uploaded file will be moved
          $uploadFileDir = './uploaded_files/';
          $dest_path = $uploadFileDir . $newFileName;
          $filename= $dest_path;
          if(move_uploaded_file($fileTmpPath, $dest_path)) 
          {
            $message ='File is successfully uploaded.';
            return $dest_path;
          }
          else 
          {
            $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
          }  
         }
    }
}
function SaveNewsInDB()
{
    $filename=SaveFile();
    $saveNews = $GLOBALS["mysqli"]->prepare("INSERT INTO news (data, title, preview, text, image) VALUES (?, ?, ?, ?, ?)");
    $data = date("Y-m-d H:i:s");
    $title = $_REQUEST["title"];
    $preview = $_REQUEST["preview"];
    $text = $_REQUEST["text"];
    $image = $filename;	
    $saveNews->bind_param('sssss', $data, $title, $preview, $text, $image);
    if ($saveNews->execute())
    {
        echo'';
    } 
    else
    {
        echo'';
    }
    header('Location:./index.php?w=show_news');
} 
?>

<?php
function AddNews()
{
    Check();
    ?>
    <div class="container">
    <form id = "add_form" action="index.php?w=save" method="post" enctype="multipart/form-data">
        <p>Заголовок: <input class="title" type="text" name="title"></p>
        <p>Анонс: <textarea class="preview" type="text" name="preview"></textarea></p>
        <p>Полный текст:<br>
            <textarea class="fullText" type="text" name="text"></textarea></p>
        <div>
            <span>Upload a File:</span>
            <input type="file" name="uploadedFile" />
        </div>
        <p><input type="submit"></p>
    </form>
</div>
    <?php
}
?>

<?php
function DeleteNewsFromDB()
{
    $deleteNews = $GLOBALS["mysqli"]->prepare("DELETE FROM news WHERE id = ?");
    $delete = $_REQUEST["delete"];
    $deleteNews->bind_param('i', $delete);
    if ($deleteNews->execute())
     {
        echo'';
    } else {
        echo'';
    }
    header('Location:./index.php?w=show_news');
}
?>

<?php
function ShowFullNews()
{
    $showFull = $GLOBALS["mysqli"]->prepare("SELECT * FROM news WHERE id=?");
    $fullText = $_REQUEST["fullText"];
    $showFull->bind_param('i', $fullText);
    $showFull->execute();
    $result = $showFull->get_result();
    ?>
    <div class="container">
        <?php
    while($row = $result->fetch_assoc()) {
        ?>
        <h2><?=$row["title"] ?></h2>
        <div class="flex">
            <image class="image" src="<?=$row["image"] ?>" alt="<?=$row["title"] ?>">
                <div>
                    <p><?=$row["text"] ?></p>
                    <a href="index.php">Назад</a>
                </div>
        </div>
        <?php
    }
    ?>
    </div>
    <?php
}
?>

<?php
function EditNews()
{
    ?>
    <div class="container">
    <form action="index.php?w=save_edit" method="post" enctype="multipart/form-data">
        <p>Заголовок: <input class="title" type="text" name="newTitle" value="<?=$_REQUEST["title"]?>"></p>
        <p>Анонс: <textarea class="preview" type="text" name="newpreview"><?=$_REQUEST["preview"]?></textarea></p>
        <p>Полный текст: <textarea class="fullText" type="text" name="newText"><?=$_REQUEST["text"]?></textarea></p>
        <div>
            <span>Upload a File:</span>
            <input type="file" name="uploadedFile" />
        </div>
        <input type="hidden" name="edit" value="<?=$_REQUEST["edit"] ?>">
        <p><input type="submit"></p>
    </form>
    </div>
    <?php
}
?>
<?php
function SaveNews()
{
    $filename=SaveFile();
    $editNews = $GLOBALS["mysqli"]->prepare("UPDATE news SET data = ?, title = ?, preview = ?, text = ?, image = ? WHERE id = ?");
    $edit = $_REQUEST["edit"];
    $data = date("Y-m-d H:i:s");
    $newTitle = $_REQUEST["newTitle"];
    $newpreview = $_REQUEST["newpreview"];
    $newText = $_REQUEST["newText"];
    $newimage = $filename;
    $editNews->bind_param('sssssi', $data, $newTitle, $newpreview, $newText, $newimage, $edit);
    if ($editNews->execute()) {
        echo '';
    } else {
        echo '';
    }
    header('Location:./index.php?w=show_news');
}?>