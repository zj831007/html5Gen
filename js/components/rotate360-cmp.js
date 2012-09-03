(function($){
	var cmpContainer;
	var Vars  = {};
	
    Chidopi.Rotate360 = {};
	
	Chidopi.rotate360 = Chidopi.Rotate360; // alias of  Rotate360
		
	// Rotate360 ko model 
	Chidopi.Rotate360.model = {
		id     : ko.observable(),
		title  : ko.observable(),
		x      : ko.observable(),
		y      : ko.observable(),
		width  : ko.observable(),
		height : ko.observable(),
		display: ko.observable(),
		
		//number : ko.observable(),
		orientation : ko.observable(),
		noticeColor : ko.observable(),
				
		fileName       : ko.observable(),
		button         : ko.observable(),
		linkButtons    : ko.observableArray(),
		hideMode       : ko.observable(),

		aspectRatio    : ko.observable(),
		zIndex         : ko.observable(),
		originWidth    : ko.observable(),
		originHeight   : ko.observable(),
		    
	};
		
	// ----------- public  methods -----------
	
	Chidopi.Rotate360.updateModel = function(json){
	    return _init_model(json);
	}
	
	Chidopi.Rotate360.init = function( vars ){ 
	
	    cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
	
	    ko.applyBindings(Chidopi.Rotate360.model, document.getElementById("rotate360_dialog"));
		 
		_init_dialog();
		 
		$("#bar_rotate360").click(function(){
			_init_model();
			_init_previewArea();
			$("#rotate360_dialog").dialog("open");
		});
		
		$("#noticeColor").ColorPicker({
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
				Chidopi.Rotate360.model.noticeColor('#' + hex);					
			}
		});			
        
		$("#btnRSelImg").button().click(function(){
		    openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_rotate360_",
				mode  :"m",
				onComplete: function (files) {
					var newNames = new Array(0);
					var oldNames = new Array(0);			
					for(var i = 0;i<files.length;i++){
					    newNames[newNames.length] = files[i];
						oldNames[oldNames.length] = files[i];						
					}
					_showRotateImages(newNames, oldNames);
				}
			});
		});
							
		$("#rotateTabs").tabs();
		
		$( "#r_sortable" ).sortable({
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		});
		$( "#r_sortable" ).disableSelection();
		
		$("#rRstoreSize").click(function(){
			var model = Chidopi.Rotate360.model;			
			var origin_width = model.originWidth();
			var origin_height = model.originHeight();	
		    if(origin_width) model.width(origin_width);
			if(origin_height)model.height(origin_height);
		});	
				
    };
	
	Chidopi.Rotate360.editCallBack = function(sys_vars){
	    var imgs = $("#rFileName").val();
		var newNames = new Array(0);
		var OldNames = new Array(0);
		if(imgs){
			var newNames = imgs.split(";");
			var OldNames = newNames;
		}
		$("#rotateTab-2-preview img").remove();
	    $( "#r_sortable li" ).remove();
		_showRotateImages(newNames,OldNames,sys_vars);

		$("#rotateTabs").tabs();
		
		$( "#r_sortable" ).sortable({
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		});
		$( "#r_sortable" ).disableSelection();

		
	}
			
	Chidopi.Rotate360.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		var model = Chidopi.Rotate360.updateModel(json);
		var id = model.id();
		var title = model.title();
		var type= "rotate360";
		var value = JSON.stringify(json);
		_createRotate360Component(model, vars);
		Global.createComponent(id, type, value, title);
	}

	//--------------- private function below -------------------
    function _init_dialog(){
		
	    $("#rotate360_dialog").dialog({			  
		 	title: Chidopi.lang.title.rotate360,
			autoOpen:false,
			width: 610,
			height: 610,
			modal: true,
			buttons:[
			    {
				text  : Chidopi.lang.btn.ok,
				click : function(){
					var model = Chidopi.Rotate360.model;
					var array = new Array(0);
					$("#r_sortable li").each(function(index){
						array[array.length] = $(this).attr("uid");
					});

                    var string = array.join(";");
					Chidopi.Rotate360.model.fileName(string);	

					var id = model.id();
                    var type = "rotate360";
                    var title = model.title();
                    
					 if(!id){                        
                        id=  type + "_" + (++Global.number);
						if(!title){
							model.title(id);
						}
                        model.id(id);
						model.zIndex(Global.number);
						_createRotate360Component();
						
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});	
						var value = JSON.stringify(json);
						
                        Global.createComponent(id, type, value, title);
					 } else {
						
						if(!title){
							model.title(id);
						}
						
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);
						_createRotate360Component();
						Global.updateComponent(id, type, value, title);
					}
					$(this).dialog("close");
				}
			    },
			    {
				text  : Chidopi.lang.btn.create,
				click : function(){
					
					var model = Chidopi.Rotate360.model;
					var array = new Array(0);
					$("#r_sortable li").each(function(index){
						array[array.length] = $(this).attr("uid");
					});

                    var string = array.join(";");
					Chidopi.Rotate360.model.fileName(string);
									
                    var title = model.title();
					var type="rotate360";
                    var id=  type + "_" + (++Global.number);
					if(!title){
						model.title(id);
					}
					model.id(id);
					model.zIndex(Global.number);
					model.x(0);
					model.y(0);
					
					var json = $("input[type!=file], select",this).toObject({mode: 'combine'});	
					var value = JSON.stringify(json);
					_createRotate360Component();
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
				$("#rotateTabs").tabs('select', '#rotateTab-1');
			}		
		});	
	}
	
	function _init_model(json){
		
		var model = Chidopi.Rotate360.model;
		if(json){
		    model.id( json.id );
			model.title( json.title ? json.title : '' );
			model.x( json.x ? json.x : 0 );
			model.y( json.y ? json.y : 0 );		
			model.width( json.width ? json.width : 0 );
			model.height( json.height ? json.height : 0 );
			model.display( json.display ? json.display : '' );
			
			//model.number( json.number );
			model.orientation( json.orientation );
			model.noticeColor( json.noticeColor);
			
			model.fileName( json.fileName ? json.fileName : '');
			model.button( json.button ? json.button : '');
			model.hideMode( json.hideMode ? json.hideMode : '');
			
			model.aspectRatio( json.aspectRatio ? json.aspectRatio : false);
			model.zIndex( json.zIndex );			
			model.originWidth( json.originWidth );
			model.originHeight( json.originHeight );	

		}else{
		    model.id("");
			model.title("");
			model.x(0);
			model.y(0);		
			model.width(0);
			model.height(0);
			model.display('');
			
			//model.number(12);
			model.orientation(0);
			model.noticeColor("#00FF00");
			
			model.fileName('');
			model.button('');
			model.hideMode('');
			
			model.aspectRatio(false);
			model.zIndex( '' );
			model.originWidth( 0 );
			model.originHeight( 0 );	
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
		return model;
	}
	
	function _init_previewArea(){
		$("#rotateTab-2-preview img").remove();
		$("#r_sortable li").remove();
	}
	
	function _createRotate360Component(model, sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;		
		if(!model) model = Chidopi.Rotate360.model;
		var id = model.id();
		$("#" + id).remove();
		var src = model.fileName().split(";")[0];
		var url  = src ? the_vars.base_url + the_vars.user_res_path + "/" + src 
		               : the_vars.base_url + "css/images/link_default_50x50.png";
		var sizeStyle = "width:"+ model.width() + "px; height:" + model.height() + "px;" ;
		var positionStyle = "left: " + model.x() + "px; top: " + model.y() + "px;" + 
		                "z-index: " + model.zIndex() + ";";
		var rotateIconStyle = 'background-color:'+ model.noticeColor() + ';';
		var rotateIconCls = model.orientation() == 0 ? 'arrow_leftright' : 'arrow_updown' ;
		var html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' + sizeStyle +
		            positionStyle +'" '+ 
					'onMouseOver="$(\'.closebox, .lChange\',this).show();" onclick="highlight(\''+id+'\');" '+
					'onMouseOut = "$(\'.closebox, .lChange\',this).hide();" >' + 
					'<img id="rotateImg_' + id + '" src="' + url + '" style="' + sizeStyle  + '" />' +  //<div class="icon" style="">
					'<div class="rotateIcon '+ rotateIconCls +'" style="'+ rotateIconStyle +'"></div>'+
					//'</div>' +
					'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
					'onclick="removeComponent(\''+ id+'\')">' +
					'<span class="closebox"></span></a>' +				
					'</div>';

	   the_vars.cmp_container.append(html);
	   
	    var cmp = $("#"+id);
		var pic = $("#rotateImg_" +id);
		var h_id = "cmp_" + id;
		pic.load(function(){					
			var _this = $(this),
			width = parseInt(_this.css("width").replace("px","")),
			height = parseInt(_this.css("height").replace("px",""));
			$(this).resizable({
				autoHide: true,
				distance: 20,
				aspectRatio: model.aspectRatio() ? model.originWidth() / model.originHeight() : false,
				start: function(event, ui) {
				},
				resize: function(e, ui) {
					width = parseInt(_this.css("width").replace("px","")),
					height = parseInt(_this.css("height").replace("px",""));
		            cmp.width(width);
					cmp.height(height);					
				},
				stop:  function(event, ui) {
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
	   

	
	}
	
	function _showRotateImages(newNames, oldNames, sys_vars){
		
		var the_vars = sys_vars ? sys_vars : Vars;
		var imageContainer = $("#r_sortable");
		for(var i = 0; i<newNames.length;i++){
			var url =  the_vars.base_url + the_vars.user_res_path +"/"+newNames[i];
			var cancel = the_vars.base_url + "css/images/cancel.png";
			var delLink = $('<a class="a_cancel" style="float:right;cursor:pointer;">' +
				          '<img border="0" src="' + cancel +'" /></a>');
			var dom = $('<li uid="'+ newNames[i] +'" class="ui-state-default"></li>');
			dom.append(delLink).append('<img class="rImage" width="100px;" src="' + url + '" title="' + oldNames[i]+'" />');

			delLink.bind('click',function(){
				var uid = $(this).parent().attr("uid");
				_removeImage(uid);
			});
            imageContainer.append(dom);
		}
		$(".rImage", imageContainer).click(function(n){
			 var url = $(this).attr('src');
			 _loadPreviewImg(url, 500, 200 );
		});
		_showFirstImage(the_vars);
	}
	
	function _showFirstImage(sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;
        if($("#r_sortable li").size()>0){
		   var first = $("#r_sortable li:first");
		   var url = the_vars.base_url + the_vars.user_res_path + "/"+ $(first).attr('uid');
           _loadPreviewImg( url, 500 , 200 );		  
		}else{			
			$("#r_upload_previewImg").remove();
		}
		_updateRotateAreaWidth();
	}

	function _updateRotateAreaWidth(){
         $("#r_sortable").width( $("#r_sortable li").size() * 120 + 20);
	}

	function _removeImage(uid){
        $("li[uid="+uid+"]").remove();       
        _showFirstImage();		
	}
	
	function _loadPreviewImg(url, max_width, max_height,container){
		var img = new Image();
		
		if(!$(container).size()){
			 container =  $("#r_upload_previewImg");
			 if(!$(container).size()){
				 container = $("<img id='r_upload_previewImg' width='500px'>");
				 $("#rotateTab-2-preview").append(container);
			 }
		} else {
			$(container).attr("src",'');			
		}
		$(img).load(function(){			
			var width = $(img).attr("width");
			var height = $(img).attr("height");
			
			if( !Chidopi.Rotate360.model.width() || !Chidopi.Rotate360.model.height() ){ 
				Chidopi.Rotate360.model.width( img.width );
			    Chidopi.Rotate360.model.height( img.height );
				Chidopi.Rotate360.model.originWidth( img.width );
				Chidopi.Rotate360.model.originHeight( img.height );
			}
			
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
	}
	
	
})(jQuery);