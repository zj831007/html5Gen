<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_gravity extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_X = "x";
	protected $KEY_Y = 'y';
	protected $KEY_WIDTH = "width";
	protected $KEY_HEIGHT = 'height';
	protected $KEY_BUTTON = 'button';
	protected $KEY_FILE = "fileName";
	protected $KEY_DISPLAY = "display";
	protected $KEY_HIDE_MODE = "hideMode";
	protected $KEY_MOVE_PAGE = "movePage";
	
	protected $KEY_BG_COLOR = "bgColor";
	protected $KEY_BD_COLOR = "bdColor";
	protected $KEY_BG_COLOR_ALPHA = "bgColorAlpha";
	protected $KEY_BD_WIDTH = "bdWidth";
	protected $KEY_TYPE = "type";
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
	
	protected $libs = array(
					   'js' => array('chdp_gravity.js'),
					   'css' => array('chdp_gravity.css') 
					   );
	public function __construct()
    {       
	}
	
	public function parseHTML($value, $param){
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
        $rgbBgColor = $this->hex2rgb($value[$this->KEY_BG_COLOR]);
		
		$data = array(
	        'id'      => $value[$this->KEY_ID],
			'left'    => $value[$this->KEY_X],
			'top'     => $value[$this->KEY_Y],
			'res_dir' => $this->res_dir,
			'file'    => explode(";",$value[$this->KEY_FILE]),
			'page'    => explode(";",$value[$this->KEY_MOVE_PAGE]),
			
			'width'   => $value[$this->KEY_WIDTH],
			'height'  => $value[$this->KEY_HEIGHT],
			'translateZ' => $value[$this->KEY_WIDTH] / 2,
			'display' => $value[$this->KEY_DISPLAY],
			'hideMode'    => $value[$this->KEY_HIDE_MODE],
			'button'  => $value[$this->KEY_BUTTON],
			
		    'b_height'  => $param["b_height"],
			'b_width'   => $param["b_width"],

			'bgColor'   => $rgbBgColor['r'] . "," . $rgbBgColor['g'] . "," . 
			               $rgbBgColor['b'] . "," . $value[$this->KEY_BG_COLOR_ALPHA],
			'bdColor'   => $value[$this->KEY_BD_COLOR],

			'bdWidth'   => $value[$this->KEY_BD_WIDTH],
			'zIndex'  => $value['zIndex'],
		);
		
		$tpl = "smarty/cmp_gravity";
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
	
	function hex2rgb( $colour ) {
	    if ( $colour[0] == '#' ) { 
            $colour = substr( $colour, 1 ); 
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) { 
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] ); 
		} else { 
			return false; 
		} 
		$r = hexdec( $r ); 
		$g = hexdec( $g ); 
		$b = hexdec( $b ); 
		return array( 'r' => $r, 'g' => $g, 'b' => $b );
	} 
}