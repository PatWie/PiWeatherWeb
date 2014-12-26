<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class HumiditySnippet implements Snippet{
	public function html(){
		return createChartTemplate('Luftfeuchtigkeit','chart-humidity');
	}
}