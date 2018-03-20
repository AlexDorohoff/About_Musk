<?php
require('phpQuery/phpQuery/phpQuery.php');
require_once("include/common.inc.php");
//TODO: define("TEMPLATE_NAMWE", "path")

$query = 'SELECT * FROM articles';
$info = dbQueryGetResult($query);

echo getView('index.twig', $info);
