<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_text2 extends CI_Driver {
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
	
	public function __construct(){
	}

	public function parseHTML($value, $param ){
	    $this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		$tpl = "smarty/cmp_text2";
		$data = array(
		    'res_dir'   => $this->res_dir,
	        'id'        => $value['id'],
			'left'    => $value['x'],
			'top'     => $value['y'],
			'text'     => str_replace('<{$user_res_path}>',$this->res_dir, $value['text']),
			'width'    => $value['width'],
			'height'   => $value['height'],
			'zIndex'  => $value['zIndex'],
			'display' => $value['display'],
			'hide'    => $value['hideMode'],
			'button'  => $value['button'],
		);
		
		$args = array($tpl , $data);
		return $this->__call("parse", $args);

	}

	public function getAllUsersFiles($array){
		
	    $text = $array['text'];
		$text = stripslashes($text);  
		preg_match_all("/<(img|source|video).+src=(('|\")(<\{){1}(.+)(\}>){1}(.+)('|\"))/Uis",$text,$out);
		
		$data = array();
		foreach($out[7] as $file){
			//echo $file;
			//if(strpos($file,'<{$user_res_path}>')){
			//   $file =  str_replace('<{$user_res_path}>','', $file);
			if($file) $data[$file] = $file;
			//}
		}
		
		return $data;
	}
	
	public function getLibrary(){
	    return array();
	}
}
