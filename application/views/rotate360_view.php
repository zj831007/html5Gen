<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>360元件</title>
	<link href="<?php echo base_url();?>css/elastic.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>js/uploadify/uploadify.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/colorpicker.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/jquery.multiselect.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/jquery.multiselect.filter.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/LoadingBar.css" rel="stylesheet"/>
    
    <script src="<?php echo base_url();?>js/jquery-1.4.4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/common.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.form.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>js/elastic.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/dialog.js" type="text/javascript"></script>	
	<script src="<?php echo base_url();?>js/uploadify/swfobject.js" type="text/javascript" ></script>
	<script src="<?php echo base_url();?>js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
	<script src="<?php echo base_url();?>js/colorpicker/colorpicker.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/colorpicker/eye.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/colorpicker/utils.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.multiselect.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.multiselect.filter.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/LoadingBar.js"></script>
	
<style type="text/css">

#div1 .icon{
	visibility:hidden; position:relative; overflow:hidden; /*background: none rgba(255, 255, 0, 0.3);*/
}
	
#rotateIcon{
	  background:url(<?php echo base_url();?>css/images/arrow.png) no-repeat 0 0  rgba(0, 255, 0, 1); 
	  position:relative; 
	  border: 1px solid #dedede; 
	  -moz-border-radius: 25px; 
	  -webkit-border-radius: 25px; 
	  width:50px; 
	  height:50px; 
	  margin: 0 auto;
	  display:none;
}
.arrow_updown{
	bottom:70%;
}
.arrow_leftright{
	bottom:40%;
	-moz-transform: rotate(90deg);
	-webkit-transform: rotate(90deg);
	-o-transform: rotate(90deg) ;
	-ms-transform: rotate(90deg);
	transform: rotate(90deg);
}

#showImg {
   position:absolute; 
   z-index:1;
}
</style>
</head>
<script>

	//var sizeArray = [[1024,768],[854,480],[1024,600],[800,600]];
    var filePrefix = "";
	var rotateFile = "";
	var firstFile = "";
	var dialog = window.chidopi;
	var templates ;
	
	function loadData(settings){ 
	    
	    $("#bFileName, #tmp_bFile").val( settings.bFileName ); 
		$("#rFileName").val( settings.rFileName ); 
		$("#rOrientation").val( settings.rOrientation ); 
		$("#rNumber").val( settings.rNumber ); 
		$("#rPX").val( settings.rPX ); 
		$("#rPY").val( settings.rPY ); 
		$("#rWidth").val( settings.rWidth ); 
		$("#rHeight").val( settings.rHeight ); 
		$("#noticeColor").val( settings.noticeColor )
		                 .css("background-color","rgb("+settings.noticeColor+")"); 
		//$("#colorSelector div").css("background-color","rgb("+settings.noticeColor+")");
	    $("#rotateIcon").css("backgroundColor", "rgba("+ settings.noticeColor + ", 1)");
		$("#rDisplay").val(settings.rDisplay);
		$("#lFileName, #tmp_lFile").val(settings.lFileName);
		$("#lPX").val(settings.lPX);
		$("#lPY").val(settings.lPY);
		
		updatePreviewArea1();
		updateShowImg();
		
		if(settings.rDisplay){
			$("#lFileName, #lPX, #lPY, #tmp_lFile").attr("disabled",false);
            $("#link_area").show();
		}
		
		var files = settings.rFileName.split(";");

		for(var i = 0; i< files.length; i++){
		    var file = files[i];
			if(file){
				var parts = file.split(".")[0].split("_");
				var name = parts[parts.length-1];						
				if(name == "01"){							    
					var filename = "<?php echo base_url();?>temp/<?php echo $user_temp;?>/" + file;
					updateRotateImg(filename);
					break;
				}
			}
		}
		
	}
	
	
	$(function(){
	
	    if('<?php echo $isAdd ?>' != '1'){
	        var settings = <?php echo $settings ?>;
			loadData(settings);
		}
	
	    $("#menu li").button();
		
		$("#t_preview").click(function(){
		    if( !$("#bFileName").val() || !$("#rFileName").val()){
				dialog.alert('Error',"請先上傳圖片");
			}else{
			    runCode();
			}
		});
		
		$("#t_save").click(function(){
			if( !$("#bFileName").val() || !$("#rFileName").val()){
				dialog.alert('Error',"請先上傳圖片");
			}else{			
				$("#div_save").dialog("open");				
			}
		});
		
		if("<?php echo $isAdd ?>" == '1'){
		    $("#t_template").click(function(){
			    $.post(
					'<?php echo base_url();?>rotate360/loadTemplates', 
					{},
					function (data, textStatus){
                        $("#sel_templates option").remove();					
					    if(data && data.length){			
							$(data).each(function(i){				
								var option = $("<option/>");
								$(option).attr("value",data[i].id);
								$(option).text(data[i].id + ":" +data[i].template_desc);
								$("#sel_templates").append(option);
							});
						}
						//templates.multiselect('refresh');
					    $( "#div_loadTemplate" ).dialog( "open" );
					},
					"json"
				);			
			});
		}else{
		    $( "#li_template" ).button( "option", "disabled", true );
		}
	    
		$("input[name=bFile]").change(function(){
		    if($(this).val())
			    $("#btn_bUpload").attr("disabled",false);
		});
		
		$("input[name=lFile]").change(function(){
		    if($(this).val())
			    $("#btn_lUpload").attr("disabled",false);
		});
		
		
		$("#rDisplay").change(function(){
		    if($(this).val()){
			    $("#tmp_lFile, #lFileName, #lPX, #lPY").attr("disabled",false);						
				$("#link_area").show();
				if($("#lFileName").val()){
					$("#tmp_lFile").val($("#lFileName").val());
				    $("#showImg").show();
				}
			}else{			    
			    $("#lForm")[0].reset();
				$("#tmp_lFile").val("點擊上傳圖片")
			    $("#tmp_lFile, #lFileName, #lPX, #lPY,#btn_lUpload").attr("disabled",true);
				$("#link_area, #showImg").hide();
			}
		});
		
		$("#lForm").ajaxForm({		    
			url:'<?php echo base_url();?>common_controller/uploadSinglePic',
			data:{ 
				 user_temp: "<?php echo $user_temp;?>" , 
				 file:'lFile',
				 prefix:"<?php echo $pageid.'_'.'link_' ?>"
			},
			success: doSuccess1
		});
		
		$("#tmp_lFile").change(function(){
		    if($(this).val() != "點擊上傳圖片"){
                $("#btn_lUpload").attr("disabled",false);
			}
		}).click(function(){
		     $('#lFile').click();
		});

		$("#lFile").change(function(){
            $('#tmp_lFile').val( $(this).val() );
            $('#tmp_lFile').change();
		});

		$("#btn_lUpload").click(function(){
			var parent = $(this).parent();
			createLoading(parent);
            $('#lForm').submit();
		});
	    
		$('#bForm').ajaxForm({			
			url:'<?php echo base_url();?>common_controller/uploadSinglePic',
			data:{ 
				 user_temp: "<?php echo $user_temp;?>" , 
				 file:'bFile',
				 prefix:"<?php echo $pageid.'_'.'bg_' ?>"
			},
			success: doSuccess						
		}); 
		
		$("#tmp_bFile").change(function(){
		    if($(this).val() != "點擊上傳圖片"){
                $("#btn_bUpload").attr("disabled",false);
			}
		}).click(function(){
		     $('#bFile').click();
		});

		$("#bFile").change(function(){
            $('#tmp_bFile').val( $(this).val() );
            $('#tmp_bFile').change();
		});

		$("#btn_bUpload").click(function(){
			var parent = $(this).parent();
			createLoading(parent);
            $('#bForm').submit();
		});

		
		$("#div_save").dialog({
		    autoOpen: false,
			height: 150,
			width: 300,
			modal: true,
			buttons: {
				"save": function() {
				
				    if($("#chk_saveTemplate").attr("checked")){
					    $("#save_template").val("Y");
						$("#template_desc").val($("#template_desc_new").val());
					}else{ 
					    $("#save_template").val("");
					}
					var queryString = $('#mainForm').formSerialize();					
					$.ajax({
					    type: "post",
						url: '<?php echo base_url();?>rotate360/save', 
						data :queryString,
						dataType : 'json',
						success : function (data, textStatus){
							window.self.LoadingBar.hide();
							if(data=="1"){
							    dialog.alert("Save",'保存成功');
							}else{
								dialog.alert("Error",'保存失敗');
							}
						},
						error : function(XMLHttpRequest, textStatus, errorThrown){
							window.self.LoadingBar.hide();
						    dialog.alert("Error",errorThrown);
						}
					});
                    window.self.LoadingBar.show();
					//$('#mainForm').attr("action","<?php echo base_url();?>rotate360/save");
					//$("#mainForm").submit();
						
					$( this ).dialog( "close" );
				} ,
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
		
		
		
		$( "#btn_rUpload" ).button().click(function() {
			initRotateDialog();
		    initUploadify();
			$( "#rotateForm" ).dialog( "open" );
		});
		
		$("#rPX, #rPY, #rWidth, #rHeight, #rOrientation").change(function(){

			if($(this).attr("type") == "text" && isNaN(parseInt($(this).val())) ){
			    $(this).val(0);
			}
			
			if($("#bFileName").val()){
		        updatePreviewArea2();
			}
		});
		
		$("#lPX, #lPY").change(function(){
		    if(isNaN(parseInt($(this).val())) ){
			    $(this).val(0);
			}
			
			if($("#lFileName").val()){
		        updatePreviewArea3();
			}
		});
		var color = $("#noticeColor");
		color.ColorPicker({
			color: '#00ff00',
			livePreview: false,
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {					
				color.css('backgroundColor', '#' + hex);
				color.val(rgb.r+", " + rgb.g + ", " + rgb.b);
				$("#rotateIcon").css("backgroundColor", "rgba("+ rgb.r+", " + rgb.g + ", " + rgb.b + ", 1)");				
			}
		});			
		/*$('#colorSelector').ColorPicker({
			color: '#00ff00',
			livePreview: false,
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#colorSelector div').css('backgroundColor', '#' + hex);
				$("#noticeColor").val(rgb.r+", " + rgb.g + ", " + rgb.b);
				$("#rotateIcon").css("backgroundColor", "rgba("+ rgb.r+", " + rgb.g + ", " + rgb.b + ", 1)");
			}			
		});*/
		
		/*templates  = $("#sel_templates").multiselect({
			multiple: false,
			selectedList: 1,
			minWidth:300,
			noneSelectedText:'no item',			
			position: { 
				my: 'top', 
				at: 'top'
			}
		}).multiselectfilter({
			label: '',
			//width:120,
			placeholder: '請輸入關鍵字'
	    });*/
		
		
		$("#div_loadTemplate").dialog({
		    autoOpen: false,
			height: 350,
			width: 500,
			modal: true,
			buttons: {
				"确定": function() {		
					loadTemplateById();
					$( this ).dialog( "close" );		
				} ,
				Cancel: function() {
					$( this ).dialog( "close" );		
				}
			}
		});
		
	});
	
	function loadTemplateById(){
	   	
	    if($("#sel_templates").val()){
			 var id = $("#sel_templates").val();
			$.ajax({
				type: "post",
				url: '<?php echo base_url();?>rotate360/loadTemplateById', 
				data : {id:id, user_temp: '<?php echo $user_temp;?>', pageid:'<?php echo $pageid;?>'},
				dataType : 'json',
				success : function (data, textStatus){
						if(data){
							$("#templateid").val(data.templateid);
							$("#template_desc_old").val(data.template_desc);
							$("#template_desc_new").val(data.template_desc);
							loadData(data.settings);
						
						}else{
							alert("模板不存在");
						}		
				},
				error : function(XMLHttpRequest, textStatus, errorThrown){
					alert(textStatus + " | " + errorThrown);
				}
			});	
			//window.open('<?php echo base_url();?>rotate360/loadTemplateById/'+ id + "/<?php echo $user_temp;?>");
		}
	}
	
	function initRotateDialog(){
		$( "#rotateForm" ).dialog({
			autoOpen: false,
			height: 300,
			width: 500,
			modal: true,
			buttons: {
				"上传": function() {				
				    $('#upload').uploadifySettings('queueSizeLimit',$("#rNumber").val());
				    $('#upload').uploadifyUpload();
					rotateFile = "";
					firstFile = "";
				} ,
				Cancel: function() {
					$( this ).dialog( "destroy" );
				}
			},
			close: function(event, ui) { 
			    $('#upload').uploadifyClearQueue();
				$( this ).dialog( "destroy" );
			}

		});
	}
	
	function initUploadify(){
	
	    $("#upload").unbind("uploadifySelect");
		$('#uploadQueue').remove();
		swfobject.removeSWF('uploadUploader'); 
	    //$("#uploadUploader").remove();
		//$("#uploadQueue").remove();
		
		
	    var testDate = new Date();		
		filePrefix =  testDate.format("YYYYMMddhhmmss") + "" + Math.round(Math.random()*10000) + "_";
		filePrefix = '<?php echo $pageid."_rotate360_"?>' + filePrefix;
		var idString="";
		$("#upload").uploadify({
			uploader: '<?php echo base_url();?>js/uploadify/uploadify.swf',
			script:   '<?php echo base_url();?>js/uploadify.php',
			//buttonImg: '<?php echo base_url();?>js/uploadify/cancel.png',
			cancelImg: '<?php echo base_url();?>js/uploadify/cancel.png',
			folder: '/temp/<?php echo $user_temp;?>',
			fileExt: '*.jpg;*.gif;*.png',
            fileDesc: 'Image Files',
			scriptAccess: 'always',
			queueSizeLimit: $("#rNumber").val(),
			multi: true,
			scriptData:{'filePrefix': filePrefix , 'customTimeStamp':false , 'saveOldName':true},
			'onError' : function (a, b, c, d) {
				if (d.status == 404){
					dialog.alert('Error','找不到文件');
				}else if (d.type === "HTTP"){
					dialog.alert('Error','error '+d.type+": "+d.status);
				}else if (d.type ==="File Size"){
					dialog.alert('Error',c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
				}else{
					dialog.alert('Error','error '+d.type+": "+d.text);
				}
			},
			'onSelect' : function(event,ID,fileObj) {			    
			    
				var name = fileObj.name.substring(0,fileObj.name.lastIndexOf("."));	
               
				var patrn=/^\d{2}$/;			
			    if (!patrn.exec(name)){
				   idString  += ID + ";";
				   return false;
				}
			},
			'onSelectOnce' : function(event,data) {
			    
				var ids = idString.split(";");
				for(var i = 0; i < ids.length; i++){				    
					if(ids[i])
				        jQuery('#upload').uploadifyCancel(ids[i]);
				}				
				idString="";			   
			},
			'onComplete' : function (event, queueID, fileObj, response, data) {
			
			    var jsonRes = jQuery.parseJSON(response);				
                var old_name = jsonRes.old_name.substring(0,jsonRes.old_name.lastIndexOf("."));	

				if(old_name == "01"){
				    firstFile = "<?php echo base_url();?>temp/<?php echo $user_temp;?>/" + jsonRes.file_name;				    
				}
				
				if(jsonRes.file_name){
					rotateFile = rotateFile +  jsonRes.file_name + ";";
				}
			},
			'onAllComplete' : function(event,data) {
			    if(rotateFile != ""){					
					$("#rFileName").val(rotateFile);
				}
				
				updateRotateImg(firstFile);
				
				$( "#rotateForm" ).dialog( "destroy" );
			}
		});
	}
	
	function updateRotateImg(file){
		$("#rotateImg").attr("src", '');
				
		if(file != ""){
			var img = new Image();
			img.src = file;
			
			$("#rotateImg").load(function(){
				
				if( $("#rPX").val() == "" )  $("#rPX").val( 0 );
				if( $("#rPY").val() == "" )  $("#rPY").val( 0 );
				
				if( !$("#rWidth").val() ) $( "#rWidth" ).val( img.width);						 
				if( !$("#rHeight").val() ) $( "#rHeight" ).val( img.height );
				
				$(".icon").css("visibility","visible");
				$("#rotateIcon").show();
				updatePreviewArea2();
			});
			
			$("#rotateImg").attr("src", img.src);
		}
	}
	
	function doSuccess(responseText, statusText) {
		var tmp_bFile = $('#tmp_bFile');
		var parent = tmp_bFile.parent();
		deleteLoading(parent);
		var result = JSON.parse(responseText);
		if("success" == result.flag){
			$("#bFileName").val(result.filename);
			updatePreviewArea1();
		}else{
			 dialog.alert("Error", result.msg);
		}
	}
	
	function doSuccess1(responseText, statusText) {
		var tmp_lFile = $('#tmp_lFile');
		var parent = tmp_lFile.parent();
		deleteLoading(parent);      
		var result = JSON.parse(responseText);
		if("success" == result.flag){			
		    $("#lFileName").val(result.filename);
			updateShowImg();
		}else{
			dialog.alert("Error", result.msg);
		}
	}
	
	function updateShowImg(){
		$("#showImg").attr("src", '');
		
		var lFileName = $("#lFileName").val();
		var url = "";
		if(lFileName){
			url= "<?php echo base_url();?>temp/<?php echo $user_temp;?>/"+lFileName;
		}
		if(url != ""){
			var img = new Image();
			img.src = url;
			
			$("#showImg").load(function(){				
				if( $("#lPX").val() == "" )  $("#lPX").val( 0 );
				if( $("#lPY").val() == "" )  $("#lPY").val( 0 );				
				updatePreviewArea3();	
				$("#showImg").show();				
			});
			
			$("#showImg").attr("src", img.src);
		}
	}
	
	function updatePreviewArea3(){
	    $("#showImg").css("left",$("#lPX").val() + "px" );
		$("#showImg").css("top",$("#lPY").val() + "px" );
	}
	
    function updatePreviewArea1(){
		var background = $("#div1");
        var bFileName = $("#bFileName").val();
		var url = "";
		if(bFileName){
			url= "<?php echo base_url();?>temp/<?php echo $user_temp;?>/"+bFileName;
		}else{
			url= "none";
		}

		$(background).css("background-image","url("+url+")");
		
		var width = $("#bWidth").val();
		var height = $("#bHeight").val();
        $(background).css("width", width +"px");
        $(background).css("height", height +"px");		
    }
	
	/*function getBackgroundSize(){
	    var indexW = $(":radio[name=bOrientation][checked]").val()=="h"? 0 : 1;		  
		var indexH = $(":radio[name=bOrientation][checked]").val()=="h"? 1 : 0;
		var size = $("#bSize").val();
		return [sizeArray[size][indexW], sizeArray[size][indexH]];
	}*/

	function updatePreviewArea2(){
	
	    $("#rotateImg").attr("width",$("#rWidth").val());
		$("#rotateImg").attr("height",$("#rHeight").val());
		$(".icon").css("left",$("#rPX").val() + "px" );
		$(".icon").css("top",$("#rPY").val() + "px" );
		$(".icon").css("width",$("#rWidth").val() + "px" );
		$(".icon").css("height",$("#rHeight").val() + "px" );

		if($("#rOrientation").val() == "0"){
		    $("#rotateIcon").removeClass("arrow_updown");
			$("#rotateIcon").addClass("arrow_leftright");		    
		}else{
		    $("#rotateIcon").addClass("arrow_updown");
			$("#rotateIcon").removeClass("arrow_leftright");	
		}
	}   
	
	function runCode(){
	    var url = "<?php echo base_url();?>rotate360/preview";
		$("#mainForm").attr("action",url);
	    $("#mainForm").attr("target","Preview");
	    $("#mainForm").submit(function(){
			var width = $("#bWidth").val();
			var heigth= $("#bHeight").val();
	        var newwin=window.open('','Preview','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width='+ width + ',height=' + heigth );
	        newwin.opener = null;
	    });
		$("#mainForm").submit();
	}
</script>
<body style="">

<div class="unit html5editor">
	<div class="container">
		<div class="unit header">
			<div class="container" style="position:relative;">
			<h3>360度元件</h3>
			<ul id="menu" style="">
			   <li id="li_template"><a id="t_template" href="#">Templates</a></li>
			   <li><a id="t_undo" href="#">Undo</a></li>
			   <li><a id="t_preview" href="#">Preview</a></li>
			   <li><a id="t_save" href="#">Save</a></li>
			</ul>
			</div>
		</div>
		<div class="unit body">
			<div class="columns on-2 same-height">
				<div id="div_left" class="column elastic content " style="">
					<div id="div_preview" class="container full-height" style="">
						<div id="div1" style="width:<?php echo $bWidth; ?>px;height:<?php echo $bHeight; ?>px">
						    <img id="showImg" style="display:none;"/>
							<div class="icon" style="">
								<img id="rotateImg"/>
								<div id="rotateIcon" style="">                         
								</div>								
							</div>							
						</div>
                    </div>
				</div>
				<div class="column fixed sidebar" style="width: 250px;">
					<div class="container full-height" >
						<p><strong>參數設置：</strong></p>
                        <form id="mainForm" method="post" action="">
						<div style="border: 1px solid #aaa;">
						    Background <br/>                        
                            <span><input type="text" readonly id="tmp_bFile" value="點擊上傳圖片"/>
							<input type="button" id="btn_bUpload" value="上傳" disabled="disabled"/></span><br/>
                            
							<!--select id="bSize" name="bSize"/> 
								<option value="0">1024x768</option>
								<option value="1">&nbsp;&nbsp;854x480</option>
								<option value="2">1024x600</option>
								<option value="3">&nbsp;&nbsp;800x600</option>							
							</select>
                            <input type="radio" value="h" name="bOrientation" checked="checked"/>水平
							<input type="radio" value="v" name="bOrientation"/>垂直-->
                            寬<input type="text" readonly class="short" name="bWidth" id="bWidth"  value="<?php echo $bWidth; ?>"/>
                			高<input type="text" readonly class="short" name="bHeight" id="bHeight" value="<?php echo $bHeight; ?>"/>							
                            <input type="hidden" name="bOrientation" value="<?php echo $bOrientation; ?>"/>
							<input type="hidden" name="bFileName" id="bFileName" />
							<input type="hidden" name="rFileName" id="rFileName" />
							<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>"/>
							<input type="hidden" name="book_id" id="book_id" value="<?php echo $bookid; ?>"/>
							<input type="hidden" name="page_id" id="page_id" value="<?php echo $pageid; ?>"/>
							<input type="hidden" name="template_id" id="template_id"/>
							<input type="hidden" name="user_temp" id="user_temp" value="<?php echo $user_temp; ?>" />
							<input type="hidden" name="template_desc_old" id="template_desc_old" />
							<input type="hidden" name="template_desc" id="template_desc" />
							<input type="hidden" name="templateid" id="templateid" />
							<input type="hidden" id="save_template" name="save_template"/>
							<input type="hidden" id="lFileName" name="lFileName" />
							<input type="hidden" id="ownerPath" name="ownerPath" value="<?php echo $ownerPath ?>"/>
						</div>
						<br/>
						<div style="border: 1px solid #aaa;">
						360 Action Object<br/>
                        <input type="button" id="btn_rUpload" value="圖片上傳"/><br/>				
						坐標&nbsp;&nbsp;&nbsp;&nbsp;
                        X：<input id="rPX" name="rPX" class="coordinates" type="text" size="5" maxlength="4"/> 
                        Y：<input id="rPY" name="rPY" class="coordinates" type="text" size="5" maxlength="4"/><br/>
                        尺寸&nbsp;&nbsp;&nbsp;&nbsp;
                        寬：<input id="rWidth" name="rWidth" class="coordinates" type="text" size="5" maxlength="4"/> 
                        高：<input id="rHeight" name="rHeight" class="coordinates" type="text" size="5" maxlength="4"/><br/>
                        圖片数目<select name="rNumber" id="rNumber">
                                    <option value="12">12</option><option value="18">18</option>
                                    <option value="24">24</option><option value="36">36</option>
                               </select>
						旋转方向<select name="rOrientation" id="rOrientation">
                                    <option value="0">水平</option><option value="1">垂直</option>
                               </select><br/>
						指示圖标背景
                        <input type="text" readonly id="noticeColor" name="noticeColor" value="0,255,0"/><br/>
                        
						初始狀態<select id="rDisplay" name="rDisplay"/>
                                   <option value="">顯示</option><option value="none">隱藏</option>
                               </select><br/>
                        <div id="link_area" style="display:none;">
                        Link圖標<span><input type="text" readonly id="tmp_lFile" value="點擊上傳圖片"/>
                         <input id="btn_lUpload" type="button" value="上傳" disabled="disabled" /></span><br/>
                         				
						Link圖標 X：<input id="lPX" name="lPX" class="coordinates" type="text" size="5" maxlength="4" disabled="disabled" /> Y：<input id="lPY" name="lPY" class="coordinates" disabled="disabled"  type="text" size="5" maxlength="4"/>
                       </div>
						
						</div>
                        </form>
                         <div class="div_file_upload">
						<form id="bForm" encType="multipart/form-data" method="post" action="uploadBackground">   
						    <input id="bFile"name="bFile" type="file" size="15"/>
                            <input type="submit" value="上傳"/>
						</form>                        
						</div>			
						             			
						<?php echo form_open_multipart('upload/index',array('id' => 'rotateForm', 'style' => 'display:none;')); ?>							
							
							文件名請以【01--36】順序命名排列好，否則將不會被加入隊列，例：01.jpg，25.png
							<br/><?php echo form_upload(array('name' => 'Filedata', 'id' => 'upload'));?>
							
						<?php echo form_close();?> 
						</div>
                        
                         <div class="div_file_upload">
						<form id="lForm" encType="multipart/form-data" method="post" action="<?php echo base_url();?>rotate360/uploadLinkIcon/<?php echo $user_temp;?>">   
						   <input id="lFile" name="lFile" type="file" size="15" />
                            <input type="submit" value="上傳" />
						</form>
                        </div>
                        
						<div id="div_save" style="padding:10px;">
							同時保存模板：
							<input type="checkbox" id="chk_saveTemplate" />
							<input type="text" name="template_desc_new" id="template_desc_new" value="<?php echo $bookname ." P".$pageid; ?>"/>
						</div>
						
						<div id="div_loadTemplate" style="padding:10px; display:none;" >
						    請選擇模板：
							<select id="sel_templates">
							</select>
						</div>					
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>