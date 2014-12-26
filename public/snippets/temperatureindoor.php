<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class TemperatureindoorSnippet implements Snippet{
	public function html(){
		return createChartTemplate('Temperatur (innen)','chart-temperature-indoor');
	}
}