<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once($_SERVER['DOCUMENT_ROOT'] . "/initial.inc.php");
if (isset($_GET['m']) && ($_GET['m'] == "show" || $_GET['m'] == "show1")) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/ebook/initial_ebook_editor.inc.php");
}

abstract class MY_Controller extends CI_Controller {

    protected $datestring = "%Y%m%d%h%i%s";
    protected $system_path = '';
    protected $except_type = ".tpl";
    //protected $sizeArray = array(array(1024,768),array(854,480),array(1024,600),array(800,600));
    /*protected $sizeArray = array(
        "portrait" => array(768, 1024),
        "landscape" => array(1024, 768),
        "iphone_portrait" => array(640, 960),
        "iphone_landscape" => array(960, 640),
        "a1280x800_portrait" => array(800, 1280),
        "a1280x800_landscape" => array(1280, 800),
        "a1024x600_portrait" => array(600, 1024),
        "a1024x600_landscape" => array(1024, 600),
        "a854x480_portrait" => array(480, 854),
        "a854x480_landscape" => array(854, 480),
    );*/
    protected $template_path = '';
    protected $common_path = '';
    protected $ownerPath = '';
    protected $view_name = '';
    protected $public_path = '';
    protected $library_path = '';
    protected $pageid = '';
    protected $language ;
    
    protected $langsDict = array(
    		    'zh-CHT' => 'cht',
    		    'zh-CHS' => 'chs',
    		    'en-US'  => 'en',
    		    'ja-JP'  => 'ja'
    		);

    function __construct() {

        parent::__construct();

        $this->load->helper(array('form', 'url', 'date', 'string', 'file', 'directory', 'language'));
        $this->load->library('upload');

        $this->system_path = $this->config->item('system_path');
        $this->template_path = $this->config->item('template_path');
        $this->common_path = $this->config->item('common_path');
        $this->public_path = $this->config->item('public_path');
        $this->library_path = $this->config->item('library_path');

        $this->view_name = $this->getViewName();
        $this->load->model('Editor_settings_model');
        $this->load->model('Ebook_page_model');
        $this->load->model('Editor_template_model');
        $this->load->model('Component_settings_model');
        
        $this->language = $_SESSION['language'];
        $this->language = $this->langsDict[$this->language]
        		        ? $this->langsDict[$this->language] 
        		        : 'cht';
        
        $this->config->set_item('language', $this->language);
        $this->lang->load('common');
    }

    protected function getOwnerPath() {
        return $this->ownerPath;
        ;
    }

    abstract function getEditorType();

    abstract function getEditorPath();

    abstract function getViewName();

    abstract function _parseHTML($forPreview = true);

    abstract function _parseSettings();

    abstract function _getAllUsersFiles($settings);

    abstract function initWithSettings(&$settingsArray, $from, $to);

    function initSettings($initArray, $from, $to) {

        $result = array("settings" => array(), "cmp_settings" => array(), "Global" => array());
        if (!$initArray) {
            return $result;
        }

        $editor_settings = $initArray['editor'];
        $componets = $initArray['components'];

        /*$bFile = $editor_settings['bFileName'];
        if ($bFile) {
            copy($from . $bFile, $to . $bFile);
        }
        $bsFile = $editor_settings['bsFileName'];
        if ($bsFile) {
            copy($from . $bsFile, $to . $bsFile);
        }*/

        $cmp_settings = array();
        $sounds = array();
        foreach ($componets as $cmp) {
            $id = "cmp_" . $cmp["cmp_id"];
            $settings = $cmp['settings'];
            $files = '';
            if ($cmp['files'])
                $files = explode(";", $cmp['files']);
            $type = $cmp['type'];
            $cmp_settings[$id] = $settings;
            /*if ($files) $this->_copyFiles($files, $from, $to);*/
            if ($type == "link") { // load Global.sounds		       
                $cmp_array = json_decode($settings, true);
                $linkType = $cmp_array['linkType'];
                if ($linkType == "button" && $cmp_array['lSound']) {
                    $sounds[$cmp_array['lSound']] = $cmp_array['lSound'];
                }
            } else if ($type == "action") {
                $cmp_array = json_decode($settings, true);
                $actionType = $cmp_array['actionType'];
                if ($cmp_array['actSound']) {
                    $sounds[$cmp_array['actSound']] = $cmp_array['actSound'];
                }
            }
        }
        $result['settings'] = $editor_settings;
        $result['cmp_settings'] = $cmp_settings;

        $global = $editor_settings['Global'];

        if ($sounds) {
            $global['sounds'] = $sounds;
        }

        $result['Global'] = $global;

        return $result;
    }

    public function index() {

        die('error');
    }

    public function show($pageid = '') {

        $type = $this->getEditorType();
        if ($type == 'video' || $type == 'motionbox' || $type == 'motionbox2') {
            $this->show1();
            return;
        }

        global $ebook, $user_profile, $page_head, $page_foot;

        if (!$pageid)
            $pageid = $_GET['pid'];

        $orientation = $ebook['orientation'];

        $userid = $user_profile['id'];

        $this->ownerPath = $this->system_path . $user_profile['user_files_path'];

        $data = $this->Editor_settings_model->getInitData($ebook, $userid);

        if ($data) {

            $data['userid'] = $userid;
            $bookid = $data['bookid'];
            //$user_temp =  $data['user_temp'];

            $user_temp = explode("@", $user_profile['username']);

            $user_temp = $userid . "_" . $user_temp[0] . "/" . $bookid . "/" . $pageid;

            // create user temp dir
            delete_files("./temp/" . $user_temp);

            $this->_mkPath("./temp/" . $user_temp);

            $data["user_temp"] = $user_temp;

            if (isset($data['settings'])) {
                //$settingsArray =json_decode( $data['settings'], true);
                $from = $this->ownerPath . $bookid . "/";
                $to = "./temp/" . $user_temp . "/";
                //$this->initWithSettings($settingsArray, $from, $to);
                //$data['settings'] = json_encode($settingsArray);

                $allFiles = $this->_getAllUsersFiles($data['settings']);
                $this->_copyFiles($allFiles, $from, $to);

                $data['isAdd'] = FALSE;
            } else {
                $data['isAdd'] = TRUE;
                $data['settings'] = '{}';
            }
            $data["ownerPath"] = $this->ownerPath;

            $data["bOrientation"] = $orientation;
            //$bg_size = $this->sizeArray[$orientation];
            $data["bWidth"] = $ebook['resolution_x'];//$bg_size[0];
            $data["bHeight"] = $ebook['resolution_y'];//$bg_size[1];

            echo $page_head;
            echo $this->load->view($this->view_name, $data, true);
            echo $page_foot;
        } else {
            die("ebook_page[" . $pageid . "] not found.");
        }
    }

    public function show1($pageid = '') {

        global $ebook, $user_profile, $page_head, $page_foot;

        if (!$pageid)
            $pageid = $_GET['pid'];

        $orientation = $ebook['orientation'];

        $userid = $user_profile['id'];

        $this->ownerPath = $this->system_path . $user_profile['user_files_path'];

        $data = $this->Editor_settings_model->getInitData1($ebook, $userid);

        if ($data) {

            $data['userid'] = $userid;

            $bookid = $data['bookid'];

            $user_temp = explode("@", $user_profile['username']);

            $user_temp = $userid . "_" . $user_temp[0] . "/" . $bookid . "/" . $pageid;

            // create user temp dir
            //delete_files("./temp/" . $user_temp);

            //$this->_mkPath("./temp/" . $user_temp);

            $data["user_temp"] = $user_temp;

            $initArray = array();

            $from = $this->ownerPath . $bookid . "/";

            $to = "./temp/" . $user_temp . "/";

            if (isset($data['settings'])) {

                $editorArray = json_decode($data['settings'], true);

                $cmpArray = $this->Component_settings_model->loadSettingsByPageId($pageid);

                $initArray = array("editor" => $editorArray, "components" => $cmpArray);

                $data['isAdd'] = FALSE;
            } else {

                $data['isAdd'] = TRUE;
            }

            $resultArray = $this->initSettings($initArray, $from, $to);
			
            foreach ($resultArray as $key => $value) {
                $data[$key] = ( json_encode($value) ) ? json_encode($value) : '{}';
            }

            $data["ownerPath"] = $this->ownerPath;

            $data["bOrientation"] = $orientation;
            //$bg_size = $this->sizeArray[$orientation];
            $data["bWidth"] = $ebook['resolution_x'];//$bg_size[0];
            $data["bHeight"] = $ebook['resolution_y'];//$bg_size[1];
			
			$data["user_files_path"]=  $user_profile['user_files_path'];
		
		    $data['language']  = $this->language;
			
            echo $page_head;
            echo $this->load->view($this->view_name, $data, true);
            echo $page_foot;
        } else {
            die("ebook_page[" . $pageid . "] not found.");
        }
    }

    public function preview() {
        $value = $this->_parseHTML(true);
        echo $value;
    }

    public function save() {

        $bookid = $this->_post("book_id");
        $pageid = $this->_post("page_id");
        $userid = $this->_post("userid");

        $save_tpl = $this->_post("save_template");
        $user_temp = $this->_post("user_temp");
        $template_id = $this->_post("template_id");
        $template_desc_old = $this->_post("template_desc_old");
        $template_desc = $this->_post("template_desc");

        //list($userid,$trackid) = explode("-",$user_temp);		
        $this->ownerPath = $this->_post("ownerPath");

        $html = $this->_parseHTML(false);

        $_GET['pid'] = $pageid;
        $INPUT['username'] = $_SESSION['username'];
        $INPUT['password'] = $_SESSION['password'];

        global $localization, $includes_path, $modules_path;
        global $homepage_url, $homepage_path, $main_images; //取得系統參數
        global $ebook, $user_profile; //取得用戶參數	
        require_once($_SERVER['DOCUMENT_ROOT'] . "/ebook/initial_ebook_editor.inc.php");

        $settings = $this->_parseSettings();

        $param = array(
            'bookid' => $bookid,
            'userid' => $userid,
            'editor_type' => $this->getEditorType(),
            'editor' => $this->getEditorType(),
            'html' => $html,
            'settings' => $settings,
            'pageid' => $pageid,
            'save_tpl' => $save_tpl,
            'template_id' => $template_id,
            'template_desc_old' => $template_desc_old,
            'template_desc' => $template_desc
        );
        try {
            $this->db->trans_begin();
            // save to db 
            // 1.settings to ebook_page_editor_settings
            // 2.save html to ebook_page	
            // 3.if save_template="Y"  save template to editor_template

            $data = $this->Editor_settings_model->save($param);
            $this->_handleData($data);
            $old_settings = $data['old_settings'];

            $data = $this->Ebook_page_model->save($param);
            $this->_handleData($data);

            $data = $this->Editor_template_model->save($param);
            $this->_handleData($data);
            $template_id = $data['template_id'];


            $user_book_path = $this->getOwnerPath() . $bookid . "/";
            $check = $this->_checkPath($user_book_path);

            if (!$check) {
                $this->_handleData(array('result', FALSE));
            }

            $allNewFiles = $this->_getAllUsersFiles($settings);
            $temp_user_path = "./temp/" . $user_temp . "/";
            // file move
            // 1. copy user_temp to template  if save_tpl==Y
            if ($save_tpl == "Y") {
                $tplPath = $this->template_path . $template_id . "/";

                delete_files($tplPath);
                $this->_checkPath($tplPath);
                $this->_copyFiles($allNewFiles, $temp_user_path, $tplPath);
            }

            $editor_path = $this->getEditorPath();
            // 2. copy res to user_files[public, editor]
            /* $res_public_from = $this->common_path . $this->public_path;		
              $res_public_to   = $user_book_path . $this->public_path;

              $this->_checkPath($res_public_to);;
              $map = directory_map($res_public_from);
              $this->_copyFiles($map, $res_public_from, $res_public_to);

              $res_editor_from = $this->common_path . $editor_path;
              $res_editor_to   = $user_book_path . $editor_path;

              $this->_checkPath($res_editor_to);;
              $map = directory_map($res_editor_from);
              $this->_copyFiles($map, $res_editor_from, $res_editor_to); */

            // 3. delete old files if existed in user_files
            if ($old_settings != '') {
                $oldFiles = $this->_getAllUsersFiles($old_settings);
                foreach ($oldFiles as $file) {
                    if ($file != "" && file_exists($user_book_path . $file)) {
                        unlink($user_book_path . $file);
                    }
                }
            }
            // 4. copy user_temp to user_files
            $this->_copyFiles($allNewFiles, $temp_user_path, $user_book_path);

            //// 5. delete user_temp dir
            //delete_files($temp_user_path);
            //// set temp_track flag = FALSE by id;
            //$data= array('flag' => 'N');
            //$where = "id = " .  $this->db->escape($trackid) ; 
            //$sql = $this->db->update_string('temp_tracker', $data, $where); 
            //$this->db->query($sql);	
            // save html to p[pic].html;
            $html_file = $user_book_path . "p" . $pageid . ".html";
            $fh = fopen($html_file, "w");
            fwrite($fh, $html);

            // make preview Image
            require_once($_SERVER['DOCUMENT_ROOT'] . "/ebook/ebook_function.inc.php");
            page_html_make_image($pageid);

            $this->db->trans_commit();

            echo "1";
        } catch (Exception $e) {

		$this->_handleData(array('result'=>FALSE, 'error'=> $e));
	}	
	}
	
	public function loadTemplates(){
		$userid = $this->_post("userid");
		$bookid = $this->_post("bookid");	
		$template =  $this->Editor_template_model->loadTemplates($this->getEditorType(), $bookid, $userid);
		$json_string = json_encode($template); 
		echo $json_string;
	}
	
	public function loadTemplateById(){
	    
	 	$id = $this->_post("id");
		$this->pageid = $this->_post("pageid");	

        $user_temp = $this->_post("user_temp");
        $data = $this->Editor_template_model->loadTemplateById($id);

        if (count($data) > 0) {
            // copy to imgages from template to temp/subdir
            $settingsArray = json_decode($data['settings'], true);
            $from = $this->template_path . $id . "/";
            $to = "./temp/" . $user_temp . "/";
            $this->initWithSettings($settingsArray, $from, $to);

            $data['settings'] = $settingsArray;
            $json_string = json_encode($data);
            echo $json_string;
        } else {
            echo "{}";
        }
    }

    function _handleData($data) {
        if (!$data['result']) {
            $this->db->trans_rollback();
            die("0");
        }
    }

    function _post($key) {
        return $this->input->post($key);
    }

    function _copyFiles($map, $from, $to, $check = false) {

        if (substr($from, -1) != "/")
            $from = $from . "/";
        if (substr($to, -1) != "/")
            $to = $to . "/";
        if (is_array($map)) {
            foreach ($map as $key => $item) {
                if (is_array($item)) {
                    $this->_checkPath($to . $key);
                    $this->_copyFiles($item, $from . $key, $to . $key);
                } else {
                    if ($check) {
                        if ($this->_get_extension($item) != $this->except_type) {
                            copy($from . $item, $to . $item);
                        }
                    } else {
                        if (is_file($from . $item)) {
                            copy($from . $item, $to . $item);
                        }
                    }
                }
            }
        } else {
            copy($from . $map, $to . $map);
        }
    }

    function _checkPath($path) {
        if ($path == '')
            return FALSE;

        if (file_exists($path)) {
            return TRUE;
        } else {
            return mkdir($path);
        }
    }

    function _mkPath($path) {
        $parsePath = explode("/", $path);
        $newPath = "";
        foreach ($parsePath as $dir) {
            $newPath .= $dir;
            if ("" != $newPath && ".." != $newPath && "." != $newPath && !is_dir($newPath)) {
                if (false == @ mkdir($newPath)) {
                    return false;
                }
            }
            $newPath .= "/";
        }
        return true;
    }

    function _get_extension($filename) {
        $x = explode('.', $filename);
        return '.' . end($x);
    }

    function _doParseHTML($forPreview = true) {
        $global = $this->_post("global");
        //$global = stripslashes($global);
        $bookid = $this->_post("book_id");
        $pageid = $this->_post("page_id");
		$user_res_path = $this->_post("user_res_path");
		
        $global = json_decode($global, true);

        $this->load->driver('plenty_parser');
        $html = '';
        $tpl_header = 'smarty/header';
        $tpl_footer = 'smarty/footer';
        $user_temp = $this->_post('user_temp');

        //echo base_url()."..".$this->library_path.$this->public_path."<br>";
        //$public_dir   = $forPreview ? base_url().$this->common_path.$this->public_path : $this->public_path ;
        $public_dir = $forPreview ? base_url() . ".." . $this->library_path . $this->public_path
		                          : substr($this->library_path,1) . $this->public_path;
               
        $library_dir = $forPreview ? base_url() . ".." . $this->library_path : substr($this->library_path,1);
		
		//$res_dir = $forPreview ? base_url() . "temp/" . $user_temp . '/' : '';
		
		$res_dir = $forPreview ? base_url() .$user_res_path : 'resource/';
       
        $b_orientation = $this->_post("bOrientation");
        $b_file = $this->_post("bFileName");
        //$b_size       = $this->_post("bSize");
        $b_color = $this->_post("bColor");
		$h_color = $this->_post("hColor");
        $b_width = $this->_post("bWidth");
        $b_height = $this->_post("bHeight");
        $b_pageWidth = $this->_post('bPageWidth');
        $b_pageHeight = $this->_post('bPageHeight');
        $b_pageScale = $this->_post('bPageScale');

        //$b_width      = $b_orientation === "h" ? $this->sizeArray[$b_size+0][0]: $this->sizeArray[$b_size+0][1];
        //$b_height     = $b_orientation === "h" ? $this->sizeArray[$b_size+0][1]: $this->sizeArray[$b_size+0][0];
        $bs_file = $this->_post("bsFileName");
        $bs_loop = $this->_post("bsLoop");
        $b_loadAction = $this->_post("bLoadAction");
        $b_unLoadAction = $this->_post("bUnLoadAction");

        $data = array(
            'public_dir' => $public_dir,
            'res_dir' => $res_dir,
			'library_dir'=>$library_dir,
            'b_orientation' => $b_orientation,
            'b_file' => $b_file,
            'b_width' => $b_width,
            'b_height' => $b_height,
            'b_color' => $b_color,
			'h_color' => $h_color,
            'bs_file' => $bs_file,
            'bs_loop' => ($bs_loop == "true") ? 'loop="loop"' : '',
            'b_loadAction' => $b_loadAction,
            'b_unLoadAction' => $b_unLoadAction,
            'forPreview' => $forPreview,
        	'b_pageWidth' => $b_pageWidth,
        	'b_pageHeight'=> $b_pageHeight,
        	'b_pageScale' => $b_pageScale,
        );

        $param = array(
            'user_temp' => $user_temp,
            'public_dir' => $public_dir,
            'res_dir' => $res_dir,
            'library_dir'=>$library_dir,
			'book_id' => $bookid,
			'page_id' => $pageid,
			'b_width' => $b_width,
            'b_height' => $b_height,
        	'b_pageWidth' => $b_pageWidth,
        	'b_pageHeight'=> $b_pageHeight,
        );
        $components = $global['components'];

        $this->load->driver("visual_component");
        $comp_html = '';
        $comp_libraries_css = array();
		$comp_libraries_js = array();
        foreach ($components as $key => $value) {
            foreach ($value as $id => $title) {
                $comp = $this->_post("cmp_" . $id);
                //$array = stripslashes($comp);
                $array = $comp;
                $array = json_decode($array, true);

                $comp_html = $comp_html . $this->visual_component->parseHTML($key, $array, $param) . '';
				$libs = $this->visual_component->getLibrary($key);
				if(libs) {
				    if($libs['css'] && count($libs['css']) && (!$comp_libraries_css[$key])){
						 $comp_libraries_css[$key] = $libs['css'];
					}
					if($libs['js'] && count($libs['js']) && (!$comp_libraries_js[$key])){
					     $comp_libraries_js[$key] = $libs['js'];
					}					
				}
            }
        }
		//print_r($comp_libraries_css);
		//echo '<br/>';
		//print_r($comp_libraries_js);
	    $data['css'] = $comp_libraries_css;
		$data['js']  = $comp_libraries_js;
		
		$html = $this->plenty_parser->parse($tpl_header, $data, true);

        $html = $html . $comp_html;

        $html = $html . $this->plenty_parser->parse($tpl_footer, array(), true);
		
        return $html;
    }

    function _doSave() {
        $global = $this->_post("global");
        //$global = stripslashes($global);
        $global = json_decode($global, true);

        $bookid = $this->_post("book_id");
        $pageid = $this->_post("page_id");
        $userid = $this->_post("userid");
        $user_temp = $this->_post("user_temp");

        // TODO for save teamplate
        //$save_tpl = $this->_post("save_template");		
        //$template_id = $this->_post("template_id");
        //$template_desc_old = $this->_post("template_desc_old");
        //$template_desc = $this->_post("template_desc");
        //list($userid,$trackid) = explode("-",$user_temp);
        $this->ownerPath = $this->_post("ownerPath");

        $html = $this->_parseHTML(false);
        $html_preview = $this->_parseHTML(true);

        $_GET['pid'] = $pageid;
        $INPUT['username'] = $_SESSION['username'];
        $INPUT['password'] = $_SESSION['password'];

        global $localization, $includes_path, $modules_path;
        global $homepage_url, $homepage_path, $main_images; //取得系統參數
        global $ebook, $user_profile; //取得用戶參數	
        require_once($_SERVER['DOCUMENT_ROOT'] . "/ebook/initial_ebook_editor.inc.php");

        $settings = $this->_parseSettings(); // visual_editor setting

        $param = array(
            'bookid' => $bookid,
            'userid' => $userid,
            'editor_type' => $this->getEditorType(),
            'editor' => $this->getEditorType(),
            'html' => $html,
            'settings' => $settings,
            'pageid' => $pageid,
                //'save_tpl' => $save_tpl,
                //'template_id' => $template_id,
                //'template_desc_old' =>$template_desc_old,
                //'template_desc' => $template_desc
        );

        try {

            $this->db->trans_begin();

            // 3.if save_template="Y"  save template to editor_template
            // 1.settings to ebook_page_editor_settings
            $data = $this->Editor_settings_model->save($param);
            $this->_handleData($data);
            $old_settings = $data['old_settings'];

            // 2.1 load old components by pageid
            $old_cmp_settings = $this->Component_settings_model->loadSettingsByPageId($pageid);
            $this->Component_settings_model->deleteSettingsByPageId($pageid);

            // 2.2 loop save component settings
            $components = $global['components'];
            $this->load->driver("visual_component");
            $comp_html = '';
            $comp_files = array(); // component user files 

            foreach ($components as $type => $value) {
                foreach ($value as $id => $title) {
                    $comp_settings = $this->_post("cmp_" . $id);
                    //$array = stripslashes($comp_settings);	
                    $array = json_decode($comp_settings, true);
                    $user_files = $this->visual_component->getAllUsersFiles($type, $array);
                    $cmp_param = array(
                        'pageid' => $pageid,
                        'cmpid' => $id,
                        'type' => $type,
                        'settings' => $comp_settings,
                        'files' => implode(";", $user_files),
                    );
                    
                    $comp_files = array_merge($comp_files, $user_files);
                    $data = $this->Component_settings_model->save($cmp_param);
                    $this->_handleData($data);
                }
            }

            // 3.save html to ebook_page	
            $data = $this->Ebook_page_model->save($param);
            $this->_handleData($data);

            //$data = $this->Editor_template_model->save($param);
            //$this->_handleData($data);
            //$template_id = $data['template_id'];	 


            $user_book_path = $this->getOwnerPath() . $bookid . "/";
            $check = $this->_checkPath($user_book_path);

            if (!$check) {
                $this->_handleData(array('result' => FALSE));
            }

            $allNewFiles = $this->_getAllUsersFiles($settings);
            //$temp_user_path = "./temp/" . $user_temp . "/";

            // file copy
            // 1. copy user_temp to template  if save_tpl==Y
            /* if($save_tpl == "Y"){			
              $tplPath = $this->template_path . $template_id ."/";

              delete_files($tplPath);
              $this->_checkPath($tplPath);
              $this->_copyFiles($allNewFiles, $temp_user_path, $tplPath);
              } */

            //$editor_path = $this->getEditorPath();
            // 2. copy res to user_files[public, editor]
            /* $res_public_from = $this->common_path . $this->public_path;		
              $res_public_to   = $user_book_path . $this->public_path;

              $this->_checkPath($res_public_to);;
              $map = directory_map($res_public_from);
              $this->_copyFiles($map, $res_public_from, $res_public_to); */


            // 3. delete old files if existed in user_files
            /*$oldFiles = array();
            if ($old_settings != '') {
                $oldFiles = $this->_getAllUsersFiles($old_settings);

                foreach ($oldFiles as $file) {
                    if ($file != "" && file_exists($user_book_path . $file)) {
                        unlink($user_book_path . $file);
                    }
                }
            }*/

            // 3.1 delete old components files
            /*$oldFiles = $this->_getOldCmpFiles($old_cmp_settings);
            foreach ($oldFiles as $file) {
                if ($file != "" && file_exists($user_book_path . $file)) {
                    unlink($user_book_path . $file);
                }
            }*/

            // 4. copy user_temp to user_files
            //$this->_copyFiles($allNewFiles, $temp_user_path, $user_book_path);

            // 4.1 copy componet file from user_temp to user_files;
            //$comp_files = array_keys($comp_files);
            //$this->_copyFiles($comp_files, $temp_user_path, $user_book_path);

            //5. delete user_temp dir
            //delete_files($temp_user_path);

            /* // set temp_track flag = FALSE by id;
              $data= array('flag' => 'N');
              $where = "id = " .  $this->db->escape($trackid) ;
              $sql = $this->db->update_string('temp_tracker', $data, $where);
              $this->db->query($sql); */

            // save html to p[pic].html;
            $html_file = $user_book_path . "p" . $pageid . ".html";
            $fh = fopen($html_file, "w");
            @fwrite($fh, $html);
            @fclose($fh);
            
            $html_file = $user_book_path . "p" . $pageid . "_preview.html";
            $fh = fopen($html_file, "w");
            @fwrite($fh, $html_preview);
            @fclose($fh);
            
            // make preview Image
            require_once($_SERVER['DOCUMENT_ROOT'] . "/ebook/ebook_function.inc.php");
            page_html_make_image($pageid);

            $this->db->trans_commit();
            echo "1";
        } catch (Exception $e) {
            $this->_handleData(array('result' => FALSE));
        }
    }

    function _getOldCmpFiles($settings) {
        $file = array();
        foreach ($settings as $setting) {
            $file = array_merge($file, explode(";", $setting["files"]));
        }
        return $file;
    }

}

// END MY_Controller Class
 
/* End of file Controller.php */
/* Location: ./application/core/MY_Controller.php */