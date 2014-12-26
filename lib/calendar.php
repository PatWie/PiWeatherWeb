<?php
date_default_timezone_set('Europe/Berlin');

class Calendar{
	public $stamp;
	
	public function __construct($t=NULL){
		if($t===NULL){
			$t = time();
		}
		$this->stamp = $t;
	}

	public function __get($k){
		$m = array('year'=>'y','month'=>'m','day'=>'d','hour'=>'h','minute'=>'i','second'=>'s');
		if(in_array($k, $m)){
			return (int) date($m[$k],$this->stamp);
		}
	}

	public function add($i,$unit){
		$m = array('year','month','day','hour','minute','second');
		if(in_array($unit, $m)){
			$this->stamp = strtotime($i.' '.$unit, $this->stamp);
		}
	}
	public function next($unit){
		$this->add(1,$unit);
	}
	public function previous($unit){
		$this->add(-1,$unit);
	}

	public function asDiff(){
		$out = '';
		$use = false;
		if($this->year>0 || $use) {
			$out .= $this->year.' Jahre';
			$use = true;
		}
		if($this->month>0 || $use) {
			$out .= $this->month.' Monate';
			$use = true;
		}
		if($this->day>0 || $use) {
			$out .= $this->day.' Tage';
			$use = true;
		}
		if($this->hour>0 || $use) {
			$out .= $this->hour.' Stunden';
			$use = true;
		}
		if($this->minute>0 || $use) {
			$out .= $this->minute.' Minuten';
			$use = true;
		}
		return $out;		
	}

	public function yesterday(){
		$this->stamp = strtotime('-1 day', $this->stamp);
	}
	public function tomorrow(){
		$this->stamp = strtotime('+1 day', $this->stamp);
	}

	public function resetClock(){
		$tmp = $this->stamp % (24*60*60)+60*60;
		$this->stamp = $this->stamp - $tmp;
	}

	

	public function text($format="Y-m-d H:i:s"){
		return date($format,$this->stamp);
		
	}
	public function time(){
		return $this->stamp;
	}
}