<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class TemperatureSnippet implements Snippet{
	public function html(){
		return createChartTemplate('Temperatur','chart-temperature');
	}
}