<?php
require('phpQuery/phpQuery/phpQuery.php');
require_once("include/common.inc.php");
$id = $_POST["id"];
$id = ' ' . $id . ' ';

$query = 'SELECT * FROM article WHERE id = ' . $id;
$info = dbQueryGetResult($query);

$info = array('inf' => $info);
echo json_encode($info);

