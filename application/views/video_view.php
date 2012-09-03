<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?php echo base_url();?>css/elastic.css" rel="stylesheet"/>	
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/colorpicker.css" rel="stylesheet"/>
<link href="<?php echo base_url();?>css/LoadingBar.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>js/jquery-1.4.4.min.js" ></script>
<script src="<?php echo base_url();?>js/jquery-ui-1.8.16.custom.min.js" ></script>
<script src="<?php echo base_url();?>js/common.js" ></script>
<script src="<?php echo base_url();?>js/jquery.form.js" ></script>
<script src="<?php echo base_url();?>js/elastic.js" ></script>
<script src="<?php echo base_url();?>js/dialog.js" ></script>	
<script src="<?php echo base_url();?>js/jquery.multiselect.min.js"></script>
<script src="<?php echo base_url();?>js/colorpicker/colorpicker.js"></script>
<script src="<?php echo base_url();?>js/colorpicker/eye.js"></script>
<script src="<?php echo base_url();?>js/colorpicker/utils.js" ></script>
<script src="<?php echo base_url();?>js/nav.js"></script>
<script src="<?php echo base_url();?>js/json_form/form2js.js"></script>
<script src="<?php echo base_url();?>js/json_form/js2form.js"></script>
<script src="<?php echo base_url();?>js/json_form/json2.js"></script>
<script src="<?php echo base_url();?>js/json_form/jquery.toObject.js"></script>
<script src="<?php echo base_url();?>js/components.js"></script>
<script src="<?php echo base_url();?>js/LoadingBar.js"></script>
<style>
#bg_dialog table , #video_dialog table {width:100%; line-height: 2.2em; margin-top:10px; margin-bottom:0px;border:1px solid #aaa;}
#bg_dialog table td.title, #video_dialog table td.title { }
#bg_dialog table td , #video_dialog table td { width:80px; border-bottom: 1px solid #AAAAAA;border-left: 1px solid #AAAAAA;}

.short { width: 35px;}
</style>
<script>
var dialog = window.chidopi;
//var sizeArray = [[1024,768],[854,480],[1024,600],[800,600]];

function loadData(){
	var settings = <?php echo $settings ?>;
	var cmp_settings = <?php echo $cmp_settings ?>;
	Global = <?php echo $Global ?>;

	$("#bOrientation").val(settings.bOrientation );
	$("#tmp_bsFileName, #tmp_bsFile").val( settings.bsFileName );
	$("#tmp_bFileName, #tmp_bFile").val( settings.bFileName ); 
	$("#tmp_bWidth").val($("#bWidth").val());
	$("#tmp_bHeight").val($("#bHeight").val());
	//$("#tmp_bSize").val( settings.bSize ); 
	$("#tmp_bColor").val( settings.bColor );	
	$("#tmp_bsLoop").attr( "checked", ( settings.bsLoop === 'true' ) );

	updateBackgroundArea();
	
	if(Global.sounds instanceof Array) Global.sounds = {}; 
    if(Global.buttons instanceof Array) Global.buttons = {}; 

	var sel = $("#lSound");
	for(key in Global.sounds){		
		var option = '<option value="' + key + '">'+Global.sounds[key] + '</option>';
		sel.append(option);
	}
	
	var links = Global.components.link;
	if(links){
		for(var id in links){
		   var uid = "cmp_" + id;
		   var component = cmp_settings[uid];
		   var json =JSON.parse(component);
		   var json_prefix = "l";
		   var title = json[json_prefix+"Title"];
		   createComponent(id, "link", component, title);
		   var linkType = json['linkType'];
		   var position = {left:json["lPX"], top: json["lPY"]};
		   var src = json['lFileName'];	
		   createVisualComponent(id, src, json_prefix, position);
		}
	}
	
	var videos = Global.components.video;
	if(videos){
		for(var id in videos){
	
			var uid = "cmp_" + id;
			var component = cmp_settings[uid];
			var json =JSON.parse(component);
			var json_prefix = "v";
			var title = json[json_prefix+"Title"];
			createComponent(id, "video", component, title);
			var width = json["vWidth"];
			var height = json["vHeight"];
			var position = {left:json["vPX"], top: json["vPY"]};
			createVideoComponent(id, 'css/images/movie-clap.png', json_prefix, width, height, title, position);
			var form = document.getElementById("video_dialog");
			js2form(form, json);			
		}
	}
}
$(function(){	
	if('<?php echo $isAdd ?>' != '1'){		
		loadData();
	}else{
		updateBackgroundArea();
		init_video_dialog();
	}
	
	$("#vButton").click(function (){
		var _this = $(this);
		if(_this.val()){
			editComponent(_this.val(),'link');
		}else{ 
			init_link_dialog();
			$("#link_dialog").dialog("open");	
		}
    });
	
	$("#menu li").button();
	
	$("#t_preview").click(function(){
		if( !$("#video_id").val()){
			dialog.alert('Error',"請先編輯視頻");
		}else{
			updateCmpData();
			doPreview();
		}
	});

	$("#t_save").click(function(){
		if( !$("#video_id").val()){
			dialog.alert('Error',"請先編輯視頻");
		}else{	
			updateCmpData();	
			//$("#div_save").dialog("open");
				var queryString = $('#mainForm').formSerialize();					
			$.ajax({
				type: "post",
				url: '<?php echo base_url();?>video/save', 
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
					dialog.alert("Error",errorThrown);
				}
			});
			window.top.LoadingBar.show();				
		}
	});
		
});

/**
 * update Background CallBack
 */
function updateBackgroundArea(){
	
	var background = $("#div-background");
	var bFileName = $("#tmp_bFileName").val();
	var url = "";
	if(bFileName){
		url= "<?php echo base_url();?>temp/<?php echo $user_temp;?>/"+bFileName;
	}else{
		url= "none";
	}

	background.css("background-color",$("#tmp_bColor").val());
	background.css("background-image","url("+url+")");
	
	//var indexW = $("#bOrientation").val()=="h"? 0 : 1;		  
	//var indexH = $("#bOrientation").val()=="h"? 1 : 0;
	//var size = $("#tmp_bSize").val();
	//background.css("width",sizeArray[size][indexW] +"px");
	//background.css("height",sizeArray[size][indexH]+"px");
	var width = $("#bWidth").val();
	var height = $("#bHeight").val();
	background.css("width", width+"px");
	background.css("height",height+"px");
}

/* ------------------ components function -----------------------*/ 
function createVisualComponent(id, src, json_prefix, position){
	
	var url = "<?php echo base_url().'temp/'.$user_temp; ?>/" + src;
	var style = "";
	if(position){
		style = "left: " + position.left + "px; top: " + position.top + "px;";
	}	
    var html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' + style +'" '+
			   'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			   'onMouseOut = "$(\'.closebox\',this).hide();" >' + 
			   '<img id="pic_' + id + '" src="' +  url +'" />'+
			   '<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			   'onclick="removeComponent(\''+ id+'\')">' +
			   '<span class="ui-icon ui-icon-closethick closebox"></span></a>' +
			   '</div>';

	$("#div-background").append(html);
	var cmp = $("#"+id);
	var pic = $("#pic_" +id);
	var h_id = "cmp_" + id;
	
	pic.load(function(){
		var _this = $(this),
		    width = parseInt(_this.css("width").replace("px","")),
			height = parseInt(_this.css("height").replace("px",""));
		$(this).resizable({
			autoHide: true,
		    distance: 20,
			aspectRatio: width / height,
			start: function(event, ui) {
			},
			stop:  function(event, ui) {
			    var hidden = $("#"+h_id);
				width = parseInt(_this.css("width").replace("px","")),
				height = parseInt(_this.css("height").replace("px",""));
				
				var json=JSON.parse(hidden.val());
				json[json_prefix +"Width"] = width;
				json[json_prefix +"Height"] = height;
				hidden.val(JSON.stringify(json));
    		}
		});
	});
	
	cmp.draggable({
		appendTo: 'parent',
		containment: 'parent',
		start: function(event, ui) {
		},
		stop: function(event, ui) {
			var hidden = $("#"+h_id);
			var json=JSON.parse(hidden.val());
			json[json_prefix +"PX"] = $(this).css("left").replace("px","");
			json[json_prefix +"PY"] = $(this).css("top").replace("px","");
			hidden.val(JSON.stringify(json));
		}
	});
	
	// resizable-handle icon z-index
	$("#"+id +" .ui-resizable-handle").css("z-index","auto");
	
	$("#vButton").val(id);
}

function updateVisualComponent(id, src, size){
	var url = "<?php echo base_url().'temp/'.$user_temp; ?>/" + src;
	var pic = $("#pic_" +id);
	pic.attr('src',url);
	if(size){
	    pic.css("width", size.width + "px");
		pic.css("height", size.height + "px");
		pic.parent().css({width: size.width + "px", height:size.height + "px" });
		pic.resizable( "option" , { aspectRatio : size.width / size.height } );
	}
}


function createVideoComponent(id, src, json_prefix, init_width, init_height, name, position){
	if(!name) name = id
	var style = "";
	if(position){
		style = "left: " + position.left + "px; top: " + position.top + "px;";
	}

	var html = '<div id="' + id + '" class="component" style="width: '+ init_width +'px; height: '+init_height+'px; '+
	           'background:url('+ src +') no-repeat center center rgba(0,0,0,0.5);' + style +
	           ' display:inline-block; position: absolute;" '+
			   'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			   'onMouseOut = "$(\'.closebox\',this).hide();" >' + 
			   '<span>'+ name +'</span>' +
			   //'<img id="pic_' + id + '" src="' +  src +'" />'+
			   '<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			   'onclick="removeComponent(\''+ id+'\')">' +
			   '<span class="ui-icon ui-icon-closethick closebox"></span></a>' +
			   '</div>';
    $("#div-background").append(html);
    var cmp = $("#"+id);
	var h_id = "cmp_" + id;
	//pic.load(function(){
	cmp.resizable({
		autoHide: true,
		aspectRatio: 16 / 9,
		grid: [10, 10],
		distance: 20,		
		start: function(event, ui) {
		},
		stop:  function(event, ui) {
			var hidden = $("#"+h_id);
			var json=JSON.parse(hidden.val());
			var width = $(this).css("width").replace("px","");
			var height = $(this).css("height").replace("px","");
			json[json_prefix +"Width"] = width;
			json[json_prefix +"Height"] = height;
			hidden.val(JSON.stringify(json));
			
			$("#"+ json_prefix + "Width").val(width);
			$("#"+ json_prefix + "Height").val(height);
		}
	});
	//});
	
	cmp.draggable({
		appendTo: 'parent',
		containment: 'parent',
		start: function(event, ui) {
		},
		stop: function(event, ui) {
			var hidden = $("#"+h_id);
			var json=JSON.parse(hidden.val());
			var left = $(this).css("left").replace("px","");
			var top = $(this).css("top").replace("px","");
			
			hidden.val(JSON.stringify(json));
						
			$("#"+ json_prefix + "PX").val(left);
			$("#"+ json_prefix + "PY").val(top);
			
		}
	});
	
	// resizable-handle icon z-index
	$("#"+id +" .ui-resizable-handle").css("z-index","auto");
}
function updateVideoComponent(id, title){
	$("#" +id + ">span").html(title);
}
/* ------------------ components function End -----------------------*/ 

/**
 * removeComponent success CallBack
 */
function removeCallBack(type){
	if(type == "link"){
	    $("#vButton").val('');
	}else if(type == "video"){
		$('#vForm')[0].reset();
		$('#vFileTitle').val('');
		$("#vFileName").val('');
		$("#video_id").val('');
	}
}

/**
 * video upload success CallBack
 */
function videoCallBack(){
	createVideo();
}

/**
 * update badkground , video input value to hidden
 */
function updateCmpData(){
	$("#global").val(JSON.stringify(Global));
	
	$("#bFileName").val($("#tmp_bFileName").val()).attr("title",$("#tmp_bFile").val());
	//$("#bSize").val($("#tmp_bSize").val());
	$("#bColor").val($("#tmp_bColor").val());
	$("#bsFileName").val($("#tmp_bsFileName").val()).attr("title",$("#tmp_bsFile").val());
	$("#bsLoop").val($("#tmp_bsLoop").attr("checked"));	
	
	var dialog = $("#video_dialog");
	var id = $("#video_id").val();
	var json = $("input[type!=file], select",dialog).toObject({mode: 'combine'});				
	var value = JSON.stringify(json);
	$("#cmp_"+id).val(value);
}

function doPreview(){
	 var url = "<?php echo base_url();?>video/preview";
		
        $("#mainForm").attr("action",url);
	    $("#mainForm").attr("target","Preview");
	    $("#mainForm").submit(function(){
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

</head>
<body>
<div class="unit">
	<div class="container">
		<div class="unit header">
			<div class="container" style="position:relative;">
			<h3>Video元件</h3>
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
						 <div id="div-background" style="">
						    <img id="showImg" style="display:none;"/>							
						</div>
                    </div>
				</div>
				<div class="column fixed sidebar" style="width: 250px;">
					<div class="container" style="height:500px; overflow-y:scroll;">
                        <table cellpadding="0" cellspacing="0">
                        <tr><th style="text-align:left">背景設定</th></tr>
                        <tr><td>
                        <!-- background dialog -->
						<?php $this->load->view("components/background",array('display'=>'show')); ?>
                        <!-- background dialog end -->
                        </td></tr>
                        </table>
                        
                        <table cellpadding="0" cellspacing="0">
                        <tr><th style="text-align:left">視頻設定</th></tr>
                        <tr><td>
                        <!-- video dialog -->
						<?php $this->load->view("components/video",array('display'=>'show'));?>
                        <!-- video dialog end -->
                        </td></tr>
                        </table>
                    </div>
				</div>
			</div>
		</div>		
	</div>
</div>

<form name="mainForm" id="mainForm" method="post">
    <input type="hidden" name="global" id="global" />
    <input type="hidden" name="bOrientation" id="bOrientation" value="<?php echo $bOrientation; ?>"/>
    <input type="hidden" name="bWidth" id="bWidth" value="<?php echo $bWidth; ?>"/>
    <input type="hidden" name="bHeight" id="bHeight" value="<?php echo $bHeight; ?>"/>
    <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>"/>
    <input type="hidden" name="book_id" id="book_id" value="<?php echo $bookid; ?>"/>
    <input type="hidden" name="page_id" id="page_id" value="<?php echo $pageid; ?>"/>							
    <input type="hidden" name="user_temp" id="user_temp" value="<?php echo $user_temp; ?>" />
    <input type="hidden" name="ownerPath" id="ownerPath" value="<?php echo $ownerPath ?>"/>
    <input type="hidden" name="bFileName" id="bFileName" title=""/ >
    <!--input type="hidden" name="bSize" id="bSize" value="0"/-->
    <input type="hidden" name="bColor" id="bColor" value="#ffffff"/>
    <input type="hidden" name="bsFileName" id="bsFileName" title=""/>
    <input type="hidden" name="bsLoop" id="bsLoop" />
</form>

<!-- link dialog -->
<?php $this->load->view("components/link",array('flag'=>'button'));?>
<!-- link dialog end -->
</body>
</html>