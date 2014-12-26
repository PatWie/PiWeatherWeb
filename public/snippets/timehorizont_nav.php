<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';



$interval = array(
	array(60*60,    60*5),   // last hour -> every 5 minutes
	array(60*60*12, 60*20),  // last 12 hour -> every 20 minutes
	array(60*60*24, 60*30),  // last 24 hour -> every 30 minutes
	array(60*60*24*3, 60*60),  // last 3 days -> every 60 minutes
	array(60*60*24*7, 60*120),  // last 7 days -> every 120 minutes
	array(60*60*24*30, 60*720),  // last 30 days -> every 480 minutes
);



class TimeHorizont_navSnippet implements Snippet{
	public function html(){
		$str = <<<EOF
    <li><a id="l0" href="#" onclick="update(this,0);">letzte Stunde</a></li>
    <li><a id="l1" href="#" onclick="update(this,1);">letzten 12 Stunden</a></li>
    <li><a id="l2" href="#" onclick="update(this,2);">letzten 24 Stunden</a></li>
    <li><a id="l3" href="#" onclick="update(this,3);">letzte 3 Tage</a></li>
    <li><a id="l4" href="#" onclick="update(this,4);">letzte 7 Tage</a></li>
    <li><a id="l5" href="#" onclick="update(this,5);">letzte 30 Tage</a></li>
EOF;
		return $str;
	}
}

