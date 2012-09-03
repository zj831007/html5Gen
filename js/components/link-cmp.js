(function($){
		
	var cmpContainer;	
	var Vars  = {};
	
    Chidopi.Link = {};
	
	Chidopi.link = Chidopi.Link; // alias
	
	Chidopi.Link.init = function(vars){
		
		cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		_init_dialog();
		 
		$("#bar_link").click(function(){
			_init_link_dialog();
			$("#link_dialog").dialog("open");		
		});
		
		/*-------------- link Image upload =----------------*/
		$("#lFileName").click(function(){
			 openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_link_",
				onComplete: function (url,size) {					
					$("#lWidth, #l_origin_width").val(size.w);
					$("#lHeight, #l_origin_height").val(size.h);
				}
			});
		});
		
		$("#btn_lCancel").click(function(){
			$("#lFileName").val('');
			$("#lWidth, #l_origin_width").val(50);
			$("#lHeight, #l_origin_height").val(50);
		});/* -------------- link Image upload End----------------*/
		
		/*-------------- link Image2 upload =----------------*/
		$("#lFileName2").click(function(){
			 openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_link_",				
			});
		});
		
		$("#btn_lCancel2").click(function(){
			$("#lFileName2").val('');		
					
		});/* -------------- link Image2 upload End----------------*/
		
		/* ------------------- Link Sound Upload -----------------------  */
		$("#lSound").click(function(){
			openKCFinder({
				field:this,
				type: "audio",
				prefix: Vars.bookid+"_"+Vars.pageid+"_sound_"
			});
		});
		$("#btn_lsCancel").click(function(){
		    $("#actSound").val('');
	    });
		/* ------------------- Link Sound Upload End -----------------------  */
		
		$("#lRstoreSize").click(function(){
			var origin_width =  $("#l_origin_width").val();
			var origin_height = $("#l_origin_height").val();			
		    if(origin_width) $("#lWidth").val(origin_width);
			if(origin_height) $("#lHeight").val(origin_height);
		});		
	}
	
	function _init_dialog(){
	    $("#link_dialog").dialog({
			title: Chidopi.lang.title.link,
			autoOpen: false, 
			width:450,
			height:400,
			modal: true,
			buttons: [
			    { 
				text: Chidopi.lang.btn.ok,
				click: function() { 
				  var id = $("#link_id").val();
				  var json_prefix = "l";
				  var title = $("#lTitle");
				  var type="link";
				  var subType=$("#sel_link_type").val();
	
				  if(!id){
						
						id= type + "_" + subType + "_" +  (++Global.number);	
						
						if(!title.val()){
							title.val(id);
						}						
						$("#link_id").val(id);
						$("#link_zindex").val(Global.number);
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_createLinkComponent(json);	
						Global.createComponent(id, type, value, title.val());					
						
					}else{
						
						if(!title.val()){
							title.val(id);
						}
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_updateLinkComponent(cmpContainer, json);
						Global.updateComponent(id, type, value, title.val());
					}
					// if subType == "button"
					// add to Button Array for other component to select Active Button
					if(subType =="button"){
						Global.buttons[id] = title.val();
					}
				  
				  $(this).dialog("close");
			  } 
			  },
			  {
			  text  : Chidopi.lang.btn.create,
			  click : function(){
				  
					var title = $("#lTitle");
					var type="link";
					var subType=$("#sel_link_type").val();
					
					var id = type + "_" + subType + "_" +  (++Global.number);				
					if(!title.val()){
						title.val(id);
					}
					$("#lPX, #lPY").val(0);
					$("#link_id").val(id);
					$("#link_zindex").val(Global.number);
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
					var value = JSON.stringify(json);
					_createLinkComponent(json);	
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
			   _reload_link_dialog_data();
			}
		});
	}
	
	Chidopi.Link.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		
		var id =json.id;
		var title = json.lTitle;
		var type= "link";
		_setNewFeatureToJson(json);
		var value = JSON.stringify(json);
		_createLinkComponent(json, vars);
		Global.createComponent(id, type, value, title);
	}
	
	function _init_link_dialog(cmp_id){
		if(cmp_id){
			
		}else{
			$("#link_dialog input").val("");
			$("#sel_link_type").val("button");
			
			$("#lPX,#lPY").val(0);
			$("#lWidth, #lHeight").val(50);
		}
		
	}
	
	function _reload_link_dialog_data(){
		// reload lSound select
		var sel = $("#lSound");
		var sel_val = sel.val();
		$("option",sel).remove();
		sel.append('<option value="">--</option>');
		for(key in Global.sounds){		
			var option = '<option value="' + key + '">'+Global.sounds[key] + '</option>';
			sel.append(option);
		}
		sel.val(sel_val);
		
		_setOriginSize();	
	}
	
	function _setOriginSize(){
		
		var ori_width = $("#l_origin_width");
		var ori_height = $("#l_origin_height");		
		if( !ori_width.val() || !ori_height.val()){
		    var img = $("#lFileName").val();
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
	
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _createLinkComponent(json, sys_vars){ 
	
	    var the_vars = sys_vars ? sys_vars : Vars;
		
	    var id = json.id, json_prefix = "l";
		
	    var url = json.lFileName ? the_vars.base_url +  the_vars.user_res_path + '/' + json.lFileName 
		          : the_vars.base_url + "css/images/link_default_50x50.png";
		
		var style = "left: " + json.lPX + "px; top: " + json.lPY + "px;" + 
		            "z-index: " + json.zIndex + ";";

		var sizeStyle = "width: " + json.lWidth + "px; height: " + json.lHeight + "px;";
	
		if(!json.lFileName){			
			sizeStyle += 'background-color:rgba(204,204,204,0.5);';
		}
		
		var url2 = json.lFileName2 ? the_vars.base_url + the_vars.user_res_path + '/' + json.lFileName2 : '';
		
		var html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' + style +'" '+
			'onMouseOver="$(\'.closebox, .lChange\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut = "$(\'.closebox, .lChange\',this).hide();" >' + 
			'<img id="pic_' + id + '" src="' +  url +'" style="' + sizeStyle +'" />'+					
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			
			(json.lFileName2 ? '<span class="lChange" style ="display:none;right: -25px; position: absolute;top: 25px;"><a id="change_' + 
			id + '" style="cursor:pointer" href="javascript:void(0);">'+ Chidopi.lang.btn.toggle +'</a></span>' : '' ) +
			'</div>';
        
		the_vars.cmp_container.append(html);
		var cmp = $("#"+id);
		var pic = $("#pic_" +id);
		var h_id = "cmp_" + id;
		//pic.load(function(){					
		//	var _this = $(this),
		//	width = parseInt(_this.css("width").replace("px","")),
		//	height = parseInt(_this.css("height").replace("px",""));
			_setResizable(pic, json, json_prefix);
		//});

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
		
		if(json.lFileName2){				    
			var changeLink = $("#change_" + id);
			changeLink.toggle(
				function(){pic.attr('src', url2);},
				function(){pic.attr('src', url);}
			);
			changeLink.bind("dblclick",function(event){event.stopPropagation();});
		}
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
	}
	
	function _updateLinkComponent(container, json){
		var url = json.lFileName ? Vars.base_url + Vars.user_res_path + '/' + json.lFileName 
		                         : Vars.base_url + 'css/images/link_default_50x50.png';
		
		var color = json.lFileName? 'rgba(204,204,204,0.5);' : '';
		var id= json.id;
		var h_id = "cmp_" + json.id;
		var pic = $("#pic_" +id);
		pic.attr('src',url).css("width", json.lWidth + "px").css("height", json.lHeight + "px");
		if(color) pic.css("background-color", color);
		pic.parent().css({width: json.lWidth + "px", height: json.lHeight + "px" });	
		pic.parent().parent().css({left: json.lPX + "px", top: json.lPY + "px"});
		
		pic.resizable( "destroy" );
		//_setResizable(pic, json, "l");
		var json_prefix= "l";
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
		
		var changeLink = $("#change_" + id);
		if(changeLink.size()) changeLink.parent().remove();
		
		var url2 = json.lFileName2 ? Vars.base_url +  Vars.user_res_path + '/' + json.lFileName2 : '';
		if(url2){
			var html = $("#" + id);
			html.append('<span style ="right: -25px; position: absolute;top: 25px;"><a id="change_' + 
						 id + '" style="cursor:pointer" href="javascript:void(0);">'+ Chidopi.lang.btn.toggle +'</a></span>' );
			changeLink = $("#change_" + id, html);
			changeLink.toggle(
				function(){pic.attr('src', url2)},
				function(){pic.attr('src', url)}
			);
			changeLink.bind("dblclick",function(event){event.stopPropagation();});		
		}		
	}
	
})(jQuery);