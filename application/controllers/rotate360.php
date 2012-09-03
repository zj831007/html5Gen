<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rotate360 extends MY_Controller {

	protected $l_delim = '{';
	protected $r_delim = '}';
	protected $editor_type = '360-degree';
	protected $rotate360_path = '';

	function __construct(){
	
		parent::__construct();	
		$this->rotate360_path = $this->config->item('rotate360_path');
	}

	function getEditorType(){
	    return $this->editor_type;
	}
	
	function getEditorPath(){
		 return $this->rotate360_path;
	}
	
    function getViewName(){
		return "rotate360_view";
	}
	
	function _getAllUsersFiles($settings){
		$settingArray = json_decode($settings, true);
		$rFiles =  explode(";",$settingArray['rFileName']);
		array_push($rFiles, $settingArray['bFileName']);
		if($settingArray['lFileName']){
			array_push($rFiles, $settingArray['lFileName']);
		}
        return $rFiles;
	}
	
	function _getNewFileName($oldName, $new_pre){
		$parts = explode("_",$oldName);
		$parts[0] =  $new_pre;
		return join("_",$parts);
		//$suffix = $this->_get_extension($oldName);
		//return $new_pre.$suffix;
	}
	
	function initWithSettings(&$settingsArray, $from, $to){
		$pre = $this->pageid;
	    //$time = time();
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
		$this->_checkPath($to);		
		
		$bFile = $settingsArray['bFileName'];
		$new_bFile = $this->_getNewFileName($bFile , $pre);
		copy($from.$bFile, $to.$new_bFile);
		$settingsArray['bFileName'] = $new_bFile;	
		
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
		$lFile = $settingsArray['lFileName'];
		if($lFile){
			$new_lFile = $this->_getNewFileName($lFile , $pre);
			copy($from.$lFile, $to.$new_lFile);
			$settingsArray['lFileName'] = $new_lFile;
		}
		
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
        $rFileNames =  explode(";",$settingsArray['rFileName']);
		$new_rFiles = array();
		foreach($rFileNames as $file){
			if($file != ""){
				//list($first,$second) = explode("_",$file);
				//$new_file = $timestamp."_".$second;
				$new_file = $this->_getNewFileName($file, $pre);
				copy($from.$file, $to.$new_file); //$file );				
				array_push($new_rFiles,$new_file);
			}
		}
		$new_rFileNames = join(";",$new_rFiles);
		$settingsArray['rFileName'] = $new_rFileNames;
    }

	public function index(){
		
		die('error');
	}	
	
	
	
	/*public function save111(){	     
	
		$bookid = $this->_post("book_id");
		$pageid = $this->_post("page_id");
		$userid = $this->_post("userid");
		$save_tpl = $this->_post("save_template");
		$rFileNames = explode(";",$this->_post('rFileName'));	
		$bFile = $this->_post("bFileName");
		$user_temp = $this->_post("user_temp");
		$templateid = $this->_post("templateid");
		$template_desc_old = $this->_post("template_desc_old");
		$template_desc = $this->_post("template_desc");
		list($userid,$trackid) = explode("-",$user_temp);
		$rDisplay = $this->_post("rDisplay");
		$lFile = $this->_post("lFileName");
		$this->ownerPath = $this->_post("ownerPath");
		
		$_GET['pid'] = $pageid;
        $INPUT['username'] = $_SESSION['username'];
		$INPUT['password'] = $_SESSION['password'];
		
		global $localization,$includes_path,$modules_path;
	    global $homepage_url, $homepage_path, $main_images; //取得系統參數
		global $ebook, $user_profile; //取得用戶參數	
		include_once($_SERVER['DOCUMENT_ROOT']."/ebook/initial_ebook_editor.inc.php");
		//include_once($_SERVER['DOCUMENT_ROOT']."/ebook2/ebook_function.inc.php");
		//page_html_make_image($pageid);
	    //die();
		
         
	    $html = $this->_parseHTML(false);
	     
		$settings = $this->_parseSettings();
		
		$param = array(
		    'bookid' => $bookid,
			'userid' => $userid,
		    'html' => $html,
			'settings' => $settings,
			'pageid' =>$pageid ,
			'save_tpl' => $save_tpl,
			'templateid' => $templateid,
			'template_desc_old' =>$template_desc_old,
			'template_desc' => $template_desc
		);
	
	    // save to db 
		// 1.settings to ebook_page_editor_settings
        // 2.save html to ebook_page	
		// 3.if save_template="Y"  save template to editor_template
		$data = $this->Rotate360_model->save($param);
		
		if($data['result']){
			// file move
			$path = $this->getOwnerPath();
			//$this->_checkPath($path);

			$path = $path.$bookid."/";
			$check = $this->_checkPath($path);
					
			if($check){
			    // template files
				
			    if($save_tpl == "Y"){
								
				    $templateid= $data['templateid'];
					$tplPath = $this->template_path . $templateid ."/";

					delete_files($tplPath);
					$this->_checkPath($tplPath);
					copy("./temp/".$user_temp."/".$bFile, $tplPath.$bFile);
					if($lFile){
						copy("./temp/".$user_temp."/".$lFile, $tplPath.$lFile);
					}
					foreach($rFileNames as $file){
						if($file != ""){
							copy("./temp/".$user_temp."/".$file, $tplPath.$file);
						}
					}
				}
				
				// copy res to path;
				$from = $this->common_path. $this->rotate360_path;
				$to = $path.$this->rotate360_path;
				$this->_checkPath($to);;
				$map = directory_map($from);
				$this->_copyFiles($map, $from, $to);
				
				
				// if has old files delete
				if($data['old_settings'] != ''){
				    $old_SettingArray = json_decode( $data['old_settings'], true);
					$old_bFile = $old_SettingArray['bFileName'];
					$old_rFileNames =  explode(";",$old_SettingArray['rFileName']);
					$old_lFile = $old_SettingArray['lFileName'];
					if($old_lFile){
						unlink($path.$old_lFile);
					}
					unlink($path.$old_bFile);
					
					foreach($old_rFileNames as $file){
						if($file != "" && file_exists($path.$file))
						{						    
							unlink($path.$file);
						}
					}
				}
				
				// rename temp images;
				rename("./temp/".$user_temp."/".$bFile, $path.$bFile);
				if($lFile){
					rename("./temp/".$user_temp."/".$lFile, $path.$lFile);
				}

				foreach($rFileNames as $file){
					if($file != "" && file_exists("./temp/".$user_temp."/".$file)){
						rename("./temp/".$user_temp."/".$file, $path.$file);
					}
				}
			}
			// set temp_track flag = FALSE by id;
			$data= array('flag' => 'N');
			$where = "id = " .  $this->db->escape($trackid) ; 
			$sql = $this->db->update_string('temp_tracker', $data, $where); 
			$this->db->query($sql);	
						
		    include_once($_SERVER['DOCUMENT_ROOT']."/ebook2/ebook_function.inc.php");
			page_html_make_image($pageid);
			
			$data["flag"] = "1";
			
		}else{
		
		    $data["flag"] = "0";
			
		}
		
		echo $data['flag'];
	}*/
	
	/*public function loadTemplates(){
		return $this->Rotate360_model->loadTemplates();
	}*/
	
	/*public function loadTemplateById(){
	   
	    $id = $this->_post("id");
		
	    $user_temp = $this->_post("user_temp");
		
		$time = time();
		$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
		
	    $data = $this->Rotate360_model->loadTemplateById($id);
	    if(count($data) > 0){		   
			// copy to imgages from template to temp/subdir
			$settingsArray =json_decode( $data['settings'], true);
			
			$bFile = $settingsArray['bFileName'];
			$bFile_pre = $this->_get_extension($bFile);
			$new_bFile = $timestamp. $bFile_pre ;	
			
			$rFileNames =  explode(";",$settingsArray['rFileName']);
			$path = $this->template_path.$id."/";
			$new_rFileNames = "";
			
			$lFile = $settingsArray['lFileName'];
			if($lFile){
				$lFile_pre = $this->_get_extension($lFile);
				$new_lFile = $timestamp. $lFile_pre ;
				copy($path.$lFile, "./temp/".$user_temp."/".$new_lFile);
				$settingsArray['lFileName'] = $new_lFile;
		    }
			
			// rename temp images;
			copy($path.$bFile, "./temp/".$user_temp."/".$new_bFile);
			//print_r( $rFileNames);
			foreach($rFileNames as $file){
				if($file != ""){
				    list($first,$second) = explode("_",$file);
					$new_file = $timestamp."_".$second;
					copy($path.$file, "./temp/".$user_temp."/".$new_file );
					$new_rFileNames = $new_rFileNames.$new_file . ";";
				}
			}
			
			$settingsArray['bFileName'] = $new_bFile;
			$settingsArray['rFileName'] = $new_rFileNames;
			$data['settings'] = $settingsArray;
			$json_string = json_encode($data);
			echo $json_string;
		}else{
		    echo "{}";
		}
	}*/
	
	function _parseSettings(){
	    $l_file ='';
		$l_left = '';
		$l_top = '';   
		$rDisplay = $this->_post('rDisplay');
		if($rDisplay){
			$l_file = $this->_post("lFileName");
			$l_left = $this->_post('lPX');
			$l_top = $this->_post('lPY');
		}
	    $data = array(		   
			'bFileName'    => $this->_post("bFileName"),
			//'bSize'        => $this->_post("bSize"),
			'bOrientation' => $this->_post("bOrientation"),
			'bWidth'       => $this->_post("bWidth"),
			'bHeight'      => $this->_post("bHeight"),

			'rFileName'    => $this->_post('rFileName'),
			'rOrientation' => $this->_post("rOrientation"),
			'rNumber'      => $this->_post("rNumber"),		   
			'rPX'          => $this->_post("rPX"),
			'rPY'          => $this->_post("rPY"),
			'rWidth'       => $this->_post("rWidth"),
			'rHeight'      => $this->_post("rHeight"),
			'noticeColor'  => $this->_post("noticeColor"),
			
			'rDisplay'     => $rDisplay,
			'lFileName'    => $l_file,
			'lPX'          => $l_left,
			'lPY'          => $l_top
		);
	    return json_encode($data);
	}
	
	function _parseHTML($forPreview = true){
		
		$this->load->driver('plenty_parser');
	    $tpl = 'smarty/rotate360';	   
	
	    $res_path = $this->common_path. $this->rotate360_path;
	
	    //$string = read_file($res_path.'rotate360.tpl');
		list($rFileName) = explode(";",$this->_post('rFileName'));
        $rFileType = $this->_get_extension($rFileName);		
		$parts = explode("_",$rFileName);
		$parts = array_slice($parts,0,count($parts) -1);
		$prefix = join("_", $parts);
		$bOrientation = $this->_post("bOrientation");
		$rOrientation = $this->_post("rOrientation");
		//$bHorizontal = $bOrientation === "h";
		$rHorizontal = $rOrientation === "0";
		$rNumber = "[". ($rHorizontal ? $this->_post("rNumber") . ",1" : "1," .  $this->_post("rNumber") ) . "]";
		$rInvert = $rHorizontal ? "[true,false]" : "[false,true]";
		$bWidth = $this->_post("bWidth");
		$bHeight = $this->_post("bHeight");
		//$bSize =  $this->_post("bSize");
		//$bWidth = $bHorizontal ? $this->sizeArray[$bSize+0][0]: $this->sizeArray[$bSize+0][1];
		//$bHeight = $bHorizontal ? $this->sizeArray[$bSize+0][1]: $this->sizeArray[$bSize+0][0];
		$bFile = $this->_post("bFileName");
		$rLeft = $this->_post("rPX");
		$rTop = $this->_post("rPY");
		$rWidth = $this->_post("rWidth");
		$rHeight = $this->_post("rHeight");
		$user_temp = $this->_post('user_temp');
		list($color_r, $color_g, $color_b) =  explode(",",$this->_post("noticeColor"));
		$l_file ='';
		$l_left = 0;
		$l_top = 0;   
		$rDisplay = $this->_post('rDisplay');
		if($rDisplay){
			$l_file = $this->_post("lFileName");
			$l_left = $this->_post('lPX');
			$l_top = $this->_post('lPY');
		}
		
	    $rotate360_dir   = $forPreview ?  base_url()."..".$this->library_path.$this->rotate360_path
	                              : "../../../..".$this->library_path.$this->rotate360_path ;
	   
	    $res_dir     = $forPreview ? base_url(). "temp/" . $user_temp . '/' : '' ;

		$data = array(
            'temp_dictionary' =>  $rotate360_dir ,
			                     //$forPreview ? base_url().'res/common/rotate360/': $this->rotate360_path,
            'r_file' => $forPreview ? $res_dir . $prefix . "_##" . $rFileType : $prefix . "_##" . $rFileType ,
			'r_number' => $rNumber,
			'r_invert' => $rInvert,
			'r_infiniteAxis' => $rInvert,
			'r_mobileTotalFrames' => $rNumber,
			'b_width'  => $bWidth,
			'b_height' => $bHeight,
			'b_File'   => $forPreview ?  $res_dir . $bFile : $bFile,
			'r_top'    => $rTop,
			'r_left'   => $rLeft,
			'r_width'  => $rWidth,
			'r_height' => $rHeight,
			'icon_r'   => $color_r,
			'icon_g'   => $color_g,
			'icon_b'   => $color_b,
			'r_display' => $rDisplay,
			'l_file'   => $forPreview ? $res_dir . $l_file : $l_file,
			'l_left'   => $l_left,
			'l_top'    => $l_top,
			'forPreview' => $forPreview,			
        );

		//$value = $this->_parse($string, $data , TRUE);
		
		//return $value;
	    return $this->plenty_parser->parse($tpl,$data,true);
	}
	
	function _parse($template, $data, $return = FALSE){
	
		if ($template == ''){
			return FALSE;
		}
		
		foreach ($data as $key => $val){
		
			$template = $this->_parse_single($key, (string)$val, $template);
		}

		if ($return == FALSE){
		
			$CI =& get_instance();
			$CI->output->append_output($template);
		}

		return $template;
	}
	
	function _parse_single($key, $val, $string){
		return str_replace($this->l_delim.$key.$this->r_delim, $val, $string);
	}
}
