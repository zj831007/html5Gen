<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_text extends CI_Driver {
	
	protected $KEY_ID = "id";
	protected $KEY_PX = "tPX";
	protected $KEY_PY = 'tPY';
	protected $KEY_POSITION = "tPosition";
	
	protected $KEY_TITLE_WIDTH = "tTitleWidth";
	protected $KEY_TITLE_HEIGHT = 'tTitleHeight';
	protected $KEY_TITLE_TEXT = "tTitleText";
	protected $KEY_TITLE_FONT = "tTitleFont";
	protected $KEY_TITLE_FONTSIZE = "tTitleFontSize";
	protected $KEY_TITLE_BG_COLOR = "tTitleBgColor";
	protected $KEY_TITLE_COLOR = "tTitleColor";
	protected $KEY_TITLE_FILE = "tTitleFileName";
	protected $KEY_TITLE_ALIGN = "tTitleAlign";
	
	protected $KEY_BODY_FILE ="tBodyFileName";
	protected $KEY_BODY_TEXT = "tBodyText";
	protected $KEY_BODY_BG_COLOR = "tBodyBgColor";
	protected $KEY_BODY_WIDTH = "tBodyWidth";
	protected $KEY_BODY_HEIGHT = "tBodyHeight";
	
	protected $KEY_BODY_FILE_WIDTH = "tBodyFileWidth";
	protected $KEY_BODY_FILE_HEIGHT = "tBodyFileHeight";
	
	protected $KEY_BODY_BG_FILE ="tBodyBgFileName";
	
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
	
	public function __construct(){
	}

	public function parseHTML($value, $param ){
	    $this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
		$tpl = "smarty/cmp_text";
		$data = array(
		    'res_dir'   => $this->res_dir,
	        'id'        => $value[$this->KEY_ID],
			't_left'    => $value[$this->KEY_PX],
			't_top'     => $value[$this->KEY_PY],
			't_position'=> $value[$this->KEY_POSITION],	
			
			't_titleFile'    => $value[$this->KEY_TITLE_FILE],
			't_titleWidth'   => $value[$this->KEY_TITLE_WIDTH],
			't_titleHeight'  => $value[$this->KEY_TITLE_HEIGHT],
			't_titleBgColor' => $value[$this->KEY_TITLE_BG_COLOR] ? $value[$this->KEY_TITLE_BG_COLOR] : '',
			't_titleColor'   => $value[$this->KEY_TITLE_COLOR],
			't_titleText'    => $value[$this->KEY_TITLE_TEXT],
			't_titleFont'    => $value[$this->KEY_TITLE_FONT],
			't_titleFontSize'=> $value[$this->KEY_TITLE_FONTSIZE],
			't_titleAlign'   => $value[$this->KEY_TITLE_ALIGN],
			
			't_bodyFile'     => $value[$this->KEY_BODY_FILE],
			't_bodyText'     => str_replace('<{$user_res_path}>',$this->res_dir, $value[$this->KEY_BODY_TEXT]),
			't_bodyBgColor'  => $value[$this->KEY_BODY_BG_COLOR] ? $value[$this->KEY_BODY_BG_COLOR] : '',
			't_bodyWidth'    => $value[$this->KEY_BODY_WIDTH],
			't_bodyHeight'   => $value[$this->KEY_BODY_HEIGHT],	
			't_bodyFileWidth'    => $value[$this->KEY_BODY_FILE_WIDTH],
			't_bodyFileHeight'   => $value[$this->KEY_BODY_FILE_HEIGHT],
			't_bodyBgFile'       => $value[$this->KEY_BODY_BG_FILE],
			'zIndex'  => $value['zIndex'],
		);
		
		$args = array($tpl , $data);
		return $this->__call("parse", $args);

	}

	public function getAllUsersFiles($array){
		$t_titleFile = $array[$this->KEY_TITLE_FILE];
		$t_bodyFile = $array[$this->KEY_BODY_FILE];
		$t_bodyBgFile = $array[$this->KEY_BODY_BG_FILE];
		$body_text = $array[$this->KEY_BODY_TEXT];
		$body_text = stripslashes($body_text);  
		preg_match_all("/<(img|source|video).+src=(('|\")(<\{){1}(.+)(\}>){1}(.+)('|\"))/Uis",$body_text,$out);
		
		$data = array();
		if($t_titleFile) $data[$t_titleFile] = $t_titleFile;
		if($t_bodyFile) $data[$t_bodyFile] = $t_bodyFile;
		if($t_bodyBgFile) $data[$t_bodyBgFile] = $t_bodyBgFile;
		foreach($out[7] as $file){
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
