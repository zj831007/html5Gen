<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_action extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_TITLE= "actTitle";
	protected $KEY_PX = "actPX";
	protected $KEY_PY = 'actPY';
	protected $KEY_TYPE = "actionType";
	protected $KEY_WIDTH = "actWidth";
	protected $KEY_HEIGHT = 'actHeight';
	protected $KEY_SOUND = 'actSound';
	protected $KEY_PAGE = "page";
	protected $KEY_FILE = "actFileName";
	protected $KEY_URL = "url";	
	
	protected $KEY_COLORING = "coloring";
	protected $KEY_JUMP = "jump";
	protected $KEY_MAP_TITLE = "map_title";
	protected $KEY_MAP_ADDR = "map_address";
	protected $KEY_MAP_TITLE2 = "map_title2";
	protected $KEY_MAP_LATITUDE = "map_latitude";
	protected $KEY_MAP_LONGITUDE = "map_longitude";
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
		
	public function __construct()
    {
	}
	
	public function parseHTML($value, $param){
		
		//print_r( $value) ;
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		
		$type = $value[$this->KEY_TYPE];
		
		$tpl = "smarty/cmp_action_normal";
		$data = array(
		    'id'        => $value[$this->KEY_ID],
			'res_dir'   => $this->res_dir,
			'act_file'  => $value[$this->KEY_FILE],			
			'act_left'  => $value[$this->KEY_PX],
			'act_top'   => $value[$this->KEY_PY],
			'act_width' => $value[$this->KEY_WIDTH],
			'act_height'=> $value[$this->KEY_HEIGHT],
			'act_sound' => $value[$this->KEY_SOUND],
			'zIndex'    => $value['zIndex'],
			'act_type'  => $value[$this->KEY_TYPE],
			'public_dir' => $this->public_dir,
		);

		switch ($type) {			
			case "url": 
			    $tpl = "smarty/cmp_url";  
				$data['url'] = $value[$this->KEY_URL];
				break;
			case "page":
			    $tpl = "smarty/cmp_page";  
				$data['page'] = $value[$this->KEY_PAGE];
				break;
			case "area":
				$tpl = "smarty/cmp_area";
			    return $this->_parseAreaHTML($value,$param);
				break;
			case "jump":
			    $data['act_args']= $value[$this->KEY_JUMP];
				break;
			case "coloring":
				$data['act_args']= $value[$this->KEY_COLORING];
				break;
			case "print":
			    $data['b_height'] = $param["b_height"];
				$data['b_width']  = $param["b_width"];
			    $tpl = "smarty/cmp_print";			   
				break;
			case "mapaddress":
			    $data['act_args']= $value[$this->KEY_MAP_TITLE].",".$value[$this->KEY_MAP_ADDR];
				break;
			case "mapgcs":
			    $data['act_args']= $value[$this->KEY_MAP_TITLE2].","
				                  .$value[$this->KEY_MAP_LATITUDE].","
								  .$value[$this->KEY_MAP_LONGITUDE];
				break;
		} 
        $args = array($tpl , $data);
		return $this->__call("parse", $args);	
	}
		
	private function _parseUrlHTML($value,$param){

		$tpl = "smarty/cmp_url";
		$data = array(
		    'id'      => $value[$this->KEY_ID],
			'act_left'  => $value[$this->KEY_PX],
			'act_top'   => $value[$this->KEY_PY],
			'res_dir' => $this->res_dir,
			'act_file'  => $value[$this->KEY_FILE],
			'act_width' => $value[$this->KEY_WIDTH],
			'act_height'=> $value[$this->KEY_HEIGHT],
			'act_sound' => $value[$this->KEY_SOUND],
			'url'     => $value[$this->KEY_URL],
			'zIndex'  => $value['zIndex'],
		);
		$args = array($tpl , $data);
		return $this->__call("parse", $args);		
	}
	
	private function _parsePageHTML($value,$param){		
		$tpl = "smarty/cmp_page";
		$data = array(
		    'id'      => $value[$this->KEY_ID],
			'act_left'  => $value[$this->KEY_PX],
			'act_top'   => $value[$this->KEY_PY],
			'res_dir' => $this->res_dir,
			'act_file'  => $value[$this->KEY_FILE],
			'act_width' => $value[$this->KEY_WIDTH],
			'act_height'=> $value[$this->KEY_HEIGHT],
			'act_sound' => $value[$this->KEY_SOUND],
			'page'     => $value[$this->KEY_PAGE],
			'zIndex'  => $value['zIndex'],
		);
		$args = array($tpl , $data);
		return $this->__call("parse", $args);	
	}
	
	private function _parseAreaHTML($value,$param){

		$tpl = "smarty/cmp_area";
		$data = array(
		    'id'      => $value[$this->KEY_ID],
			'res_dir' => $this->res_dir,
			'act_left'  => $value[$this->KEY_PX],
			'act_top'   => $value[$this->KEY_PY],
			'act_width' => $value[$this->KEY_WIDTH],
			'act_height'=> $value[$this->KEY_HEIGHT],
			'act_sound' => $value[$this->KEY_SOUND],
			'zIndex'  => $value['zIndex'],
		);
		$args = array($tpl , $data);
		return $this->__call("parse", $args);
	}
	
	public function getAllUsersFiles($array){
    	$act_file = $array[$this->KEY_FILE];
		$act_sound = $array[$this->KEY_SOUND];
		$data = array();
		if($act_file) $data[$act_file] = $act_file;
		if($act_sound) $data[$act_sound] = $act_sound;
		return $data;
	}
	
	public function getLibrary(){
	    return array();
	}
}