<?php
header('Content-Type: application/json');
include_once '../../config.system.php';

$interval = array(
	array(60*60*6,    60*5),   // last  6 hour -> every 5 minutes
	array(60*60*12, 60*10),  // last 24 hour -> every 60 minutes
    array(60*60*24, 60*30),  // last 24 hour -> every 60 minutes
	array(60*60*24*3, 60*60),  // last 3 days -> every 120 minutes
	array(60*60*24*7, 60*60*6),  // last 7 days -> every 120 minutes
	array(60*60*24*30, 60*60*12),  // last 30 days -> every 480 minutes
);


class AVG{
	private $count = 0;
	private $arr=NULL;
	public function add($arr){
		if($this->arr === NULL){
			$this->arr = $arr;
			$this->count = 1;
		}else{
			for ($i=1; $i < count($arr); $i++) { 
				$this->arr[$i] += $arr[$i]*1.0;
			}
			$this->count++;
			#echo "get  ".$arr[1]." yield   ".$this->arr[1]."  --   ".$this->count."\n";
			
		}
	}
	public function get(){
		for ($i=1; $i < count($this->arr); $i++) { 
			$this->arr[$i] =round($this->arr[$i]/($this->count),1);
		}
		$this->count = 0;
		$arr = $this->arr;
		$this->arr = NULL;
		return $arr;
	}
}


$endTime    = (isset($_GET['e']) && ($_GET['e']!='')) ? $_GET['e'] : time();
if(isset($local))
    $endTime = 1417386841;
$mode = (isset($_GET['m']) && ($_GET['m']!='')) ? $_GET['m']-1 : 1;
$startTime = $endTime-$interval[$mode][0];
$startTime = ((int)($startTime/60))*60;
$sensors    = (isset($_GET['t'])) ? explode(':',$_GET['t']) : explode(':','T1');
$resolution = $interval[$mode][1];


$DisplayChart = new TFA();
$DayChart = new TFA();
$numDays = abs($endTime - $startTime)/60/60/24;
$interval_average = new AVG();
$daily_average = new AVG();
$first = true;


$endTime = ((int)($endTime/60))*60;
$startTime = ((int)($startTime/60))*60;
for ($i = 0; $i <= $numDays; $i++) {
	$filename = dataPath('raw/'.date('Y-m-d', strtotime("+{$i} day", $startTime)) .'.raw'); 
	if(file_exists($filename)){
		$lines = explode(PHP_EOL,file_get_contents($filename));
		foreach ($lines as $line) {
			if($line == '')
				continue;
			// get parts
			$parts = explode(':',$line);
			// round time (drop seconds)
			$TS = ((int)($parts[0]/60))*60;
			$parts[0] = $TS;
			// check bounds
			if( $TS > $endTime)
				break;
			if( $TS < $startTime)
				continue;
			// compute daily average
			$daily_average->add($parts);
			if(($TS+60*60)%(60*60*24)===0){
				$arr = $daily_average->get();
				$arr[0] = round((int)$parts[0]/60 ,0)*60;
				$DayChart->add($arr);
			}
			// handle display data
            #echo $resolution."-----".$TS%$resolution."\n";
			if(($TS+60*60)%$resolution!=0){
				$interval_average->add($parts);
				continue;
			}
			$arr = $interval_average->get();
			$arr[0] = round((int)$parts[0]/60 ,0)*60;
			if($first){
				$first=false;
				continue;
			}
			$DisplayChart->add($arr);
		}
	}
}
echo json_encode($DisplayChart->getData($sensors));
