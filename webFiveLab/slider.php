<?php

function doSomething()
{
    if(array_key_exists("w", $_GET))
    {
        $w = $_GET["w"];
        switch($w)
        {
            case "save_edit":
                SaveNews();
                break;
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
}
?>

<?php
function getSlider()
{
    ?>
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
                    
                        
                    </div>
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
                        <?php
}
?>

<?php
 function getPosts()
 {
     ?>
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
                    <?php
 }
 ?>










?>