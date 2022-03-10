<?php
function ShowAllNews()
{
    $result = $GLOBALS["mysqli"]->query('SELECT * FROM news ORDER BY data DESC LIMIT 10'); // запрос на выборку
    ?>
    <div class="container">
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
                            <input type="submit" value="Редактировать">
                        </form>
                        <form action="index.php?w=delete" method="post">
                            <input type="hidden" name="delete" value="<?=$row["id"] ?>">
                            <input type="submit" value="Удалить">
                        </form>
                    </div>
    </li>
        <?php
    }
    ?>
    </ul>
    </div>
    <?php
}
?>

<?php
function SaveNewsInDB()
{
    $saveNews = $GLOBALS["mysqli"]->prepare("INSERT INTO news (data, title, preview, text, image) VALUES (?, ?, ?, ?, ?)");
    $data = date("Y-m-d H:i:s");
    $title = $_REQUEST["title"];
    $preview = $_REQUEST["preview"];
    $text = $_REQUEST["text"];
    $image = $_REQUEST["image"];	
    $saveNews->bind_param('sssss', $data, $title, $preview, $text, $image);
    if ($saveNews->execute()) {
        echo'';
    } else {
        echo'';
    }
}
?>

<?php
function AddNews()
{
    ?>
    <div class="container">
    <form action="index.php?w=save" method="post">
        <p>Заголовок: <input type="text" name="title"></p>
        <p>Анонс: <input type="text" name="preview"></p>
        <p>Полный текст:<br>
            <textarea type="text" name="text"></textarea></p>
        <p>Изображение: <input type="text" name="image"></p>
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
    <form action="index.php?w=save_edit" method="post">
        <p>Заголовок: <input type="text" name="newTitle" value="<?=$_REQUEST["title"]?>"></p>
        <p>Анонс: <input type="text" name="newpreview" value="<?=$_REQUEST["preview"]?>"></p>
        <p>Полный текст: <textarea type="text" name="newText"><?=$_REQUEST["text"]?></textarea></p>
        <p>Изображение: <input type="text" name="newimage" value="<?=$_REQUEST["image"]?>"></p>
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
    $editNews = $GLOBALS["mysqli"]->prepare("UPDATE news SET data = ?, title = ?, preview = ?, text = ?, image = ? WHERE id = ?");
    $edit = $_REQUEST["edit"];
    $data = date("Y-m-d H:i:s");
    $newTitle = $_REQUEST["newTitle"];
    $newpreview = $_REQUEST["newpreview"];
    $newText = $_REQUEST["newText"];
    $newimage = $_REQUEST["newimage"];
    $editNews->bind_param('sssssi', $data, $newTitle, $newpreview, $newText, $newimage, $edit);
    if ($editNews->execute()) {
        echo '';
    } else {
        echo '';
    }
}?>