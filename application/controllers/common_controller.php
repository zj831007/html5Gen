<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_controller extends CI_Controller {
	protected $datestring = "%Y%m%d%h%i%s";
	function __construct(){
	
		parent::__construct();
		$this->load->helper(array('date', 'string'));
		$this->load->library('upload');
	}

	/**
	 * old method for slider 
	 */
	public function uploadSingleImage($user_temp='', $file=''){		
		if(!$user_temp) $user_temp = $this->input->post("user_temp");
		if(!$file) $file =  $this->input->post("file");
		
		$time = time();
		$newFileName = mdate($this->datestring, $time).random_string('numeric',4) ;
        $config['file_name'] = $newFileName ;
		
		$config['upload_path'] = './temp/'.$user_temp;
		$config['allowed_types'] = 'gif|jpg|png';
		
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload($file))
		{
            echo  $this->upload->display_errors();
		} 
		else
		{
			$data = array('upload_data' => $this->upload->data());
            echo $data["upload_data"]["file_name"];
		}
	}
	
	// for visual_editor
	public function uploadSinglePic($user_temp='', $file='', $prefix=''){
				
		if(!$user_temp) $user_temp = $this->input->post("user_temp");
		if(!$file)      $file      = $this->input->post("file");
		if(!$prefix)    $prefix    = $this->input->post("prefix");
		
		$time = time();
		$newFileName = mdate($this->datestring, $time).random_string('numeric',4) ;
        $config['file_name'] = $prefix.$newFileName ;
		
		$config['upload_path'] = './temp/'.$user_temp;
		$config['allowed_types'] = 'gif|jpg|png';
		
		$this->_doUpload($config, $file);
	}
	
	public function uploadAudio($user_temp='', $file='', $prefix=''){
		
		if(!$user_temp) $user_temp = $this->input->post("user_temp");
		if(!$file)      $file      = $this->input->post("file");
		if(!$prefix)    $prefix    = $this->input->post("prefix");
		
		$time = time();
		$newFileName = mdate($this->datestring, $time).random_string('numeric',4) ;
        $config['file_name'] = $prefix.$newFileName ;
		
		$config['upload_path'] = './temp/'.$user_temp;
		$config['allowed_types'] = 'mp3|m4a';
		
		$this->_doUpload($config, $file);
	}
	
	public function uploadVideo($user_temp='', $file='', $prefix=''){
		
		if(!$user_temp) $user_temp = $this->input->post("user_temp");
		if(!$file)      $file      = $this->input->post("file");
		if(!$prefix)    $prefix    = $this->input->post("prefix");

		$time = time();
		$newFileName = mdate($this->datestring, $time).random_string('numeric',4) ;
        $config['file_name'] = $prefix.$newFileName ;
		
		$config['upload_path'] = './temp/'.$user_temp;
		$config['allowed_types'] = 'mp4|m4v';		
		$this->_doUpload($config, $file);
	}
	
	function _doUpload($config, $file){
	    $this->upload->initialize($config);
        $result = array();
		if ( ! $this->upload->do_upload($file))
		{
			$result['flag'] ="error";
			$result['msg'] =$this->upload->display_errors('','');
		} 
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$result["flag"] = "success";
			$result['filename'] = $data["upload_data"]["file_name"];
			$result['title'] = $data["upload_data"]['client_name'];
			$result['width'] = $data["upload_data"]['image_width'];
			$result['height'] = $data["upload_data"]['image_height'];
		}
		echo json_encode($result);
	}

}
