<?php


class TFA{
	public $data = array();


	public function add($str){
		$this->data[] = new TFALine($str);
	}

	public function getData($parameters){
		global $TFA_CODES;
		global $TFA_LABEL;

		$out = array();
		foreach ($parameters as  $value) {
			$series = array();
			foreach ($this->data as $point) {
				if($point->valid($value))
					$series[] = array($point->TS,$point->$value);
			}
			$out[] = array('key'=>$TFA_LABEL[$TFA_CODES[$value]],'values'=>$series);
		}

		return $out;

	}
}