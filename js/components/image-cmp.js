(function($){
	var cmpContainer;
	var Vars  = {};
    Chidopi.Image = {};	
	Chidopi.image = Chidopi.Image; // alias of  Slider2
	
	Chidopi.Image.init = function(vars){
		
		cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		 _init_dialog();
		 
		$("#bar_img").click(function(){
			_init_img_dialog();
			$("#img_dialog").dialog("open");		
		});
		
		$("#iDisplay").change(function(){
			var $_this =  $(this);
			var iButton = $("#iButton");
			var iHide = $("#iHide");
			var iHideAction = $("#iHideAction");
			if($_this.val()){
				iButton.attr("disabled",false);
				iHide.attr("disabled",false);
				iHideAction.attr("disabled",false);
				$("#div_img_display").show();
			}else{
				iButton.attr("disabled",true);
				iHide.attr("disabled",true);
				iHideAction.attr("disabled",true).attr("checked",false).change();
				$("#div_img_display").hide();
			}
		});
		
		$("#iFileName").click(function(){
			openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_img_",
				onComplete: function (url,size) {					
					$("#iWidth, #i_origin_width").val(size.w);
					$("#iHeight, #i_origin_height").val(size.h);
				}
			});
		});
		
		$("#btn_iCancel").click(function(){
			$("#iFileName").val('');
			$("#iWidth, #i_origin_width").val(50);
			$("#iHeight, #i_origin_height").val(50);
		});
		
		$("#iLoadAction").change(function(){
			var $_this =  $(this);
			var tr_load = $("#tr_img_load_action");
			
			if($_this.attr("checked")){			
				$("input,select", tr_load).attr("disabled",false);
				tr_load.show();
			}else{
				$("input,select", tr_load).attr("disabled",true);
				tr_load.hide();
			}
		});
		$("#iLoadAction").change();
		
		$("#iHideAction").change(function(){
			var $_this =  $(this);
			var tr_hide = $("#tr_img_hide_action");
			if($_this.attr("checked")){
				$("input,select",tr_hide).attr("disabled",false);
				tr_hide.show();
			}else{
				$("input,select",tr_hide).attr("disabled",true);
				tr_hide.hide();
			}
		});
		$("#iHideAction").change();
		
		$("#iRstoreSize").click(function(){
			var origin_width =  $("#i_origin_width").val();
			var origin_height = $("#i_origin_height").val();			
		    if(origin_width) $("#iWidth").val(origin_width);
			if(origin_height) $("#iHeight").val(origin_height);
		});
	}
	
	Chidopi.Image.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		
		var id =json.id;
		var title = json.iTitle;
		var type= "img";
		_setNewFeatureToJson(json);		
		var value = JSON.stringify(json);
		_createImageComponent(json, vars);
		Global.createComponent(id, type, value, title);
	}
	
		
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _init_dialog(){
		$("#img_dialog").dialog({
			title: Chidopi.lang.title.image,
			autoOpen:false,
			width:500,
			height:600,
			modal: true,
			buttons:[
				{
				text : Chidopi.lang.btn.ok, 
				click : function(){
					var id = $("#img_id").val();					
					var json_prefix = "i";
					var title = $("#iTitle");
					var type = "img";
					if(!id){											
						id =  type + "_" + (++Global.number);						
						if(!title.val()){
							title.val(id);
						}						
						$("#img_id").val(id);
						$("#img_zindex").val(Global.number);				
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_createImageComponent(json);
						Global.createComponent(id, type , value, title.val());	
								
					}else{
						
						if(!title.val()){
							title.val(id);
						}
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_updateImageComponent(cmpContainer, json);
						Global.updateComponent(id, type, value, title.val());
					}
					$(this).dialog("close");
				}
				},
				{
				text: Chidopi.lang.btn.create,
				click: function(){
					var type = "img";
					var title = $("#iTitle");
					var id =  type + "_" + (++Global.number);						
					if(!title.val()){
						title.val(id);
					}
					$("#iPX, #iPY").val(0);
					$("#img_id").val(id);
					$("#img_zindex").val(Global.number);	
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
					var value = JSON.stringify(json);
					_createImageComponent(json);	
					Global.createComponent(id, type , value, title.val());
					$(this).dialog("close");
				}
				},
				{
				text: Chidopi.lang.btn.cancel, 
				click:function(){$(this).dialog("close");}
				}
			],
			open: function(event, ui) { 
			   //$("#iDisplay").change();
			   _reload_img_dialog_data();
			}
		});
	}
	
	function _init_img_dialog(cmp_id){
		var img_id = $("#img_id").val();
		if(cmp_id){
			
		}else{
			$("#img_dialog input[type!=checkbox], #iDisplay, #iHide, #iLoadPos, #iHidePos").val("");
			$("#iPX, #iPY ,#iLoad2D, #iLoad3DY, #iLoad3DX, #iHide2D, #iHide3DX, #iHide3DY," +
			  " #iLoadOpacity, #iHideOpacity, #iLoadDelay, #iHideDelay").val(0).change();
			$("#iLoadSpeed, #iHideSpeed").val(1.0).change();
			$("#iWidth, #iHeight").val(50);
			$("#img_dialog input[type=checkbox]").attr("checked",false);
		}

	}
	
	function _reload_img_dialog_data(){
		
		// reload iButton select
		var sel = $("#iButton");
		var sel_val = sel.val()? sel.val():'';
		$("option",sel).remove();
		sel.append('<option value=""></option>');
		for(key in Global.buttons){		
			var option = '<option value="' + key + '">'+Global.buttons[key] + '</option>';
			sel.append(option);
		}

		sel.val(sel_val);

		$("#iLoad2D, #iLoad3DY, #iLoad3DX, #iHide2D, #iHide3DX, #iHide3DY, " 
		  +" #iLoadOpacity,  #iHideOpacity, #iLoadDelay, #iHideDelay").each(function(){
			if(!$(this).val()) $(this).val(0);
		}).change();
		$("#iLoadSpeed, #iHideSpeed").each(function(){
			if(!$(this).val()) $(this).val(1);
		}).change();
		$("#iDisplay, #iLoadAction, #iHideAction").change();
		
		_setOriginSize();
	}

	function _setOriginSize(){
		var ori_width = $("#i_origin_width");
		var ori_height = $("#i_origin_height");
		if( !ori_width.val() || !ori_height.val()){
		    var img = $("#iFileName").val();
			if(img){
			    var image = new Image();				
				image.onload = function(){					
				    ori_width.val(this.width);
					ori_height.val(this.height);
			    };
				image.src = Vars.base_url + Vars.user_res_path + "/" + img;
			}else{
			    ori_width.val(50);
				ori_height.val(50);
			}
		}
	}
		
	function _createImageComponent(json, sys_vars){
		
		var the_vars = sys_vars ? sys_vars : Vars;
		
	    var id = json.id, json_prefix = "i";
		
	    var url =  json.iFileName ? the_vars.base_url + the_vars.user_res_path + '/' + json.iFileName
		           : the_vars.base_url + "css/images/link_default_50x50.png";
		
		var style = "left: " + json.iPX + "px; top: " + json.iPY + "px;"+ 
		            "z-index: " + json.zIndex + ";";

		var sizeStyle = "width: " + json.iWidth + "px; height: " + json.iHeight + "px;";
	
		if(!json.iFileName){			
			sizeStyle += 'background-color:rgba(204,204,204,0.5);';
		}
		
		var html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' + style +'" '+
			'onMouseOver="$(\'.closebox, .lChange\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut = "$(\'.closebox, .lChange\',this).hide();" >' + 
			'<img id="pic_' + id + '" src="' +  url +'" style="' + sizeStyle +'" />'+					
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			'</div>';
			
		the_vars.cmp_container.append(html);
		var cmp = $("#"+id);
		var pic = $("#pic_" +id);
		var h_id = "cmp_" + id;
		pic.load(function(){					
			var _this = $(this),
			width = parseInt(_this.css("width").replace("px","")),
			height = parseInt(_this.css("height").replace("px",""));
			_setResizable(this, json, json_prefix);
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
	
	function _setResizable(component, json, json_prefix){
        var _this = $(component);
		var h_id = "cmp_" + json.id;
		_this.resizable({
			autoHide: true,
			distance: 20,
			aspectRatio: json.aspectRatio ? json.originWidth / json.originHeight : false,
			start: function(event, ui) {
			},
			stop: function(event, ui) {
				var hidden = $("#"+h_id);
				width = parseInt(_this.css("width").replace("px","")),
				height = parseInt(_this.css("height").replace("px",""));
				var json=JSON.parse(hidden.val());
				json[json_prefix +"Width"] = width;
				json[json_prefix +"Height"] = height;
				hidden.val(JSON.stringify(json));
			}
		});
	}
	
	function _updateImageComponent(container, json){
		var url = json.iFileName ? Vars.base_url +  Vars.user_res_path + '/' + json.iFileName 
		          : Vars.base_url + "css/images/link_default_50x50.png";
		var id = json.id;
		var h_id = "cmp_" + json.id;
		var pic = $("#pic_" +id);
		var color = json.lFileName? 'rgba(204,204,204,0.5);' : '';
		pic.attr('src',url).css("width", json.iWidth + "px").css("height", json.iHeight + "px");
		if(color) pic.css("background-color", color);
		pic.parent().css({width: json.iWidth + "px", height: json.iHeight + "px" });
		pic.parent().parent().css({left: json.iPX + "px", top: json.iPY + "px"});
		pic.resizable( "destroy" );
		//_setResizable(pic, json, "i");
		var json_prefix= "i";
		pic.resizable({
			autoHide: true,
			distance: 20,
			aspectRatio: json.aspectRatio ? json.originWidth / json.originHeight : false,
			start: function(event, ui) {
			},
			stop: function(event, ui) {
				var hidden = $("#"+h_id);
				width = parseInt(pic.css("width").replace("px","")),
				height = parseInt(pic.css("height").replace("px",""));
				var json=JSON.parse(hidden.val());
				json[json_prefix +"Width"] = width;
				json[json_prefix +"Height"] = height;
				hidden.val(JSON.stringify(json));
			}
		});
	}
})(jQuery);