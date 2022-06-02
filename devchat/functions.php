<?php
    if(!isset($_SESSION["id"])) session_start();
    global $db;
    global $myId;
    $db = new mysqli("localhost", "root", "", "chat");
    //wrapper
    if(isset($_POST["createRoom"]))
    {
        createRoom(0,$_SESSION["id"], $_POST["userid"]);
    }
    if(isset($_POST["pushMessage"]))
    {
        if (isset($_POST["uploadedFile"]))
        {
            print("I am here");
        }
        pushMessage($_SESSION["id"],$_POST['message'], $_POST['roomid']);
    }
    if(isset($_POST["getUser"]))
    {
        echo getUser($_POST["userid"]);
    }
    if(isset($_POST["drawAllMessage"]))
    {
        if(isset($_POST["activeId"]))
        {
            echo drawAllMessages($_SESSION["id"], $_POST["activeId"]);
        }
        else
        {
            echo drawAllMessages($_SESSION["id"]);
        }
    }
    if(isset($_POST["getAllContacts"]))
    {
        if(isset($_POST["activeId"]))
        {
            echo drawAllContacts($_SESSION["id"], $_POST["activeId"]);
        }
        else
        {
            echo drawAllContacts($_SESSION["id"]);
        }
    }
?>

<?php
    function drawContact($username, $roomid, $userid, $status = "", $image = "", $activeId = -2)
    {
        if($activeId == $roomid)
        {
        ?>
       <li class="contact active" id="<?=$roomid?>">
       <?php
        }
        else
        {
            ?>
            <li class="contact" id="<?=$roomid?>">
            <?php
        }
        ?>
					<div class="wrap">
						<span class="contact-status <?=$status?>"></span>
						<img src="<?=$image?>" alt="" />
						<div class="meta">
							<p class="name" id="<?=$userid?>"><?=$username?></p>
						</div>
					</div>
		</li>
    <?php
    }
?>

<?php
    function drawAllContacts($q, $activeId = -3)
    {
        $req = $GLOBALS["db"]->prepare("select * from `user`");
        $req->execute();
        $res = $req->get_result();
        $yourId = $q;
        ?>
        <ul>
        <?php
        while($row = $res->fetch_assoc())
        {
            $reqRooms = $GLOBALS["db"]->prepare("select * from `rooms` where userid = $yourId");
            $reqRooms->execute();
            $resRooms = $reqRooms->get_result();
            $roomId = -1;
            while($rowRooms = $resRooms->fetch_assoc())
            {
                $id = $row['id'];
                $roomid = $rowRooms['roomid'];
                $req = $GLOBALS["db"]->prepare("select * from `rooms` where userid = $id and roomid = $roomid");
                $req->execute();
                $resUser = $req->get_result();
                if ($rowUser = $resUser->fetch_assoc())
                {
                    $roomId = $roomid; 
                    break;
                }
            }
            if($row['id']!=$yourId)
                drawContact($row["username"],$roomId,$row['id'],$row["status"],$row["img"],$activeId);
        }
        ?>
        </ul>
        <?php
    }
?>

<?php
    function drawMessage($yourMessage, $id, $text)
    {
        if($yourMessage == true)
        {
            ?>
            <li class="sent" id="<?=$id?>"> 
                <p><?=$text?></p>
            </li>
            <?php
        }
        else
        {
            ?>
             <li class="replies" id="<?=$id?>"> 
                <p><?=$text?></p>
            </li>
            <?php
        }
    }
?>
<?php
    function drawAllMessages($yourId, $activeId = -2)
    {
        $reqRooms = $GLOBALS["db"]->prepare("select * from `room`");
        $reqRooms->execute();
        $resRooms = $reqRooms->get_result();
        while($rowRooms = $resRooms->fetch_assoc())
        {
            $id = $rowRooms["id"];
            $reqMsg = $GLOBALS["db"]->prepare("select * from `message` where roomid = $id");
            $reqMsg->execute();
            $resMsg = $reqMsg->get_result();
            if($activeId == $id)
            {
            ?>
                <ul id="<?=$id?>">
            <?php
            }
            else
            {
                ?>
                <ul hidden id="<?=$id?>">
                <?php
            }
            while($rowMsg = $resMsg->fetch_assoc())
            {
                $sender = false;
                if($yourId==$rowMsg['senderid'])
                    $sender = true;
                 drawMessage($sender,$rowMsg['id'], $rowMsg['message']); 
               
            }
            ?>
            </ul>
                <?php
        }
    }
?>
<?php
    function pushMessage($senderid, $text, $roomid)
    {
        $req = $GLOBALS["db"]->prepare("insert into `message` (message, senderid, roomid, status) values (?,?,?,?)");
        $st = 1;
        $req->bind_param('ssss',$text, $senderid, $roomid,$st);
        $req->execute();
    }
?>
<?php
    function createRoom($roomname, $founderid, $senderid)
    {
        if(!is_numeric($founderid))
        {
            $founderid = $senderid;
        }
        $req = $GLOBALS["db"]->prepare("select * from `room` where roomname='$roomname' and founderid='$founderid'");
        $req->execute();
        $res = $req->get_result();
        if($row = $res->fetch_assoc())
        {
            $id = $row['id'];
            $req = $GLOBALS["db"]->prepare("select * from `rooms` where roomid='$id' and userid='$founderid'");
            $req->execute();
            $res1 = $req->get_result();
            if($row1 = $res1->fetch_assoc())
            {
                $req = $GLOBALS["db"]->prepare("select * from `rooms` where roomid='$id' and userid='$senderid'");
                $req->execute();
                $res2 = $req->get_result();
                if($row2 = $res2->fetch_assoc())
                {
                    echo $id;
                    return;
                }
            }
        }
        $req = $GLOBALS["db"]->prepare("insert into `room` (roomname, founderid) values (?,?)");
        $req->bind_param('ss',$roomname, $founderid);
        $req->execute();
        $req = $GLOBALS["db"]->prepare("select * from `room` where roomname='$roomname' and founderid=$founderid ORDER BY id DESC");
        $req->execute();
        $res = $req->get_result();
        $row = $res->fetch_assoc();
        $roomid = $row['id'];
        $req = $GLOBALS["db"]->prepare("insert into `rooms` (userid, roomid) values (?,?)");
        $req->bind_param('ss',$founderid, $roomid);
        $req->execute();
        $req = $GLOBALS["db"]->prepare("insert into `rooms` (userid, roomid) values (?,?)");
        $req->bind_param('ss',$senderid, $roomid);
        $req->execute();
        echo $roomid;
    }
?>
<?php
    function getUser($id)
    {
        $req = $GLOBALS["db"]->prepare("select * from `user` where id=$id");
        $req->execute();
        $res = $req->get_result();
        $row = $res->fetch_assoc();
        ?>
        <img src="<?=$row["img"]?>" class="<?=$row["status"]?>" alt="" />
			<p><?=$row["username"]?></p>
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
?>