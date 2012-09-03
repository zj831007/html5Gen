<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visual_component_spotlight extends CI_Driver {

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
       
        $tpl = "smarty/cmp_spotlight";
        $data = array(
            'zIndex'=>$value["zIndex"],
            'id' => $value["id"],
            'x' => $value["x"],
            'y' => $value["y"],
            'res_dir' => $this->res_dir,
            'library_dir'=>$this->library_dir,
            'width' => $value["width"],
            'height' => $value["height"],
            
            'color' => $value["color"],
            'opacity' => $value["opacity"],
            'weight' => $value["weight"],
            
            'img' => $value["img"],
            'imgEffect' => $value["imgEffect"],
            
            'maskcolor' => $value["maskcolor"],
            'maskopacity' => $value["maskopacity"],
            
            'spotShape' => $value["spotShape"],
            'spotRadius' => $value["spotRadius"],
            'spotWidth' => $value["spotWidth"],
            'spotHeight' => $value["spotHeight"],
            
            'touchAction' => $value["touchAction"],
            'touchAudio' => $value["touchAudio"],
            
            'succAction' => $value["succAction"],
            'succActionPage' => $value["succActionPage"],
            'jumpText' => $value["jumpText"]
        );
        $args = array($tpl, $data);
        return $this->__call("parse", $args);
    }

    public function getAllUsersFiles($array) {
        //取得所有资源
        $userFiles = array();
        if($array['img']){
            $userFiles[$array['img']]=$array['img'];
        }
        
        if($array['touchAudio']){
            $userFiles[$array['touchAudio']]=$array['touchAudio'];
        }
        
        return $userFiles;
    }
	
	public function getLibrary(){
	    return array();
	}

}