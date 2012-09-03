<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ebook_page_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }		
	
	function save($param){
	
        $html = $param['html'];
		$pageid = $param['pageid'];		
		$bookid = $param['bookid'];
		$userid = $param['userid'];
		$editor = $param['editor'];

        // 1.save html to ebook_page	
        // 2.update ebook
					
		$data = array('page_html ' => $html,'editor' => $editor);
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
        $data['result'] = TRUE;
        return $data;		
	}
	
	
	function loadPageByBookId($bookid, $pageid = ''){
	    $sql = "select id, title from ebook_page where ebook_id = ?  and is_delete = 0 "
		       //.(($pageid) ? " and id <> ? " : "") 
			   . " ORDER BY sort ;";

		$data = array($bookid);
		//if($pageid){
		//    $data[1] = $pageid;
		//}
		$query = $this->db->query($sql, $data);
		
		$result = array();
		$i = 0;
		foreach ($query->result() as $row){
		   if($pageid && $pageid == $row->id){
			   ++$i;
		   }else{
		       $result[++$i] =  array( 'id' => $row->id, "title"=> $i . ". " .$row->title, "index" => $i-1, "name" => $row->title  );		   
		   }
		}
		return $result;
	}
}
?>