<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends MY_Controller {


	protected $video_path = '';
	protected $editor_type = 'video';

	function __construct(){
	
		parent::__construct();		
		//$this->video_path = $this->config->item('');
	}
	
	function getEditorType(){
	    return $this->editor_type;
	}
	
	function getEditorPath(){
		 return $this->video_path;
	}

    function getViewName(){
		return "video_view";
	}
	
	public function save(){
		$this->_doSave();		
	}
	
	function _parseHTML($forPreview = true){
		return $this->_doParseHTML($forPreview);
    }
	
	function _parseSettings(){
		
	   $global = $this->_post("global");
	   $global = stripslashes($global);
	   $global = json_decode($global, true);
	   $global['sounds'] = array();
	   $global['pages'] = array();
	   
	   $data = array(		   
			'bFileName'    => $this->_post("bFileName"),
			//'bSize'        => $this->_post("bSize"),
			'bOrientation' => $this->_post("bOrientation"),
			'bWidth'       => $this->_post("bWidth"),
			'bHeight'      => $this->_post("bHeight"),
			'bColor'       => $this->_post("bColor"),
			'bsFileName'   => $this->_post("bsFileName"),
			'bsLoop'       => $this->_post("bsLoop"),
			'Global'       => $global,		
		);
	    return json_encode($data);
	}
	
	function _getAllUsersFiles($settings){
		$settingArray = json_decode($settings, true);
		$files = array();		
		array_push($files, $settingArray['bFileName']);
		if($settingArray['bsFileName']){
			array_push($files, $settingArray['bsFileName']);
		}
        return $files;
	}
	
	function _getNewFileName($oldName, $new_pre){
		$suffix = $this->_get_extension($oldName);
		return $new_pre.$suffix;
	}

	function initWithSettings(&$settingsArray, $from, $to){
	}
	
	/*function initSettings($initArray, $from, $to){
		
		$result = array("settings"=>array(), "cmp_settings" => array(), "Global" => array() );
		if( !$initArray ){
			return $result;
		}

		$editor_settings = $initArray['editor'];
		$componets = $initArray['components'];
		
        $bFile = $editor_settings['bFileName'];
		if($bFile){
		    copy($from.$bFile, $to.$bFile);
		}
		$bsFile = $editor_settings['bsFileName'];
		if($bsFile){
		    copy($from.$bsFile, $to.$bsFile);
		}
		
		$cmp_settings = array();
		$sounds = array();
		foreach($componets as $cmp){
		   $id = "cmp_".$cmp["cmp_id"];
		   $settings = $cmp['settings'];
		   $files =  '';
		   if($cmp['files'])
		       $files = explode(";",$cmp['files']);
		   $type = $cmp['type'];
		   $cmp_settings[$id] = $settings;
		   if($files)
		       $this->_copyFiles($files, $from, $to);
		   if($type == "link"){ // load Global.sounds
		       $cmp_array = stripslashes($settings);	
			   $cmp_array = json_decode($cmp_array, true);
			   $linkType = $cmp_array['linkType'];
			   if($linkType == "button" && $cmp_array['lSound']){
				   $sounds[$cmp_array['lSound']] =  $cmp_array['lSound'];
			   }
		   }		   
		}
        $result['settings'] = $editor_settings;
		$result['cmp_settings'] = $cmp_settings;
		
		$global = $editor_settings['Global'];
		
		if($sounds ){
			 $global['sounds'] = $sounds;			 
		}
		
		$result['Global'] = $global;
		
		return $result;
	}*/
	
}
