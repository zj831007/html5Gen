<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_rotate360 extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_X = "x";
	protected $KEY_Y = 'y';
	protected $KEY_WIDTH = "width";
	protected $KEY_HEIGHT = 'height';
	protected $KEY_BUTTON = 'button';
	protected $KEY_FILE = "fileName";
	protected $KEY_DISPLAY = "display";
	protected $KEY_HIDE_MODE = "hideMode";
	protected $KEY_ORIENTATION ="orientation";
	protected $KEY_NOTICE_COLOR = "noticeColor";
    protected $KEY_ZINDEX = "zIndex";
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
	protected $lib_dir;
	
	protected $libs = array(
					   'js' => array('jquery.reel.js'),
					   'css' => array('css/style.css') 
					   );
	public function __construct()
    {       
	}
	
	public function parseHTML($value, $param){
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		$this->lib_dir = $param['library_dir']."rotate360/";
        
		$files = explode(";",$value[$this->KEY_FILE]);
		$data = array(
	        'id'        => $value[$this->KEY_ID],
			'left'    => $value[$this->KEY_X],
			'top'     => $value[$this->KEY_Y],
			'res_dir' => $this->res_dir,
			'file'    => $value[$this->KEY_FILE],
			'width'   => $value[$this->KEY_WIDTH],
			'height'  => $value[$this->KEY_HEIGHT],
			'display' => $value[$this->KEY_DISPLAY],
			'hideMode'=> $value[$this->KEY_HIDE_MODE],
			'button'  => $value[$this->KEY_BUTTON],
			'notice_color' => $value[$this->KEY_NOTICE_COLOR],
			'orientation' => $value[$this->KEY_ORIENTATION],
			'number'  => sizeof($files),
			'lib_dir' => $this->lib_dir,			
			'zIndex'  => $value['zIndex'],
		);
		
		$tpl = "smarty/cmp_rotate360";
        $args = array($tpl , $data);
		return $style. $this->__call("parse", $args);
	}
	
	public function getAllUsersFiles($array){

		$arr = array();
		foreach( explode(";", $array[$this->KEY_FILE]) as $value ){
			$arr[$value] = $value;
		}
				
		return $arr;
	}
	
	public function getLibrary(){
	    return $this->libs;
	}
}