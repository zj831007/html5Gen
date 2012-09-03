(function($){
		
	var cmpContainer;	
	var Vars  = {};
	
    Chidopi.Audio = {};
	
	Chidopi.audio = Chidopi.Audio; // alias
	
	Chidopi.Audio.init = function(vars){
		
		cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
		
		_init_dialog();
		
		$("#bar_audio").click(function(){
			_init_audio_dialog();
			$("#audio_dialog").dialog("open");
		});
			
		$("#aPlay").change(function(){
			var _this = $(this);
			var area2 = $("#audio_area2");
			var area1 = $("#audio_area1");
			if(_this.val() == "loop"){
				area2.hide();
				$("#aEndAction").attr("disabled", true);
				area1.hide();
				$("#aPage").attr("disabled",true);
			}else{
			   area2.show();
			   $("#aEndAction").attr("disabled", false);
			   $("#aEndAction").change();
			}
		});	
		
		$("#aEndAction").change(function(){
			var $_this =  $(this);
			var aPage = $("#aPage");
			if($_this.val() == "page"){
				aPage.attr("disabled",false);
				$("#audio_area1").show();
			}else{
				aPage.attr("disabled",true);
				$("#audio_area1").hide();
			}
		});
		
		$("#aFileName").click(function(){
			  openKCFinder({
				field:this,
				type: "audio",
				prefix: Vars.bookid+"_"+Vars.pageid+"_audio_"
			});
		});
		
		$("#btn_aCancel").click(function(){
			$("#aFileName").val('');
		});
	}
	
	Chidopi.Audio.createComponent = function(component, vars){
		
	    var json = JSON.parse(component);		
		var id =json.id;
		var title = json.iTitle;
		var type= "audio";	
		var value = JSON.stringify(json);
		Global.createComponent(id, type, value, title);
	}
	
	function _init_dialog() {
		
	    $("#audio_dialog").dialog({
			title: Chidopi.lang.title.audio,
			autoOpen:false,
			width:400,
			height:320,
			modal: true,
			buttons:[
			    {
				text  : Chidopi.lang.btn.ok,
				click : function(){
										
					var id = $("#audio_id").val();				
					var json_prefix = "a";
					var title = $("#aTitle");
					var type="audio";
					if(!id){
						
						id= type + "_" + (++Global.number);	
						
						if(!title.val()){
							title.val(id);
						}
										
						$("#audio_id").val(id);								
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						Global.createComponent(id, type, value, title.val());				
						
					}else{
						
						if(!title.val()){
							title.val(id);
						}
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);				
						Global.updateComponent(id, type, value, title.val());	
					}
					
					$(this).dialog("close");
				}
			    },
			    {
				text  : Chidopi.lang.btn.create,
				click : function(){
				    var json_prefix = "a";
					var title = $("#aTitle");
					var type="audio";
					var id= type + "_" + (++Global.number);
					if(!title.val()){
						title.val(id);
					}									
					$("#audio_id").val(id);								
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
					var value = JSON.stringify(json);
					Global.createComponent(id, type, value, title.val());	
				}
			    },
			    {
				text  : Chidopi.lang.btn.cancel,
				click : function(){$(this).dialog("close");}			
			    }
			],
			open: function(event, ui) { 
			   _reload_audio_dialog_data();
			}
		});
	}
	
	function _init_audio_dialog(cmp_id){

		var dialog = $("#audio_dialog");
		if(cmp_id){
			
		}else{		
			$("input[type!=checkbox], #aEndAction",dialog).val("");
			//$("select option:first",dialog).attr("selected","selected");
			//alert($("select",dialog).size());
			$("#aPlayOnLoad").attr("checked",false);
			$("select",dialog).each(function(){
				$("option:first",this).attr("selected","selected");
			});
			
		}
	}
	
	function _reload_audio_dialog_data(){
		// reload aButton select
		var sel = $("#aButton");
		var sel_val = sel.val();
		$("option",sel).remove();
		sel.append('<option value=""></option>');		
		for(key in Global.buttons){		
			var option = '<option value="' + key + '">'+Global.buttons[key] + '</option>';
			sel.append(option);
		}
		sel.val(sel_val);
		
		var sel_page = $("#aPage");
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
			},
			error: function(jqXHR, textStatus, errorThrown){
				dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
			}
		});
		$("#aPlay").change();
		$("#aEndAction").change();
	}

})(jQuery);
