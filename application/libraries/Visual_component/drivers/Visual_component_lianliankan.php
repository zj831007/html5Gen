<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visual_component_lianliankan extends CI_Driver {

    protected $user_temp;
    protected $public_dir;
    protected $res_dir;
    protected $library_dir;

    public function __construct() {
        
    }
 
    public function parseHTML($value, $param) {

        $this->user_temp = $param['user_temp'];
        $this->public_dir = $param['public_dir'];
        $this->res_dir = $param['res_dir'];
        $this->library_dir = $param['library_dir'];
       
        $tpl = "smarty/cmp_lianliankan";
        $data = array(
            'id' => $value["id"],
            'x' => $value["x"],
            'y' => $value["y"],
            'res_dir' => $this->res_dir,
            'library_dir'=>$this->library_dir,
            'width' => $value["width"],
            'height' => $value["height"],
            'rightAudio' => $value["rightAudio"],
            'rightImg' => $value["rightImg"],
            'errorAudio' => $value["errorAudio"],
            'errorImg' => $value["errorImg"],
            'finishImg' => $value["finishImg"],
            'succAction' => $value["succAction"],
            'succActionPage' => $value["succActionPage"],
            'finishAudio' => $value["finishAudio"],
            'bgpic' => $value["bgpic"],
            'lineColor' => $value["lineColor"],
            'lineWidth'=>$value['lineWidth'],
            'pointWidth' =>$value['pointWidth'],
            'jumpText' =>$value['jumpText'],
            'lines' => json_encode($value["lines"]),
            'points' => json_encode($value["points"]),
			'zIndex'  => $value['zIndex'],
        );
        $args = array($tpl, $data);
        return $this->__call("parse", $args);
    }

    public function getAllUsersFiles($array) {
        //取得所有资源
        $userFiles = array();
        
        if($array['rightAudio']){
            $userFiles[$array['rightAudio']]=$array['rightAudio'];
        }
        if($array['rightImg']){
            $userFiles[$array['rightImg']]=$array['rightImg'];
        }
        if($array['errorAudio']){
            $userFiles[$array['errorAudio']]=$array['errorAudio'];
        }
        if($array['errorImg']){
            $userFiles[$array['errorImg']]=$array['errorImg'];
        }
        if($array['bgpic']){
            $userFiles[$array['bgpic']]=$array['bgpic'];
        }
        if($array['finishImg']){
            $userFiles[$array['finishImg']]=$array['finishImg'];
        }
        if($array['finishAudio']){
            $userFiles[$array['finishAudio']]=$array['finishAudio'];
        }
        //完成音效
        $points = $array['points'];
        if(is_array($points)){
            foreach ($points as $point) {
                if($point["type"] == "image"){
                    $src =  $point["src"];
                    $userFiles[basename($src)] =  basename($src);
                }
                
            }
        }
        
        return $userFiles;
    }
	
	public function getLibrary(){
	    return array();
	}

}