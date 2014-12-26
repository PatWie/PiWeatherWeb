<?php

include_once '../config.php';

$t = time();
$c = new Calendar($t);

echo $c->time().'<br>';
echo $c->text().'<br><hr>';
$c->add(5,'day');
echo $c->time().'<br>';
echo $c->text().'<br><hr>';
$c->resetClock();
echo $c->time().'<br>';
echo $c->text().'<br><hr>';
$c->previous('year');
echo $c->time().'<br>';
echo $c->text().'<br><hr>';