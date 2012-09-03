<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_slider2 extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_X = "x";
	protected $KEY_Y = 'y';
	protected $KEY_WIDTH = "width";
	protected $KEY_HEIGHT = 'height';
	protected $KEY_BUTTON = 'button';
	protected $KEY_FILE = "fileName";
	protected $KEY_DISPLAY = "display";
	protected $KEY_HIDE_MODE = "hideMode";
	
	protected $KEY_TOUCH = "touch";
	protected $KEY_AUTO = "auto";
	protected $KEY_DOCK = "dock";
	protected $KEY_ARROW = "arrow";
	protected $KEY_CHANGE_MODE = "changeMode";
	protected $KEY_DOCK_ALIGN = "dockAlign";
	protected $KEY_DOCK_POSITION = "dockPosition";
	protected $KEY_DOCK_COLOR = "dockColor";
	protected $KEY_DOCK_COLOR_CURRENT = "dockColorCurrent";
	protected $KEY_DOCK_SHOWTEXT = "dockShowText";
	protected $KEY_DOCK_TEXT_COLOR = "dockTextColor";
	protected $KEY_DOCK_TEXT_COLOR_CURRENT = "dockTextColorCurrent";
	protected $KEY_DOCK_SIZE = "dockSize";
	protected $KEY_ARROW_POSITION = "arrowPosition";
	protected $KEY_ARROW_FILE = "arrowFileName";
	
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
	
    protected $KEY_TRANS_PIC = "transPic";
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
	
	protected $libs = array(
					   'js' => array('jquery.nivo.slider.js',
					   				 'jquery.touchwipe.1.1.1.js',),
					   'css' =>array('nivo-slider.css')
					   );
	public function __construct()
    {       
	}
	
	public function parseHTML($value, $param){
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];

		
		$data = array(
	        'id'        => $value[$this->KEY_ID],
			'left'    => $value[$this->KEY_X],
			'top'     => $value[$this->KEY_Y],
			'res_dir'   => $this->res_dir,
			'file'    =>  explode(";",$value[$this->KEY_FILE]),
			'width'   => $value[$this->KEY_WIDTH],
			'height'  => $value[$this->KEY_HEIGHT],
			'display' => $value[$this->KEY_DISPLAY],
			'hideMode'    => $value[$this->KEY_HIDE_MODE],
			'button'  => $value[$this->KEY_BUTTON],
			'touch'   => $value[$this->KEY_TOUCH],
			'auto'    => $value[$this->KEY_AUTO],
			'dock'    => $value[$this->KEY_DOCK],
			'arrow'   => $value[$this->KEY_ARROW],
			'changeMode' => $value[$this->KEY_CHANGE_MODE],
			'dockAlign'  => $value[$this->KEY_DOCK_ALIGN],
			'dockPosition' => $value[$this->KEY_DOCK_POSITION],
			'dockColor' => $value[$this->KEY_DOCK_COLOR],
			'dockColorCurrent' => $value[$this->KEY_DOCK_COLOR_CURRENT],
			'dockShowText' => $value[$this->KEY_DOCK_SHOWTEXT],
			'dockTextColor' => $value[$this->KEY_DOCK_TEXT_COLOR],
			'dockTextColorCurrent' => $value[$this->KEY_DOCK_TEXT_COLOR_CURRENT],
			'dockSize' => $value[$this->KEY_DOCK_SIZE],
			'arrowPosition' => $value[$this->KEY_ARROW_POSITION],
			'arrowFileName' => $value[$this->KEY_ARROW_FILE],

		    'b_height'  => $param["b_height"],
			'b_width'   => $param["b_width"],
			'b_pageWidth' => $param['b_pageWidth'],
			'b_pageHeight'=> $param['b_pageHeight'],
			'offset_w'  => 100,
			'offset_h'  => 50,
			'zIndex'   => $value['zIndex'],
			'transPic' => $value[$this->KEY_TRANS_PIC] ? 'true': 'false',
			
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
		
		$tpl = "smarty/cmp_slider2";
        $args = array($tpl , $data);
		return $style. $this->__call("parse", $args);
	}
	
	public function getAllUsersFiles($array){

		$arr = array();
		foreach( explode(";", $array[$this->KEY_FILE]) as $value ){
			$arr[$value] = $value;
		}
		
		if($array[$this->KEY_ARROW_FILE]){
		    $arr[$array[$this->KEY_ARROW_FILE]] = $array[$this->KEY_ARROW_FILE];
		}
		
		return $arr;
	}
	
	public function getLibrary(){
	    return $this->libs;
	}
}