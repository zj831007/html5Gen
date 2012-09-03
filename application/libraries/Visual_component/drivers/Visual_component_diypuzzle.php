<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visual_component_diypuzzle extends CI_Driver {

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
       
        $tpl = "smarty/cmp_diypuzzle";
        $data = array(
            'id' => $value["id"],
            'x' => $value["x"],
            'y' => $value["y"],
            'res_dir' => $this->res_dir,
            'library_dir'=>$this->library_dir,
            'width' => $value["width"],
            'height' => $value["height"],
            'bgpic' => $value["bgpic"],
            'rightAudio' => $value["rightAudio"],
            'rightImg' => $value["rightImg"],
            'rightText' => $value["rightText"],
            'rightEffect' => $value["rightEffect"],
            'finishImg' => $value["finishImg"],
            'finishAudio' => $value["finishAudio"],
            'finishText' => $value["finishText"],
            'finishEffect' => $value["finishEffect"],
            'fontStyle' => $value["fontStyle"],
            'fontColor' => $value["fontColor"],
            'fontSize' => $value["fontSize"],
            'blockDis' => $value["blockDis"],
            'timeLimit' => $value["timeLimit"],
            'scoreShow' => $value["scoreShow"],
            'retestShow' => $value["retestShow"],
            'succAction' => $value["succAction"],
            'succActionPage' => $value["succActionPage"],
            'inEffect' => $value["inEffect"],
            'outEffect' => $value["outEffect"],
            'useEffect' => $value["useEffect"],
            'timeRestart' => $value["timeRestart"],
            'jumpText' => $value["jumpText"],
            'points' => json_encode($value["points"]),
			'zIndex'  => $value['zIndex'],
        );
        $args = array($tpl, $data);
        return $this->__call("parse", $args);
    }

    public function getAllUsersFiles($array) {
        //取得所有资源
        $userFiles = array();
        if($array['bgpic']){
            $userFiles[$array['bgpic']]=$array['bgpic'];
        }
        
        if($array['rightAudio']){
            $userFiles[$array['rightAudio']]=$array['rightAudio'];
        }
        if($array['rightImg']){
            $userFiles[$array['rightImg']]=$array['rightImg'];
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