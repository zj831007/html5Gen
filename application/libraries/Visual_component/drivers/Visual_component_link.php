<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_link extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_TITLE= "lTitle";
	protected $KEY_PX = "lPX";
	protected $KEY_PY = 'lPY';
	protected $KEY_TYPE = "linkType";
	protected $KEY_WIDTH = "lWidth";
	protected $KEY_HEIGHT = 'lHeight';
	protected $KEY_SOUND = 'lSound';
	protected $KEY_PAGE = "page";
	protected $KEY_FILE = "lFileName";
	protected $KEY_FILE2 = "lFileName2";
	protected $KEY_URL = "url";	
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
		
	public function __construct()
    {
	}
	
	public function parseHTML($value, $param){
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		
		$type = $value[$this->KEY_TYPE];

		switch ($type) {
			case "button":
				return $this->_parseButtonHTML($value,$param);
				break; 		    
		}
        
	}
	
	private function _parseButtonHTML($value,$param){
		$tpl = "smarty/cmp_button";
		$data = array(
	        'id'      => $value[$this->KEY_ID],
			'l_left'  => $value[$this->KEY_PX],
			'l_top'   => $value[$this->KEY_PY],
			'res_dir' => $this->res_dir,
			'public_dir' => $this->public_dir,
			'l_file'  => $value[$this->KEY_FILE],
			'l_file2' => $value[$this->KEY_FILE2],
			'l_width' => $value[$this->KEY_WIDTH],
			'l_height'=> $value[$this->KEY_HEIGHT],
			'l_sound' => $value[$this->KEY_SOUND],
			'zIndex'  => $value['zIndex'],
		);
		$args = array($tpl , $data);
		return $this->__call("parse", $args);
	}
	
	
	public function getAllUsersFiles($array){
    	$l_file = $array[$this->KEY_FILE];
		$l_file2 = $array[$this->KEY_FILE2];
		$l_sound = $array[$this->KEY_SOUND];
		$data = array();
		if($l_file) $data[$l_file] = $l_file;
		if($l_file2) $data[$l_file2] = $l_file2;
		if($l_sound) $data[$l_sound] = $l_sound;
		return $data;
	}
	
	public function getLibrary(){
	    return array();
	}
}