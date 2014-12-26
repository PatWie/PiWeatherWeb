<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class UvSnippet implements Snippet{
	public function html(){
		return createChartTemplate('UV','chart-uv');
	}
}