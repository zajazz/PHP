<?php
define(DIR_LOGS, 'logs');


function logging()
{
	$today = date('G:i:s d.m.Y');
    file_put_contents(DIR_LOGS . '/log.txt', $today . "\r\n", FILE_APPEND);
    
    $logs = count(explode("\r\n", file_get_contents(DIR_LOGS . '/log.txt')));
	
    if ($logs >= 10) {
		$dir = __DIR__ . '/' . DIR_LOGS . '/';
		$count = count(scandir($dir)) - 2;
        rename($dir . 'log.txt', $dir . 'log' . $count . '.txt');
    }
}

logging();
