<?php
function drawAllMessages()
{
    $reqRooms = $GLOBALS["db"]->prepare("select * from `room`");
    $reqRooms->execute();
    $resRooms = $reqRooms->get_result();
    while($rowRooms = $resRooms->fetch_assoc())
    {
        $id = $rowRooms["id"];
        $reqMsg = $GLOBALS["db"]->prepare("select * from `message` where 'roomid' = $id");
        $reqMsg->execute();
        $resMsg = $reqMsg->get_result();
        while($rowMsg = $resMsg->fetch_assoc())
        {
            ?>
            <ul class="ng-hide" id="<?=$id?>">
            <?php
            $sender = false;
            if($_SESSION['id']==$rowMsg['senderid'])
                $sender = true;
             drawMessage($sender,$rowMsg['id'], $rowMsg['message']); ?>
            </ul>
            <?php
        }
    }
}
?>