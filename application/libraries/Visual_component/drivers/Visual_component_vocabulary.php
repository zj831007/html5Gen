<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visual_component_vocabulary extends CI_Driver {
	
	protected $KEY_ID = "id";
	
 	 
	protected $user_temp ;
	protected $public_dir;
	protected $res_dir;
    protected $library_dir;

	public function __construct(){
	}
	
	public function parseHTML($value, $param){
		
		$this->user_temp = $param['user_temp'];
		$this->public_dir = $param['public_dir'];
		$this->res_dir = $param['res_dir'];
        $this->library_dir = $param['library_dir'];
		$tpl = "smarty/cmp_vocabulary.php";

		$data = array(
	        'id'        => $value[$this->KEY_ID],
			'res_dir'   => $this->res_dir,
            'library_dir'=>$this->library_dir,
            'x' => $value["x"],
            'y' => $value["y"],
            'width' => $value["width"],
            'height' => $value["height"],
            'zIndex'  => $value['zIndex'],
            "json"=>json_encode($value)
		);
		
		$args = array($tpl , $data);
		return $this->__call("parse", $args);
	}
	
	public function getAllUsersFiles($array){

		$data = array();
 	    if($array['rightAudio']) $data[$array['rightAudio']] = $array['rightAudio']; //答对音效
 	    if($array['finishAudio']) $data[$array['finishAudio']] = $array['finishAudio'];//完成音效
  	    if($array['errorAudio']) $data[$array['errorAudio']] = $array['errorAudio'];//答错音效
 	    if($array['backIcon']['pic1']) $data[$array['backIcon']['pic1']] = $array['backIcon']['pic1'];//返回按钮
 	    if($array['backIcon']['pic2']) $data[$array['backIcon']['pic2']] = $array['backIcon']['pic2'];//返回按钮
 	    if($array['particle']['img']) $data[$array['particle']['img']] = $array['particle']['img'];//粒子图片
 	    $_start = $array['startScene'];
	    if($_start['loadingPic']) $data[$_start['loadingPic']] = $_start['loadingPic'];
	    if($_start['bgPic']) $data[$_start['bgPic']] = $_start['bgPic'];
	    if($_start['bgSound']) $data[$_start['bgSound']] = $_start['bgSound'];
	    if($_start['bgSoundIcon']['pic1']) $data[$_start['bgSoundIcon']['pic1']] = $_start['bgSoundIcon']['pic1'];
	    if($_start['bgSoundIcon']['pic2']) $data[$_start['bgSoundIcon']['pic2']] = $_start['bgSoundIcon']['pic2'];
	    if($_start['startIcon']['pic1']) $data[$_start['startIcon']['pic1']] = $_start['startIcon']['pic1'];
	    if($_start['startIcon']['pic2']) $data[$_start['startIcon']['pic2']] = $_start['startIcon']['pic2'];
	    if($_start['continueIcon']['pic1']) $data[$_start['continueIcon']['pic1']] = $_start['continueIcon']['pic1'];
	    if($_start['continueIcon']['pic2']) $data[$_start['continueIcon']['pic2']] = $_start['continueIcon']['pic2'];
	    if($_start['scoreIcon']['pic1']) $data[$_start['scoreIcon']['pic1']] = $_start['scoreIcon']['pic1'];
	    if($_start['scoreIcon']['pic2']) $data[$_start['scoreIcon']['pic2']] = $_start['scoreIcon']['pic2'];
	    
	    $_succ = $array['succScene'];
	    if($_succ['bgPic']) $data[$_succ['bgPic']] = $_succ['bgPic'];
	    if($_succ['tryAgainIcon']['pic1']) $data[$_succ['tryAgainIcon']['pic1']] = $_succ['tryAgainIcon']['pic1'];
	    if($_succ['tryAgainIcon']['pic2']) $data[$_succ['tryAgainIcon']['pic2']] = $_succ['tryAgainIcon']['pic2'];
	    if($_succ['scoreIcon']['pic1']) $data[$_succ['scoreIcon']['pic1']] = $_succ['scoreIcon']['pic1'];
	    if($_succ['scoreIcon']['pic2']) $data[$_succ['scoreIcon']['pic2']] = $_succ['scoreIcon']['pic2'];
	    
	    $_fail = $array['failScene'];
	    if($_fail['bgPic']) $data[$_fail['bgPic']] = $_fail['bgPic'];
	    if($_fail['tryAgainIcon']['pic1']) $data[$_fail['tryAgainIcon']['pic1']] = $_fail['tryAgainIcon']['pic1'];
	    if($_fail['tryAgainIcon']['pic2']) $data[$_fail['tryAgainIcon']['pic2']] = $_fail['tryAgainIcon']['pic2'];
	    if($_fail['scoreIcon']['pic1']) $data[$_fail['scoreIcon']['pic1']] = $_fail['scoreIcon']['pic1'];
	    if($_fail['scoreIcon']['pic2']) $data[$_fail['scoreIcon']['pic2']] = $_fail['scoreIcon']['pic2'];
	    
	    $_score = $array['scoreScene'];
	    if($_score['bgPic']) $data[$_score['bgPic']] = $_score['bgPic'];
	    
	    $_levels = $array['levelScenes'];
	    foreach ($_levels as $_level){
	    	if($_level['bgPic']) $data[$_level['bgPic']] = $_level['bgPic'];
	    	if($_level['bgSound']) $data[$_level['bgSound']] = $_level['bgSound'];
	    	if($_level['readyGoIcon']['pic1']) $data[$_level['readyGoIcon']['pic1']] = $_level['readyGoIcon']['pic1'];
	    	if($_level['readyGoIcon']['pic2']) $data[$_level['readyGoIcon']['pic2']] = $_level['readyGoIcon']['pic2'];
	    	$_gameContent = $_level['gameContent'];
	    	if($_gameContent){
	    		foreach($_gameContent as $_content){
	    			if($_content['question']) $data[$_content['question']] = $_content['question'];
	    			if($_content['answer']) $data[$_content['answer']] = $_content['answer'];
	    			if($_content['audio']) $data[$_content['audio']] = $_content['audio'];
	    		}
	    	}
	    }
	    
	    $_menu =  $array['menuScene'];
	    if($_menu){
	    	if($_menu['bgPic']) $data[$_menu['bgPic']] = $_menu['bgPic'];
	    	if($_menu['menu']['modeMenu']['callengeIcon']['pic1'])
	    		$data[$_menu['menu']['modeMenu']['callengeIcon']['pic1']] = $_menu['menu']['modeMenu']['callengeIcon']['pic1'];
	    	if($_menu['menu']['modeMenu']['callengeIcon']['pic2'])
	    		$data[$_menu['menu']['modeMenu']['callengeIcon']['pic2']] = $_menu['menu']['modeMenu']['callengeIcon']['pic2'];
	    	if($_menu['menu']['modeMenu']['menuPic']['pic1'])
	    		$data[$_menu['menu']['modeMenu']['menuPic']['pic1']] = $_menu['menu']['modeMenu']['menuPic']['pic1'];
	    	if($_menu['menu']['modeMenu']['practiceIcon']['pic1'])
	    		$data[$_menu['menu']['modeMenu']['practiceIcon']['pic1']] = $_menu['menu']['modeMenu']['practiceIcon']['pic1'];
	    	if($_menu['menu']['modeMenu']['practiceIcon']['pic2'])
	    		$data[$_menu['menu']['modeMenu']['practiceIcon']['pic2']] = $_menu['menu']['modeMenu']['practiceIcon']['pic2'];
	    	
	    	if($_menu['menu']['levelMenu']['menuPic']['pic1'])
	    		$data[$_menu['menu']['levelMenu']['menuPic']['pic1']] = $_menu['menu']['levelMenu']['menuPic']['pic1'];
	    	
	    	$_levelIcons = $_menu['menu']['levelMenu']['levelItems'];
	    	if($_levelIcons){
	    		foreach($_levelIcons as $_icon){
	    			if($_icon['pic1']) $data[$_icon['pic1']] = $_icon['pic1'];
	    			if($_icon['pic2']) $data[$_icon['pic2']] = $_icon['pic2'];
	    		}
	    	}
	    }
	    
		return $data;
	}
	
	public function getLibrary(){
	    return array();
	}
}