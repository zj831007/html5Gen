define(function(require, exports, module) {
	
	var _type = "text2", _inited = false;;
	
	var $_dialog = $("#text2_dialog");
	
	var _vars = {};
	
	var _model = {
        id          : ko.observable(),
		title       : ko.observable(),
		x           : ko.observable(),
		y           : ko.observable(),
		width       : ko.observable(),
		height      : ko.observable(),
		zIndex      : ko.observable(),
		display     : ko.observable(),
		hideMode    : ko.observable(),
		button      : ko.observable(),
		linkButtons : ko.observableArray(),
		text        : ko.observable(),
		aspectRatio : ko.observable(),
	};
	
	
	var _toJSON = function(){
		var _ignore = ['linkButtons'];
		var copy = JSON.parse(ko.toJSON(_model));
		
		$(_ignore).each(function(){
			delete copy[this];
		});
		console.log(copy);
		return copy;
		
	}
	
	var _initDialog = function(){
		$_dialog.dialog({
			title: Chidopi.lang.title.text2,
			autoOpen: false, 
			width:700,
			height:670,
			modal: true,
			buttons: [
			  {
			  text  : Chidopi.lang.btn.ok,
			  click : function() {
				  var instance = CKEDITOR.instances['t2BodyText'];
				  var id = _model.id();
                  var type = _type;
                  var title = _model.title();
                  _model.text(instance.getData());
	
				  var hidden, json ;
			      var old_t2BodyText = _model.text();
				  var new_t2BodyText = '';	
				  if(old_t2BodyText){
				      new_t2BodyText = old_t2BodyText.replaceAll(_vars.user_res_path, _vars.user_files_tpl);
					  _model.text(new_t2BodyText);
				  }
				  
                  if(!id){                        
                      id=  type + "_" + (++Global.number);
					  if(!title){
					      _model.title(id);
				      }
					  _model.id(id);
					  _model.zIndex(Global.number);
						
					  var json = _toJSON();
					  var value = JSON.stringify(json);
					  hidden = Global.createComponent(id, type, value, title);
				  } else {
					  if(!title){
					      _model.title(id);
					  }
					  var json = _toJSON();
				      var value = JSON.stringify(json);						
				      hidden = Global.updateComponent(id, type, value, title);	
                  }
                  
                  hidden.data("old_t2BodyText","");
				  if(new_t2BodyText){
				      hidden.data("old_t2BodyText",old_t2BodyText);
				  }
				  _createText2Component(json, _vars);
				  $(this).dialog("close");
			  } 
			  },
			  {
		      text  : Chidopi.lang.btn.create,
			  click : function(){
				  var instance = CKEDITOR.instances['t2BodyText'];
				  _model.text(instance.getData());
				  var type = _type;
				  var old_t2BodyText = _model.text();
				  var new_t2BodyText = '';	
				  if(old_t2BodyText){
				      new_t2BodyText = old_t2BodyText.replaceAll(_vars.user_res_path, _vars.user_files_tpl);
					  _model.text(new_t2BodyText);
				  }
				  var title = _model.title();
				 
                  var id=  type + "_" + (++Global.number);
				  if(!title){
				      _model.title(id);
				  }
				  _model.id(id);
				  _model.zIndex(Global.number);
				  _model.x(0);
				  _model.y(0);
				  
				  var json = _toJSON();
			      var value = JSON.stringify(json);						
			     
			      hidden = Global.createComponent(id, type, value, title);	
				  
				  hidden.data("old_t2BodyText","");
				  if(new_t2BodyText){
				      hidden.data("old_t2BodyText",old_t2BodyText);
				  }
				  _createText2Component(json, _vars);
				  
			      $(this).dialog("close");
			  }
			  },
			  {
			  text  : Chidopi.lang.btn.cancel,
			  click : function() {$(this).dialog("close");}
			  }
			],
			open: function(event, ui) { 
				//_reload_text_dialog_data(); 				
				var t2BodyText = $("#t2BodyText");
				
				var value = _model.text();
				_createCkEditor();
				if(value){
					var id = _model.id();
					value = $("#cmp_" +id).data("old_t2BodyText");
					_model.text(value);
				}
				
				var instance = CKEDITOR.instances['t2BodyText'];
				instance.setData(value);
			},
		}); 
	};
	
	var _createCkEditor = function(){
		   
		var instance = CKEDITOR.instances['t2BodyText'];
		
		if(instance) {
			//instance.setData("");
			CKEDITOR.remove(instance);
			instance.destroy();		
			instance = null;
		}
	
		CKEDITOR.config.filebrowserImageUploadUrl = 'kcfinder/upload.php?type=images';
		CKEDITOR.config.filebrowserImageBrowseUrl = 'kcfinder/browse.php?type=images';
		CKEDITOR.config.filebrowserVideoBrowseUrl = "kcfinder/browse.php?type=video";
		CKEDITOR.config.user_files_path = _vars.user_res_path;
		CKEDITOR.config.language = Chidopi.lang.code2;
		CKEDITOR.replace( 
		   't2BodyText',
		   {
			toolbar: 'MyToolbar',
			width: '540',
			height: '200',
			resize_enabled: true
			} );
	}
	
	var _initialize = function(){
		
		//console.log("_initialize");

		_vars = Chidopi.sys_vars;
		
		ko.applyBindings(_model, $_dialog[0]);
		
		_initDialog();
		
		_inited = true;
    	
	};
	
	if(!_inited){
		_initialize();
	};
	
	var _initCreate = function(){
    	_init_model();
		$_dialog.dialog("open");
	};
	
	var _createText2Component = function(json, sys_vars){
		var the_vars = sys_vars ,id = json.id;		
		
		//var detail = _createTextDetail(json, the_vars);
		var sizeStyle = "width:"+ json.width + "px; height:" + json.height + "px;" ; 
        
		var positionStyle = "left: " + json.x + "px; top: " + json.y + "px;" + "z-index: " + json.zIndex + ";";
		
		$("#" + id).remove();
		
		var content ='<div id="text_'+ id +'" style="overflow: hidden;'+sizeStyle+'">' +
		 ( $("#cmp_" + id).data("old_t2BodyText") ? $("#cmp_" + id).data("old_t2BodyText") : json.text ) +
		  '</div>'
		 
		var html = '<div id="' + id + '" class="component" style=" '+
			'background:none no-repeat center center rgba(0,0,0,0.1);' +
			' display:inline-block; position: absolute; ' +
            positionStyle +'" '+ 
			'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
			'onMouseOut="$(\'.closebox\',this).hide();" >'  + content +
			'<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
			'onclick="removeComponent(\''+ id+'\')">' +
			'<span class="closebox"></span></a>' +
			'</div>';
		//alert(html);
		the_vars.cmp_container.append(html);
	
		var cmp = $("#"+id);
		var h_id = "cmp_" + id;
	    
		var text =  $("#text_"+id);
		text.resizable({
			autoHide: true,
			aspectRatio: json.aspectRatio ? json.width / json.height : false,
			distance: 20,
			start: function(event, ui) {
			},
			resize: function(event, ui){
				var w = $(this).css("width");
				var h =  $(this).css("height");
				text.width(w);
				text.height(h);
			},
			stop:  function(event, ui) {
				var hidden = $("#"+h_id);
				var json=JSON.parse(hidden.val());
				var w = $(this).css("width");
				var h =  $(this).css("height");
				json['width'] = w.replace("px","");
				json['height'] = h.replace("px","");
	
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
				json["x"] = $(this).css("left").replace("px","");
				json["y"] = $(this).css("top").replace("px","");
				hidden.val(JSON.stringify(json));
			}
		});
	    
		// resizable-handle icon z-index
		$("#"+id +" .ui-resizable-handle").css("z-index","auto");
	}
	
	var _createComponent = function(component,sys_vars){
        var json = JSON.parse(component);
		
		var id =json.id;
		var title = json.title;
		var type= _type;
		var value = JSON.stringify(json);
		
		Global.createComponent(id, type, value, title);
		if(json.text){
    	    var old_t2BodyText = json.text.replaceAll( sys_vars.user_files_tpl, sys_vars.user_res_path);
			$("#cmp_"+id).data("old_t2BodyText",old_t2BodyText);
		}
		_createText2Component(json, sys_vars);
	};
	
	var _init_model = function(json){
		if(json){
			_model.id(json.id);
			_model.title(json.title);
			_model.x(json.x);
			_model.y(json.y);		
			_model.width(json.width);
			_model.height(json.height);
			_model.zIndex(json.zIndex);
			_model.display( json.display ? json.display : '' );
			_model.button( json.button ? json.button : '');
			_model.hideMode( json.hideMode ? json.hideMode : '');
			_model.text( json.text ? json.text : '');
			_model.aspectRatio( json.aspectRatio ? json.aspectRatio : false);
			
		}else{
			_model.id("");
			_model.title("");
			_model.x(0);
			_model.y(0);		
			_model.width(200);
			_model.height(200);
			_model.zIndex( '' );
			_model.display('');
			_model.button('');
			_model.hideMode('');
			_model.text('');
			_model.aspectRatio(false);
		}
		
		var button = function(id, title) {  
			this.id = id;   
			this.title = title;  
        };
        
		var buttons = [];
		for(key in Global.buttons){	
		    buttons.push(new button(key, Global.buttons[key]));
		}
		if(!_model.linkButtons) _model.linkButtons =  ko.observableArray();
		_model.linkButtons(buttons);
	};
    
    var _editComponent = function(component){
    	
    	_init_model(component);
    	
    	$_dialog.dialog("open");
	};
	
  
	exports.createComponent = _createComponent;
	
	exports.editComponent = _editComponent;
	
	exports.initCreate = _initCreate;

});