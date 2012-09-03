(function($){
	var cmpContainer;
	var Vars  = {};
	
    Chidopi.Gravity = {};
	
	Chidopi.gravity = Chidopi.Gravity; // alias of  Gravity
		
	// Gravity ko model 
	Chidopi.Gravity.model = {
		id     : ko.observable(),
		title  : ko.observable(),
		x      : ko.observable(),
		y      : ko.observable(),
		width  : ko.observable(),
		height : ko.observable(),
		display: ko.observable(),		
		fileName       : ko.observable(),
		button         : ko.observable(),
		linkButtons    : ko.observableArray(),
		hideMode       : ko.observable(),
		movePage       : ko.observable(),
				
		aspectRatio    : ko.observable(),
		zIndex         : ko.observable(),
		originWidth    : ko.observable(),
		originHeight   : ko.observable(),
		bgColor        : ko.observable(),
		bdColor        : ko.observable(),
		bgColorAlpha   : ko.observable(),
		bdWidth        : ko.observable(),
		type           : ko.observable(),
		    
	};
			
	// ----------- public  methods -----------
	
	Chidopi.Gravity.updateModel = function(json){
	    return _init_model(json);
	}
	
	Chidopi.Gravity.init = function( vars ){ 
	
	    cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
	
	    ko.applyBindings(Chidopi.Gravity.model, document.getElementById("gravity_dialog"));
		 
		_init_dialog();
		 
		$("#bar_gravity").click(function(){
			_init_model();
			//_init_previewArea();
			$("#gravity_dialog").dialog("open");
		});
				
		$('#gBgColor ,#gBdColor').each(function(){
			var obj =   $(this)
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
					return false;
				},
				onChange: function (hsb, hex, rgb) {					
					obj.css('backgroundColor', '#' + hex);
					obj.val('#' + hex);
					obj.change();
				}
			});			
		});
				
		$("#gRstoreSize").click(function(){
			var model = Chidopi.Gravity.model;			
			var origin_width = model.originWidth();
			var origin_height = model.originHeight();
		    if(origin_width) model.width(origin_width);
			if(origin_height)model.height(origin_height);
		});	

		/*-------------- gravity cube upload =----------------*/
		$("#gFileTitle").click(function(){
			var id = $(this).attr("uid");
			openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_gravity_",
				onComplete: function (url,size) {					
					$("#gFileName"+id).val(url);
					setWidth(size.w);
					$("#cubePreview3").css("background-image",
			        'url('+ Vars.base_url + Vars.user_res_path+'/' + url + ")" );
				}
			});
		});
	
		$("#btn_gCancel").click(function(){
			var id = $('#gFileTitle').attr("uid");
			$('#gFileTitle').val('');
			$("#gFileName" + id).val('');
			setWidth(100);
			$("#cubePreview3").css("background-image",'none');
		});/*-------------- gravity cube upload end ----------------*/
		
        $(".face").button().click(function(){
			var $_this = $(this);
			$(".face").removeClass("faceActive");
			$_this.addClass("faceActive");
			var id = $_this.attr("uid");
			var file = $("#gFileName"+id).val();
			$("#gFileTitle").val(file).attr("uid",id);
			$("#cubePreview3").css("background-image", file ?
			                'url('+ Vars.base_url + Vars.user_res_path+'/' + file + ")" : 
							'none');
			var page_value = $("#gMovePage"+id).val();
			$("#gSelPage").val(page_value);
		});
		
		$("#gSelPage").change(function(){
		    var uid = $(".faceActive").attr("uid");
			var val = $(this).val();
			console.log("["+ uid +"]:" +  val );
			$("#gMovePage" + uid).val( val ? val : '' );
			
		});
		
    };
	
	//Chidopi.Gravity.editCallBack = function(sys_vars){}
			
	Chidopi.Gravity.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		var model = Chidopi.Gravity.updateModel(json);
		var id = model.id();
		var title = model.title();
		var type= "gravity";
		//_setNewFeatureToJson(json);
		var value = JSON.stringify(json);
		_createGravityComponent(model, vars);
		Global.createComponent(id, type, value, title);
	}
	
	//--------------- private function below -------------------
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _init_dialog(){
	    $("#gravity_dialog").dialog({
			title: Chidopi.lang.title.gravity,
			autoOpen:false,
			width:600,
			height:450,
			modal: true,
			buttons:[
				{
				text  : Chidopi.lang.btn.ok,
				click : function(){
					
					var model = Chidopi.Gravity.model;
					var array = new Array(6);
					array[0] =  $("#gFileName1").val() ?  $("#gFileName1").val() : '';
					array[1] =  $("#gFileName2").val() ?  $("#gFileName2").val() : '';
					array[2] =  $("#gFileName3").val() ?  $("#gFileName3").val() : '';
					array[3] =  $("#gFileName4").val() ?  $("#gFileName4").val() : '';
					array[4] =  $("#gFileName5").val() ?  $("#gFileName5").val() : '';
					array[5] =  $("#gFileName6").val() ?  $("#gFileName6").val() : '';
					var string = array.join(";");
					Chidopi.Gravity.model.fileName(string);	
					
					array = new Array(6);
					array[0] =  $("#gMovePage1").val() ?  $("#gMovePage1").val() : '';
					array[1] =  $("#gMovePage2").val() ?  $("#gMovePage2").val() : '';
					array[2] =  $("#gMovePage3").val() ?  $("#gMovePage3").val() : '';
					array[3] =  $("#gMovePage4").val() ?  $("#gMovePage4").val() : '';
					array[4] =  $("#gMovePage5").val() ?  $("#gMovePage5").val() : '';
					array[5] =  $("#gMovePage6").val() ?  $("#gMovePage6").val() : '';
					string = array.join(";");
					Chidopi.Gravity.model.movePage(string);
					
                    model.height(model.width());
					var id = model.id();
                    var type = "gravity";
                    var title = model.title();
                    
					 if(!id){                        
                        id=  type + "_" + (++Global.number);
						if(!title){
							model.title(id);
						}
                        model.id(id);
						model.zIndex(Global.number);
						_createGravityComponent();
						
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});	
						var value = JSON.stringify(json);
						
                        Global.createComponent(id, type, value, title);
					 } else {
						
						if(!title){
							model.title(id);
						}
						
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);						
						_createGravityComponent();
						Global.updateComponent(id, type, value, title);	

					}
					//closeUploadDialog();
					$(this).dialog("close");
				}
				},
				{
				text  :  Chidopi.lang.btn.create,
				click : function(){				 
					
					var model = Chidopi.Gravity.model;
					var array = new Array(6);
					array[0] =  $("#gFileName1").val() ?  $("#gFileName1").val() : '';
					array[1] =  $("#gFileName2").val() ?  $("#gFileName2").val() : '';
					array[2] =  $("#gFileName3").val() ?  $("#gFileName3").val() : '';
					array[3] =  $("#gFileName4").val() ?  $("#gFileName4").val() : '';
					array[4] =  $("#gFileName5").val() ?  $("#gFileName5").val() : '';
					array[5] =  $("#gFileName6").val() ?  $("#gFileName6").val() : '';
					var string = array.join(";");
					Chidopi.Gravity.model.fileName(string);	
					
					array = new Array(6);
					array[0] =  $("#gMovePage1").val() ?  $("#gMovePage1").val() : '';
					array[1] =  $("#gMovePage2").val() ?  $("#gMovePage2").val() : '';
					array[2] =  $("#gMovePage3").val() ?  $("#gMovePage3").val() : '';
					array[3] =  $("#gMovePage4").val() ?  $("#gMovePage4").val() : '';
					array[4] =  $("#gMovePage5").val() ?  $("#gMovePage5").val() : '';
					array[5] =  $("#gMovePage6").val() ?  $("#gMovePage6").val() : '';
					string = array.join(";");
					Chidopi.Gravity.model.movePage(string);
					
					model.height(model.width());
                    var title = model.title();
					var type="gravity";
                    var id=  type + "_" + (++Global.number);
					if(!title){
						model.title(id);
					}
					model.id(id);
					model.zIndex(Global.number);
					model.x(0);
					model.y(0);
					_createGravityComponent();					
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});	
					var value = JSON.stringify(json);
					Global.createComponent(id, type, value, title);
					$(this).dialog("close");						
				}
				},
				{
				text  : Chidopi.lang.btn.cancel,
				click : function(){$(this).dialog("close");}			
				}
			],
			open: function(event, ui) {	
				_reload_gravity_dialog_data();
			}		
		});	
	};
	
	function _reload_gravity_dialog_data(){
		
		var gSelPage = $("#gSelPage");
		$("option", gSelPage).remove();
		var fragment = $("<select/>");
		fragment.append('<option value="">---</option>');
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
				gSelPage.append(fragment.html());
				
				$("#face1").click();
			},
			error: function(jqXHR, textStatus, errorThrown){
				dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
			}
		});
	    
	}
	
	function _init_model(json){
		$(".tmp_file, .tmp_page").val('');		
		var model = Chidopi.Gravity.model;
		if(json){
		    model.id( json.id );
			model.title( json.title ? json.title : '' );
			model.x( json.x ? json.x : 0 );
			model.y( json.y ? json.y : 0 );		
			model.width( json.width ? json.width : 0 );
			model.height( json.height ? json.height : 0 );
			model.display( json.display ? json.display : '' );
			
			model.fileName( json.fileName ? json.fileName : '');
			model.button( json.button ? json.button : '');
			model.hideMode( json.hideMode ? json.hideMode : '');
			model.aspectRatio( json.aspectRatio );
			model.zIndex( json.zIndex );

			model.movePage(json.movePage ? json.movePage : '');
			
		    model.originWidth( json.originWidth );
			model.originHeight( json.originHeight );
			model.bgColor( json.bgColor ); 
			model.bdColor( json.bdColor ); 
			model.bgColorAlpha ( json.bgColorAlpha );
			model.bdWidth( json.bdWidth );
			model.type( json.type );
			if(json.fileName){
			    var files = json.fileName.split(";");
				for(var i = 0; i<files.length; i++){
				    $("#gFileName" + (i+1)).val(files[i]);
				}
			}
			
			if(json.movePage){
			    var pages = json.movePage.split(";");
				for(var i = 0; i<pages.length; i++){
				    $("#gMovePage" + (i+1)).val(pages[i]);
				}
			}
			
		}else{
		    model.id("");
			model.title("");
			model.x(0);
			model.y(0);		
			model.width(100);
			model.height(100);
			model.display('');
			
			model.fileName('');
			model.movePage('');
			model.button('');
			model.hideMode('');
			
			model.aspectRatio(true);
			model.zIndex( '' );
			model.originWidth( 100 );
			model.originHeight( 100 );	
			model.bgColor("#000000"); 
			model.bdColor("#555555"); 
			model.bgColorAlpha ("0.5");
			model.bdWidth("1");
			model.type("cube");
		}
	    
		var button = function(id, title) {  
			this.id = id;   
			this.title = title;  
        };  
		var buttons = [];
		for(key in Global.buttons){	
		    buttons.push(new button(key, Global.buttons[key]));
		}
		if(!model.linkButtons) model.linkButtons =  ko.observableArray();
		model.linkButtons(buttons);
        $("#gDisplay").change();
		return model;
	}
	
	function setWidth(width){
	    var file1 = $("#gFileName1"),
		    file2 = $("#gFileName2"),
	        file3 = $("#gFileName3"),
			file4 = $("#gFileName4"),
			file5 = $("#gFileName5"),
			file6 = $("#gFileName6");
			
		if(file1.val() || file2.val() || file3.val() ||
		   file4.val() || file5.val() || file6.val()){
			   ;
		 }else{
		     $("#gWidth, #gHeight, #g_origin_width, #g_origin_height").val(width);
		 }
	}
	
	function _createGravityComponent(model, sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;
		if(!model) model = Chidopi.Gravity.model;
	    var id = model.id();
		$("#" + id).remove();
		var files = model.fileName().split(";");
		var filename = '';
		for(var i = 0; i < files.length; i++){
			if(files[i]){
				filename = files[i];
				break;
			}
		}
				
	    var url =  filename ?  the_vars.base_url + the_vars.user_res_path + '/' + filename 
		                    : the_vars.base_url + "css/images/link_default_50x50.png";
		
		var style = "left: " + model.x() + "px; top: " + model.y() + "px;" + 
		            "z-index: " + model.zIndex() + ";";

		var sizeStyle = "width: " + model.width() + "px; height: " + model.height() + "px;";
	
		//if(!json.iFileName){
		var color  =  HexToRGB(model.bgColor());
			sizeStyle += 'background-color:rgba('+ color.r+','+ color.g+ ','+ color.b+',0.5);';
		//}
		
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
			var _this = $(this);
			_this.resizable({
				autoHide: true,
				distance: 20,
				aspectRatio: model.aspectRatio() ? model.originWidth() / model.originHeight() : false,
				start: function(event, ui) {
				},
				stop: function(event, ui) {
					var hidden = $("#"+h_id);
					width = parseInt(_this.css("width").replace("px","")),
					height = parseInt(_this.css("height").replace("px",""));
					var json=JSON.parse(hidden.val());
					json["width"] = width;
					json["height"] = height;
					hidden.val(JSON.stringify(json));
				}
			});
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
				json["x"] = $(this).css("left").replace("px","");
				json["y"] = $(this).css("top").replace("px","");
				hidden.val(JSON.stringify(json));
			}
		});
		
		// resizable-handle icon z-index
		$("#"+id +" .ui-resizable-handle").css("z-index","auto");
	}	

})(jQuery);