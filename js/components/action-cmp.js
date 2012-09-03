(function($){
	var cmpContainer;	
	var Vars  = {};
	
    Chidopi.Action = {};
	
	Chidopi.action = Chidopi.Action; // alias
	
	Chidopi.Action.init = function(vars){
		
	    cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		_init_dialog();
		
		$("#bar_action").click(function(){
			_init_action_dialog();
			$("#action_dialog").dialog("open");		
		});
		
		$("#sel_action_type").change(function(){
			_updateButtonArea();		
		});	
		
		$("#sel_action_type").change();
		
		/*-------------- Image upload =----------------*/
		$("#actFileName").click(function(){	
			openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_action_",
				onComplete: function (url,size) {					
					$("#actWidth, #act_origin_width").val(size.w);
					$("#actHeight, #act_origin_height").val(size.h);
				}
			});
		});
		
		$("#btn_actCancel").click(function(){
			$("#actFileName").val('');
			$("#actWidth, #act_origin_width").val(50);
			$("#actHeight, #act_origin_height").val(50);
		});/* -------------- Image upload End----------------*/
		
		/* ------------------- Sound Upload -----------------------  */
		$("#actSound").click(function(){
			 openKCFinder({
				field:this,
				type: "audio",
				prefix: Vars.bookid+"_"+Vars.pageid+"_sound_"
			});		
		});
		
		$("#btn_sCancel").click(function(){
		    $("#actSound").val('');
	    });
		/* -------------- sound upload End----------------*/
		
		$("#actRstoreSize").click(function(){
			var origin_width =  $("#act_origin_width").val();
			var origin_height = $("#act_origin_height").val();			
		    if(origin_width) $("#actWidth").val(origin_width);
			if(origin_height) $("#actHeight").val(origin_height);
		});	
	}
	
	Chidopi.Action.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		
		var id =json.id;
		var title = json.actTitle;
		var type= "action";
		_setNewFeatureToJson(json);		
		var value = JSON.stringify(json);
		_createActionComponent(json, vars);
		Global.createComponent(id, type, value, title);
	}
	
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _init_dialog(){
		
        $("#action_dialog").dialog({
			title: Chidopi.lang.title.action,
			autoOpen: false, 
			width:400,
			height:430,
			modal: true,
			buttons: [
			    {
			    text  : Chidopi.lang.btn.ok,
			    click : function() {
				  			  
				  var id = $("#action_id").val();
				  var json_prefix = "act";
				  var title = $("#actTitle");
				  var type="action";
				  var subType=$("#sel_action_type").val();
							  
				  if(!id){						
						id= type + "_" + subType + "_" +  (++Global.number);	
	
						if(!title.val()){
							title.val(id);
						}															
						$("#action_id").val(id);
						$("#act_zindex").val(Global.number);
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_createActionComponent(json);
						Global.createComponent(id, type, value, title.val());					
						
					}else{						
						if(!title.val()){
							title.val(id);
						}
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
	
						_updateActionComponent(cmpContainer, json);
						updateComponent(id, type, value, title.val());
					}				  
				  $(this).dialog("close");
			  } 
			  },
			  {
			  text  : Chidopi.lang.btn.create,
			  click : function(){
					var title = $("#actTitle");
					var type="action";
					var subType=$("#sel_action_type").val();
					
					var id = type + "_" + subType + "_" +  (++Global.number);				
					if(!title.val()){
						title.val(id);
					}
					$("#actPX, #actPY").val(0);
					$("#action_id").val(id);
					$("#act_zindex").val(Global.number);
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
					var value = JSON.stringify(json);
					_createActionComponent(json);	
					Global.createComponent(id, type , value, title.val());
					$(this).dialog("close");
			  }
			  },
			  {
			  text  : Chidopi.lang.btn.cancel,
			  click : function() {$(this).dialog("close");}
			  }
			],
			open: function(event, ui) { 
			   //$("#sel_link_type").change();
			   _reload_action_dialog_data();
			}
		});       
	}

	function _createActionComponent(json, sys_vars){
	
		var the_vars = sys_vars ? sys_vars : Vars;
		var name = json.actTitle;		
		var id = json.id, json_prefix = "act"; 
		var style = "left: " + json.actPX + "px; top: " + json.actPY + "px;" + "z-index:" + json.zIndex + ";";
		var sizeStyle = "width: " + json.actWidth + "px; height: " + json.actHeight + "px;";
		var url = json.actFileName ? the_vars.base_url + the_vars.user_res_path + '/' + json.actFileName 
		          : the_vars.base_url + "css/images/link_default_50x50.png";
		if(!json.lFileName){			
			sizeStyle += 'background-color:rgba(0,0,0,0.3);';
		}

		var html = '';
		if(json.actionType == "area"){		    
			 html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute; ' + 
			 sizeStyle + style +' " '+
			'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut = "$(\'.closebox\',this).hide();" >' + 
			'<span>'+ name +'</span>' +
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			'</div>';
		}else{
			html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' + style +'" '+
			'onMouseOver="$(\'.closebox, .lChange\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut = "$(\'.closebox, .lChange\',this).hide();" >' + 
			'<img id="pic_' + id + '" src="' +  url +'" style="' + sizeStyle +'" />'+					
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +			
			'</div>';
		}
	
		the_vars.cmp_container.append(html);
		var cmp = $("#"+id);
		var h_id = "cmp_" + id;
		
		if(json.actionType == "area"){
		   _setResizable(cmp, json, json_prefix);		   
		}else{
			var pic = $("#pic_" +id);
   			_setResizable(pic, json, json_prefix);
		}		
	
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
	
	function _updateActionComponent(container, json){
		
		var url = json.actFileName ? Vars.base_url + Vars.user_res_path + '/' + json.actFileName 
		                           : Vars.base_url + 'css/images/link_default_50x50.png';
		var json_prefix= "act";
		var h_id = "cmp_" + json.id;
		var color = json.actFileName? 'rgba(0,0,0,0.3);' : '';
		var id= json.id;
		if(json.actionType == "area"){
			
			var cmp = $("#"+id);
			cmp.css("width", json.actWidth + "px").css("height", json.actHeight + "px")  
			   .css({left: json.actPX + "px", top: json.actPY + "px"});			
			cmp.resizable( "destroy" )
			   .resizable({
					autoHide: true,
					distance: 20,
					aspectRatio: json.aspectRatio ? json.originWidth / json.originHeight : false,
					start: function(event, ui) {
					},
					stop: function(event, ui) {
						var hidden = $("#"+h_id);
						width = parseInt(cmp.css("width").replace("px","")),
						height = parseInt(cmp.css("height").replace("px",""));
						var json=JSON.parse(hidden.val());
						json[json_prefix +"Width"] = width;
						json[json_prefix +"Height"] = height;
						hidden.val(JSON.stringify(json));
					}
				});
			$("#" +id + ">span").html(json.actTitle);
		}else{
			var pic = $("#pic_" +id);
			pic.attr('src',url).css("width", json.actWidth + "px").css("height", json.actHeight + "px");
			if(color) pic.css("background-color", color);
			pic.parent().css({width: json.actWidth + "px", height: json.actHeight + "px" });	
			pic.parent().parent().css({left: json.actPX + "px", top: json.actPY + "px"});
			
			pic.resizable( "destroy" );
			
			pic.resizable({
				autoHide: true,
				distance: 20,
				aspectRatio: json.aspectRatio ? json.originWidth / json.originHeight : false,
				start: function(event, ui) {
				},
				stop:  function(event, ui) {
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
		
	}

	
	function _init_action_dialog(cmp_id){
		if(cmp_id){
			
		}else{
			$("#action_dialog input, select").val("");
			$("#sel_action_type option:first").attr("selected","selected");
			$("#actColoring option:first").attr("selected","selected");
			$("#actPX,#actPY").val(0);
			$("#actWidth, #actHeight").val(50);
			$("#actUrl").val("http://");
		}
	}
	
	function _reload_action_dialog_data(){
		// reload lSound select
		/*var sel = $("#actSound");
		var sel_val = sel.val();
		$("option",sel).remove();
		sel.append('<option value="">--</option>');
		for(key in Global.sounds){		
			var option = '<option value="' + key + '">'+Global.sounds[key] + '</option>';
			sel.append(option);
		}
		sel.val(sel_val);
		*/
		var sel_page = $("#actPage");
		//var sel_jump = $("#actJump");
		var page_value = sel_page.val();
		//var jump_value = sel_jump.val();
		$("option", sel_page).remove();
		//$("option", sel_jump).remove();
		
		var fragment = $("<select/>");
		//var fragment2 = $("<select/>");		
		$.ajax({
			url: Vars.base_url + 'motionbox/loadpageInfo',
			data: { bookid: Vars.bookid, pageid: Vars.pageid },
			type: "POST",
			dataType: 'json',
			success: function (data, textStatus, jqXHR){
				for (var i in data){
					fragment.append('<option value="' + data[i].id +'">'+data[i].title + '</option>');
					//fragment2.append('<option value="' + data[i].index +'">第'+ (data[i].index+1)+ "頁--" +data[i].name + '</option>');
				}
				sel_page.append(fragment.html());
				sel_page.val(page_value);
				
				//sel_jump.append(fragment2.html());
				//sel_jump.val(jump_value);
			},
			error: function(jqXHR, textStatus, errorThrown){
				dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
			}
		});
		
		// edit link dont change type [button, url, page, area]
		if($("#action_id").val()) {
			$("#sel_action_type option").each(function(){
				var _this = $(this);
				//_this.attr("disabled", !_this.attr("selected"));
			});
		}else{ 
			 $("#sel_action_type option").attr("disabled",false);
		}
		
		$("#sel_action_type").change();	   
		_setOriginSize();	
	}
	
	function _setOriginSize(){
		
		var ori_width = $("#act_origin_width");
		var ori_height = $("#act_origin_height");		
		if( !ori_width.val() || !ori_height.val()){
		    var img = $("#actFileName").val();
			if(img){
			    var image = new Image();				
				image.onload = function(){
				    ori_width.val(this.width);
					ori_height.val(this.height);
			    };
				image.src = Vars.base_url + Vars.user_res_path + '/' + img;
			}else{
			    ori_width.val(50);
				ori_height.val(50);
			}
		}
	}
	
	function _updateButtonArea(){
		var type= $("#sel_action_type").val();		
		var area1 = $("#action_edit_area1");
		var sub = $("#action_dialog .sub_action");
		sub.hide();
		$("input,select",sub).attr("disabled",true);
		
        if(type == "area"){
		    area1.hide();
			$("input, select",area1).attr("disabled",true);
		}else{
			area1.show();
			$("input, select",area1).attr("disabled",false);
		    var area = $("#action_edit_" + type);
			if(area.size()){
				area.show();
				$("input, select", area).attr("disabled",false);
			}
		}
		/*if (type=="url"){
			area1.show();
			$("input, select",area1).attr("disabled",false);
			area2.show();
			$("input",area2).attr("disabled",false);
			area3.hide();
			$("select",area3).attr("disabled",true);
		}else if (type=="page"){
			area1.show();
			$("input, select",area1).attr("disabled",false);
			area2.hide();
			$("input",area2).attr("disabled",true);
			area3.show();
			$("select",area3).attr("disabled",false);
		}else{
			area1.hide();
			$("input, select",area1).attr("disabled",true);
			area2.hide();
			$("input",area2).attr("disabled",true);
			area3.hide();
			$("select",area3).attr("disabled",true);
		}*/
	}
})(jQuery);