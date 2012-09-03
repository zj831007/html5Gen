<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Motionbox extends MY_Controller {


	protected $editor_path = '';
	protected $editor_type = 'motionbox2';

	function __construct(){
	
		parent::__construct();		
		$this->load->model('Component_settings_model');
	}
	
	/*public function show($pageid=''){

		global $ebook,$user_profile, $page_head, $page_foot;
		
		if(!$pageid) $pageid= $_GET['pid'];
		
		$orientation = $ebook['orientation'] ;	
    	
		$userid = $user_profile['id'];

		$this->ownerPath =  $this->system_path . $user_profile['user_files_path'];

        $data = $this->Editor_settings_model->getInitData1($ebook, $userid);	
				
		if($data){
			$data['userid'] = $userid;
			$bookid = $data['bookid'];
			
			// rebuild user_temp
			$user_temp = explode("@", $user_profile['username']);
			$user_temp = $userid."_".$user_temp[0]."/".$bookid."/".$pageid;

			// create user temp dir
			delete_files("./temp/". $user_temp);
			$this->_mkPath("./temp/". $user_temp);
			$data["user_temp"] = $user_temp;
			
			// initial
			if(isset($data['settings'])){
		        $settingsArray =json_decode( $data['settings'], true);
				
				$cmpSettingsArray = $this->Component_settings_model->loadSettingsByPageId($pageid);
				
				$array = array( 'editor_settings' => $settingsArray, 'componets' =>$cmpSettingsArray);
				
				$from = $this->ownerPath. $bookid . "/";
				$to   = "./temp/" . $user_temp . "/";
				
                $this->initWithSettings($array, $from, $to);
                
				$data['Global'] = json_encode($array['global']);
				$data['cmp_settings'] = (json_encode($array['cmp_settings']))? json_encode($array['cmp_settings']) :'{}';
				$data['isAdd'] = FALSE;
				
			}else{
				$data['isAdd'] = TRUE;
				$data['settings'] = '{}';
				$data['Global'] = '{}';
				$data['cmp_settings'] = '{}';
			}        
			$data["ownerPath"] = $this->ownerPath;
			
			// TODO
			//$data["bOrientation"] = "h";
			$data["bOrientation"] = $orientation;
			$bg_size = $this->sizeArray[$orientation];
			$data["bWidth"] = $bg_size[0];
			$data["bHeight"] = $bg_size[1];
			
			echo $page_head;
			echo $this->load->view($this->view_name,$data,true);
			echo $page_foot;
		}else {
		    die("ebook_page[".$pageid."] not found.");
		}
	}*/

    public function save(){
		$this->_doSave();		
	}
	
	function getEditorType(){
	    return $this->editor_type;
	}
	
	function getEditorPath(){
		 return $this->editor_path;
	}

    function getViewName(){
		return "motionbox_view";
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
			'bFileName'    => urlencode($this->_post("bFileName")),
			//'bSize'        => $this->_post("bSize"),
			'bOrientation' => $this->_post("bOrientation"),
			'bWidth'       => $this->_post("bWidth"),
			'bHeight'      => $this->_post("bHeight"),
			'bColor'       => $this->_post("bColor"),
			'bsFileName'   => urlencode($this->_post("bsFileName")),
			'bsLoop'       => $this->_post("bsLoop"),
			'bLoadAction'  => $this->_post("bLoadAction"),
			'bUnLoadAction'=> $this->_post("bUnLoadAction"),
			'Global'       => $global,
	   		'bPageWidth'   => $this->_post('bPageWidth'),
	   		'bPageHeight'  => $this->_post('bPageHeight'),
	   		'bPageScale'   => $this->_post('bPageScale'),
	   		
		);
	    return urldecode(json_encode($data));
			
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
	}
	
	function initWithSettings(&$array, $from, $to){
		/*$editor_settings = $array['editor_settings'];
		$componets = $array['componets'];
		
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

		$array['cmp_settings'] = $cmp_settings ;
		
		$global = $editor_settings['Global'];
		
		if($sounds ){
			 $global['sounds'] = $sounds;			 
		}
		
		$array['global'] = $global;*/
	}	
	
	function loadpageInfo(){
	    $bookid = $this->_post("bookid");
		$pageid = $this->_post("pageid");
		$data = $this->Ebook_page_model->loadPageByBookId($bookid, $pageid);		
		echo json_encode($data);
	}
	
}
