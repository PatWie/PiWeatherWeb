<?php

include_once '../config.system.php';
include_once LOCATION.'lib/snippet.interface.php';


class TimeHorizont_navSnippet implements Snippet{
    public function html(){
        $str = <<<EOF
    <li><a id="l0" href="#" onclick="update(this,1);">letzten 6 Stunde</a></li>
    <li><a id="l1" href="#" onclick="update(this,2);">letzten 12 Stunden</a></li>
    <li><a id="l2" href="#" onclick="update(this,3);">letzten 24 Stunden</a></li>
    <li><a id="l3" href="#" onclick="update(this,4);">letzte 3 Tage</a></li>
    <li><a id="l4" href="#" onclick="update(this,5);">letzte 7 Tage</a></li>
    <li><a id="l5" href="#" onclick="update(this,6);">letzte 30 Tage</a></li>
EOF;
        return $str;
    }
}

