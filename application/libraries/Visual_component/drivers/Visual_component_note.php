<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_note extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_PX = "nPX";
	protected $KEY_PY = 'nPY';
	protected $KEY_WIDTH = "nWidth";
	protected $KEY_HEIGHT = 'nHeight';
	protected $KEY_BUTTON = 'nButton';
	protected $KEY_DISPLAY = "nDisplay";
	protected $KEY_TITLE = "nTitle";
	protected $KEY_FONT = "nFont";
	protected $KEY_FONTSIZE = "nFontSize";
	protected $KEY_MAX_LENGTH = "nMaxlength";
		
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
	
	public function __construct(){
	}

	public function parseHTML($value, $param ){
	    $this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		
		$data = array(
	        'id'        => $value[$this->KEY_ID],
			'n_left'    => $value[$this->KEY_PX],
			'n_top'     => $value[$this->KEY_PY],			
			'n_file'    => $value[$this->KEY_FILE],
			'n_width'   => $value[$this->KEY_WIDTH],
			'n_height'   => $value[$this->KEY_HEIGHT],			
			'n_button'  => $value[$this->KEY_BUTTON],			
			'n_display' => $value[$this->KEY_DISPLAY],
			'n_title'   => $value[$this->KEY_TITLE],
			'n_font'    => $value[$this->KEY_FONT],
			'n_fontsize'=> $value[$this->KEY_FONTSIZE],
			'n_maxlength'=>$value[$this->KEY_MAX_LENGTH],
			'book_id'   => $param['book_id'],
			'page_id'   => $param['page_id'],
			
			'b_height'  => $param["b_height"],
			'b_width'   => $param["b_width"],
			
			'width'   => $value[$this->KEY_WIDTH],
			'height'   => $value[$this->KEY_HEIGHT],
			'b_pageWidth' => $param['b_pageWidth'],
			'b_pageHeight'=> $param['b_pageHeight'],
			'offset_w'  => 0,
			'offset_h'  => 0,
			'zIndex'  => $value['zIndex'],
						
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
		
		$tpl = "smarty/cmp_note";
		$args = array($tpl , $data);
		return $style. $this->__call("parse", $args);

	}

	public function getAllUsersFiles($array){
		return array();
	}
	
	public function getLibrary(){
	    return array();
	}
}
