<?php

include_once '../config.system.php';


class Page{
	protected $html;
	protected $substitute = array();

	public function __construct($file){
		$this->html = file_get_contents(LOCATION.'public/template/'.$file.'.html');

	}


	public function __set($k, $v){
		$this->substitute[$k] = $v;
	}

	public function __toString(){
		$html = $this->html;

		// replace snippets
		$re = "/{{snippet:(\\w*)}}/U"; 
		preg_match_all($re, $html, $matches);

		for ($i=0; $i < count($matches[0]); $i++) { 
			
			if(!isset($matches[0][$i]))
				continue;
			
			$f = LOCATION.'public/snippets/'.$matches[1][$i].'.php';
			if(file_exists($f)){
				include_once $f ;
				$clsname = $matches[1][$i].'Snippet';
				$snippet = new $clsname();
				$html = str_replace($matches[0][$i], $snippet->html(), $html);
			}else{
				$html = str_replace($matches[0][$i], 'snippet '.$matches[0][$i].'not found!', $html);
			}

			
		}
		

		// replace constants
		$s = array_merge($this->substitute,array('WEBPATH'=>WEBPATH,'title'=>'Wetter'));
		foreach ($s as $key => $value) {
			$html = str_replace('{{'.$key.'}}', $value, $html);
		}
		return $html;
	}
}