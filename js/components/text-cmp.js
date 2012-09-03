(function($,Global,CKEDITOR){
	
	var cmpContainer;
	
	var Vars  = {};
	
    Chidopi.Text = {};
	
	Chidopi.text = Chidopi.Text; // alias
	
	Chidopi.Text.init = function(vars){
		
		cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		_init_dialog();
		
		$("#bar_text").click(function(){
			_init_text_dialog();
			$("#text_dialog").dialog("open");		
		});
		
		/*-------------- Title Background upload =----------------*/
		$("#tmp_tTitleFile").click(function(){
			openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_text_title_",
				onComplete: function (url,size) {					
					$("#tTitleWidth").val(size.w);
					$("#tTitleHeight").val(size.h);
				}
			});
		});
		
		$("#btn_tTitleCancel").click(function(){			
			$('#tmp_tTitleFile').val('');
			$("#tTitleWidth").val(150);
			$("#tTitleHeight").val(50);
		});/* -------------- Title Background upload End----------------*/
		
		/*-------------- Body File upload =----------------*/		
		$("#tmp_tBodyFile").click(function(){			
			openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_text_body_",
				onComplete: function (url,size) {					
					$("#tBodyWidth").val(size.w);
					$("#tBodyHeight").val(size.h);
				}
			});
		});
		
		$("#btn_tBodyCancel").click(function(){
			$('#tmp_tBodyFile').val('');
			$("#tBodyWidth").val(150);	
			$("#tBodyHeight").val(200);
		});/* -------------- Body File upload End----------------*/
		
		/*-------------- Body Background upload =----------------*/
		$("#tmp_tBodyBgFile").click(function(){			 
			 openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_text_body_bg_",
				onComplete: function (url,size) {					
					$("#tBodyFileWidth").val(size.w);
					$("#tBodyFileHeight").val(size.h);
				}
			});
		});
		
		$("#btn_tBodyBgCancel").click(function(){
			$('#tmp_tBodyBgFile').val('');
			$("#tBodyFileWidth").val('');	
			$("#tBodyFileHeight").val('');
		});/* -------------- Body Background upload End----------------*/
		
		var colors = $("#tTitleBgColor, #tTitleColor, #tBodyBgColor");
		colors.each(function(){
			var obj = $(this);
			obj.ColorPicker({
				livePreview: false,
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					$(colpkr).css("z-index","99999");
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					$(colpkr).css("z-index","auto");
					obj.change();
					return false;
				},
				onChange: function (hsb, hex, rgb) {					
					obj.css('backgroundColor', '#' + hex);
					obj.val('#' + hex);
				}
			});
		});
				
		$("#tPosition").change(function(){
            var value = $(this).val();
			if(value == "top" || value == "bottom"){
			    $("#tPY").val(0).attr("readonly", true);
				$("#tPX").attr("readonly",false);
			}else{
			    $("#tPX").val(0).attr("readonly", true);
				$("#tPY").attr("readonly",false);
			}
		});
		$("#tabs-text-dialog").tabs();	
	}
			
	Chidopi.Text.createComponent = function(component, vars){
		vars.user_files_tpl  = "<{$user_res_path}>";
	    var json = JSON.parse(component);		
		var id =json.id;
		var title = json.iTitle;
		var type= "text";
		_setNewFeatureToJson(json);		
		var value = JSON.stringify(json);		
		Global.createComponent(id, type, value, title);
		if(json.tBodyText){
    	    var old_tBodyText = json.tBodyText.replaceAll( vars.user_files_tpl, vars.user_res_path);
			$("#cmp_"+id).data("old_tBodyText",old_tBodyText);
		}
		
		_createTextComponent(json, vars);
	}
	
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _init_dialog(){
	    $("#text_dialog").dialog({
			title:Chidopi.lang.title.text,
			autoOpen:false,
			width:720,
			height:630,
			modal: true,
			buttons:[
			    {
				text  : Chidopi.lang.btn.ok,
				click : function(){					
					var instance = CKEDITOR.instances['tBodyText'];
					var id = $("#text_id").val();
					var json_prefix = "t";					
					var titleText = $("#tTitleText");
					var type="text";
					$("#tBodyText").val(instance.getData());
					if( !$("#tBodyFileHeight").val() || !$("#tBodyFileWidth").val() ){
					   $("#tBodyFileWidth").val($("#tBodyWidth").val());
					   $("#tBodyFileHeight").val($("#tBodyHeight").val());
				    }
					var hidden, json ;
					var old_tBodyText = $('#tBodyText').val();
					var new_tBodyText = '';	
					if(old_tBodyText){
						new_tBodyText = old_tBodyText.replaceAll(Vars.user_res_path, Vars.user_files_tpl);
						$('#tBodyText').val(new_tBodyText);
					}
					
					if(!id){	
									
						id= type + "_" + (++Global.number);
						
						$("#text_id").val(id);
						$("#text_zindex").val(Global.number);
						
						json = $("input[type!=file], select, textarea",this).toObject({mode: 'combine'});
						var value = JSON.stringify(json);						
						hidden = Global.createComponent(id, type, value, titleText.val());
						//_createTextComponent(json);
						
					}else{						
						json = $("input[type!=file], select, textarea",this).toObject({mode: 'combine'});
						var value = JSON.stringify(json);						
						hidden = Global.updateComponent(id, type, value, titleText.val());	
						//_createTextComponent(json);	                
					}
					hidden.data("old_tBodyText","");
					if(new_tBodyText){
						hidden.data("old_tBodyText",old_tBodyText);
					}
					_createTextComponent(json);	
					$(this).dialog("close");
				}
			    },
			    {
				text  : Chidopi.lang.btn.create,
				click : function(){
					var instance = CKEDITOR.instances['tBodyText'];
					var titleText = $("#tTitleText");
					var type="text";
					$("#tBodyText").val(instance.getData());
					
					var old_tBodyText = $('#tBodyText').val();
					var new_tBodyText = '';	
					if(old_tBodyText){
						new_tBodyText = old_tBodyText.replaceAll(Vars.user_res_path, Vars.user_files_tpl);
						$('#tBodyText').val(new_tBodyText);
					}
					var id = type + "_" + (++Global.number);		
					if( !$("#tBodyFileHeight").val() || !$("#tBodyFileWidth").val() ){
						$("#tBodyFileWidth").val($("#tBodyWidth").val());
						$("#tBodyFileHeight").val($("#tBodyHeight").val());
					}
					$("#tPX, #tPY").val(0);
					$("#text_id").val(id);
					$("#text_zIndex").val(Global.number);					
					var json = $("input[type!=file], select, textarea",this).toObject({mode: 'combine'});
					var value = JSON.stringify(json);					
					var hidden =Global.createComponent(id, type , value, titleText.val());
					
					hidden.data("old_tBodyText","");
					if(new_tBodyText){
						hidden.data("old_tBodyText",old_tBodyText);
					}
					_createTextComponent(json);	
					$(this).dialog("close");
				}
			    },
			    {
				text  : Chidopi.lang.btn.cancel,
				click : function(){$(this).dialog("close");}			
			    }
			],
			open: function(event, ui) {
				
				_reload_text_dialog_data(); 				
				var tBodyText = $("#tBodyText");
				var value = tBodyText.val();
				createCkEditor();
				if(value){
					var id = $("#text_id").val();
					value = $("#cmp_" +id).data("old_tBodyText");
					tBodyText.val(value);
				}
				
				var instance = CKEDITOR.instances['tBodyText'];
				instance.setData(value);
			}
		});
	}
	
	function _init_text_dialog(cmp_id){

		var dialog = $("#text_dialog");
		if(cmp_id){
			
		}else{			
			$("input,#tBodyText",dialog).val("");
			$("#tPX, #tPY").val(0);
			$("#tTitleWidth, #tBodyWidth").val(150);
			$("#tTitleHeight").val(50);		
			$("#tBodyHeight").val(200);
			$("#tTitleBgColor, #tTitleColor, #tBodyBgColor").css("background-color","#fff");
			// other select first option
			$("#tTitleFont option:first, #tTitleFontSize option:first, #tTitleAlign option:first, #tPosition option:first").attr("selected","selected");					
		}
	}
	
	function _reload_text_dialog_data(){
	   if( !$("#tBodyBgFileName").val() ){
	       $("#tBodyFileWidth").val('');
		   $("#tBodyFileHeight").val('');
	   }
	   $("#tPosition").change();
	}
	
	function createCkEditor(){
	   
		var instance = CKEDITOR.instances['tBodyText'];
		
		if(instance) {
			//instance.setData("");
			CKEDITOR.remove(instance);
			instance.destroy();		
			instance = null;
		}
	
	    var prefix = Vars.bookid+ "_" + Vars.pageid + "_text_" ; 
		CKEDITOR.config.filebrowserImageUploadUrl = 'kcfinder/upload.php?type=images&prefix=' + prefix;
		CKEDITOR.config.filebrowserImageBrowseUrl = 'kcfinder/browse.php?type=images&prefix=' + prefix;
		CKEDITOR.config.filebrowserVideoBrowseUrl = "kcfinder/browse.php?type=video";
		CKEDITOR.config.user_files_path = /*"../" +*/ Vars.user_res_path;
		CKEDITOR.config.language = Chidopi.lang.code2;
		//CKEDITOR.config.startupFocus = true; 
		//CKEDITOR.config.startupShowBorders = false; 
		CKEDITOR.replace( 
		   'tBodyText',
		   {
			toolbar: 'MyToolbar',
			width: '540',
			height: '200',
			resize_enabled: true
			} );
	}
	
	function _createTextDetail(json, vars){
		var id = json.id;
		var titleUrl  = json.tTitleFileName ? "url(" + vars.base_url + /*"../" +*/ vars.user_res_path + 
		                json.tTitleFileName + ")" : 'none';
		var bodyBgUrl = json.tBodyBgFileName ? "url(" + vars.base_url + /*"../" +*/ vars.user_res_path + 
		                json.tBodyBgFileName + ")" : 'none';
		var bodyUrl   = json.tBodyFileName ? "url(" + vars.base_url + /*"../" +*/ vars.user_res_path +
		                json.tBodyFileName + ")" : 'none';
	    var titleBgColor = json.tTitleBgColor ? json.tTitleBgColor : '',
		    titleColor   = json.tTitleColor   ? json.tTitleColor   : '',
			bodyBgColor  = json.tBodyBgColor  ? json.tBodyBgColor  : '';
		var titleStyle = 'background:' + titleUrl + ' no-repeat center center ' + titleBgColor + '; ' +
			'color: '+ titleColor + '; font-family:'+ json.tTitleFont +'; font-size: '+ json.tTitleFontSize +'; ' +
			'width:' + json.tTitleWidth +'px; height:' + json.tTitleHeight +'px; ' + 
		    'overflow: hidden; text-align:'+ json.tTitleAlign + "; " + 
			'-webkit-background-size:' + json.tTitleWidth + "px "+ json.tTitleHeight + 'px; ' + 
			'-moz-background-size: ' + json.tTitleWidth + "px "+ json.tTitleHeight + 'px; ' + 
			'background-size:' + json.tTitleWidth + "px "+ json.tTitleHeight + 'px; ';
	
		var bodyStyle =  'background:' + bodyUrl + ' no-repeat 0 0 ' + bodyBgColor + '; ' +
			'width:'+ json.tBodyWidth +'px; height:'+ json.tBodyHeight +'px;overflow:hidden; ' + 
			'-webkit-background-size:' + json.tBodyWidth + "px "+ json.tBodyHeight + 'px; ' + 
			'-moz-background-size: ' + json.tBodyWidth + "px "+ json.tBodyHeight + 'px; ' + 
			'background-size: ' + json.tBodyWidth + "px "+ json.tBodyHeight + 'px; ' + 
			((json.tPosition =='left' || json.tPosition == "right") ? 'float:left;' : '');

		var bodyContent = '<div id="body_' + id + '" style="' + bodyStyle + '"; >' + 
		                  '<div style="background: '+ bodyBgUrl + ' no-repeat center center; width: ' + 
						  json.tBodyFileWidth + 'px; height: '+ json.tBodyFileHeight + 'px;">' +
						 ( $("#cmp_" + id).data("old_tBodyText") ? $("#cmp_" + id).data("old_tBodyText") : json.tBodyText ) +
						  // json.tBodyText + 
						  '</div>' +
						  '</div>'
		
		var titleText = '';
		if(json.tTitleText) 
			titleText = '<table width="100%" height="100%" style="margin:0; padding:0;"><tr>'+
			'<td valign="middle" style="padding:10px;">' + json.tTitleText + '</td></tr></table>';
		var style = "";
		var axis = "";
		var content = "";
		switch(json.tPosition){
			case "top":
				style= //'width:' + Math.max(value.title.width, value.body.width) + 'px;' +
				// 'height:' + (parseInt(value.title.height)+ parseInt(value.body.height)) + 'px;' +
				'left:'+ json.tPX + 'px; top: 0;';
				axis = "x";
				content = bodyContent + '<div id="title_'+ id + '" style="' + titleStyle +'" >'+ titleText +'</div>' ;
				break;
			case "bottom":
				style= //'width:' + Math.max(value.title.width,value.body.width) + 'px;' +
				//'height:' + (parseInt(value.title.height)+ parseInt(value.body.height)) + 'px;' +
				'left:'+ json.tPX + 'px; bottom: 0;'; 
				axis = "x";
				content = '<div id="title_'+ id + '" style="' + titleStyle +'" >'+ titleText +'</div>' + bodyContent;
				break;
			case "left":
				style= //'width:' + (parseInt(value.title.width) + parseInt(value.body.width)) + 'px;' +
				//'height:' + Math.max(value.title.height , value.body.height) + 'px;' +
				'top:'+ json.tPY + 'px; left: 0;'; 
				axis = "y";
				content = bodyContent + '<div id="title_'+ id + '" style="float:left;' + titleStyle +'" >'+ titleText +'</div>' ;
				break;
			case "right":
				style= //'width:' + (parseInt(value.title.width) + parseInt(value.body.width)) + 'px;' +
				//'height:' + Math.max(value.title.height , value.body.height) + 'px;' +				   
				'top:'+ json.tPY + 'px; right: 0;'; 
				axis = "y";
				content = '<div id="title_'+ id + '" style="float:left;' + titleStyle +'" >'+ titleText +'</div>' +
					      bodyContent;
		}
		style += "z-index: " + json.zIndex + ";";

		return {style: style, content: content, axis:axis};
	}
	
	function _createTextComponent(json, vars){
		
		var the_vars = sys_vars ? sys_vars : Vars;
		
	    var id = json.id, json_prefix = "t";		
		
		var detail = _createTextDetail(json, the_vars);
		
		$("#" + id).remove();
	
		var html = '<div id="' + id + '" class="component" style=" '+
			'background:none no-repeat center center rgba(0,0,0,0.1);' + detail.style +
			' display:inline-block; position: absolute;" '+
			'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut="$(\'.closebox\',this).hide();" >' + detail.content	+	   
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			'</div>';
		the_vars.cmp_container.append(html);
	
		var cmp = $("#"+id);
		var h_id = "cmp_" + id;
	
		var title = $("#title_"+id);
		title.resizable({
			autoHide: true,
			aspectRatio: json.aspectRatioTitle ? json.tTitleWidth / json.tTitleHeight : false,
			start: function(event, ui) {
			},
			resize: function(event, ui){
				var w = $(this).css("width");
				var h =  $(this).css("height");
				title.css({'-webkit-background-size': w + " " + h,
				           '-moz-background-size': w + " "+ h , 
						   'background-size': w + " "+ h});
			},
			stop:  function(event, ui) {
				var hidden = $("#"+h_id);
				var json=JSON.parse(hidden.val());
				var w = $(this).css("width");
				var h =  $(this).css("height");
				json[json_prefix +"TitleWidth"] = w.replace("px","");
				json[json_prefix +"TitleHeight"] = h.replace("px","");			
				hidden.val(JSON.stringify(json));
			}
		});
		var body =  $("#body_"+id);
		body.resizable({
			autoHide: true,
			aspectRatio: json.aspectRatioBody ? json.tBodyWidth / json.tBodyHeight : false,
			distance: 20,
			start: function(event, ui) {
			},
			resize: function(event, ui){
				var w = $(this).css("width");
				var h =  $(this).css("height");
				body.css({'-webkit-background-size': w + " "+ h,
				          '-moz-background-size': w + " "+ h ,
						  'background-size': w + " "+ h});
			},
			stop:  function(event, ui) {
				var hidden = $("#"+h_id);
				var json=JSON.parse(hidden.val());
				var w = $(this).css("width");
				var h =  $(this).css("height");
				json[json_prefix +"BodyWidth"] = w.replace("px","");
				json[json_prefix +"BodyHeight"] = h.replace("px","");
	
				hidden.val(JSON.stringify(json));
			}
		});
	
		cmp.draggable({
			appendTo: 'parent',
			axis: detail.axis,
			containment: 'parent',
			distance: 20,
			start: function(event, ui) {
			},
			stop: function(event, ui) {
				var hidden = $("#"+h_id);
				var json=JSON.parse(hidden.val());
				if(json.tPosition =="left" || json.tPosition =="right"){
					json[json_prefix +"PY"] = $(this).css("top").replace("px","");
				}else if(json.tPosition == "top" || json.tPosition == "bottom"){
					json[json_prefix +"PX"] = $(this).css("left").replace("px","");
				}			
	
				hidden.val(JSON.stringify(json));
			}
		});
	
		// resizable-handle icon z-index
		$("#"+id +" .ui-resizable-handle").css("z-index","auto");
	}	
	
})(jQuery,Global,CKEDITOR);
