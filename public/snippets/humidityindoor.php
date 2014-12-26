<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class HumidityindoorSnippet implements Snippet{
	public function html(){
		return createChartTemplate('Luftfeuchtigkeit (innen)','chart-humidity-indoor');
	}
}