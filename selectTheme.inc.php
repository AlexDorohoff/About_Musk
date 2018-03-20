<?php
require('phpQuery/phpQuery/phpQuery.php');
require_once("include/common.inc.php");

$theme = $_POST["theme"];
$theme= "'" . $theme . "'" ;

$query = 'SELECT * FROM articles WHERE theme = ' . $theme;
$info = dbQueryGetResult($query);

$info = array('inf' => $info);
echo json_encode($info);
