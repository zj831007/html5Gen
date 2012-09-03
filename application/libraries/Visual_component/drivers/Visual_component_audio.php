<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_audio extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_BUTTON = 'aButton';
	protected $KEY_FILE = "aFileName";
	protected $KEY_PLAY = "aPlay";
	protected $KEY_END_ACTION = "aEndAction";
	protected $KEY_PAGE = "aPage";
	protected $KEY_BUTTON_MODE  = "buttonMode";
	protected $KEY_PLAY_ON_LOAD  = "playOnLoad";
 	 
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
	
	public function __construct(){
	}
	
	public function parseHTML($value, $param){
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		$tpl = "smarty/cmp_audio";

		$data = array(
	        'id'        => $value[$this->KEY_ID],
			'res_dir'   => $this->res_dir,
			'a_file'    => $value[$this->KEY_FILE],
			'a_button'  => $value[$this->KEY_BUTTON],
			'a_play'    => $value[$this->KEY_PLAY],
			'a_EndAction' => $value[$this->KEY_END_ACTION],
			'a_page'    => $value[$this->KEY_PAGE],
			'button_mode' => $value[$this->KEY_BUTTON_MODE],
			'play_on_load'  => $value[$this->KEY_PLAY_ON_LOAD],
		);
		
		$args = array($tpl , $data);
		return $this->__call("parse", $args);
	}
	
	public function getAllUsersFiles($array){
		return array( $array[$this->KEY_FILE] => $array[$this->KEY_FILE]);
	}
	
	public function getLibrary(){
	    return array();
	}
}