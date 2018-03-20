<?php

$g_previousTime = 0;
function writeLog($message)
{
global $g_previousTime;

$fw = @fopen(ROOT_DIR . "/log/debug.log", "a");
if ($fw) {
$currentTime = microtime(true);
$diff = 0;
if ($g_previousTime > 0) {
$diff = $currentTime - $g_previousTime;
}
$g_previousTime = $currentTime;
$message = $currentTime . " - " . $diff . " - " . $message . "\r\n";
fwrite($fw, $message);
fclose($fw);
}
}