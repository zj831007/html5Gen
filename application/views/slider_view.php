<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Slider元件</title>
	<link href="<?php echo base_url();?>css/elastic.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>css/slider/coda-slider.css" rel="stylesheet" type="text/css" />
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
	<script src="<?php echo base_url();?>js/uploadify/jquery.uploadify.v2.1.4.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/colorpicker/colorpicker.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/colorpicker/eye.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/colorpicker/utils.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.multiselect.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.multiselect.filter.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/LoadingBar.js"></script>
	
	
<style type="text/css">

#showImg {
   position:absolute; 
   z-index:1;
}
#menu{
	top:5px;
}

fieldset{
	 border: 1px solid #888;
}

#sortable { list-style-type: none; margin: 0; padding: 0; }
#sortable li { list-style-type:none; float:left ;margin: 3px 3px 3px 0; padding: 1px; width: 100px; /*height: 90px;*/ text-align: center; }
/*#selectable .ui-selecting { background: #FECA40; }
  #selectable .ui-selected { background: #F39814; color: white; }*/

#sortalbe li .cancel { float:right;}

#tabs-1-preview{ 
    width:510px; height:200px; padding:5px;border:1px solid #ccc; 
	text-align:center; vertical-align:middle; display:table-cell;
}
</style>

<script>
    var dialog = window.chidopi;
	//var sizeArray = [[1024,768],[854,480],[1024,600],[800,600]];

	var sliderFile = '' ;
	var sliderNewNames = new Array(0);
	var sliderOldNames = new Array(0);
	var imageNumber = 0;
	var colorPicks = ['#sDockColor','#sDockColorCurrent','#sDockTextColor','#sDockTextColorCurrent'];

	function loadData(settings){
        $("#bFileName, #tmp_bFile").val( settings.bFileName ); 
		//$("#bSize").val( settings.bSize ); 
		$("#bOrientation").val(settings.bOrientation );  
		
		$("#sFileName").val( settings.sFileName ); 
		$("#sPX").val( settings.sPX ); 
		$("#sPY").val( settings.sPY ); 
		$("#sWidth").val( settings.sWidth ); 
		$("#sHeight").val( settings.sHeight ); 
		
		if( settings.sTouch ) $("#sTouch").attr( "checked", true );
		
		if( settings.sAuto ) $("#sAuto").attr( "checked", true );

		if( settings.sArrow ) $("#sArrow").attr( "checked", true );
		$("#sArrowPosition").val( settings.sArrowPosition );
		$("#sArrowFileName").val( settings.sArrowFileName );
		
		if( settings.sDock ) $("#sDock").attr( "checked", true );
		$("#sDockAlign").val( settings.sDockAlign);
		$("#sDockPosition").val( settings.sDockPosition );
		$("#sDockColor").val( settings.sDockColor );
		$("#sDockColorCurrent").val( settings.sDockColorCurrent );
		if( settings.sDockShowText ) $("#sDockShowText").attr( "checked", true );
		$("#sDockTextColor").val( settings.sDockTextColor );
		$("#sDockTextColorCurrent").val( settings.sDockTextColorCurrent );
		$("#sDockSize").val( settings.sDockSize );
				
		$("#sDisplay").val( settings.sDisplay );
		$("#lFileName, #tmp_lFile").val( settings.lFileName );
		$("#lPX").val( settings.lPX );
		$("#lPY").val( settings.lPY );
		
		updatePreviewArea1()
		// 更新預覽圖檔
		url = "<?php echo base_url().'temp/'.$user_temp; ?>/" + settings.sFileName.split(";")[0];						
		updateSliderImage(url);
		
		//if(settings.sArrowFileName){
		    //doSuccess1( settings.sArrowFileName , "success");
			updateArrowArea();
			updatePreviewArea3();
		//}
		
		updateDockColor();
		updateDockArea(); 
		updatePreviewArea4();
		if( settings.sDisplay ){
		    //doSuccess2( settings.lFileName, "success");
			updateLinkArea(); 
			updateShowImg();
		}
	}

	$(function(){
		
		if('<?php echo $isAdd ?>' != '1'){
			var settings = <?php echo $settings ?>;
			loadData(settings);
		}else{
			updatePreviewArea1();
		}

		$("#menu li").button();
		
		$("#t_preview").click(function(){
		    if( !$("#bFileName").val() || !$("#sFileName").val()){
				dialog.alert('Error',"請先上傳圖片");
			}else{
			    doPreview();
			}
		});
		
		$("#t_save").click(function(){
			if( !$("#bFileName").val() || !$("#sFileName").val()){
				dialog.alert('Error',"請先上傳圖片");
			}else{			
				$("#div_save").dialog("open");				
			}
		});


		
		$( "#btn_sUpload" ).button().click(function() {

			initSliderDialog();
			initUploadify();

			var imgs = $("#sFileName").val();
			if(imgs){
				sliderNewNames = imgs.split(";");
				sliderOldNames = sliderNewNames;
			}
			updatePreviewArea();
			sliderNewNames = new Array(0);
            sliderOldNames = new Array(0);

			$("#tabs").tabs();
			$( "#sortable" ).sortable({
				placeholder: "ui-state-highlight",
				forcePlaceholderSize:true
			});
			$( "#sortable" ).disableSelection();

			$( "#div_slider" ).dialog( "open" );
		});

        $("#sTouch").change(function(){
             //$("#sAuto").attr("disabled",$(this).attr("checked"));
			 $("#sAuto").attr( "checked", false );
		});
		
		$("#sAuto").change(function(){
             $("#sTouch").attr( "checked", false );	  
		});

        $("#sPX, #sPY, #sWidth, #sHeight").change(function(){
			
			if( isNaN( parseInt( $(this).val() ) ) ){
				$(this).val(0);
			}

		    updatePreviewArea2();
		});
		
		        
	});


	function initSliderDialog(){

		$( "#div_slider" ).dialog({
			title:"Slider圖片上傳",
			autoOpen: false,
			height: 600,
			width: 600,
			modal: true,
			buttons: {
				"確定": function(){
					var array = new Array(0);
					$("#sortable li").each(function(index){
						array[array.length] = $(this).attr("uid");
					});

                    var string = array.join(";");					
					$("#sFileName").val(string);
					closeUploadDialog();
					$( this ).dialog("destroy");
					var url = '';
					if(array[0]){
						// 更新預覽圖檔,更新settings
						url = "<?php echo base_url().'temp/'.$user_temp; ?>/"+array[0];						
					}
					updateSliderImage(url);

				} ,
				Cancel: function() {
					closeUploadDialog();
					$( this ).dialog("destroy");
				}
			},
			close: function(event, ui) { 
			    closeUploadDialog();
				//$( this ).dialog( "destroy" );
			}

		});
	}

	function updateSliderImage(url){

		var container = $("#firstSliderImg-1");
		
		if(url){

			var img = new Image();
			img.src = url;
			
            $(container).load(function(){

                if( $("#sPX").val() == "" )  $("#sPX").val( 0 );
				if( $("#sPY").val() == "" )  $("#sPY").val( 0 );
				
				if( !$("#sWidth").val() ) $( "#sWidth" ).val( img.width);
				if( !$("#sHeight").val() ) $( "#sHeight" ).val( img.height );

				$("#coda-slider-wrapper-1").css("visibility","visible");

                updatePreviewArea2();


			});

            $(container).attr("src", img.src);			
			
		}else{
            $(container).attr("src",'');
            $("#coda-slider-wrapper-1").css("visibility","hidden");
            $("#sPX, #sPY, #sWidth, #sHeight").val("");
		}
	}

	function closeUploadDialog(){

		$("#upload").unbind("uploadifySelect");
		$("#upload").unbind("uploadifyError");
		$("#upload").unbind("uploadifyComplete");
		$("#upload").unbind("uploadifyAllComplete");
		$('#uploadQueue').remove();
		swfobject.removeSWF('uploadUploader'); 
		$("#upload_previewImg").remove();
        $("#sortable li").remove();
		
	}
	

	function initUploadify(){
	
	    //var testDate = new Date();		
		//filePrefix =  testDate.format("YYYYMMddhhmmss") + "" + Math.round(Math.random()*10000) + "_";
		filePrefix = '<?php echo $pageid."_slider_"?>';
		$("#upload").uploadify({
			uploader: '<?php echo base_url();?>js/uploadify/uploadify.swf',
			script:   '<?php echo base_url();?>js/uploadify.php',
			//buttonImg: '<?php echo base_url();?>js/uploadify/cancel.png',
			cancelImg: '<?php echo base_url();?>js/uploadify/cancel.png',
			folder: '/temp/<?php echo $user_temp;?>',
			fileExt: '*.jpg;*.gif;*.png',
            fileDesc: 'Image Files',
			scriptAccess: 'always',
			multi: true,
			auto:false,
			scriptData:{'filePrefix': filePrefix , 'customTimeStamp':true},
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
			'onComplete' : function (event, queueID, fileObj, response, data) {
			    var jsonRes = jQuery.parseJSON(response);				
                var old_name = jsonRes.old_name;	
                var new_name = jsonRes.file_name;
				if(new_name){
					sliderNewNames[sliderNewNames.length] = new_name;
					sliderOldNames[sliderOldNames.length] = old_name;
				}
			},
			'onAllComplete' : function (event,data) {
				updatePreviewArea();
				sliderNewNames = new Array(0);
				sliderOldNames = new Array(0);		
			}
		});
	}

	function updatePreviewArea(){
		showSliderImages(sliderNewNames,sliderOldNames);
	}

	function updatePreviewArea2(){

        var width = $( "#sWidth" ).val();
		var height = $( "#sHeight" ).val();
		var firstSlider = $( "#firstSliderImg-1" );
		var coda_slider_wrapper = $("#coda-slider-wrapper-1");

		firstSlider.attr( "width", width );
		firstSlider.attr( "height", height );
		coda_slider_wrapper.css( "width", width + "px" );
		$( "#coda-slider-1, #coda-slider-1 .panel" ).css( "width", width + "px" );
		$( "#coda-slider-1, #coda-slider-1 .panel-wrapper" ).css( "height", height + "px" );

        coda_slider_wrapper.css( "left", $( "#sPX" ).val() + "px" );
        coda_slider_wrapper.css( "top", $( "#sPY" ).val() + "px" );	
		
	}   

    function showSliderImages(newNames, oldNames){
        var imageContainer = $("#sortable");
		for(var i = 0; i<newNames.length;i++){
			var url = "<?php echo base_url()?>temp/<?php echo $user_temp;?>/"+newNames[i];
			var cancel = "<?php echo base_url()?>js/uploadify/cancel.png";
			var dom = '<li uid="'+ newNames[i] +'" class="ui-state-default">' +
				      '<a class="a_cancel" style="float:right;cursor:pointer;" onclick="removeImage(\''+ newNames[i] +'\');">' +
				      '<img border="0" src="' + cancel +'" /></a>' +
				      '<img class="sImage" width="100px;" src="' + url + '" title="' + oldNames[i]+'" /></li>';
            var li = $(dom);
            imageContainer.append(li);			
		}

		$(".sImage").click(function(n){
			 var url = $(this).attr('src');
			 loadPreviewImg(url, 500, 200 );
		});
		sliderFile += sliderNewNames.join(";") ;
		showFirstImage();
	}

	function showFirstImage(){
        if($("#sortable li").size()>0){
		   var first = $("#sortable li:first");
		   var url = "<?php echo base_url()?>temp/<?php echo $user_temp;?>/"+ $(first).attr('uid');
           loadPreviewImg( url, 500 , 200 );		  
		}else{
			$("#upload_previewImg").attr("src","");
		}
		updateSliderAreaWidth();
	}

	function updateSliderAreaWidth(){
         $("#sortable").width( $("#sortable li").size() * 120 + 20);
	}

	function removeImage(uid){
        $("li[uid="+uid+"]").remove();       
        showFirstImage();		
	}

	function loadPreviewImg(url, max_width, max_height,container){
		var img = new Image();
		
		if(!$(container).size()){
			 container =  $("#upload_previewImg");
			 if(!$(container).size()){
				 container = $("<img id='upload_previewImg' width='500px'>");
				 $("#tabs-1-preview").append(container);
			 }
		} else {
			$(container).attr("src",'');			
		}
		$(img).load(function(){			
			var width = $(img).attr("width");
			var height = $(img).attr("height");
			if( width / height >= max_width / max_height ){
				if( width > max_width ){					
					height = ( height * max_width ) / width;
					width = max_width;
				}				
			}else{				
				if( height > max_height){  
					width = ( width * max_height ) / height; 
					height = max_height;       
				}
			}
			$(container).css("width",width).css("height",height);
		  });
         img.src = url;
         $(container).attr("src",img.src);
		 //$(img).remove();

	}

    function doPreview(){
		 var url = "<?php echo base_url();?>slider/preview";
		
        $("#mainForm").attr("action",url);
	    $("#mainForm").attr("target","Preview");
	    $("#mainForm").submit(function(){
			//var size = getBackgroundSize();
			var width = $("#bWidth").val();
			var height = $("#bHeight").val();
	        var newwin = window.open('','Preview','location=yes,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no,width=' + width + ', height=' + height );
	        newwin.opener = null;
	    });
		$("#mainForm").submit();
		$("#mainForm").unbind("submit");
	}
	
	/*function getBackgroundSize(){
	    var indexW = $("#bOrientation").val()=="h"? 0 : 1;		  
		var indexH = $("#bOrientation").val()=="h"? 1 : 0;
		var size = $("#bSize").val();
		return [sizeArray[size][indexW], sizeArray[size][indexH]];
	}*/
	
</script>

<style>
	#tr_sDock table , #tr_sArrow table{margin-bottom:0;border:0px solid #aaa;}
	#tr_sDock td , #tr_sArrow td{
		 border-bottom:1px solid #aaa;
		 border-left: 1px solid #aaa;  
	}
	#sTable, #bTable {margin-bottom:0;border:1px solid #aaa;} 
    #sTable td ,  #bTable->td {
		 border-bottom:1px solid #aaa;
		 border-left: 1px solid #aaa;  
	}
	#tr_sDock input[type="text"] { width:40px;}
	#tmp_bFile, #tmp_sFile, #tmp_lFile { width:100px; }
	.div_file_upload {filter:alpha(opacity:0);opacity: 0}
</style>
</head>
<body>
<div class="unit html5editor">
	<div class="container">
		<div class="unit header">
			<div class="container" style="position:relative;">
			<h3>Slider元件</h3>
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
					<div id="div_preview" class="container" style="">
						<div id="div1" style="">
						    <img id="showImg" style="display:none;"/>
							<?php $this->load->view("slider_preview");?>
						</div>
                    </div>
				</div>
				<div class="column fixed sidebar" style="width: 250px;">
					<div class="container" style="height:600px; overflow-y:scroll;">
						<p><strong>參數設置：</strong></p>						
						<form id="mainForm" method="post" action="">
						<table id="bTable"  cellspacing="0" cellpadding="0" width="100%"> 
						    <tr><th colspan="2" style="border-bottom:1px solid #aaa;">背景</th></tr>
						    <tr>
								<td>上傳</td>
								<td>
									<input type="text" readonly id="tmp_bFile" value="點擊上傳圖片"/>
									<input type="button" id="btn_bUpload" value="上傳" disabled="disabled"/>
								</td>
							</tr>
							<tr>
							    <td>尺寸</td>
								<td>
                                寬<input type="text" readonly class="short" name="bWidth" id="bWidth"  value="<?php echo $bWidth; ?>"/>
                				高<input type="text" readonly class="short" name="bHeight" id="bHeight" value="<?php echo $bHeight; ?>"/>
									<!--select id="bSize" name="bSize"> 
										<option value="0">1024x768</option>
										<option value="1">&nbsp;&nbsp;854x480</option>
										<option value="2">1024x600</option>
										<option value="3">&nbsp;&nbsp;800x600</option>							
									</select-->
								</td>
							</tr>
                        </table>				
						<!--div style="border: 1px solid #aaa;"-->
						<table id="sTable" cellspacing="0" cellpadding="0" width="100%"><tbody>
						    <tr><th colspan="2" style="border-bottom:1px solid #aaa;">Slider</th></tr>
							<tr><td colspan="2"><div id="btn_sUpload">图片管理</div></td></tr>
							
							<input type="hidden" name="bOrientation" value="<?php echo $bOrientation; ?>"/>
                            <input type="hidden" name="bWidth" id="bWidth" value="<?php echo $bWidth; ?>"/>
    						<input type="hidden" name="bHeight" id="bHeight" value="<?php echo $bHeight; ?>"/>
							<input type="hidden" name="bFileName" id="bFileName"/ >
							<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>"/>
							<input type="hidden" name="book_id" id="book_id" value="<?php echo $bookid; ?>"/>
							<input type="hidden" name="page_id" id="page_id" value="<?php echo $pageid; ?>"/>							
							<input type="hidden" name="user_temp" id="user_temp" value="<?php echo $user_temp; ?>" />
							<input type="hidden" name="ownerPath" id="ownerPath" value="<?php echo $ownerPath ?>"/>
							
							<input type="hidden" name="template_id" id="template_id"/>
							<input type="hidden" name="template_desc_old" id="template_desc_old" />
							<input type="hidden" name="template_desc" id="template_desc" />
							<input type="hidden" name="save_template" id="save_template" />
                            
							<input type="hidden" name="sFileName" id="sFileName" />
							<input type="hidden" name="sArrowFileName" id="sArrowFileName" />
							<input type="hidden" name="lFileName" id="lFileName" />
						    <tr>
						        <td>坐標</td>
							    <td>X：<input id="sPX" name="sPX" class="coordinates" type="text" size="5" maxlength="4"/> &nbsp;
							        Y：<input id="sPY" name="sPY" class="coordinates" type="text" size="5" maxlength="4"/>
							    </td>
						    </tr>
							    <td>尺寸</td>
							    <td>寬：<input id="sWidth" name="sWidth" class="coordinates" type="text" size="5" maxlength="4"/>&nbsp;
							        高：<input id="sHeight" name="sHeight" class="coordinates" type="text" size="5" maxlength="4"/>
						        </td>
							</tr>
							<tr>
							    <td>切換</td>
								<td>滑動切換 <input type="checkbox" id="sTouch" name="sTouch" value="1"/>&nbsp;
                                    自動播放 <input type="checkbox" id="sAuto" name="sAuto" value="1"/><br/>									
								</td>								
							</tr>
<!-- For Slider Dock  -->
<script>
    $(function(){

	    $('#sDockColor ,#sDockColorCurrent, #sDockTextColor, #sDockTextColorCurrent').each(function(){
			var obj =   $(this)
		    obj.ColorPicker({
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
					obj.css('backgroundColor', '#' + hex);
					obj.val('#' + hex);
					updateDockColor();					
				}
			});			
		});


        $("#sDock, #sDockAlign, #sDockPosition, #sDockSize").change(function(){			
			if($(this).attr("id") == "sDock"){
			    updateDockArea();
			}
		    updatePreviewArea4();
		});
	});

     // SliderDock
	function updateDockColor(){
		$("#coda-nav-1 a").each(function(){
			var obj = $(this);
		   if(obj.hasClass('current')){
			   obj.css({background: $("#sDockColorCurrent").val(), color:$("#sDockTextColorCurrent").val()});
		   }else {
			   obj.css({background: $("#sDockColor").val(), color:$("#sDockTextColor").val()});
		   }
			
		});
	}

	function updatePreviewArea4(){

         if($("#sDock").attr("checked")){
			var nav = $("#coda-nav-1");

			nav.show();

			var ul = $("#coda-nav-1 ul");

			if( $("#sDockPosition").val() == "top"){
				$("#coda-slider-wrapper-1").prepend(nav.remove());
			}else{
				$("#coda-slider-wrapper-1").append(nav.remove());
			}
            
			$("a", ul).each(function(index){
				var self = $(this);
			    self.html($("#sDockShowText").attr("checked")? index+1 : '');
				self.removeClass("small");
				self.removeClass("normal");
				self.removeClass("large");
				self.addClass($("#sDockSize").val());
			});

			if($("#sDockAlign").val() == "left"){
				ul.css("float","left");
				ul.css("width","auto");
			}else if($("#sDockAlign").val() == "right"){
				ul.css("float","right");
				ul.css("width","auto");
			}else{				
				ul.css("float","none");
				ul.css("width", ($("li", ul).width() + 2) * 3  + "px");
			}

		 }else{
             $("#coda-nav-1").hide();
		 }
    }

	function updateDockArea(){

		var tbody = $("#tr_sDock table tbody");
		var sDockShowText = $("#sDockShowText");
        if($("#sDock").attr("checked")){
 			tbody.show();
			$("select,input",tbody).attr("disabled",false);

			sDockShowText.change(function(){
				if($(this).attr("checked")){
			        $("#tr_dockColor").show();
					$("#sDockTextColor, #sDockTextColorCurrent").attr("disabled",false);
				} else {
					$("#sDockTextColor, #sDockTextColorCurrent").attr("disabled",true);
                    $("#tr_dockColor").hide();
				}
				updatePreviewArea4();
			});
            sDockShowText.change();
		}else{
            sDockShowText.unbind("change");
            tbody.hide();
			$("select,input",tbody).attr("disabled",true);
		}
	}

</script>
							 <tr id="tr_sDock"><td colspan="2">
								<table width="100%" >
								<thead>
								    <tr><th colspan="2" style="text-align:left; padding-left:5px; border-bottom:1px solid #aaa;">
									    Dock切換 <input type="checkbox" id="sDock" name="sDock" value="1"/>
									</th></tr>
								</thead>
								<tbody style="display:none;">
								    <tr style="">
								        <td>Dock位置</td>
										<td>
										  水平<select id="sDockAlign" name="sDockAlign">
							                        <option value="left">左</option>
													<option value="center">中</option>
													<option value="right">右</option>
											  </select>
										  垂直<select id="sDockPosition" name="sDockPosition">
                                                    <option value="top">頂部</option>
													<option value="bottom">底部</option>
										       </select>
										</td>
									</tr>
									<tr>
									    <td>Dock顏色</td>
										<td>
										    默認<input type="text" readonly id="sDockColor" name="sDockColor" value="#1e5a47"/>
											選中<input type="text" readonly id="sDockColorCurrent" name="sDockColorCurrent" value="#f0a017"/>
										</td>
									</tr>
									<tr>
									    <td colspan = "2">
										    顯示編號<input type="checkbox" id="sDockShowText" name="sDockShowText" value="1"/>
										</td>
									</tr>
									<tr id="tr_dockColor">
									    <td>編號顏色</td>
										<td> 
										    默認<input type="text" readonly id="sDockTextColor" name="sDockTextColor" value="#FFFFFF"/>
											選中<input type="text" readonly id="sDockTextColorCurrent" name="sDockTextColorCurrent" value="#FFFFFF"/>
										</td>
									</tr>
									<tr>
									    <td>Dock尺寸</td>
										<td>
										    <select id="sDockSize" name="sDockSize">
											    <option value="normal">一般</option>
											    <option value="small">較小</option>
											    <option value="large">較大</option>
										    </select>
										</td>
									</tr>
								</tbody>
								</table>                                 
							<td>
							</tr>
<!-- Slider Dock end -->
							<tr id="tr_sArrow"><td colspan="2" >
							    <table width="100%" >
								<thead>
								    <tr><th colspan="2" style="text-align:left; padding-left:5px; border-bottom:1px solid #aaa;">
									   箭頭切換 <input type="checkbox" id="sArrow" name="sArrow" value="1"/>
									</th></tr>
								</thead>
								<tbody style="display:none;">
								    <tr>
									    <td>箭頭位置</td>
										<td>
										    <select id="sArrowPosition" name="sArrowPosition">
							                   <option value="1">圖片內側</option>
											   <option value="2">圖片外側</option>
										    </select>
										</td>
									</tr>
									<tr>
									    <td colspan ="2">左側箭頭圖片,size:30×30</td>
									</tr>
									<tr>
									    <td colspan = "2">
										<input type="text" readonly id="tmp_sFile" value="點擊上傳圖片"/>
										<input type="button" id="btn_sArrowUpload" value="上傳"  disabled="disabled" />
										</td>
									</tr>
								</tbody>
								</table>
							</td></tr>
                           <tr>
							    <td>初始狀態</td>
	 	 						<td><select id="sDisplay" name="sDisplay" >
							           <option value="">顯示</option>
									   <option value="none">隱藏</option>
							        </select>
								</td>
							<tr>
							<tr id="tr_link1" style="display:none">
							    <td>Link圖標</td>
							    <td>X：<input id="lPX" name="lPX" class="coordinates" type="text" size="5" maxlength="4" disabled="disabled" />
							        Y：<input id="lPY" name="lPY" class="coordinates" disabled="disabled"  type="text" size="5" maxlength="4"/>
								</td>
							</tr>
							<tr id="tr_link2" style="display:none">
							    <td>上傳</td>
								<td>
								    <input type="text" readonly id="tmp_lFile" value="點擊上傳圖片"/>
									<input type="button" id="btn_lUpload" value="上傳" disabled="disabled"/>
								</td>
							</tr>
						</tbody>
						</table>							
						</form>
<!-- For Background -->
<script>
    $(function(){
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

		/*$("#bSize").change(function(){
		    updatePreviewArea1();
		});*/
    });

	function doSuccess(responseText, statusText) {
		var tmp_bsFile = $('#tmp_bFile');
		var parent = tmp_bsFile.parent();
		deleteLoading(parent);
		var result = JSON.parse(responseText);
		if("success" == result.flag){			
			$("#bFileName").val(result.filename);
			updatePreviewArea1();
		}else{
		    dialog.alert("Error", result.msg);
		}
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
	    //var indexW = $("#Orientation").val()=="h"? 0 : 1;		  
		//var indexH = $("#Orientation").val()=="h"? 1 : 0;
		//var size = $("#bSize").val();
		//$(background).css("width",sizeArray[size][indexW] +"px");
		//$(background).css("height",sizeArray[size][indexH]+"px");
		var width = $("#bWidth").val();
		var height = $("#bHeight").val();
		background.css("width", width+"px");
		background.css("height",height+"px");
	}

</script>
                        <div class="div_file_upload">
                        <form id="bForm" encType="multipart/form-data" method="post" >   
								<input id="bFile" name="bFile" type="file" size="15"/>
								<input type="submit" value="上傳" disabled="disabled" />
						</form>
                        </div>
<!-- Background end -->
<!-- For SiderArrow-->
<script>
	$(function(){
        $("#aForm").ajaxForm({
		    //url:'<?php echo base_url();?>common_controller/uploadSingleImage/<?php echo $user_temp;?>/sArrowFile',
			url:'<?php echo base_url();?>common_controller/uploadSinglePic',
			data:{ 
				 user_temp: "<?php echo $user_temp;?>" , 
				 file:'sArrowFile',
				 prefix:"<?php echo $pageid.'_'.'sliderArrow_' ?>"
			},
			success: doSuccess1
		});

		$("#sArrow, #sArrowPosition").change(function(){
            if($(this).attr("id") == "sArrow"){
			    updateArrowArea();
			}
		     updatePreviewArea3();
		});
		
		$("#tmp_sFile").click(function(){
			$('#sArrowFile').click();	
		}).change(function(){
		    if($(this).val()){
                $("#btn_sArrowUpload").attr("disabled",false);
			}
		});
		
		$("#btn_sArrowUpload").click(function(){
			var parent = $(this).parent();
			createLoading(parent);
		    $('#aForm').submit();
		});		
		
		$("#sArrowFile").change(function(){
		    $("#tmp_sFile").val($(this).val());
		    $("#tmp_sFile").change();
		});
		
	});

	 // ArrowImage
	function doSuccess1(responseText, statusText) {
		var tmp_bsFile = $('#tmp_sFile');
		var parent = tmp_bsFile.parent();
		deleteLoading(parent);
        var result = JSON.parse(responseText);
		if("success" == result.flag){		
			$("#sArrowFileName").val(result.filename);
			updatePreviewArea3()
		}else{
		    dialog.alert(responseText);
		}
	}

	 // SliderArrow
	function updatePreviewArea3(){
		
		var background = $("#div1");
		var sArrowFileName = $("#sArrowFileName").val();
		var url = "";
		if(sArrowFileName){
			url= "<?php echo base_url();?>temp/<?php echo $user_temp;?>/"+sArrowFileName;
			$("#coda-nav-right-1 img, #coda-nav-left-1 img").attr("src",url);
		}
		

        if($("#sArrow").attr("checked")){
			$("#coda-nav-left-1, #coda-nav-right-1").show();			
			if($("#sArrowPosition").val() == 2){
				$("#coda-slider-wrapper-1").css("padding","0 30px");
			}else{
                $("#coda-slider-wrapper-1").css("padding","0");
			}
		}else{
            $("#coda-nav-left-1, #coda-nav-right-1").hide();
			$("#coda-slider-wrapper-1").css("padding","0");
		}

	}

	function updateArrowArea(){
        var tbody = $("#tr_sArrow table tbody");
		
        if($("#sArrow").attr("checked")){
 			tbody.show();
			$("select,input",tbody).attr("disabled",false);			
		}else{           
            tbody.hide();
			$("select,input",tbody).attr("disabled",true);
		}

	}
</script>
                        <div class="div_file_upload">
						<form id="aForm" encType="multipart/form-data" method="post" >   
							<input id="sArrowFile" name="sArrowFile" type="file" size="10"/>
							<input type="submit" value="上傳" />
						</form>
                        </div>
<!-- SliderArrow end -->

<!-- For LinkIcon -->
<script>
	$(function(){
		$('#lForm').ajaxForm({
			//url:'<?php echo base_url();?>common_controller/uploadSingleImage/<?php echo $user_temp;?>/lFile',
			url:'<?php echo base_url();?>common_controller/uploadSinglePic',
			data:{ 
				 user_temp: "<?php echo $user_temp;?>" , 
				 file:'lFile',
				 prefix:"<?php echo $pageid.'_'.'link_' ?>"
			},
			success: doSuccess2
		});

		$("#sDisplay").change(function(){
			updateLinkArea();
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

		$("#lPX, #lPY").change(function(){
		    if(isNaN( parseInt( $(this).val() ) ) ){
				$(this).val( 0 );
			}
            updatePreviewArea5();
		});


	});
	
	function updateLinkArea(){
		if($("#sDisplay").val()){
			$("#tr_link1, #tr_link2").show();
			$("#tmp_lFile, #lFileName, #lPX, #lPY").attr("disabled",false);
			if($("#lFileName").val()){
				$("#showImg").show();
			}
		}else{
			$("#tr_link1, #tr_link2").hide();
			$("#tmp_lFile, #lFileName, #lPX, #lPY, #btn_lUpload").attr("disabled",true);
			$("#lForm")[0].reset();
			$("#tmp_lFile").val("點擊上傳圖片")
			$("#showImg").hide();
		}
	}
	 // LinkButton
	function doSuccess2 (responseText, statusText) {
		var tmp_bsFile = $('#tmp_lFile');
		var parent = tmp_bsFile.parent();
		deleteLoading(parent);
		var result = JSON.parse(responseText);
		if("success" == result.flag){		
			$("#lFileName").val(result.filename);
			updateShowImg();
		}else{
			dialog.alert(responseText);
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
				updatePreviewArea5();	
				$("#showImg").show();				
			});
			
			$("#showImg").attr("src", img.src);
		}
	}
	
	function updatePreviewArea5(){
		$("#showImg").css("left",$("#lPX").val() + "px" );
		$("#showImg").css("top",$("#lPY").val() + "px" );
	}

</script>
                        <div class="div_file_upload">
					    <form id="lForm" encType="multipart/form-data" method="post" >   
						Link圖標<input id="lFile" name="lFile" type="file"/>
						        <input type="submit" value="上傳" />
					   </form>
                       </div>
<!-- LinkIcon end -->

<!-- Slider Dialog -->					  
						<div id="div_slider" style="display:none;">							
							<div id="div_sliderImageArea" style="width:100%;">
							    <div id="tabs" style="height:500px; ">
									<UL>										
										<LI><A href="#tabs-1">圖片管理</A>
										<LI><A href="#tabs-2">上傳</A> 
									</UL>
									<div id="tabs-1">
									    <p>可以拖動底部圖片改變次序</p>
									    <div id="tabs-1-preview" style="">
										    <img id="upload_previewImg" width="500px;"/>
										</div>
										<div style="width:520px; overflow-x:scroll;">
									    <UL id='sortable'>									  

										</UL>
										</div>
									</div>
									<div id=tabs-2>
									   <form id="sliderForm" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>?upload/index">
										<input id="upload" type="file" value="" name="Filedata">
										</form>
										<input type="button" onclick="javascript: $('#upload').uploadifyUpload();" value="upload"/>
									</div>
								</div>
							</div>
						</div>
<!-- Slider Diagog End -->
<!-- Save Dialog -->
<script>
$(function(){
    $("#div_save").dialog({
		title:'保存',
		autoOpen: false,
		height: 150,
		width: 300,
		modal: true,
		buttons: {
			"Save": function() {			
				if($("#chk_saveTemplate").attr("checked")){
					$("#save_template").val("Y");
					$("#template_desc").val($("#template_desc_new").val());
				}else{ 
					$("#save_template").val("");
				}
				var queryString = $('#mainForm').formSerialize();					
				$.ajax({
					type: "post",
					url: '<?php echo base_url();?>slider/save', 
					data :queryString,
					dataType : 'json',
					success : function (data, textStatus){
						  window.top.LoadingBar.hide();
						  if(data=="1"){
							   dialog.alert("Save",'保存成功');
						  }else{
							   dialog.alert("Error",'保存失敗');
						  }
					},
					error : function(XMLHttpRequest, textStatus, errorThrown){
						window.top.LoadingBar.hide();
						dialog.alert("Error",errorThrown + " : " + textStatus);
					}
				});
                window.top.LoadingBar.show();
				//$('#mainForm').attr("action","<?php echo base_url();?>slider/save");
				//$("#mainForm").submit();
					
				$( this ).dialog( "close" );
			} ,
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});		
});
</script>
                        <div id="div_save" style="padding:10px;">
							同時保存模板：
							<input type="checkbox" id="chk_saveTemplate" />
							<input type="text" name="template_desc_new" id="template_desc_new" value="<?php echo $bookname ." P".$pageid; ?>"/>
						</div>
<!-- Save Diagog End -->
<!-- Load Template Dialog -->
<script>
$(function(){
	
	if("<?php echo $isAdd ?>" == '1'){
		$("#t_template").click(function(){
			
			$.ajax({
				type: "post",
				url: '<?php echo base_url();?>slider/loadTemplates', 
				data : {userid:'<?php echo $userid;?>', bookid:'<?php echo $bookid;?>'},
				dataType : 'json',
				success : function (data, textStatus){
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
				error : function(XMLHttpRequest, textStatus, errorThrown){
					alert(textStatus + " | " + errorThrown);
				}
			});				
		});
	}else{
		$( "#li_template" ).button( "option", "disabled", true );
	}
	
	$("#div_loadTemplate").dialog({
		title: "選擇模板",
		autoOpen: false,
		height: 200,
		width: 300,
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
			url: '<?php echo base_url();?>slider/loadTemplateById', 
			data : {id:id, user_temp: '<?php echo $user_temp;?>', pageid:'<?php echo $pageid;?>'},
			dataType : 'json',
			success : function (data, textStatus){
					if(data){						
						$("#template_id").val(data.template_id);
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
	

</script>
                        <div id="div_loadTemplate" style="padding:10px; display:none;" >
						    請選擇模板：
							<select id="sel_templates">
							</select>
						</div>
<!-- Template Dialog End -->

					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
</body>
</html>