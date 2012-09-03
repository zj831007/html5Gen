<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends MY_Controller {


	protected $slider_path = '';
	protected $editor_type = 'slider';

	function __construct(){
	
		parent::__construct();		
		$this->slider_path = $this->config->item('slider_path');
	}
	
	function getEditorType(){
	    return $this->editor_type;
	}
	
	function getEditorPath(){
		 return $this->slider_path;
	}

    function getViewName(){
		return "slider_view";
	}
	
	function _parseHTML($forPreview = true){
	  
	   $this->load->driver('plenty_parser');
       $tpl = 'smarty/slider';	   
	   $user_temp = $this->_post('user_temp');
	   
	   //$slider_dir   = $forPreview ? base_url().$this->common_path.$this->slider_path : $this->slider_path ;
	   //$public_dir   = $forPreview ? base_url().$this->common_path.$this->public_path : $this->public_path ;
	   $public_dir   = $forPreview ? base_url()."..".$this->library_path.$this->public_path
		                          : "../../../..".$this->library_path.$this->public_path ;
	   
	   $slider_dir   = $forPreview ?  base_url()."..".$this->library_path.$this->slider_path
	                              : "../../../..".$this->library_path.$this->slider_path ;
	   
	   $image_dir     = $forPreview ? base_url(). "temp/" . $user_temp . '/' : '' ;
	   $b_orientation = $this->_post("bOrientation");
	   $b_file        = $this->_post("bFileName");
	   //$b_size       = $this->_post("bSize");
	   $b_width       = $this->_post("bWidth");
	   $b_height      = $this->_post("bHeight");
	   //$b_width      = $b_rientation === "h" ? $this->sizeArray[$b_size+0][0]: $this->sizeArray[$b_size+0][1];
	   //$b_height     = $b_rientation === "h" ? $this->sizeArray[$b_size+0][1]: $this->sizeArray[$b_size+0][0];
	   
	   $s_files  = explode(";",$this->_post('sFileName'));
	   $s_left   = $this->_post('sPX');
	   $s_top    = $this->_post("sPY");
	   $s_width  = $this->_post("sWidth");
	   $s_height = $this->_post("sHeight");
	   $s_touch  = $this->_post("sTouch") ? 'true' : 'false';
	   $s_auto   = $this->_post("sAuto") ? 'true' : 'false';
	   
	   $s_arrow         = $this->_post("sArrow") ? 'true' : 'false';	   
	   $s_arrowFileName = $this->_post("sArrowFileName") ? $this->_post("sArrowFileName") : '';
	   $s_arrowPosition = $this->_post("sArrowPosition");
	   
	   $s_dock                 = $this->_post("sDock")? 'true' : 'false';
	   $s_dockAlign            = $this->_post("sDockAlign");
	   $s_dockPosition         = $this->_post("sDockPosition");
	   $s_dockColor            = $this->_post("sDockColor");
	   $s_dockColorCurrent     = $this->_post("sDockColorCurrent");
	   $s_dockShowText         = $this->_post("sDockShowText");
	   $s_dockTextColor        = $this->_post("sDockTextColor");
	   $s_dockTextColorCurrent = $this->_post("sDockTextColorCurrent");
	   $s_dockSize             = $this->_post("sDockSize");
	   
	   $s_display = $this->_post("sDisplay"); // '' and none	   
	   $l_left    = $this->_post("lPX");
	   $l_top     = $this->_post("lPY");
	   $l_file    = $this->_post("lFileName");
        $data = array(
	        'slider_dir'  => $slider_dir,
			'public_dir'  => $public_dir,
			'image_dir' => $image_dir,
		    'b_orientation' => $b_orientation,
			'b_file' => $b_file,
			'b_width' => $b_width,
			'b_height' => $b_height,			
			's_files' => $s_files,
			's_left' => $s_left,
			's_top' => $s_top,
			's_width' => $s_width,
			's_height' => $s_height,
			's_touch' => $s_touch,
			's_auto' => $s_auto,
			's_arrow' => $s_arrow,
			's_arrowFileName' => $s_arrowFileName,
			's_arrowPosition' => $s_arrowPosition,
			's_dock' => $s_dock,
			's_dockAlign' => $s_dockAlign,
			's_dockPosition' => $s_dockPosition,
			's_dockColor' => $s_dockColor,
			's_dockColorCurrent' => $s_dockColorCurrent,
			's_dockShowText' => $s_dockShowText,
			's_dockTextColor' => $s_dockTextColor,
			's_dockTextColorCurrent' => $s_dockTextColorCurrent,
			's_dockSize' => $s_dockSize,
			's_display' => $s_display,
			'l_left' => $l_left,
			'l_top' => $l_top,
			'l_file' => $l_file,
			'forPreview' => $forPreview,
	   );
	   return $this->plenty_parser->parse($tpl,$data,true);
    }
	
	function _parseSettings(){
				
		$lFileName ='';
		$lPX = '';
		$lPY = '';   
		$sDisplay = $this->_post("sDisplay");
		if($sDisplay == "none"){
			$lFileName = $this->_post("lFileName");
			$lPX = $this->_post("lPX");
			$lPY = $this->_post("lPY");
		}
		$sArrow  = $this->_post("sArrow");
		$sArrowFileName = '';
		$sArrowPosition = '';
		if($sArrow){
			$sArrowFileName = $this->_post("sArrowFileName");
			$sArrowPosition = $this->_post("sArrowPosition");
		}
		
		$sDockAlign = '';
		$sDockPosition = '';
		$sDockColor = '';
		$sDockColorCurrent = '';
		$sDockShowText = '';
		$sDockTextColor = '';
		$sDockTextColorCurrent = '';
		$sDockSize = '';
		$sDock = $this->_post("sDock");
		
		if($sDock){
		    $sDockAlign = $this->_post("sDockAlign");
			$sDockPosition = $this->_post("sDockPosition");
			$sDockColor = $this->_post("sDockColor");
			$sDockColorCurrent = $this->_post("sDockColorCurrent");
			$sDockShowText = $this->_post("sDockShowText");
			if($sDockShowText){
				$sDockTextColor = $this->_post("sDockTextColor");
				$sDockTextColorCurrent = $this->_post("sDockTextColorCurrent");
			}
			$sDockSize = $this->_post("sDockSize");
		}
		
	    $data = array(		   
			'bFileName'    => $this->_post("bFileName"),
			//'bSize'        => $this->_post("bSize"),
			'bOrientation' => $this->_post("bOrientation"),
			'bWidth'       => $this->_post("bWidth"),
			'bHeight'      => $this->_post("bHeight"),

			'sFileName'    => $this->_post('sFileName'), 
			'sPX'          => $this->_post("sPX"),
			'sPY'          => $this->_post("sPY"),
			'sWidth'       => $this->_post("sWidth"),
			'sHeight'      => $this->_post("sHeight"),
			
			'sTouch'       => $this->_post("sTouch"),
			'sAuto'        => $this->_post("sAuto"),
		
			'sArrow'       => $sArrow,
			'sArrowFileName' => $sArrowFileName,
			'sArrowPosition' => $sArrowPosition,
			
			'sDock'        => $sDock,
			'sDockAlign'=> $sDockAlign ,
			'sDockPosition'=> $sDockPosition ,
			'sDockColor'=> $sDockColor,
			'sDockColorCurrent'=> $sDockColorCurrent ,
			'sDockShowText'=> $sDockShowText ,
			'sDockTextColor'=> $sDockTextColor ,
			'sDockTextColorCurrent'=> $sDockTextColorCurrent ,
			'sDockSize'=> $sDockSize ,
			
			'sDisplay'     => $sDisplay,
			'lFileName'    => $lFileName,
			'lPX'          => $lPX,
			'lPY'          => $lPY
		);
	    return json_encode($data);
	}
	
	function _getAllUsersFiles($settings){
		$settingArray = json_decode($settings, true);
		$sFiles =  explode(";",$settingArray['sFileName']);
		array_push($sFiles, $settingArray['bFileName']);
		if($settingArray['sArrowFileName']){
			array_push($sFiles, $settingArray['sArrowFileName']);
		}
		if($settingArray['lFileName']){
			array_push($sFiles, $settingArray['lFileName']);
		}
        return $sFiles;
	}
	
	function _getNewFileName($oldName, $new_pre){
		$parts = explode("_",$oldName);
		$parts[0] =  $new_pre;
		return join("_",$parts);
		//$suffix = $this->_get_extension($oldName);
		//return $new_pre.$suffix;
	}
	
	function initWithSettings(&$settingsArray, $from, $to){
		$pre = $this->pageid;

		//$time = time();
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
		
		$this->_checkPath($to);

		$bFile = $settingsArray['bFileName'];
		$new_bFile = $this->_getNewFileName($bFile , $pre);
		copy($from.$bFile, $to.$new_bFile);
		$settingsArray['bFileName'] = $new_bFile;
		
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
        $sFiles = explode(";",$settingsArray['sFileName']);
		$new_sFiles = array();
		foreach( $sFiles as $sFile){
			//list($first,$second) = explode("_",$sFile);
			//$new_sFile = $timestamp."_".$second;
			$new_sFile = $this->_getNewFileName($sFile, $pre);
			copy($from.$sFile, $to.$new_sFile);
			array_push($new_sFiles,$new_sFile);
		}
		$new_sFileName = join(";",$new_sFiles);
		$settingsArray['sFileName'] = $new_sFileName;
		
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
		$new_sArrowFile = '';
		$sArrowFile = $settingsArray['sArrowFileName'];
		if($sArrowFile){
			$new_sArrowFile = $this->_getNewFileName($sArrowFile , $pre);
			copy($from.$sArrowFile, $to.$new_sArrowFile);
			$settingsArray['sArrowFileName'] = $new_sArrowFile;
		}
		
		//$timestamp = mdate($this->datestring, $time).random_string('numeric',4);
		$new_lFile = '';
		$lFile = $settingsArray['lFileName'];
		if($lFile){
			$new_lFile = $this->_getNewFileName($lFile , $pre);
			copy($from.$lFile, $to.$new_lFile);
			$settingsArray['lFileName'] = $new_lFile;
		}
	}
}
