<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';

class CurrentSnippet implements Snippet{
	public function html(){

		$LATEST = new TFALine(explode(':',file_get_contents(dataPath('last.dat'))));

		$STATS = json_decode(file_get_contents(dataPath('stats.json')));

		$html = new Page('current');

		$html->date             = (new Calendar($LATEST->TS))->text();
		$html->temperature      = $LATEST->T1;
		$html->color            = 'white';
		$html->huminity         = $LATEST->H1;
		$html->windspeed        = $LATEST->WS;
		$html->uv               = $LATEST->UV;
		$html->airpressure      = $LATEST->PRESS;
		$html->temp_max         = $STATS->maxTempVal;
		$html->temp_max_date    = (new Calendar($STATS->maxTempTS))->text();
		$html->temp_min         = $STATS->minTempVal;
		$html->temp_min_date    = (new Calendar($STATS->minTempTS))->text();
		$html->temp_avg         = round($STATS->meanTempVal,2);
		$html->last_update      = 'f';

		// some color gradient from pale-blue to red
		$balance = map($LATEST->T1,array($STATS->minTempVal,$STATS->maxTempVal));
		$html->feeling          = '#'.mixcolors('8FFFE7','FF1212',$balance);
	
		return $html;
	}
}