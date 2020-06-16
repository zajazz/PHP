<?php
define('DIR_IMG', 'img');
$images_tmp = scandir(__DIR__ . '/' . DIR_IMG);

$tmp = '';
foreach ($images_tmp as $value){
	if(strlen($value) > 2){
		$tmp .= "<a href=" . DIR_IMG .'/'. $value ." target='_blank'>
					<img src=" . DIR_IMG .'/'. $value .">
				 </a>";
	}
}

$temp = file_get_contents('template.tpl');
$temp = str_replace('{{CODE}}', $tmp, $temp);
echo $temp;