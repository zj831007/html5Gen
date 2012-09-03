(function($){
	var cmpContainer;
	var Vars  = {};
	
    Chidopi.Slider2 = {};
	
	Chidopi.slider2 = Chidopi.Slider2; // alias of  Slider2
		
	// splider2 ko model 
	Chidopi.Slider2.model = {
		id     : ko.observable(),
		title  : ko.observable(),
		x      : ko.observable(),
		y      : ko.observable(),
		width  : ko.observable(),
		height : ko.observable(),
		display: ko.observable(),
		touch  : ko.observable(),
		auto   : ko.observable(),
		dock   : ko.observable(),
		arrow  : ko.observable(),
		dockAlign        : ko.observable(),
		dockPosition     : ko.observable(),
		dockColor        : ko.observable(),
		dockColorCurrent : ko.observable(),
		dockShowText     : ko.observable(),
		dockTextColor    : ko.observable(),
		dockTextColorCurrent : ko.observable(),
		dockSize       : ko.observable(),
		arrowPosition  : ko.observable(),
		//arrowFileTitle : ko.observable(),
        arrowFileName  : ko.observable(),
		fileName       : ko.observable(),
		button         : ko.observable(),
		linkButtons    : ko.observableArray(),
		hideMode       : ko.observable(),
		changeMode     : ko.observable(),
		
		loadAction     : ko.observable(),		
		loadPos        : ko.observable(),		
		load2D         : ko.observable(),
		load3DX        : ko.observable(),
		load3DY        : ko.observable(),
		loadSpeed      : ko.observable(),
		loadOpacity    : ko.observable(),
		loadDelay      : ko.observable(),
		
		hideAction     : ko.observable(),
		hidePos        : ko.observable(),
		hide2D         : ko.observable(),
		hide3DX        : ko.observable(),
		hide3DY        : ko.observable(),
		hideSpeed      : ko.observable(),
		hideOpacity    : ko.observable(),
		hideDelay      : ko.observable(),
		
		aspectRatio    : ko.observable(),
		zIndex         : ko.observable(),
		originWidth    : ko.observable(),
		originHeight   : ko.observable(),
		
		transPic       : ko.observable(),
		    
	};
	// splider2 ko model bind
	Chidopi.Slider2.model.supportDock =  ko.dependentObservable(function () {
		if(Chidopi.Slider2.model.dock() == true){
			if(Chidopi.Slider2.model.dockShowText() == true){
				$("#s2DockTextColor, #s2DockTextColorCurrent").attr("disabled",false);
			}
		    return true;
		}else{
			$("#s2DockTextColor, #s2DockTextColorCurrent").attr("disabled",true);
		    return false;
		}		   
	});
		
	// ----------- public  methods -----------
	
	Chidopi.Slider2.updateModel = function(json){
	    return _init_model(json);
	}
	
	Chidopi.Slider2.init = function( vars ){ 
	
	    cmpContainer = vars.cmp_container;
		
		if(vars) Vars = vars;
	
	    ko.applyBindings(Chidopi.Slider2.model, document.getElementById("slider2_dialog"));
		 
		_init_dialog();
		 
		$("#bar_slider2").click(function(){
			_init_model();
			_init_previewArea();
			$("#slider2_dialog").dialog("open");
		});
		
		$("#s2Touch").change(function(){
			Chidopi.Slider2.model.auto(false);	
		});
		
		$("#s2Auto").change(function(){
			Chidopi.Slider2.model.touch(false);	
		});
		
		$("#s2Display").change(function(){
		    if(Chidopi.Slider2.model.display()){
				$("#s2HideAction").attr("disabled",false);
			}else{
			    $("#s2HideAction").attr("disabled",true);
				Chidopi.Slider2.model.hideAction(false);
			}
		});
		
		$("#s2Tabs").tabs();
		
		$( "#s2_sortable" ).sortable({
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		});
		$( "#s2_sortable" ).disableSelection();
		
		$('#s2DockColor ,#s2DockColorCurrent, #s2DockTextColor, #s2DockTextColorCurrent').each(function(){
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
					
		$("#s2ArrowFileName").click(function(){
			 openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_slider2_",
				onComplete: function (url) {					
					Chidopi.Slider2.model.arrowFileName(url);
				}
			});
		});
		
		$("#btn_s2aCancel").click(function(){
			Chidopi.Slider2.model.arrowFileName('');
		});
		
		
		$("#s2RstoreSize").click(function(){
			var model = Chidopi.Slider2.model;			
			var origin_width = model.originWidth();
			var origin_height = model.originHeight();	
		    if(origin_width) model.width(origin_width);
			if(origin_height)model.height(origin_height);
		});	
		
    	$("#btnSelImg").button().click(function(){
		    openKCFinder({
				field:this,
				prefix: Vars.bookid+"_"+Vars.pageid+"_slider2_",
				mode  :"m",
				onComplete: function (files) {					
					for(var i = 0;i<files.length;i++){
					    sliderNewNames[sliderNewNames.length] = files[i];
						sliderOldNames[sliderOldNames.length] = files[i];						
					}
					_showSliderImages(sliderNewNames, sliderOldNames);
					sliderNewNames = new Array(0);
					sliderOldNames = new Array(0);	
				}
			});
		});
    };
	
	Chidopi.Slider2.editCallBack = function(sys_vars){
	    var imgs = $("#s2FileName").val();
		if(imgs){
			sliderNewNames = imgs.split(";");
			sliderOldNames = sliderNewNames;
		}
		$("#s2Tab-2-preview img").remove();
	    $( "#s2_sortable li" ).remove();
		_showSliderImages(sliderNewNames,sliderOldNames,sys_vars);
		sliderNewNames = new Array(0);
		sliderOldNames = new Array(0);
		
		$("#s2Tabs").tabs();		
		$( "#s2_sortable" ).sortable({
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		});
		$( "#s2_sortable" ).disableSelection();
		
	}
			
	Chidopi.Slider2.createComponent = function(component, vars){
	    var json = JSON.parse(component);
		var model = Chidopi.Slider2.updateModel(json);
		var id = model.id();
		var title = model.title();
		var type= "slider2";
		_setNewFeatureToJson(json);
		var value = JSON.stringify(json);
		_createSliderComponent(model, vars);
		Global.createComponent(id, type, value, title);
	}
	
	//--------------- private function below -------------------
	function _setNewFeatureToJson(json){
		if(!json.zIndex) {json.zIndex =  json.id.substring(json.id.lastIndexOf("_")+1);};
	}
	
	function _init_dialog(){
	    $("#slider2_dialog").dialog({
			title: Chidopi.lang.title.slider2,
			autoOpen:false,
			width:720,
			height:650,
			modal: true,
			buttons:[
				{
				text  : Chidopi.lang.btn.ok,
				click : function(){
					var model = Chidopi.Slider2.model;
					var array = new Array(0);
					$("#s2_sortable li").each(function(index){
						array[array.length] = $(this).attr("uid");
					});

                    var string = array.join(";");
					Chidopi.Slider2.model.fileName(string);	

					var id = model.id();
                    var type = "slider2";
                    var title = model.title();
                    
					 if(!id){                        
                        id=  type + "_" + (++Global.number);
						if(!title){
							model.title(id);
						}
                        model.id(id);
						model.zIndex(Global.number);
						_createSliderComponent();
						
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});	
						var value = JSON.stringify(json);
						
                        Global.createComponent(id, type, value, title);
					 } else {
						
						if(!title){
							model.title(id);
						}
						
						var json = $("input[type!=file], select",this).toObject({mode: 'combine'});				
						var value = JSON.stringify(json);						
						_createSliderComponent();
						Global.updateComponent(id, type, value, title);	

					}
					//closeUploadDialog();
					$(this).dialog("close");
				}
				},
				{
				text  : Chidopi.lang.btn.create,
				click : function(){				 
					
					var model = Chidopi.Slider2.model;
					var array = new Array(0);
					$("#s2_sortable li").each(function(index){
						array[array.length] = $(this).attr("uid");
					});

                    var string = array.join(";");
					Chidopi.Slider2.model.fileName(string);	
									
                    var title = model.title();
					var type="slider2";
                    var id=  type + "_" + (++Global.number);
					if(!title){
						model.title(id);
					}
					model.id(id);
					model.zIndex(Global.number);
					model.x(0);
					model.y(0);
					_createSliderComponent();					
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
				$("#s2Tabs").tabs('select', '#s2Tab-1');
			}		
		});	
	};
	
	function _init_model(json){		
		var model = Chidopi.Slider2.model;
		if(json){
		    model.id( json.id );
			model.title( json.title ? json.title : '' );
			model.x( json.x ? json.x : 0 );
			model.y( json.y ? json.y : 0 );		
			model.width( json.width ? json.width : 0 );
			model.height( json.height ? json.height : 0 );
			model.display( json.display ? json.display : '' );
			model.touch( json.touch ? json.touch : false );
			model.auto( json.auto ? json.auto : false );
			model.dock( json.dock ? json.dock : false );
			model.arrow( json.arrow ? json.arrow : false );  
			model.dockAlign( json.dockAlign ? json.dockAlign : "");        
			model.dockPosition( json.dockPosition ? json.dockPosition : "" );    
			model.dockColor( json.dockColor ? json.dockColor : "#1e5a47");      
			model.dockColorCurrent(json.dockColorCurrent ? json.dockColorCurrent : "#f0a017"); 
			model.dockShowText( json.dockShowText ? json.dockShowText : false);
			model.dockTextColor( json.dockTextColor ? json.dockTextColor : "#FFFFFF");
			model.dockTextColorCurrent( json.dockTextColorCurrent ? json.dockTextColorCurrent : "#FFFFFF");
			model.dockSize( json.dockSize ? json.dockSize : "normal");
			model.arrowPosition( json.arrowPosition ? json.arrowPosition : "1");  
			//model.arrowFileTitle( json.arrowFileTitle ? json.arrowFileTitle : "");
			model.arrowFileName( json.arrowFileName ? json.arrowFileName : "");
			model.fileName( json.fileName ? json.fileName : '');
			model.button( json.button ? json.button : '');
			model.hideMode( json.hideMode ? json.hideMode : '');
			model.changeMode( json.changeMode ? json.changeMode : 'fade');
			
			model.loadAction( json.loadAction ? json.loadAction : false);
			model.hideAction( json.hideAction ? json.hideAction : false);
			model.loadPos( json.loadPos ? json.loadPos : '' );
			model.hidePos( json.hidePos ? json.hidePos : '' );
			model.load2D( json.load2D ? json.load2D : 0 );
			model.load3DX( json.load3DX ? json.load3DX : 0 );
			model.load3DY( json.load3DY ? json.load3DY : 0 );
			model.loadOpacity( json.loadOpacity ? json.loadOpacity : 0 );
			model.loadDelay( json.loadDelay ? json.loadDelay : 0 );
			model.loadSpeed( json.loadSpeed ? json.loadSpeed : 1.0 );
			model.hide2D( json.hide2D ? json.hide2D : 0 );
			model.hide3DX( json.hide3DX ? json.hide3DX : 0 );
			model.hide3DY( json.hide3DY ? json.hide3DY : 0 );
			model.hideOpacity( json.hideOpacity ? json.hideOpacity : 0 );
			model.hideDelay( json.hideDelay ? json.hideDelay : 0 );
			model.hideSpeed( json.hideSpeed ? json.hideSpeed : 1.0 );
			
			model.aspectRatio( json.aspectRatio ? json.aspectRatio : false);
			model.zIndex( json.zIndex );
			
			if( !json.originWidth || !json.originHeight ) {
			    _setOriginSize(model,json);
			}else{
			    model.originWidth( json.originWidth );
				model.originHeight( json.originHeight ); 
			}
			
			model.transPic(json.transPic ? json.transPic : false);

		}else{
		    model.id("");
			model.title("");
			model.x(0);
			model.y(0);		
			model.width(0);
			model.height(0);
			model.display('');
			model.touch(false);
			model.auto(false);
			model.dock(false);
			model.arrow(false);  
			model.dockAlign("");        
			model.dockPosition("");    
			model.dockColor("#1e5a47");      
			model.dockColorCurrent("#f0a017"); 
			model.dockShowText(false);
			model.dockTextColor("#FFFFFF");
			model.dockTextColorCurrent("#FFFFFF");
			model.dockSize("normal");
			model.arrowPosition("1");  
			//model.arrowFileTitle("");
			model.arrowFileName("");
			model.fileName('');
			model.button('');
			model.hideMode('');
			model.changeMode('fade');
			model.loadAction(false);
			model.hideAction(false);
			model.loadPos( '' );
			model.hidePos( '' );
			model.load2D( 0 );
			model.load3DX( 0 );
			model.load3DY( 0 );
			model.loadOpacity( 0 );
			model.loadDelay( 0 );
			model.loadSpeed( 1.0 );
			model.hide2D( 0 );
			model.hide3DX( 0 );
			model.hide3DY( 0 );
			model.hideOpacity( 0 );
			model.hideDelay( 0 );
			model.hideSpeed( 1.0 );	
			model.aspectRatio(false);
			model.zIndex( '' );
			model.originWidth( 0 );
			model.originHeight( 0 );
			
			model.transPic(false);
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
        $("#s2LoadDelay, #s2LoadSpeed, #s2LoadOpacity, #s2HideDelay, #s2HideSpeed, #s2HideOpacity, #s2Display").change();
		return model;
	}
	
	function _setOriginSize(model, json){
		var img = json.fileName ? json.fileName.split(";")[0] : '' ;
		if(img && Vars.base_url){
			var image = new Image();				
			image.onload = function(){
				model.originWidth(this.width);
				model.originHeight(this.height);				
			};
			image.src = Vars.base_url + Vars.user_res_path+"/" + img;
		}else{
			model.originWidth( model.width );
			model.originHeight( model.height );	
		}
	}

	var sliderNewNames = new Array(0);
	var sliderOldNames = new Array(0);
	var imageNumber = 0;
	   	
	function _showSliderImages(newNames, oldNames, sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;
		
        var imageContainer = $("#s2_sortable");
		for(var i = 0; i<newNames.length;i++){
			var url =  the_vars.base_url + the_vars.user_res_path +"/"+newNames[i];
			var cancel = the_vars.base_url + "js/uploadify/cancel.png";
			var delLink = $('<a class="a_cancel" style="float:right;cursor:pointer;">' +
				          '<img border="0" src="' + cancel +'" /></a>');
			var dom = $('<li uid="'+ newNames[i] +'" class="ui-state-default"></li>');
			dom.append(delLink).append('<img class="sImage" width="100px;" src="' + url + '" title="' + oldNames[i]+'" />');

			delLink.bind('click',function(){
				var uid = $(this).parent().attr("uid");
				_removeImage(uid);
			});
            imageContainer.append(dom);
		}
		$(".sImage", imageContainer).click(function(n){
			 var url = $(this).attr('src');
			 _loadPreviewImg(url, 500, 200 );
		});
		_showFirstImage(the_vars);
	}

	function _showFirstImage(sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;
        if($("#s2_sortable li").size()>0){
		   var first = $("#s2_sortable li:first");
		   var url = the_vars.base_url + the_vars.user_res_path + "/"+ $(first).attr('uid');
           _loadPreviewImg( url, 500 , 200 );		  
		}else{			
			$("#s2_upload_previewImg").remove();
		}
		_updateSliderAreaWidth();
	}

	function _updateSliderAreaWidth(){
         $("#s2_sortable").width( $("#s2_sortable li").size() * 120 + 20);
	}

	function _removeImage(uid){
        $("li[uid="+uid+"]").remove();       
        _showFirstImage();		
	}
	
	function _loadPreviewImg(url, max_width, max_height,container){
		var img = new Image();
		
		if(!$(container).size()){
			 container =  $("#s2_upload_previewImg");
			 if(!$(container).size()){
				 container = $("<img id='s2_upload_previewImg' width='500px'>");
				 $("#s2Tab-2-preview").append(container);
			 }
		} else {
			$(container).attr("src",'');			
		}
		$(img).load(function(){			
			var width = $(img).attr("width");
			var height = $(img).attr("height");
			
			if( !Chidopi.Slider2.model.width() ) Chidopi.Slider2.model.width( img.width );
			if( !Chidopi.Slider2.model.height() ) Chidopi.Slider2.model.height( img.height );
			
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
	
	function _init_previewArea(){
		$("#s2Tab-2-preview img").remove();
		$( "#s2_sortable li" ).remove();
	}
	 
	var dockArray = {'normal':[69,28,31],'small':[63,26,29],'large':[75,24,37]};
	function _createSliderComponent(model, sys_vars){
		var the_vars = sys_vars ? sys_vars : Vars;		
		if(!model) model = Chidopi.Slider2.model;
		var id = model.id();
		$("#" + id).remove();
		var src = model.fileName().split(";")[0];
		var url  = src ? the_vars.base_url + the_vars.user_res_path + "/" + src : '';
		var sizeStyle = "width:"+ model.width() + "px; height:" + model.height() + "px;" + 
		                "z-index: " + model.zIndex() + ";";
		var positionStyle = "left: " + model.x() + "px; top: " + model.y() + "px;";
		var marginStyle1 = ''; 
		marginStyle1 = model.dock() ? 'margin-' + model.dockPosition()+': ' + dockArray[model.dockSize()][2] + "px;" : '0;';
		marginStyle1 += "margin-left: " + ((model.arrow() && model.arrowPosition() == "2") ? '42px;' : '0;') +
		                "margin-right: " + ((model.arrow() && model.arrowPosition() == "2") ? '42px;' : '0;');
		 
		
		var html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' +  sizeStyle +
		            positionStyle +  marginStyle1 +'" '+ 
					'onMouseOver="$(\'.closebox, .lChange\',this).show();" onclick="highlight(\''+id+'\');" '+
					'onMouseOut = "$(\'.closebox, .lChange\',this).hide();" >' + 
					_createSlider2Detail(the_vars) +				
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
					var nav = $(".nivo-controlNav", cmp)
					var data =  nav.attr("data");
					if(data == "center"){
						//console.log( $(".nivo-controlNav", cmp).css('left'));
					    nav.css("left", ( width - dockArray[model.dockSize()][0] ) / 2 + 'px');
					}
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
	
	function _createSlider2Detail(sys_vars){
		var model = Chidopi.Slider2.model;
		var id = model.id();
		var src = model.fileName().split(";")[0];
		var url  = src ? sys_vars.base_url + sys_vars.user_res_path + "/" + src : '';
		var sizeStyle = "width:"+ model.width() + "px; height:" + model.height() + "px;";
		var positionStyle = "left: " + model.x() + "px; top: " + model.y() + "px;";
		
        var dock ='';
        if( model.dock()){
			dock =  '<div class="nivo-controlNav" data="' + model.dockAlign() + '" style="' + model.dockPosition() + ': -' + dockArray[model.dockSize()][2] +'px;' ;
			if(model.dockAlign() == "left")
			    dock += 'left: 15px;';
		    else if(model.dockAlign() == "right")
			    dock += 'right: 15px;';
		    else
			    dock += 'left:' + ( model.width() - dockArray[model.dockSize()][0] ) / 2 + 'px;'; 
		    dock += '">';
			if( model.dockShowText( )){
			    //console.log( model.dockColorCurrent() + " , " + model.dockColor());
			    dock += '<a class="nivo-control active ' + model.dockSize() + '" style="background-color:' + 
				         model.dockColorCurrent() + '; color:' + model.dockTextColorCurrent() + '">1</a>' + 
						'<a class="nivo-control ' + model.dockSize() + '" style="background-color:' + 
						model.dockColor() + '; color:' + model.dockTextColor() + '">2</a>'+
						'<a class="nivo-control ' +  model.dockSize() + '" style="background-color:' + 
						model.dockColor()+'; color:' + model.dockTextColor() + '">3</a></div>';
			}else{
				dock += '<a class="nivo-control active ' + model.dockSize() + '" style="background-color:' + 
				        model.dockColorCurrent() + '">&nbsp;</a>' + 
						'<a class="nivo-control ' + model.dockSize() + '" style="background-color:' + 
						model.dockColor() + '">&nbsp;</a>' +
						'<a class="nivo-control ' + model.dockSize() + '" style="background-color:' + 
						model.dockColor() + '">&nbsp;</a></div>';
			}			
		}
		var nav = '';
		if( model.arrow()){
			var navPos ='';
			if(model.arrowPosition() == "1"){
			    navPos = '12px;'
			}else{
			    navPos = -(12 + 30) + 'px;';
			}
			if(model.arrowFileName()){
			    var navsrc =  sys_vars.base_url + sys_vars.user_res_path + "/" + model.arrowFileName();
				nav = '<div class="nivo-directionNav"><a class="nivo-prevNav" style="background:url(' + navsrc + 
				      ');left:' + navPos + '">Prev</a><a class="nivo-nextNav" style="background:url(' + navsrc + 
					  ');right:' + navPos + '">Next</a></div>';
			}else{
				nav = '<div class="nivo-directionNav"><a class="nivo-prevNav" style="left:' + navPos + 
				      '">Prev</a><a class="nivo-nextNav" style="right:' + navPos + '">Next</a></div>';
			}
		}
	    var slider2 = '<div class="slider-wrapper" style="' +'">' + 
		              '<div class="nivoSlider"  style="position: relative;">' + dock + 
					  '<div class="nivo_subcontainer" style="' + '' +'"><img id="pic_' + id + 
					  '" src="' +  url +'" style="' + sizeStyle +'" /></div>'+
					  nav + "</div></div>";
	
	    return slider2;
					  
	}
	

})(jQuery);