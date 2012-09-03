<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rotate360_model extends CI_Model {

    protected $editor_type='rotate360';

    function __construct(){
        parent::__construct();
    }
	
	function getInitData($ebook ,$userid){
	
	    $pageid = $ebook['page']['id'];
		$bookname= $ebook['name'];
		$bookid = $ebook['id'];
        
	    //query book info by pageid;
		//$sql = "select a.id, b.name, a.ebook_id from ebook_page a, ebook b where b.id= a.ebook_id and a.id = ?";
		//$query = $this->db->query($sql, array($pageid));
		$data = array();
		//if ($query->num_rows() > 0){
		if($ebook){
		    //$row = $query->row(); 
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
			
			$insert = array(
				   'page_id' =>  $data['pageid'] ,
				   'user_id' => $userid ,
				   'flag' => 'Y'
			);

			$this->db->insert('temp_tracker', $insert);
			$data['user_temp'] = $userid.'-'.mysql_insert_id();
        }
		return $data;
		
    }
	
	function save($param){
	
        $html = $param['html'];
		$settings = $param['settings'];
		$pageid = $param['pageid'];
		$save_tpl = $param['save_tpl'];
		$templageid= $param['templateid'];
		$template_desc_old = $param['template_desc_old'];
		$template_desc = $param['template_desc'];
		$bookid = $param['bookid'];
		$userid = $param['userid'];
		$old_settings = '';
		
		// 1.settings to ebook_page_editor_settings
        // 2.save html to ebook_page	
		// 3.if save_template="Y"  save template to editor_template	
		$this->db->trans_start();
		
		$sql = "select * from ebook_page_editor_settings where page_id=?";
		$query = $this->db->query($sql,array($pageid));
		if($query->num_rows() > 0){
		
		    $row = $query->row();
			$old_settings = $row->settings;
			
		    $data = array('settings' => $settings);
		    $where = "page_id= ".$this->db->escape($pageid) ; 		
		    $sql = $this->db->update_string("ebook_page_editor_settings", $data, $where);
		}else{
		    $data = array('page_id'=>$pageid, 'editor_type'=> $this->editor_type, 'settings' =>$settings );
		    $sql = $this->db->insert_string("ebook_page_editor_settings",$data);
		}
		$this->db->query($sql);	
		
		$data = array('page_html ' => $html,'editor' => '360-degree');
		$where = "id = " . $this->db->escape($pageid). " AND ebook_id = ".$this->db->escape($bookid). " AND is_delete = 0" ; 
		$sql = $this->db->update_string('ebook_page', $data, $where); 		
		$this->db->query($sql);	
		
		//更新電子書修改時間
		$sql = "UPDATE `ebook`
			SET update_time = NOW(),
				update_user_no = '".$userid."'
			WHERE id = '".$bookid."'
				AND is_delete = 0";
		$this->db->query($sql);
		
		if($save_tpl == 'Y'){
		    //echo $template_desc_old . "|" . $template_desc;
            if($template_desc_old == $template_desc){
			    //update
				$data = array('settings' => $settings);
			    $where = "id= ".$this->db->escape($templageid) ; 		
			    $sql = $this->db->update_string("editor_template", $data, $where);
				$this->db->query($sql);
			}else{
			    $data = array('template_desc'=>$template_desc , 'settings'=> $settings, 'type' => $this->editor_type);
				$sql = $this->db->insert_string("editor_template",$data);
				$this->db->query($sql);
				$templageid = mysql_insert_id();
			}
		}	
		
		$this->db->trans_complete();
		
		$data['templateid'] =$templageid;
		$data['old_settings'] = $old_settings;		
        $data['result'] = TRUE;
        return $data;		
	}
	
	function loadTemplates(){
		$sql = "SELECT id, template_desc FROM editor_template where type= ? order by update_date desc;";
		$query = $this->db->query($sql, array($this->editor_type));	   
		$json_string = json_encode($query->result_array()); 
		echo $json_string;
	}
	
	function loadTemplateById($id){
	    $data = array();
	    $sql = "SELECT * FROM editor_template where id = ?";
		$query = $this->db->query($sql, array($id));
		if($query->num_rows() > 0){
		     $row = $query->row();
			 $data['templateid'] =  $row -> id;
			 $data['template_desc'] = $row->template_desc;
			 $data['settings'] = $row->settings;
		}
        return $data;
	}
}
?>