<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor_settings_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
	
	function getInitData1($ebook){
		$pageid = $ebook['page']['id'];
		$bookname= $ebook['name'];
		$bookid = $ebook['id'];

		$data = array();	
		if($ebook){

		    $data = array(
				'pageid' => $pageid,
				'bookname' => $bookname,
				'bookid'   => $bookid
		    );		
		
			$sql = "select * from ebook_page_editor_settings where page_id = ?";
			$query = $this->db->query($sql, array($pageid));
			
			if ($query->num_rows() > 0){
			   $row = $query->row(); 
			   $data['settings'] = $row->settings;
			}
        }

		return $data;	
	}
	
	function getInitData($ebook ,$userid){
	
	    $pageid = $ebook['page']['id'];
		$bookname= $ebook['name'];
		$bookid = $ebook['id'];

		$data = array();	
		if($ebook){

		    $data = array(
				'pageid' => $pageid,
				'bookname' => $bookname,
				'bookid'   => $bookid
		    );		
		
			$sql = "select * from ebook_page_editor_settings where page_id = ?";
			$query = $this->db->query($sql, array($pageid));
			
			if ($query->num_rows() > 0){
			   $row = $query->row(); 
			   $data['settings'] = $row->settings;
			}
			
			/*
			$insert = array(
				   'page_id' =>  $data['pageid'] ,
				   'user_id' => $userid ,
				   'flag' => 'Y'
			);

			$this->db->insert('temp_tracker', $insert);
			$data['user_temp'] = $userid.'-'.mysql_insert_id();
			*/
        }

		return $data;		
    }
	
	function save($param){
	
		$settings = $param['settings'];
		$pageid = $param['pageid'];
		$bookid = $param['bookid'];
		$userid = $param['userid'];
		$editor_type = $param['editor_type'];
		$old_settings = '';

		// 1. get old_settings if the record existed in DB
		// 2. insert/update settings to [ebook_page_editor_settings]
		$sql = "select * from ebook_page_editor_settings where page_id=?";
		$query = $this->db->query($sql,array($pageid));
		if($query->num_rows() > 0){
		
		    $row = $query->row();
			$old_settings = $row->settings;
			
		    $data = array('settings' => $settings, 'update_user_no' => $userid);
		    $where = "page_id= ".$this->db->escape($pageid) ; 		
		    $sql = $this->db->update_string("ebook_page_editor_settings", $data, $where);
		}else{
		    $data = array('page_id'=>$pageid, 
			              'editor_type'=> $editor_type, 
						  'settings' =>$settings, 
						  'create_user_no' => $userid,
						  'update_user_no' => $userid,
						  'create_date' => mdate('%Y-%m-%d %h:%i:%s', time()),
						  'update_date' => mdate('%Y-%m-%d %h:%i:%s', time()),
			);
		    $sql = $this->db->insert_string("ebook_page_editor_settings",$data);
		}
		$this->db->query($sql);	
		$data['old_settings'] = $old_settings;		
        $data['result'] = TRUE;
        return $data;		
	}	
}
?>