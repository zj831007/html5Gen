<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Component_settings_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
	
	function save($param){
		$data = array(
					'page_id'=> $param['pageid'], 
					'type'=> $param['type'],
					'settings' =>$param['settings'], 
					'cmp_id' =>$param['cmpid'], 
					'files'=>$param['files']  
				);
		$sql = $this->db->insert_string("ebook_page_component_settings",$data);
		$this->db->query($sql);	
		$data['result'] = TRUE;
		return $data;
	}	
	
	function loadSettingsByPageId($pageid){
	    $sql = "select * from ebook_page_component_settings where page_id = ? ";
		$data = array($pageid);	
		$query = $this->db->query($sql, $data);
		return $query->result_array();
	}
	
	function deleteSettingsByPageId($pageid){
	    $sql = "delete from ebook_page_component_settings where page_id = ? ";
		$data = array($pageid);	
		$query = $this->db->query($sql, $data);
		return array('result' => TRUE);
	}
}
?>