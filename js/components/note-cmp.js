(function($,Global){
		
	var cmpContainer;	
	var Vars  = {};
	
    Chidopi.Note = {};
	
	Chidopi.note = Chidopi.Note; // alias
	
	Chidopi.Note.init = function(vars){
		
		cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		_init_dialog();
		
		$("#bar_note").click(function(){
			_init_note_dialog();
			$("#note_dialog").dialog("open");		
		});
		
		$("#nDisplay").change(function(){
		   var $_this =  $(this);
			var nButton = $("#nButton");
			var nHideAction = $("#nHideAction");
			if($_this.val()){
				nButton.attr("disabled",false);
				nHideAction.attr("disabled",false);
				$("#note_area1").show();
			}else{
				nButton.attr("disabled",true);
				nHideAction.attr("disabled",true).attr("checked",false).change();
				$("#note_area1").hide();
			}
		});
		
		$("#nLoadAction").change(function(){
			var $_this =  $(this);
			var tr_load = $("#tr_note_load_action");
			
			if($_this.attr("checked")){			
				$("input,select", tr_load).attr("disabled",false);
				tr_load.show();
			}else{
				$("input,select", tr_load).attr("disabled",true);
				tr_load.hide();
			}
		});
		
		$("#nLoadAction").change();
		
		$("#nHideAction").change(function(){
			var $_this =  $(this);
			var tr_hide = $("#tr_note_hide_action");
			if($_this.attr("checked")){
				$("input,select",tr_hide).attr("disabled",false);
				tr_hide.show();
			}else{
				$("input,select",tr_hide).attr("disabled",true);
				tr_hide.hide();
			}
		});
		$("#nHideAction").change();
	}
	
	Chidopi.Note.createComponent = function(component, vars){
	    var json = JSON.parse(component);		
		var id =json.id;
		var title = json.nTitle;
		var type= "note";
		_setNewFeatureToJson(json);
		var value = JSON.stringify(json);
		_createNoteComponent(json, vars);
		Global.createComponent(id, type, value, title);
	}
	
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _init_dialog(){
		$("#note_dialog").dialog({
			title: Chidopi.lang.title.note,
			autoOpen:false,
			width:500,
			height:600,
			modal: true,
			buttons:[
			    {
				text  : Chidopi.lang.btn.ok,
				click : function(){
					var id = $("#note_id").val();
					var json_prefix = "n";
					var title = $("#nTitle");
					var type="note";
					if(!id){
						id= type + "_" + (++Global.number);	
										
						$("#note_id").val(id);
						$("#note_zindex").val(Global.number);
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_createNoteComponent(json);
						Global.createComponent(id, type, value, title.val());
						
					}else{
						
						if(!title.val()){
							title.val(id);
						}
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
	
						_updateNoteComponent(cmpContainer, json);
						Global.updateComponent(id, type, value, title.val());	
					}
					$(this).dialog("close");
				}
			    },
			    {
				text  : Chidopi.lang.btn.create,
				click : function(){
				    var title = $("#nTitle");
					var type="note";
					
					var id= type + "_" + (++Global.number);				
					if(!title.val()){
						title.val(id);
					}
					$("#nPX, #nPY").val(0);
					$("#note_id").val(id);
					$("#note_zindex").val(Global.number);
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
					var value = JSON.stringify(json);
					_createNoteComponent(json);	
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
			   _reload_note_dialog_data();
			}
		});
	}
	
	function _init_note_dialog(cmp_id){

		var dialog = $("#note_dialog");
		if(cmp_id){
			
		}else{
			
			$("input[type!=checkbox], #nDisplay",dialog).val("");
			$("#nPX, #nPY").val(0);
			$("#nWidth").val(200);
			$("#nHeight").val(50);
			// other select first option
			$("#nFont option:first, #nFontSize option:first").attr("selected","selected");
			$("#nLoad2D, #nLoad3DY, #nLoad3DX, #nHide2D, #nHide3DX, #nHide3DY," +
			  " #nLoadOpacity, #nHideOpacity, #nLoadDelay, #nHideDelay").val(0).change();
			$("#nLoadSpeed, #nHideSpeed").val(1.0).change();
			$("input[type=checkbox]",dialog).attr("checked",false);
			$("#nTitle").val(Chidopi.lang.msg.inputTitle); 
		}
		
		//reload_note_dialog_data();
	}
	
	function _reload_note_dialog_data(){
		// reload nButton select
		var sel = $("#nButton");
		var sel_val = sel.val();
		$("option",sel).remove();
		sel.append('<option value=""></option>');	
		for(key in Global.buttons){		
			var option = '<option value="' + key + '">'+Global.buttons[key] + '</option>';
			sel.append(option);
		}
		sel.val(sel_val);
		$("#nLoad2D, #nLoad3DY, #nLoad3DX, #nHide2D, #nHide3DX, #nHide3DY, " 
		  +" #nLoadOpacity,  #nHideOpacity, #nLoadDelay, #nHideDelay").each(function(){
			if(!$(this).val()) $(this).val(0);
		}).change();
		$("#nLoadSpeed, #nHideSpeed").each(function(){
			if(!$(this).val()) $(this).val(1);
		}).change();
		$("#nDisplay, #nLoadAction, #nHideAction").change()
	
	}

	function _createNoteComponent(json, sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;
		
	    var id = json.id, json_prefix = "n";		
		var	style = "left: " + json.nPX + "px; top: " + json.nPY + "px;" + 
		            "z-index: " + json.zIndex + ";";
		var	sizeStyle = "width: " + json.nWidth + "px; height: " + json.nHeight + "px;";

		var html = '<div id="' + id + '" class="component" style=" '+
			'background:none no-repeat center center rgba(0,0,0,0.1);' + style +
			' display:inline-block; position: absolute;" '+
			'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut="$(\'.closebox\',this).hide();" >' + 
			'<span style="font-size:medium; background-color:transparent;">'+ json.nTitle +'</span>' +
			'<textarea id="text_' + id + '" style= "' + sizeStyle + ' background-color: rgba(255,255,255,1); '+
			'font-family:'+ json.nFont +'; font-size:'+ json.nFontSize +'; line-height:1.5em;  resize: none;  " > ' +
			'demo</textarea>' +
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			'</div>';
			
		the_vars.cmp_container.append(html);
	
		var cmp = $("#"+id);
		var h_id = "cmp_" + id;
		var text = $("#text_"+id);
		text.resizable({
			autoHide: true,
			distance: 20,
            aspectRatio: json.aspectRatio ? json.nWidth / json.nHeight : false,
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
	
	function _updateNoteComponent(container, json){
		var id= json.id;
		var cmp = $("#"+id);
		var h_id = "cmp_" + id;
		var text = $("#text_"+id);	
		var json_prefix= "n";
		$("#" +id + ">span").html(json.nTitle);

		text.css("font-family",json.nFont)
		    .css("font-size",json.nFontSize)
			.parent().css("width", json.nWidth + "px").css("height", json.nHeight + "px");
			
		text.resizable( "destroy" )
		    .resizable({
			    autoHide: true,
				distance: 20,
				aspectRatio: json.aspectRatio ? json.nWidth / json.nHeight : false,
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
		cmp.css("top", json.nPY + "px").css("left", json.nPX + "px");		  
	}
	
})(jQuery,Global);