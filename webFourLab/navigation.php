<?php
function GetNews($offset, $limit)
{
    $query = $GLOBALS["mysqli"]->prepare("SELECT * FROM news ORDER BY data DESC LIMIT $offset, $limit");
    $query->execute();
    $result = $query->get_result();
    return $result;
}