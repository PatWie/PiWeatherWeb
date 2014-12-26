<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class WindspeedSnippet implements Snippet{
	public function html(){
		return createChartTemplate('Windgeschw. m/s','chart-windspeed');
	}
}