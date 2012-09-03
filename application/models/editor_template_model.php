<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor_template_model extends CI_Model {   

    function __construct(){
        parent::__construct();
    }	
	
	function save($param){	

		$settings = $param['settings'];
		$save_tpl = $param['save_tpl'];
		$template_id= $param['template_id'];
		$template_desc_old = $param['template_desc_old'];
		$template_desc = $param['template_desc'];
		$editor_type = $param['editor_type'];
		$bookid = $param['bookid'];
		$pageid = $param['pageid'];
		$userid = $param['userid'];
		
		//if save_template="Y"  save template to editor_template
		if($save_tpl == 'Y'){			
            if($template_desc_old == $template_desc){
			    //update
				$data = array('settings' => $settings, 'update_user_no' => $userid);
			    $where = "id= ".$this->db->escape($template_id) ; 		
			    $sql = $this->db->update_string("editor_template", $data, $where);
				$this->db->query($sql);
			}else{
			    $data = array(
				    'template_desc'=>$template_desc , 
					'settings'=> $settings, 
					'type' => $editor_type,
					'pageid' => $pageid,
					'bookid' => $bookid,
					'create_user_no' => $userid,
					'update_user_no' => $userid,
					'create_date' => mdate('%Y-%m-%d %h:%i:%s', time()),
					'update_date' => mdate('%Y-%m-%d %h:%i:%s', time()),
				);
				$sql = $this->db->insert_string("editor_template",$data);
				$this->db->query($sql);
				$template_id = mysql_insert_id();
			}
		}	
	
		$data['template_id'] =$template_id;
        $data['result'] = TRUE;
        return $data;		
	}
	
	function loadTemplates($editor_type, $bookid, $userid){
		$sql = "SELECT id, template_desc FROM editor_template where type= ? and bookid = ? and (create_user_no = ? or update_user_no = ? ) order by update_date desc;";
		$query = $this->db->query($sql, array($editor_type, $bookid, $userid ,$userid ));		
		return $query->result_array();		
	}
	
	function loadTemplateById($id){
	    $data = array();
	    $sql = "SELECT * FROM editor_template where id = ?";
		$query = $this->db->query($sql, array($id));
		if($query->num_rows() > 0){
		     $row = $query->row();
			 $data['template_id'] =  $row -> id;
			 $data['template_desc'] = $row->template_desc;
			 $data['settings'] = $row->settings;
		}
        return $data;
	}
}
?>