<?php


class TFALine{
	public $data = array();

	public function __construct($raw){
		$this->data = $raw;
	}

	public function valid($sensor){
		return true;
	}

	public function __get($k){

		global $TFA_CODES;
		if(array_key_exists($k, $TFA_CODES)){
			return $this->data[$TFA_CODES[$k]];
		}
	}
}
