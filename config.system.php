<?php

date_default_timezone_set('Europe/Berlin');


$stations = array(
	'int'	
);

$TFA_CODES = array(
	'TS' => 0,'T0' => 1,'H0' => 2,'T1' => 3,'H1' => 4,'T2' => 5,'H2' => 6,
	'T3' => 7,'H3' => 8,'T4' => 9,'H4' => 10,'T5' => 11, 'H5' => 12,'PRESS' => 13,
	'UV' => 14,'FC' => 15,'STORM' => 16,'WD' => 17,'WS' => 18,'WG' => 19,'WC' => 20,'RC' => 21);


$TFA_LABEL = array(
	0 => 'zeit', 1 => 'InnenTemp.', 2 => 'H0', 3 => 'AussenTemp.', 4 => 'Luftfeuchtigkeit', 
	5 => 'T2', 6 => 'H2', 7 => 'T3', 8 => 'H3', 9 => 'T4', 10 => 'H4', 11 => 'T5', 12 => 'H5', 
	13 => 'PRESS', 14 => 'UV', 15 => 'FC', 
	16 => 'STORM', 17 => 'WD', 18 => 'Windgeschw. m/s', 19 => 'WG', 20 => 'WC', 21 => 'RC');

function __autoload($class_name) {
	$f = LOCATION.'lib/'.strtolower($class_name) . '.php';
	if(file_exists($f))
    	include_once $f;
}


function dataPath($p=''){
	global $stations;
	if(isset($_GET['s']) && in_array($_GET['s'], $stations)){
		return LOCATION.'data/'.$_GET['s'].'/'.$p;
	}else{
		return LOCATION.'data/'.$stations[0].'/'.$p;
	}
}

function map($value,$domain,$range=array(0,1)){
	$r = ($range[1] - $range[0])/($domain[1] - $domain[0]);
	return ($value-$domain[0])*$r+$range[0];
}

function mixcolors($color1, $color2,$balance = 0.5)
{

  $c1_p1 = hexdec(substr($color1, 0, 2));
  $c1_p2 = hexdec(substr($color1, 2, 2));
  $c1_p3 = hexdec(substr($color1, 4, 2));

  $c2_p1 = hexdec(substr($color2, 0, 2));
  $c2_p2 = hexdec(substr($color2, 2, 2));
  $c2_p3 = hexdec(substr($color2, 4, 2));

  $m_p1 = sprintf('%02x', (round(((1-$balance)*$c1_p1 + ($balance)*$c2_p1))));
  $m_p2 = sprintf('%02x', (round(((1-$balance)*$c1_p2 + ($balance)*$c2_p2))));
  $m_p3 = sprintf('%02x', (round(((1-$balance)*$c1_p3 + ($balance)*$c2_p3))));

 return    $m_p1 . $m_p2 . $m_p3;
}

function createChartTemplate($title,$id){
	return '<div class="col-md-6">            
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">'.$title.' (<span class="time">letzten 24 Stunden</span>)</h3>
        </div>
        <div class="panel-body">
            <div id="'.$id.'" style="height: 300px;">
                <svg></svg>
            </div>
        </div>
    </div>
</div>';
}

if(file_exists(__DIR__."/config.user.php"))
	require __DIR__."/config.user.php";
else
	echo "no";