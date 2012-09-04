<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_img extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_PX = "iPX";
	protected $KEY_PY = 'iPY';
	protected $KEY_WIDTH = "iWidth";
	protected $KEY_HEIGHT = 'iHeight';
	protected $KEY_BUTTON = 'iButton';
	protected $KEY_FILE = "iFileName";
	protected $KEY_DISPLAY = "iDisplay";
	protected $KEY_HIDE = "iHide";   // 消失動作
	
	protected $KEY_LOAD_ACTION = "loadAction";
	protected $KEY_LOAD_POS = "loadPos";
	protected $KEY_LOAD_2D = "load2D";
	protected $KEY_LOAD_3D_X = "load3DX";
	protected $KEY_LOAD_3D_Y = "load3DY";
	protected $KEY_LOAD_SPEED = "loadSpeed";
	protected $KEY_LOAD_OPACITY = "loadOpacity";
	protected $KEY_LOAD_DELAY = "loadDelay";
	
	protected $KEY_HIDE_ACTION = "hideAction";
	protected $KEY_HIDE_POS = "hidePos";
	protected $KEY_HIDE_2D = "hide2D";
	protected $KEY_HIDE_3D_X = "hide3DX";
	protected $KEY_HIDE_3D_Y = "hide3DY";
	protected $KEY_HIDE_SPEED = "hideSpeed";
	protected $KEY_HIDE_OPACITY = "hideOpacity";
	protected $KEY_HIDE_DELAY = "hideDelay";
	
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

		
		$data = array(
	        'id'        => $value[$this->KEY_ID],
			'i_left'    => $value[$this->KEY_PX],
			'i_top'     => $value[$this->KEY_PY],
			'res_dir'   => $this->res_dir,
			'i_file'    => $value[$this->KEY_FILE],
			'i_width'   => $value[$this->KEY_WIDTH],
			'i_height'  => $value[$this->KEY_HEIGHT],
			'i_display' => $value[$this->KEY_DISPLAY],
			'i_hide'    => $value[$this->KEY_HIDE],
			'i_button'  => $value[$this->KEY_BUTTON],
           
		    'b_height'  => $param["b_height"],
			'b_width'   => $param["b_width"],
			'b_pageWidth' => $param['b_pageWidth'],
			'b_pageHeight'=> $param['b_pageHeight'], 	
			'width'   => $value[$this->KEY_WIDTH],
			'height'  => $value[$this->KEY_HEIGHT],
			'offset_w'  => 0,
			'offset_h'  => 0,
			'zIndex'  => $value['zIndex'],
			'tap'     => $value['iTap'],
			
			$this->KEY_LOAD_ACTION => $value[$this->KEY_LOAD_ACTION],
			$this->KEY_LOAD_POS => $value[$this->KEY_LOAD_POS],
			$this->KEY_LOAD_2D => $value[$this->KEY_LOAD_2D],
			$this->KEY_LOAD_3D_X => $value[$this->KEY_LOAD_3D_X],
			$this->KEY_LOAD_3D_Y => $value[$this->KEY_LOAD_3D_Y],
			$this->KEY_LOAD_SPEED => $value[$this->KEY_LOAD_SPEED],
			$this->KEY_LOAD_OPACITY => $value[$this->KEY_LOAD_OPACITY],
			$this->KEY_LOAD_DELAY   => $value[$this->KEY_LOAD_DELAY],
			
			$this->KEY_HIDE_ACTION => $value[$this->KEY_HIDE_ACTION],
			$this->KEY_HIDE_POS => $value[$this->KEY_HIDE_POS],
			$this->KEY_HIDE_2D => $value[$this->KEY_HIDE_2D],
			$this->KEY_HIDE_3D_X => $value[$this->KEY_HIDE_3D_X],
			$this->KEY_HIDE_3D_Y => $value[$this->KEY_HIDE_3D_Y],
			$this->KEY_HIDE_SPEED => $value[$this->KEY_HIDE_SPEED],
			$this->KEY_HIDE_OPACITY => $value[$this->KEY_HIDE_OPACITY],
			$this->KEY_HIDE_DELAY   => $value[$this->KEY_HIDE_DELAY],
		);
		$tpl = "smarty/css/loadAction.tpl";
		$args = array($tpl , $data);
		$style = ($value[$this->KEY_LOAD_ACTION]) ? $this->__call("parse", $args): '';
		
		$tpl = "smarty/css/hideAction.tpl";
		$args = array($tpl , $data);
		$style = ($value[$this->KEY_HIDE_ACTION]) ? $style.$this->__call("parse", $args): $style.'';
		
		$tpl = "smarty/cmp_image";
		$args = array($tpl , $data);		
		return $style. $this->__call("parse", $args);
	}
	
	public function getAllUsersFiles($array){
		return array( $array[$this->KEY_FILE] => $array[$this->KEY_FILE]);
	}
	
	public function getLibrary(){
	    return array();
	}
}