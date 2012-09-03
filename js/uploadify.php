<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

require_once("../log4php/Logger.php");
Logger::configure("../log4php/log.properties");

Logger::getLogger("default")->debug("begin upload....");

if (!empty($_FILES)) {

	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	
	if (function_exists('realpath') AND @realpath("../".$_REQUEST['folder'] . '/') !== FALSE)
	{
		$targetPath = str_replace("\\", "/", realpath("../" . $_REQUEST['folder']). '/');
	}
		
	Logger::getLogger("default")->debug(" targetPath: " . $targetPath);
	
	//$filePrefix = $_REQUEST['filePrefix'];
	
    $randString = '';
	if(isset($_REQUEST['customTimeStamp'])&& $_REQUEST['customTimeStamp'] == 'true'){
		$randString = date("YmdHis", time()).rand(1000, 9999);
	}
	
	if(isset($_REQUEST['filePrefix']) && $_REQUEST['filePrefix'] ){
        $filePrefix = $_REQUEST['filePrefix'];
	}else {
        $filePrefix = '';
	}
	$newf_name = '';
	$old_name = prep_filename($_FILES['Filedata']['name']);
		
	if(isset($_REQUEST['saveOldName'])&& $_REQUEST['saveOldName'] == 'true'){		
		$newf_name = $filePrefix. $randString . '_'. $old_name;
	}else{
		$newf_name = $filePrefix. $randString . get_extension($old_name);
	}
	
	$targetFile =  str_replace('//','/',$targetPath) . $newf_name;
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
	Logger::getLogger("default")->debug("move : " . $tempFile . " to " . $targetFile);	
		move_uploaded_file($tempFile,$targetFile);	
		
		//echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
		
	   $filearray = array();
	   $filearray['file_name'] = $newf_name;
	   $filearray['old_name'] = $old_name;
  
	   $json_array = json_encode($filearray);
	   echo $json_array;

		//echo $targetFile;
	// } else {
	// 	echo 'Invalid file type.';
	// }
}

	function prep_filename($filename) {
	   if (strpos($filename, '.') === FALSE) {
		  return $filename;
	   }
	   $parts = explode('.', $filename);
	   $ext = array_pop($parts);
	   $filename    = array_shift($parts);
	   foreach ($parts as $part) {
		  $filename .= '.'.$part;
	   }
	   $filename .= '.'.$ext;
	   return $filename;
	}
	
	function get_extension($filename)
	{
		$x = explode('.', $filename);
		return '.'.end($x);
	}
?>