<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visual_component_qa extends CI_Driver {

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
       
        $tpl = "smarty/cmp_qa";
        $data = array(
            'id' => $value["id"],
            'x' => $value["x"],
            'y' => $value["y"],
            'res_dir' => $this->res_dir,
            'library_dir'=>$this->library_dir,
            'width' => $value["width"],
            'height' => $value["height"],
            'bgPic' => $value["bgPic"],
            'bgColor' => $value["bgColor"],
            'flipPage' => $value["flipPage"],
            'scoreType' => $value["scoreType"],
            'rightEvent' => $value["rightEvent"],
            'rightAudio' => $value["rightAudio"],
            'rightPic' => $value["rightPic"],
            'errorAudio' => $value["errorAudio"],
            'errorPic' => $value["errorPic"],
            'finishAudio' => $value["finishAudio"],
            'confirmPic' => $value["confirmPic"],
            'finishAction' => $value["finishAction"],
            'jumpPage' => $value["jumpPage"],
            'jumpText' => $value["jumpText"],
            'topics' => json_encode($value["topics"]),
	    'zIndex'  => $value['zIndex'],
        );

        $args = array($tpl, $data);
        return $this->__call("parse", $args);
    }

    public function getAllUsersFiles($array) {
        //取得所有资源
        $userFiles = array();
        
        if($array["bgPic"]){
            $userFiles[$array["bgPic"]]=$array["bgPic"];
        }
        if($array["rightAudio"]){
            $userFiles[$array["rightAudio"]]=$array["rightAudio"];
        }
        if($array["rightPic"]){
            $userFiles[$array["rightPic"]]=$array["rightPic"];
        }
        if($array["errorAudio"]){
            $userFiles[$array["errorAudio"]]=$array["errorAudio"];
        }
        if($array["errorPic"]){
            $userFiles[$array["errorPic"]]=$array["errorPic"];
        }
        if($array["finishAudio"]){
            $userFiles[$array["finishAudio"]]=$array["finishAudio"];
        }
        if($array["confirmPic"]){
            $userFiles[$array["confirmPic"]]=$array["confirmPic"];
        }
        
        if(is_array($array["topics"])){
            foreach ($array["topics"] as $topic) {
                if($topic["pic"]){
                    $userFiles[$topic["pic"]]=$topic["pic"];
                }
                if(is_array($topic["options"])){
                    foreach($topic["options"] as $option){
                        if($option["pic"]){
                            $userFiles[$option["pic"]]=$option["pic"];
                        }
                    }
                }
            }
        }
        
        return $userFiles;
    }
	
	public function getLibrary(){
	    return array();
	}

}