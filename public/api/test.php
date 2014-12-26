<?php
header('Content-Type: application/json');
include_once '../../config.system.php';

$interval = array(
	array(60*60,    60*5),   // last hour -> every 5 minutes
	array(60*60*12, 60*20),  // last 12 hour -> every 20 minutes
	array(60*60*24, 60*20),  // last 24 hour -> every 30 minutes
	array(60*60*24*3, 60*20),  // last 3 days -> every 60 minutes
	array(60*60*24*7, 60*20),  // last 7 days -> every 120 minutes
	array(60*60*24*30, 60*20),  // last 30 days -> every 480 minutes
);



$endTime    = (isset($_GET['e']) && ($_GET['e']!='')) ? $_GET['e'] : time();
$endTime    = 1417388341-60*60*4-26*60;
$mode = 5;
$startTime = $endTime-$interval[$mode][0];
$startTime = ((int)($startTime/60/60))*60*60;
$sensors    = (isset($_GET['t'])) ? explode(':',$_GET['t']) : explode(':','T1');
$resolution = $interval[$mode][1];


$chart = new TFA();
$numDays = abs($endTime - $startTime)/60/60/24;
$last_point = 0;
for ($i = 0; $i <= $numDays; $i++) {
	$filename = dataPath('raw/'.date('Y-m-d', strtotime("+{$i} day", $startTime)) .'.raw'); 
	if(file_exists($filename)){
		$lines = explode(PHP_EOL,file_get_contents($filename));
		foreach ($lines as $line) {
			if($line == '')
				continue;
			$parts = explode(':',$line);
			if(abs($parts[0]-$last_point)<$resolution)
				continue;
			if( $parts[0] > $endTime) 
				break;
			if( $parts[0] < $startTime) 
				continue;
			$last_point = $parts[0];
			$chart->add($parts);
		}	
	}
}

echo $chart->getData($sensors);
