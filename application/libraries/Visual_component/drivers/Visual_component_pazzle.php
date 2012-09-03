<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visual_component_pazzle extends CI_Driver {

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
       
        $tpl = "smarty/cmp_pazzle";
        $data = array(
            'id' => $value["id"],
            'x' => $value["x"],
            'y' => $value["y"],
            'res_dir' => $this->res_dir,
            'library_dir'=>$this->library_dir,
            'row' => $value["row"],
            'col' => $value["col"],
            'width' => $value["width"],
            'height' => $value["height"],
            'pazzlePics' => $value["pazzlePics"],
            'rewardPics' => $value["rewardPics"],
            'audios' => $value["audios"],
            'succAudios' => $value["succAudios"],
            'succAction' => $value["succAction"],
            'succActionPage'=>$value['succActionPage'],
            'jumpText'=>$value['jumpText'],
			'zIndex'  => $value['zIndex'],
        );
        $args = array($tpl, $data);
        return $this->__call("parse", $args);
    }

    public function getAllUsersFiles($array) {
        //取得所有资源
        $userFiles = array();
        //拼图图片
        $pazzlePics = $array['pazzlePics'];
        if(is_array($pazzlePics)){
            foreach ($pazzlePics as $fname) {
                $userFiles[$fname] = $fname;
            }
        }
        //奖励图片
        $pazzlePics = $array['rewardPics'];
        if(is_array($pazzlePics)){
            foreach ($pazzlePics as $fname) {
                $userFiles[$fname] = $fname;
            }
        }
        //移动音效
        $audios = $array['audios'];
        if(is_array($audios)){
            foreach ($audios as $fname) {
                $userFiles[$fname] = $fname;
            }
        }
        //完成音效
        $succAudios = $array['succAudios'];
        if(is_array($succAudios)){
            foreach ($succAudios as $fname) {
                $userFiles[$fname] = $fname;
            }
        }
        
        return $userFiles;
    }
	
	public function getLibrary(){
	    return array();
	}

}