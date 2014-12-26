<?php
header("Content-Type:text/plain");
include_once '../../config.system.php';


if(!isset($_GET['k']) || ($_GET['k'] != SECRET)){
	echo "SECRET:            ".'invalid'.PHP_EOL;
	echo "                   ".'--> abort'.PHP_EOL;
	exit;
}else{
	echo "SECRET:            ".'valid'.PHP_EOL;
}
if(!isset($_GET['s']) || !in_array($_GET['s'], $stations)){
	echo "STATION:           ".'unkown'.PHP_EOL;
	echo "                   ".'--> abort'.PHP_EOL;
	exit;
}else{
	echo "STATION:           ".'kown'.PHP_EOL;
	echo "                   ".'--> hello "'.$_GET['s'].'"'.PHP_EOL;
}
echo "                   ".'--> handle request'.PHP_EOL;
echo "REQUEST_URI:       ".$_SERVER['REQUEST_URI'].PHP_EOL;

if(!isset($_GET['q']) || ($_GET['q']=='')){
	echo "                   ".'--> data not found'.PHP_EOL;
	exit;
}else{
	echo "                   ".'--> data found'.PHP_EOL;
}
echo "RAWDATA:           ".$_GET['q'].PHP_EOL;

$q = $_GET['q'];
$p = explode(':',$q);
echo "INTERPRET TIME:    ".date("Y-m-d",(int)$p[0]).PHP_EOL;
$filename = dataPath('raw/'.date('Y-m-d',  (int)$p[0]) .'.raw');
#$filename = LOCATION."data/kus/raw/".$_GET['s']."/".date("Y-m-d",(int)$p[0]).'.raw';
echo "ADD TO FILE:       ".$filename.PHP_EOL;


#exit;
if(!file_exists($filename))
		touch($filename);
file_put_contents($filename,$q.PHP_EOL,FILE_APPEND);
	file_put_contents("../data/last_ts.dat",$q);
