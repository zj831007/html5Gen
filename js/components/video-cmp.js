(function($){
	var cmpContainer;	
	var Vars  = {};
	
    Chidopi.Video = {};
	
	Chidopi.video = Chidopi.Video; // alias
	
	Chidopi.Video.init = function(vars){
		
		cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		_init_dialog();
		
		$("#bar_video").click(function(){
			_init_video_dialog();
			$("#video_dialog").dialog("open");
		});
		
		$("#vDisplay").change(function(){
			_updateDisplayArea();
		});
		$("#vEndAction").change(function(){
			_updateActionArea();
			
		});
		
		$("#vFileName").click(function(){
			 openKCFinder({
				field:this,
				type:'video',
				prefix: Vars.bookid+"_"+Vars.pageid+"_video_",
				onComplete: function (url,size) {					
					$("#actWidth, #act_origin_width").val(size.w);
					$("#actHeight, #act_origin_height").val(size.h);
				}
			});
		});
		
		$("#btn_vCancel").click(function(){
			$("#vFileName").val('');
			$("#vWidth, #vHeight").val(0);
		});
		
		$("#vFileType").change(function(){
			var value = $(this).val();
			var tr_vFileName =$("#tr_vFileName"); 
			var tr_vUrl = $("#tr_vUrl");
			if(value=="file"){
				$(tr_vUrl).hide();
				$("input",tr_vUrl).attr('disabled',true);
				$(tr_vFileName).show();
				$("input",tr_vFileName).attr('disabled',false);
			}else if(value=='url'){
				$(tr_vFileName).hide();
				$("input",tr_vFileName).attr('disabled',true);
				$(tr_vUrl).show();
				$("input",tr_vUrl).attr('disabled',false);
			}
		}).change();
		
					
		$("#vPFileName").click(function(){
			 openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_video_poster_",
				onComplete: function (url,size) {					
					$("#vWidth").val(size.w);
				    $("#vHeight").val(size.h);
				}
			});
		});
		
		$("#btn_vPCancel").click(function(){
			$("#vPFileName").val('');			
		});
		
		$("#vLoadAction").change(function(){
			var $_this =  $(this);
			var tr_load = $("#tr_video_load_action");
			
			if($_this.attr("checked")){			
				$("input,select", tr_load).attr("disabled",false);
				tr_load.show();
			}else{
				$("input,select", tr_load).attr("disabled",true);
				tr_load.hide();
			}
		});
		$("#vLoadAction").change();
		
		$("#vHideAction").change(function(){
			var $_this =  $(this);
			var tr_hide = $("#tr_video_hide_action");
			if($_this.attr("checked")){
				$("input,select",tr_hide).attr("disabled",false);
				tr_hide.show();
			}else{
				$("input,select",tr_hide).attr("disabled",true);
				tr_hide.hide();
			}
		});
		$("#vHideAction").change();
	}

	Chidopi.Video.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		
		var id =json.id;
		var title = json.iTitle;
		var type= "video";
		_setNewFeatureToJson(json);		
		var value = JSON.stringify(json);
		_createVideoComponent(json, vars);
		Global.createComponent(id, type, value, title);
	}
	
	
	function _init_dialog(){
		
		$("#video_dialog").dialog({
			title: Chidopi.lang.title.video,
			autoOpen:false,
			width:500,
			height:600,
			modal: true,
			buttons:[
			    {     
				text  : Chidopi.lang.btn.ok,
				click : function(){
					
					_createVideo();
									
					$(this).dialog("close");
				}
			    },
			    {
				text  : Chidopi.lang.btn.create,
				click : function(){
					var title = $("#vTitle");
					var type="video";
					
					
					var id = id= type + "_" + (++Global.number);
					if(!title.val()){
						title.val(id);
					}
					$("#vPX, #vPY").val(0);
					$("#video_id").val(id);
					$("#video_zindex").val(Global.number);
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
					var value = JSON.stringify(json);
					_createVideoComponent(json);	
					Global.createComponent(id, type , value, title.val());

					$(this).dialog("close");					
				
				}
			    },
			    {
				text  : Chidopi.lang.btn.cancel,
				click : function(){$(this).dialog("close");}
			    }
			],
			open: function(event, ui) { 
			   _reload_video_dialog_data();
			}
		});
	}
	
	function _init_video_dialog(cmp_id){

		var dialog = $("#video_dialog");
		if(cmp_id){
			
		}else{
			
			$("input[type!=checkbox], #vDisplay, #vEndAction, #vLoadPos, #vHidePos",dialog).val("");
			$("#vPX, #vPY ,#vLoad2D, #vLoad3DY, #vLoad3DX, #vHide2D, #vHide3DX, #vHide3DY," +
			  " #vLoadOpacity, #vHideOpacity, #vLoadDelay, #vHideDelay").val(0).change();
			//$("#vVolume").val(0.5).change();
			$("#vLoadSpeed, #vHideSpeed").val(1.0).change();
			$("input[type=checkbox]",dialog).attr("checked",false);
			$("#vWidth, #vHeight").val(0);
			$('#vFileType').val('file');
			$("#vUrl").val("http://");
		}
	}
	
	function _reload_video_dialog_data(){
		
		var sel = $("#vButton");
		var sel_val = sel.val();
		$("option",sel).remove();	
		sel.append('<option value="">--</option>');
		for(key in Global.buttons){		
			var option = '<option value="' + key + '">'+Global.buttons[key] + '</option>';
			sel.append(option);
		}
		sel.val(sel_val);
		
		var sel_page = $("#vPage");
		var page_value = sel_page.val();
		$("option", sel_page).remove();
		var fragment = $("<select/>");
		
		$.ajax({
			url: Vars.base_url + 'motionbox/loadpageInfo',
			data:{ 
				 bookid: Vars.bookid, 
				 pageid: Vars.pageid
			},
			type: "POST",
			dataType: 'json',
			success: function (data, textStatus, jqXHR){
				for (var i in data){
					fragment.append('<option value="' + data[i].id +'">' + data[i].title + '</option>');
				}
				sel_page.append(fragment.html());
				sel_page.val(page_value);
				$("#vDisplay").change();
				$("#vEndAction").change();
				$("#vLoadAction, #vHideAction").change();
			},
			error: function(jqXHR, textStatus, errorThrown){
				dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
			}
		});
			
		$("#vLoad2D, #vLoad3DY, #vLoad3DX, #vHide2D, #vHide3DX, #vHide3DY, " 
		  +" #vLoadOpacity,  #vHideOpacity, #vLoadDelay, #vHideDelay").each(function(){
			if(!$(this).val()) $(this).val(0);
		}).change();
		$("#vLoadSpeed, #vHideSpeed").each(function(){		
			if(!$(this).val()) $(this).val(1);
		}).change();
		$("#vFileType").change();
	}
	
	
	function _createVideo(){
	
		var dialog = $("#video_dialog");
		var id = $("#video_id").val();
		//var src = $("#vPFileName").val() ? $("#vPFileName").val() : 'css/images/movie-clap.png';
		var json_prefix = "v";		
		var title = $("#vTitle");
		var type="video";
		if(!id){			
			id= type + "_" + (++Global.number);	
			
			if(!title.val()){
				title.val(id);
			}
									
			$("#video_id").val(id);
			$("#video_zindex").val(Global.number);
			var json = $("input[type!=file], select",dialog).toObject({mode: 'combine'});
			var value = JSON.stringify(json);
			_createVideoComponent(json);	
			Global.createComponent(id, type, value, title.val());
					
		}else{
			
			if(!title.val()){
				title.val(id);
			}
			var json = $("input[type!=file], select",dialog).toObject({mode: 'combine'});				
			var value = JSON.stringify(json);
			_updateVideoComponent(json);
			Global.updateComponent(id, type, value, title.val());	
		}
	}
	
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
		if(!json.vFileType) {json.vFileType = "file"};
	}
	
	function _createVideoComponent(json, sys_vars){ 
	
		var the_vars = sys_vars ? sys_vars : Vars;
		
		var id = json.id, json_prefix = "v";
		
		var name = json.vTitle ? json.vTitle : id;
		
		var src = json.vPFileName ? "url(" + the_vars.base_url +  the_vars.user_res_path + "/" +  json.vPFileName + ")"
								  : "url(" + the_vars.base_url + 'css/images/movie-clap.png)';
	
		var	style = "left: " + json.vPX + "px; top: " + json.vPY + "px;" + "background-size: " + 
					(json.vPFileName ? "100% 100%;" : "64px 64px;") + 
		            "z-index: " + json.zIndex + ";";
	
		var html = '<div id="' + id + '" class="component" style="width: '+ json.vWidth + 'px; height: ' + json.vHeight + 'px; '+
			'background: '+ src +' no-repeat center center rgba(0,0,0,0.5);' + style +
			' display:inline-block; position: absolute;" '+
			'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut = "$(\'.closebox\',this).hide();" >' + 
			'<span>'+ name +'</span>' +
			//'<img id="pic_' + id + '" src="' +  src +'" />'+
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			'</div>';
		the_vars.cmp_container.append(html);
		var cmp = $("#"+id);
		var h_id = "cmp_" + id;
		cmp.resizable({
			autoHide: true,
			containment: 'parent',
			aspectRatio: json.aspectRatio ? json.vWidth / json.vHeight : false,			
			distance: 20,		
			start: function(event, ui) {
			},
			stop:  function(event, ui) {
				var hidden = $("#"+h_id);
				var json=JSON.parse(hidden.val());
				json[json_prefix +"Width"] = $(this).css("width").replace("px","");
				json[json_prefix +"Height"] = $(this).css("height").replace("px","");
				hidden.val(JSON.stringify(json));
			}
		});
	
		cmp.draggable({
			appendTo: 'parent',
			containment: 'parent',
			distance: 20,
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
	}
	
	function _updateDisplayArea(){
		var $_this =  $("#vDisplay");
		var vButton = $("#vButton");
		if($_this.val()){
			$("#vAuto").attr("disabled",true);
			vButton.attr("disabled",false);
			$("#video_area1").show();
		}else{
			$("#vAuto").attr("disabled",false);
			vButton.attr("disabled",true);
			$("#video_area1").hide();
		}
	}
	
	function _updateActionArea(){
		var $_this =  $("#vEndAction");
		var vPage = $("#vPage");
		var vHideAction = $("#vHideAction");
		if($_this.val() == "page"){
			vHideAction.attr("disabled",true).attr("checked",false).change();
			vPage.attr("disabled",false);
			$("#video_area2").show();
		}else if($_this.val() == "hide"){
			vHideAction.attr("disabled",false);
			vPage.attr("disabled",true);
			$("#video_area2").hide();
		}else{
			vHideAction.attr("disabled",true).attr("checked",false).change();
			vPage.attr("disabled",true);
			$("#video_area2").hide();
		}
	}
	
	function _updateVideoComponent(json){ 
		var id= json.id;
		var h_id = "cmp_" + json.id;
		var component = $("#"+id);
		var json_prefix = "v";
		
		$("#" +id + ">span").html(json.vTitle);
    	var src = json.vPFileName ? "url(" + Vars.base_url +  Vars.user_res_path + "/" +  json.vPFileName + ")"
								  : "url(" + Vars.base_url + 'css/images/movie-clap.png)';
		component.css("background-image",src)
				 .css("background-size",json.vPFileName ? "100% 100%" : "64px 64px")
				 .css("width",json.vWidth + "px")
				 .css("height",json.vHeight+ "px")
				 .css("left", json.vPX + "px")
				 .css("top", json.vPY + "px")
				 .resizable( "destroy" )
		         .resizable({
					autoHide: true,
					containment: 'parent',
					aspectRatio: json.aspectRatio ? json.vWidth / json.vHeight : false,			
					distance: 20,		
					start: function(event, ui) {
					},
					stop:  function(event, ui) {
						var hidden = $("#"+h_id);
						var json=JSON.parse(hidden.val());
						json[json_prefix +"Width"] = $(this).css("width").replace("px","");
						json[json_prefix +"Height"] = $(this).css("height").replace("px","");
						hidden.val(JSON.stringify(json));
					}
				});
	}
	
})(jQuery);