define(function(require, exports, module) {
	
	var _inited = false;
	
	var $_dialog = $("#vocabulary_dialog"),
	    $_type = $("select[name='sceneType']",$_dialog),
	    $_name = $("input[name='sceneName']",$_dialog),
	    //$_scenes = $("select[name='scenes']",$_dialog),
	    $_levels = $("select[name='levels']",$_dialog),
	    $_gameAudios = $("select[name='gameAudios']",$_dialog),
	    $_canvas_div = $("#vo_scenceCanvas td>div"),
	    
	    $_sceneInfo = {
		    start:{ name : Chidopi.lang.msg.scene_start, type : 1 },
		    menu:{ name : Chidopi.lang.msg.scene_levelMenu, type : 2 },
	    	level:{ name : Chidopi.lang.msg.scene_level, type : 3 },
	    	succ: { name : Chidopi.lang.msg.scene_succ,  type : 4 },
	    	fail: { name : Chidopi.lang.msg.scene_fail,  type : 5 },
	        score:{ name : Chidopi.lang.msg.scene_score, type : 6 },
	    }
     
	
    // var _fabric = require('fabric.min.js').fabric,
    var _canvas ;
    
	var _vars = {};
	
	ko.bindingHandlers['optionsTitle'] = {
	    'update': function(element, valueAccessor, allBindingsAccessor) {
	        var allBindings = allBindingsAccessor();
	        //get our array of options
	        var options = ko.utils.unwrapObservable(allBindings['options']);
	        //get the property that contains our title
	        var property = ko.utils.unwrapObservable(valueAccessor());
	
	        //get the option elements for this select element
	        var optionElements = $("option", element);
	        //if a caption was specified, then skip it when assigning title
	        var skipCaption = allBindings["optionsCaption"] ? 1 : 0;
	
	        //loop through options and assign title to appropriate optionElement
	        for (var i = 0, j = options.length; i < j; i++) {
	            var option = optionElements[i + skipCaption];
	            //option.title = options[i][property];
	            option.title = option.text;
	        }
	    }
	};

	
	var _absModel = function(type,scene){
		var obj = this;
		this.stopFlag = false;
		this.type = type;
		this.sceneType = scene;
		this.x = ko.observable();
		this.y = ko.observable();
		this.width = ko.observable();
		this.height = ko.observable();
		
		this.x.subscribe(function(newValue){
			if(obj.stopFlag) return;
	    	var img = _getCanvasObjectByType(obj.type);
			if(img){
				var axis2 = obj.changeToAxis2(parseInt(newValue), obj.y());
				if(img.getLeft() != axis2.x){
					img.set({left:axis2.x});
					_canvas.renderAll(); 
				}
			}
	    });
	    
	    this.y.subscribe(function(newValue){
	    	if(obj.stopFlag) return;
	    	var img = _getCanvasObjectByType(obj.type);
			if(img){
				var axis2 = obj.changeToAxis2(obj.x(), parseInt(newValue));
				if(img.getTop() != axis2.y){
					img.set({top:axis2.y});
					_canvas.renderAll(); 
				}
			}
	    });
	    
	    this.width.subscribe(function(newValue){
	    	if(obj.stopFlag) return;
	    	var img = _getCanvasObjectByType(obj.type);
			if(img){
				if(img.getWidth() != parseInt(newValue)){
					img.set({width: parseInt(newValue)});
					_canvas.renderAll(); 
					var x = img.getLeft(), y = img.getTop();
					var axis1 = obj.changeToAxis1(x, y);
					obj.x(axis1.x).y(axis1.y);
				}
			}
	    });
	    
	    this.height.subscribe(function(newValue){
	    	if(obj.stopFlag) return;
	    	var img = _getCanvasObjectByType(obj.type);
			if(img){
				if(img.getHeight() != parseInt(newValue)){
					img.set({height: parseInt(newValue)});
					_canvas.renderAll();
					var x = img.getLeft(), y = img.getTop();
					var axis1 = obj.changeToAxis1(x, y);
					obj.x(axis1.x).y(axis1.y);
				}
			}
	    });
	    
	    this.changeToAxis2 = function(x1, y1){
	    	var w = obj.width() ? obj.width() : 0;
	    	var h = obj.height() ? obj.height() : 0;
	    	return  {x: parseInt(x1 - 0 + w/2), y: parseInt(y1 - 0 + h/2) };
	    }
	    
	    this.changeToAxis1 = function(x2, y2){
	    	var w = obj.width() ? obj.width() : 0;
	    	var h = obj.height() ? obj.height() : 0;
	    	return { x: parseInt(x2 - w/2), y: parseInt(y2 - h/2) };
	    }
	    
	    this.notInitialed = function(){
	    	return typeof(obj.x()) == "undefined" || typeof(obj.y()) == "undefined" 
	    		    || isNaN(obj.x()) || isNaN(obj.y()); 
	    }
	    
	};

	var _updateCanvasText = function(settings,textModel){
		var text = _getCanvasObjectByType(textModel.type);
		if(text){
			text.set(settings);
			_canvas.renderAll();
		}
	};

	var _TextModel = function(type,scene){
		var obj = this;
		_absModel.call(this,type,scene);
		
		this.fontFamily = ko.observable('Arial');
		this.size = ko.observable(40);
		//this.color = ko.observable('#000');
		this.rgb = ko.observable('0,0,0');
		
		this.color = ko.computed(function(){
			 var arr = obj.rgb().split(',');
			 return {
				 r:arr[0],
				 g:arr[1],
				 b:arr[2]
			 };
		});
		
		this.fontFamily.subscribe(function(newValue){
			_updateCanvasText({fontFamily:newValue},obj);
		});
		
		this.size.subscribe(function(newValue){
			_updateCanvasText({fontSize: newValue},obj);
		});
		
		this.rgb.subscribe(function(newValue){
			_updateCanvasText({fill:'rgb('+ newValue+')'},obj);
			
		});
		
		this.fromJS = function(json){
			if(!json) return;
			obj.x(json.x - 0);
	    	obj.y(json.y - 0);
	    	obj.width(json.width - 0);
	    	obj.height(json.height - 0);
	    	obj.fontFamily(json.fontFamily);
	    	obj.size(json.size);
	    	obj.rgb(json.rgb ? json.rgb : '0,0,0');
	    	//obj.color(json.color);
		}
		
	};
	
	var _RectModel = function(type,scene){
		var obj = this;
		_absModel.call(this,type,scene);
		this.fromJS = function(json){
	    	if(!json) return;
	    	obj.x(json.x - 0);
	    	obj.y(json.y - 0);
	    	obj.width(json.width - 0);
	    	obj.height(json.height - 0);
		}
	};
	
	var _ImageModel = function(type,scene){
		
		var obj = this;
		_absModel.call(this,type,scene);
		
		this.pic1 = ko.observable();
		this.pic2 = ko.observable();
		
		//this.action = ko.observable();
		
	    this.pic1.subscribe(function(newValue){
	    	if(obj.stopFlag) return;
	    	console.log(obj.type + "," + obj.type.indexOf("levelIcon"));
	    	if(obj.type.indexOf("levelIcon")>-1)return;
	    	switch(obj.type){
	    	    case 'readyGo':
	    	    	_drawImageFromModel2(_canvas,obj);
	    	    	break;
	    	    case 'modeMenu':
	    	    case 'modeBack':
	    	    case 'callenge':
	    	    case 'practice':
	    	    case 'levelMenu':
	    	    case 'levelBack':
	    	    	return;
	    	    	break;
	    	    default:
	    	    	_drawAndUpdateImage(newValue,obj);
	    	        
	    	}
	    });
	    
	    this.fromJS = function(json){
	    	if(!json) return;
	    	obj.stopFlag = true;
	    	obj.x(parseInt(json.x));
	    	obj.y(parseInt(json.y));
	    	obj.width(json.width - 0);
	    	obj.height(json.height - 0);
	    	//obj.action(json.action);
	    	obj.pic1(json.pic1);
	    	obj.pic2(json.pic2);
	    	obj.stopFlag = false;
		}
	};
	
	var _LevelImageModel= function(type,scene){
		
		var obj = this;
		_ImageModel.call(this, type, scene);
		this.action = ko.observable();
		//this.completePic = ko.observable();
		
		this.fromJS = function(json){
			if(!json) return;
	    	obj.stopFlag = true;
	    	obj.x(parseInt(json.x));
	    	obj.y(parseInt(json.y));
	    	obj.width(json.width - 0);
	    	obj.height(json.height - 0);
	    	obj.pic1(json.pic1);
	    	obj.pic2(json.pic2);
	    	obj.action(json.action);
	    	//obj.completePic(json.completePic);
	    	obj.stopFlag = false;
	    	
		}
		
//		this.action.subscribe(function(newValue){
//			//alert(newValue);
//		});
	}
	
	var _model = {
		number : ko.observable(),
        id     : ko.observable(),
		title  : ko.observable(),
		x      : ko.observable(),
		y      : ko.observable(),
		width  : ko.observable(),
		height : ko.observable(),
		zIndex : ko.observable(),
		aspectRatio: ko.observable(),
		
		rightAudio  : ko.observable(),
		errorAudio  : ko.observable(),
		finishAudio : ko.observable(),
		rightScore  : ko.observable(),
		errorScore  : ko.observable(),
		
		backIcon    : ko.observable(new _ImageModel('back',0)),
		sceneSwitchMode : ko.observable(),
		sceneSwitchColor: ko.observable(),
	    //scenes      : ko.observableArray(),
	    currentScene : ko.observable(),
	   
	    levelScenes : ko.observableArray(),
	    
	    particle : {
	    	img: ko.observable(),
	    	number: ko.observable(),
	    	count : 1,
	    	type : ko.observable(),
	    },
	    
	    gameMode: {
	    	challenge   : ko.observable(),
	        practice    : ko.observable(),
	        practiceMode: ko.observable(),
	    },
	    
	};
	
	_model.gameMode.challenge.subscribe(function(newValue){
		if(newValue == false){
			_model.menuScene().radioMenu('l');
		}
	});
	
	_model.gameMode.practice.subscribe(function(newValue){
		if(newValue==false){
			_model.gameMode.challenge(true);
		}
	});
	
	var _drawOverlayImage = function(pic, showOverlay){
	    var src = "";
	    if(pic && showOverlay){
			src = _vars.base_url + _vars.user_res_path + "/" + pic;
		}
		_canvas.setOverlayImage(src,_canvas.renderAll.bind(_canvas));
	};
	
	var _getCanvasImageByType = function(type){
		var the_obj ;
	    _canvas.forEachObject(function (obj) {
	        if (type == obj.oType) {
	          the_obj = obj;
	          return;
	        }
	    });
	    return the_obj;
	};
	
	var _getCanvasObjectByType = function(type){
    	return _getCanvasImageByType(type);
    };
	
	var _drawImageFromModel = function(canvas, imageModel){
		var pic = imageModel.pic1();
		if(pic){
			var url = _vars.base_url + _vars.user_res_path + "/" + pic;
			fabric.Image.fromURL(url, function (img) {
				var	x = imageModel.x(),
	                y = imageModel.y(),
	                w = imageModel.width(),
	                h = imageModel.height();
		        
		        var axis2 = imageModel.changeToAxis2(x,y);
		        oImg = img.set({ left: axis2.x, top: axis2.y, width: w, height: h});
		        oImg.hasControls = false;
		        oImg.relUrl = pic;
		        oImg.oType = imageModel.type;
		        canvas.add(oImg);
		        if(imageModel.type == 'levelMenu' || imageModel.type == 'modeMenu' ){
		        	_canvas.sendToBack(oImg);			        	
		        }
		    });
		}
	};
	
	var _drawImageFromModel2 = function(canvas, imageModel){
		var pic = imageModel.pic1();
		var old = _getCanvasImageByType(imageModel.type);
		
		if(old) _canvas.remove(old);
		
		if(pic){
			var url = _vars.base_url + _vars.user_res_path + "/" + pic;
			fabric.Image.fromURL(url, function (img) {
				var centerCoord = _canvas.getCenter();
				var	x = centerCoord.left,
	                y = centerCoord.top,
	                w = img.width,
	                h = img.height;
		        
		        oImg = img.set({ left: x, top: y, width: w, height: h});
		        //oImg.hasControls = false;
		        oImg.selectable = false;
		        oImg.relUrl = pic;
		        oImg.oType = imageModel.type;
		        _canvas.add(oImg);
		        _canvas.sendToBack(oImg);
		        var axis1 = imageModel.changeToAxis1(x,y);
		        imageModel.x(axis1.x).y(axis1.y).width(w).height(h);
		    });
		}
	};
	
	var _drawRectFromModel = function(canvas, rectModel){
		var old = _getCanvasObjectByType(rectModel.type);
		if(old) canvas.remove(old);
		var centerCoord = canvas.getCenter();
		var x = rectModel.x(),
		    y = rectModel.y(),
		    axis2 = rectModel.changeToAxis2(x,y);
		
		var rect = new fabric.Rect({
	        left: axis2.x,
	        top: axis2.y,
	        width: rectModel.width(),
	        height: rectModel.height(),
	        fill: '#00ff00',
	        opacity: 0.7
	       
	    });
		
		rect.oType = rectModel.type;
		rect.lockRotation = true;
		canvas.add(rect);
	};
	
	var _drawTextFromModel = function(canvas, textModel, selectable){
		var textJson = {wordText: 'test_word', time:'120', score:'0'};
		var old = _getCanvasObjectByType(textModel.type);
		if(old) canvas.remove(old);
		var x = textModel.x(),
		    y = textModel.y(),
		    axis2 = textModel.changeToAxis2(x,y);
		var text = new fabric.Text( textJson[textModel.type], {
	        left: axis2.x,
	        top: axis2.y,
	        fontFamily: textModel.fontFamily(),
	        fill: "rgb("+ textModel.rgb ()+")",//textModel.color(),
	        fontSize: textModel.size()-0,
	    });
		text.hasControls = false;
		//text.hasBorders = false;
		if(selectable == false) text.selectable = selectable;
        text.oType = textModel.type;
		canvas.add(text);
	};
	
	var _drawAndUpdateImage = function(pic, imageModel, notDraw){
		var old = _getCanvasImageByType(imageModel.type);
		if(old) _canvas.remove(old);
		if(pic){
			var url = _vars.base_url + _vars.user_res_path + "/" + pic;
			fabric.Image.fromURL(url, function (img) {
				var w = img.get('width'),
				    h = img.get('height'),
	                x = imageModel.x() ? imageModel.x() : 0,
	                y = imageModel.y() ? imageModel.y() : 0;
		        imageModel.width(w);
		        imageModel.height(h);
		        imageModel.x(x);
		        imageModel.y(y);
		        if(imageModel.sceneType && notDraw != true){ // scene 0 dont draw
			        var axis2 = imageModel.changeToAxis2(x,y);
			        oImg = img.set({ left: axis2.x, top: axis2.y});
			        oImg.hasControls = false;
			        oImg.relUrl = pic;
			        oImg.oType = imageModel.type;
			        _canvas.add(oImg);
			        if(imageModel.type == 'levelMenu' || imageModel.type == 'modeMenu' ){
			        	_canvas.sendToBack(oImg);			        	
			        }
		        }
		    });
		}else{
			imageModel.width(0);
	        imageModel.height(0);
	        imageModel.x(0);
	        imageModel.y(0);
		}
	};
	
	var _drawBackgroundImage = function(pic){
		var src = "";
		if(pic){
		    src = _vars.base_url + _vars.user_res_path + "/" + pic;
		}
		_canvas.backgroundImageStretch = true;
		_canvas.setBackgroundImage(src, _canvas.renderAll.bind(_canvas));
		
	};
	
	var _absScene = function(){
		var $_parent = this;
		this.id = ko.observable();
	    this.name = ko.observable();
	    this.type = ko.observable();
	    this.draw = function(canvas, parent){};
	    
	    this.fromJS = function(json){
	    	if(!json) return;
    	    $_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
    	
	    };
	}
	// 1
	var _startScene = function(){
		var $_parent = this;
		_absScene.call(this);
	    this.loadingPic = ko.observable();
	    this.bgPic = ko.observable();
	    this.bgSound = ko.observable();
	    this.bgSoundIcon = ko.observable(new _ImageModel('bgSound',1));
	    this.startIcon = ko.observable(new _ImageModel('start',1));
	    this.continueIcon = ko.observable(new _ImageModel('continue',1));
	    this.scoreIcon = ko.observable(new _ImageModel('score',1));
	    this.showOverlay = ko.observable(),
	    
	    this.showOverlay.subscribe(function(newValue){
			_drawOverlayImage($_parent.loadingPic(), newValue);
		});
	    
	    this.loadingPic.subscribe(function (newValue) {
	        //$_parent.showOverlay(newValue || "");
	    	_drawOverlayImage(newValue,$_parent.showOverlay());
	    });
	    
	    this.bgPic.subscribe(function (newValue) {
	    	if(_model.checkScene()!=1)return;
	    	_drawBackgroundImage(newValue);
	    });
	    
	    this.handleMoving = function(target){
	    	var _type = target.oType;
	    	var x = target.getLeft(),
	    	    y = target.getTop();
	    	var img_model ;
	    	switch(_type){
	    	    case 'bgSound':
	    	        img_model = $_parent.bgSoundIcon();
	    	        break;
	    	    case 'start':
	    	        img_model = $_parent.startIcon();
	    	        break;
	    	    case 'continue':
	    	    	img_model = $_parent.continueIcon();
	    	    	break;
	    	    case 'score':
	    	    	img_model = $_parent.scoreIcon();
	    	    	break;
	    	}
	    	if(img_model){
	    		img_model.stopFlag = true;
	    		var axis1 = img_model.changeToAxis1(x,y);
	    		img_model.x(axis1.x);
	    		img_model.y(axis1.y);
	    		img_model.stopFlag = false;
	    	}
	    };

	    this.draw = function(canvas, parent){
	    	_drawBackgroundImage($_parent.bgPic());
	    	_drawImageFromModel(canvas,$_parent.bgSoundIcon());
	    	_drawImageFromModel(canvas,$_parent.startIcon());
	    	_drawImageFromModel(canvas,$_parent.continueIcon());
	    	_drawImageFromModel(canvas,$_parent.scoreIcon());
	    };
	    
	    this.fromJS = function(json){
	    	if(!json) return;
	    	$_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
	    	$_parent.loadingPic(json.loadingPic);
	    	$_parent.bgPic(json.bgPic);
	    	$_parent.bgSound(json.bgSound);
	    	
            var imageModel = new _ImageModel('bgSound',1);
            imageModel.fromJS(json.bgSoundIcon);
	    	$_parent.bgSoundIcon(imageModel);
	    	
	    	imageModel = new _ImageModel('start',1);
            imageModel.fromJS(json.startIcon);
	    	$_parent.startIcon (imageModel);
	    	
	    	imageModel = new _ImageModel('continue',1);
            imageModel.fromJS(json.continueIcon);
	    	$_parent.continueIcon (imageModel);
	    	
	    	imageModel = new _ImageModel('score',1);
            imageModel.fromJS(json.scoreIcon);
	    	$_parent.scoreIcon(imageModel);
	    	
	    };
	}
	
    // 选关场景 2
	var _menuScene = function(){
		var $_parent = this;
		_absScene.call(this);
		this.bgPic = ko.observable();
		this.radioMenu = ko.observable('m');
		this.menu = {
				modeMenu: {
					menuPic : ko.observable(new _ImageModel("modeMenu",2)),
					menuBack: ko.observable(new _RectModel("modeBack",2)),
					callengeIcon : ko.observable(new _ImageModel("callenge",2)),
					practiceIcon : ko.observable(new _ImageModel("practice",2)),
				},
				levelMenu:{
					menuPic: ko.observable(new _ImageModel("levelMenu",2)),
					menuBack: ko.observable(new _RectModel("levelBack",2)),
					levelItems: ko.observableArray([]),
				}
		}
		
		this.binding = function(){
			
			$.each($_parent.menu.levelMenu.levelItems(),function(n,value){
				value.pic1.subscribe(function(newValue){
					console.log("binding");
    		    	var menu = $_parent.radioMenu();
    				_drawAndUpdateImage(newValue,value,menu != "l");
    		    });
	    	});
		};
		
		this.menu.modeMenu.menuPic().pic1.subscribe(function (newValue) {
			var menu = $_parent.radioMenu();
			_drawAndUpdateImage(newValue,$_parent.menu.modeMenu.menuPic(),menu != "m");
	    });
		this.menu.modeMenu.callengeIcon().pic1.subscribe(function (newValue) {
			var menu = $_parent.radioMenu();
			_drawAndUpdateImage(newValue,$_parent.menu.modeMenu.callengeIcon(),menu != "m");
	    });
		
		this.menu.modeMenu.practiceIcon().pic1.subscribe(function (newValue) {
			var menu = $_parent.radioMenu();
			_drawAndUpdateImage(newValue,$_parent.menu.modeMenu.practiceIcon(),menu != "m");
	    });
		
		this.menu.levelMenu.menuPic().pic1.subscribe(function (newValue) {
			var menu = $_parent.radioMenu();
			_drawAndUpdateImage(newValue,$_parent.menu.levelMenu.menuPic(),menu != "l");
	    });
		
		this.bgPic.subscribe(function (newValue) {
	    	if(_model.checkScene()!=2)return;
	    	_drawBackgroundImage(newValue);
	    });
		
		this.radioMenu.subscribe(function (newValue) {
			_canvas.clear();
	 		_canvas.renderAll();
	 		drawMenu(_canvas,_model);
	    });
		
		this.menu.levelMenu.levelItems.subscribe(function (newValue) {
			_canvas.clear();
	 		_canvas.renderAll();
	 		drawMenu(_canvas,_model);
	    });
		
		this.handleScaling = function(target){
	    	var _type = target.oType;
	    	var w = parseInt(target.getWidth()),
	    	    h = parseInt(target.getHeight()),
	    	    model;
	        switch(_type){
	            case 'modeBack':
	            	model = $_parent.menu.modeMenu.menuBack();
	            	break;
	            case 'levelBack':
	            	model = $_parent.menu.levelMenu.menuBack();
	            	break;
	        }
	        
	        if(model){
	    		model.stopFlag = true;
	    		var x = target.getLeft(),
	    			y = target.getTop();
	    		var axis1 = model.changeToAxis1(x,y);
	    		model.x(axis1.x);
	    		model.y(axis1.y);
	    		model.width(w);
	    		model.height(h);
	    		model.stopFlag = false;
	    	}
	    }
	    
	    this.handleMoving = function(target){
	    	var _type = target.oType;
	    	var x = target.getLeft(),
	    	    y = target.getTop();
	    	
	    	var model ;
	    	switch(_type){
	    	    case 'modeMenu':
	    	    	model = $_parent.menu.modeMenu.menuPic();
	    	        break;
	    	    case 'modeBack' :
	    	    	model = $_parent.menu.modeMenu.menuBack();
	    	    	break;
	    	    case 'callenge':
	    	    	model = $_parent.menu.modeMenu.callengeIcon();
	    	    	break;
	    	    case 'practice':
	    	    	model = $_parent.menu.modeMenu.practiceIcon();
	    	    	break;
	    	    case 'levelMenu':
	    	    	model = $_parent.menu.levelMenu.menuPic();
	    	    	break;
	    	    case 'levelBack':
	    	    	model = $_parent.menu.levelMenu.menuBack();
	    	    	break;
	    	    default:
	    	    	$.each($_parent.menu.levelMenu.levelItems(),function(n,value){
	    	    		if(_type == value.type){
	    	    			model = value;
	    	    		}
	    	    	});
	    	}
	    	
	    	if(model){
	    		model.stopFlag = true;
	    		var axis1 = model.changeToAxis1(x,y);
	    		model.x(axis1.x);
	    		model.y(axis1.y);
	    		model.stopFlag = false;
	    	}
	    };
	    
	    var drawMenu = function(canvas, parent){
	    	if(_model.checkScene()!=2)return;
	    	var menu = $_parent.radioMenu();
	    	if(menu == 'm'){
	    		_drawImageFromModel(canvas, $_parent.menu.modeMenu.menuPic());
		    	_drawRectFromModel(canvas, $_parent.menu.modeMenu.menuBack());
		    	_drawImageFromModel(canvas, $_parent.menu.modeMenu.callengeIcon());
		    	_drawImageFromModel(canvas, $_parent.menu.modeMenu.practiceIcon());
		    	
	    	}else{
	    		_drawImageFromModel(canvas, $_parent.menu.levelMenu.menuPic());
		    	_drawRectFromModel(canvas, $_parent.menu.levelMenu.menuBack());
		    	// draw level icons
		    	var icons = $_parent.menu.levelMenu.levelItems();
		    	$.each(icons,function(n,value){
		    		_drawImageFromModel(canvas, value);
		    	});
	    	}
	    }
		
	    this.draw = function(canvas, parent){
	    	_drawBackgroundImage($_parent.bgPic());
	    	if($_parent.menu.modeMenu.menuBack().notInitialed()){
	    		$_parent.menu.modeMenu.menuBack()
	    		     .x(parseInt(parent.width()-100))
	    		     .y(parseInt(parent.height()/3))
	    		     .width(50).height(50);
	    	}
	    	
	    	if($_parent.menu.levelMenu.menuBack().notInitialed()){
	    		$_parent.menu.levelMenu.menuBack()
	    		     .x(parseInt(parent.width()-100))
	    		     .y(parseInt(parent.height()/3))
	    		     .width(50).height(50);
	    	}
	    	drawMenu(canvas,parent);
	    	
	    };
	    
	    this.fromJS = function(json){
	    	if(!json) return;
	    	$_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
	    	$_parent.bgPic(json.bgPic);
	    	$_parent.radioMenu(json.radioMenu);
	    	
	    	var imageModel = new _ImageModel('modeMenu',2);
            imageModel.fromJS(json.menu.modeMenu.menuPic);
	    	$_parent.menu.modeMenu.menuPic(imageModel);
	    	
	    	imageModel = new _RectModel('modeBack',2);
            imageModel.fromJS(json.menu.modeMenu.menuBack);
	    	$_parent.menu.modeMenu.menuBack(imageModel);
	    	
	    	imageModel = new _ImageModel('callenge',2);
            imageModel.fromJS(json.menu.modeMenu.callengeIcon);
	    	$_parent.menu.modeMenu.callengeIcon(imageModel);
	    	
	    	imageModel = new _ImageModel('practice',2);
            imageModel.fromJS(json.menu.modeMenu.practiceIcon);
	    	$_parent.menu.modeMenu.practiceIcon(imageModel);
	    	
	    	imageModel = new _ImageModel('levelMenu',2);
            imageModel.fromJS(json.menu.levelMenu.menuPic);
	    	$_parent.menu.levelMenu.menuPic(imageModel);
	    	
	    	imageModel = new _RectModel('levelBack',2);
            imageModel.fromJS(json.menu.levelMenu.menuBack);
	    	$_parent.menu.levelMenu.menuBack(imageModel);
	    	
	    	$.each(json.menu.levelMenu.levelItems,function(n,value){
	    		imageModel = new _LevelImageModel(value.type,2);
	    		imageModel.fromJS(value);
	    		$_parent.menu.levelMenu.levelItems().push(imageModel);
	    		/*imageModel.pic1.subscribe(function(newValue){
	    			console.log("fromJS");
    		    	var menu = _model.menuScene().radioMenu();
    				_drawAndUpdateImage(newValue,imageModel,menu != "l");
    		    });*/
	    	});
	    	
	    	$_parent.menu.modeMenu.menuPic().pic1.subscribe(function (newValue) {
				var menu = $_parent.radioMenu();
				_drawAndUpdateImage(newValue,$_parent.menu.modeMenu.menuPic(),menu != "m");
		    });
		    
	    	$_parent.menu.modeMenu.callengeIcon().pic1.subscribe(function (newValue) {
				var menu = $_parent.radioMenu();
				_drawAndUpdateImage(newValue,$_parent.menu.modeMenu.callengeIcon(),menu != "m");
		    });
			
	    	$_parent.menu.modeMenu.practiceIcon().pic1.subscribe(function (newValue) {
				var menu = $_parent.radioMenu();
				_drawAndUpdateImage(newValue,$_parent.menu.modeMenu.practiceIcon(),menu != "m");
		    });
			
	    	$_parent.menu.levelMenu.menuPic().pic1.subscribe(function (newValue) {
				var menu = $_parent.radioMenu();
				_drawAndUpdateImage(newValue,$_parent.menu.levelMenu.menuPic(),menu != "l");
		    });
	    };
	};
	
	var gameObj = function(qu,an,wo,au){
    	this.question = qu;
    	this.answer   = an;
    	this.word     = wo;
    	this.audio    = au;
	};
	
	// 3
	var _levelScene = function(){
		var $_parent = this;
		_absScene.call(this);
	    this.bgPic = ko.observable();
	    this.bgSound = ko.observable();
	    this.readyGoIcon = ko.observable(new _ImageModel("readyGo",3));
	    this.readyWidth = ko.observable();
	    
	    this.timeLimit = ko.observable(120);
	    //this.succAction = ko.observable();
	    //this.failAction = ko.observable();
	    this.gameRounds = ko.observable(12);//轮次 答题次数
	    this.gameColomn = ko.observable(5);
	    
	    this.timeStay = ko.observable(0);
	    this.direction = ko.observable("BT");
	    
	    this.timeText = ko.observable(new _TextModel("time",3));
	    this.scoreText = ko.observable(new _TextModel("score",3));
	    this.wordText = ko.observable(new _TextModel("wordText",3));
	    this.wordRect = ko.observable(new _RectModel("wordRect",3));
	    this.gameRect = ko.observable(new _RectModel("game",3));
	    
	    this.gameQuestions = ko.observableArray([]),
	    this.gameAnswers = ko.observableArray([]),
	    this.gameWords = ko.observable('');
	    this.gameAudios = ko.observableArray([]),
	    
	    this.gameContent = [],
	    this.gameAnswerSize = {
	    	//row : ko.observable(1),
	    	col : ko.observable(1),
	    	width : ko.observable(0),
	    	height: ko.observable(0),
	    },
	   
	    this.bgPic.subscribe(function (newValue) {
	    	if(_model.checkScene()!=3)return;
	    	_drawBackgroundImage(newValue);
	    });
	    
	    this.gameAnswers.subscribe(function(newValue){
	    	var imgs = $_parent.gameAnswers();
	    	if(imgs.length && $_parent.gameAnswerSize.width() < 1){
	    		var url = _vars.base_url + _vars.user_res_path + "/" + imgs[0];
				fabric.Image.fromURL(url, function (img) {
					$_parent.gameAnswerSize.width(img.width).height(img.height);
			    });
	    	}else{
	    		if(!imgs.length){
	    		    $_parent.gameAnswerSize.width(0).height(0);
	    	    }
	    	}
	    });
	    
	    this.handleScaling = function(target){
	    	var _type = target.oType;
	    	var w = parseInt(target.getWidth()),
	    	    h = parseInt(target.getHeight()),
	    	    model;
	        switch(_type){
	            case 'wordRect':
	            	model = $_parent.wordRect();
	            	break;
	            case 'game':
	            	model = $_parent.gameRect();
	            	break;
	        }
	        
	        if(model){
	    		model.stopFlag = true;
	    		var x = target.getLeft(),
	    			y = target.getTop();
	    		var axis1 = model.changeToAxis1(x,y);
	    		model.x(axis1.x);
	    		model.y(axis1.y);
	    		model.width(w);
	    		model.height(h);
	    		model.stopFlag = false;
	    	}
	    }
	    
	    this.handleMoving = function(target){
	    	var _type = target.oType;
	    	var x = target.getLeft(),
	    	    y = target.getTop();
	    	
	    	var model ;
	    	switch(_type){
	    	    case 'back':
	    	    	model = _model.backIcon();
	    	        break;
	    	    case 'wordRect' :
	    	    	model = $_parent.wordRect();
	    	    	$_parent.wordText().x(parseInt($_parent.wordRect().x() - 0 + $_parent.wordRect().width() / 2))
                    .y(parseInt($_parent.wordRect().y() - 0 + $_parent.wordRect().height() / 2));
	    	    	break;
	    	    case 'time':
	    	    	model = $_parent.timeText();
	    	    	break;
	    	    case 'score':
	    	    	model = $_parent.scoreText();
	    	    	break;
	    	    case 'game':
	    	    	model = $_parent.gameRect();
	    	    	break;
	    	}
	    	
	    	if(model){
	    		model.stopFlag = true;
	    		var axis1 = model.changeToAxis1(x,y);
	    		model.x(axis1.x);
	    		model.y(axis1.y);
	    		model.stopFlag = false;
	    	}
	    };
	    
	    // $_parent == this
	    // parent == _model
	    this.draw = function(canvas, parent){
	    	parent.levelScene($_parent);
	    	_drawBackgroundImage($_parent.bgPic());
	    	_drawImageFromModel(canvas, parent.backIcon());
	    	
	    	if($_parent.timeText().notInitialed()){
	    		$_parent.timeText().x(parseInt(parent.width()/2)).y(200);
	    	}
	    	if($_parent.scoreText().notInitialed()){
	    		$_parent.scoreText().x(parent.width()-50).y(200);
	    	}
	    	if($_parent.wordRect().notInitialed()){
	    		$_parent.wordRect().x(50).y(100).width(300).height(120);
	    		$_parent.wordText().x(parseInt($_parent.wordRect().x() - 0 + $_parent.wordRect().width() / 2))
                                   .y(parseInt($_parent.wordRect().y() - 0 + $_parent.wordRect().height() / 2));
	    		
	    	}
	    	if($_parent.gameRect().notInitialed()){
	    		$_parent.gameRect().x(0).y(parseInt(parent.height()/3))
	    		                   .width(parent.width()-0).height(parseInt(parent.height()*2/3));
	    	}
	    	
	    	_drawImageFromModel2(canvas, $_parent.readyGoIcon());
	    	_drawTextFromModel(canvas, $_parent.wordText(),false);
	    	_drawRectFromModel(canvas, $_parent.wordRect());
	    	_drawRectFromModel(canvas, $_parent.gameRect());
	    	_drawTextFromModel(canvas, $_parent.timeText());
	    	_drawTextFromModel(canvas, $_parent.scoreText());
	    };
	    
	    this.addOption = function(type, field){
	    	openKCFinder({
				 field:this,
				 prefix: '',
				 mode  :"m",
				 type: type,
				 onComplete: function (files) {					
				     for(var i = 0;i<files.length;i++){
				    	 $_parent[field]().push(files[i])
					 }
				     $_parent[field].valueHasMutated();
				 }
			});
	    };
	    
	    this.delOption = function(name, field){
	    	
	    	var $select = $("select[name='"+name+"']",$_dialog);
	    	
	    	if($select.val()) $_parent[field].remove($select.val());
	    	
	    	$select.change();
	    };
	    
	    this.moveUp = function(name,field){
	    	
	    	var $select = $("select[name='"+name+"']",$_dialog);
	    	
	    	if($select.val()){
	    		var index = $select[0].selectedIndex;
	    		if(index < 1) return;
	    		var options = $_parent[field]();
	    		var curr = options[index];
				var prev = options[index-1];
				options[index] = prev;
				options[index-1] = curr;
			   
				$_parent[field].valueHasMutated();
	    	}
		};
		
		this.moveDown = function(name, field){
			var $select = $("select[name='"+name+"']",$_dialog);
			if($select.val()){
				
				var index = $select[0].selectedIndex;
				var options = $_parent[field]();
				
				if(index == options.length-1) return;
				
				var curr = options[index];
				var next = options[index+1];
				options[index] = next;
				options[index+1] = curr;
			   
				$_parent[field].valueHasMutated();
			}
		};
		
		
		this.fromJS = function(json){
			    	
	    	if(!json) return;
	    	$_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
	    	$_parent.bgPic(json.bgPic);
	    	$_parent.bgSound(json.bgSound);
		    $_parent.readyWidth(json.readyWidth);
		    
		    $_parent.timeLimit(json.timeLimit);
		    //$_parent.succAction(json.succAction);
		    //$_parent.failAction(json.failAction);
		    $_parent.gameRounds(json.gameRounds);
		    $_parent.gameColomn(json.gameColomn);
		    $_parent.timeStay(json.timeStay? json.timeStay: 0);
		    $_parent.direction(json.direction ? json.direction : 'BT');
		    
		    var model = new _ImageModel('readyGo',3);
		    model.fromJS(json.readyGoIcon);
			$_parent.readyGoIcon(model);
			
			model = new _TextModel("time",3);
			model.fromJS(json.timeText);
		    $_parent.timeText(model);
		    
		    model = new _TextModel("score",3);
			model.fromJS(json.scoreText);
		    $_parent.scoreText(model);
		    
		    model = new _TextModel("wordText",3);
			model.fromJS(json.wordText);
		    $_parent.wordText(model);
		    
		    model = new _RectModel("wordRect",3);
			model.fromJS(json.wordRect);
		    $_parent.wordRect(model);
		    
		    model = new _RectModel("game",3);
			model.fromJS(json.gameRect);
		    $_parent.gameRect(model);
		    
//		    $_parent.gameAnswerSize.row(json.gameAnswerSize.row);
		    $_parent.gameAnswerSize.col(json.gameAnswerSize.col);
		    $_parent.gameAnswerSize.width(json.gameAnswerSize.width);
		    $_parent.gameAnswerSize.height(json.gameAnswerSize.height);
		    
		    var words = [], notEmpty = false;
		    $.each(json.gameContent,function(n,value) { 
		        if(value.question) $_parent.gameQuestions().push(value.question);
		        if(value.answer) $_parent.gameAnswers().push(value.answer);
		        words.push(value.word);
		        if(value.word){ notEmpty = true;}
		        if(value.audio) $_parent.gameAudios().push(value.audio);
		    });
		    if(notEmpty){
		    	$_parent.gameWords(words.join(","));
		    }
		    //$_parent.gameWords(json.gameWords);
		    //$_parent.gameAudios(json.gameAudios);
	    	
		};
	};
	//4
	var _succScene = function(){
		var $_parent = this;
		_absScene.call(this);
	    this.bgPic = ko.observable();
	    this.tryAgainIcon = ko.observable(new _ImageModel('tryAgain',4));
	    this.scoreIcon = ko.observable(new _ImageModel('score',4));
	    
	    this.bgPic.subscribe(function (newValue) {
	    	if(_model.checkScene()!=4)return;
	    	_drawBackgroundImage(newValue);
	    });
	    
	    this.handleMoving = function(target){
	    	var _type = target.oType;
	    	var x = target.getLeft(),
	    	    y = target.getTop();
	    	var img_model ;
	    	switch(_type){
	    	    case 'back':
	    	    	img_model = _model.backIcon();
	    	        break;
	    	    case 'tryAgain':
	    	    	img_model = $_parent.tryAgainIcon();
	    	    	break;
	    	    case 'score':
	    	    	img_model = $_parent.scoreIcon();
	    	    	break;
	    	}
	    	
	    	if(img_model){
	    		img_model.stopFlag = true;
	    		var axis1 = img_model.changeToAxis1(x,y);
	    		img_model.x(axis1.x);
	    		img_model.y(axis1.y);
	    		img_model.stopFlag = false;
	    	}
	    };
	    
	    this.draw = function(canvas, parent){
	    	_drawBackgroundImage($_parent.bgPic());
	    	_drawImageFromModel(canvas, parent.backIcon());
	    	_drawImageFromModel(canvas,$_parent.tryAgainIcon());
	    	_drawImageFromModel(canvas,$_parent.scoreIcon());
	    };
	    
	    this.fromJS = function(json){
	    	
	    	if(!json) return;
	    	$_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
	    	$_parent.bgPic(json.bgPic);
	    	var model = new _ImageModel('tryAgain',4);
	    	model.fromJS(json.tryAgainIcon);
	    	this.tryAgainIcon(model);
	    	
	    	model = new _ImageModel('score',4);
	    	model.fromJS(json.scoreIcon);
		    this.scoreIcon(model);
	    }
	    
	};
	//5
	var _failScene = function(){
		var $_parent = this;
		_absScene.call(this);
	    this.bgPic = ko.observable();
	    this.tryAgainIcon = ko.observable(new _ImageModel('tryAgain',5));
	    this.scoreIcon = ko.observable(new _ImageModel('score',5));
	    
	    this.bgPic.subscribe(function (newValue) {
	    	if(_model.checkScene()!=5)return;
	    	_drawBackgroundImage(newValue);
	    });
	    
	    this.handleMoving = function(target){
	    	var _type = target.oType;
	    	var x = target.getLeft(),
	    	    y = target.getTop();
	    	var img_model ;
	    	switch(_type){
	    	    case 'back':
	    	    	img_model = _model.backIcon();
	    	        break;
	    	    case 'tryAgain':
	    	    	img_model = $_parent.tryAgainIcon();
	    	    	break;
	    	    case 'score':
	    	    	img_model = $_parent.scoreIcon();
	    	    	break;
	    	}
	    	
	    	if(img_model){
	    		img_model.stopFlag = true;
	    		var axis1 = img_model.changeToAxis1(x,y);
	    		img_model.x(axis1.x);
	    		img_model.y(axis1.y);
	    		img_model.stopFlag = false;
	    	}
	    };
	    
	    this.draw = function(canvas, parent){
	    	_drawBackgroundImage($_parent.bgPic());
	    	_drawImageFromModel(canvas, parent.backIcon());
	    	_drawImageFromModel(canvas,$_parent.tryAgainIcon());
	    	_drawImageFromModel(canvas,$_parent.scoreIcon());
	    };
	    
	    this.fromJS = function(json){
	    	
	    	if(!json) return;
	    	$_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
	    	$_parent.bgPic(json.bgPic);
	    	var model = new _ImageModel('tryAgain',5);
	    	model.fromJS(json.tryAgainIcon);
	    	this.tryAgainIcon(model);
	    	
	    	model = new _ImageModel('score',5);
	    	model.fromJS(json.scoreIcon);
		    this.scoreIcon(model);
	    }
	};
	//6
	var _scoreScene = function(){
		var $_parent = this;
		_absScene.call(this);
		this.bgPic = ko.observable();
	    
	    this.bgPic.subscribe(function (newValue) {
	    	if(_model.checkScene()!=6)return;
	    	_drawBackgroundImage(newValue);
	    });
	    
	    this.draw = function(canvas, parent){
	    	_drawBackgroundImage($_parent.bgPic());
	    	_drawImageFromModel(canvas, parent.backIcon());
	    };
	    
	    this.handleMoving = function(target){
	    	var _type = target.oType;
	    	var x = target.getLeft(),
	    	    y = target.getTop();
	    	var img_model ;
	    	switch(_type){
	    	    case 'back':
	    	    	img_model = _model.backIcon();
	    	        break;
	    	}
	    	
	    	if(img_model){
	    		img_model.stopFlag = true;
	    		var axis1 = img_model.changeToAxis1(x,y);
	    		img_model.x(axis1.x);
	    		img_model.y(axis1.y);
	    		img_model.stopFlag = false;
	    	}
	    };
	    
	    this.fromJS = function(json){
	    	
	    	if(!json) return;
	    	$_parent.id(json.id);
    	    $_parent.name(json.name);
    	    $_parent.type(json.type);
	    	$_parent.bgPic(json.bgPic);
	    }
		
	};
	
	_model.textArray = ko.observableArray([
        "Arial",
        "Comic Sans MS",
        "Courier New",
        "Georgia",
        "Lucida Sans Unicode",
        "Tahoma",
        "Times New Roman",
        "Trebuchet MS",
        "Verdana",
	]);
	
	_model.startScene   = ko.observable(new _startScene());
	_model.levelScene   = ko.observable(new _levelScene());
	_model.succScene    = ko.observable(new _succScene());
	_model.failScene    = ko.observable(new _failScene());
	_model.scoreScene   = ko.observable(new _scoreScene());
	
	_model.menuScene = ko.observable(new _menuScene());
	
	_model.scenes = ko.computed(function(){
		var scenes = [];
		scenes.push(_model.startScene());
		if(_model.gameMode.practice()){
		    scenes.push(_model.menuScene());
		}
		scenes.push(_model.succScene());
		scenes.push(_model.failScene());
		scenes.push(_model.scoreScene());
		$.each(_model.levelScenes(),function(n, value){
			scenes.push(value);
		});
		return scenes;
	});
	
	_model.useParticle = ko.computed(function(){
		return _model.particle.img() != "";
	});
	
	_model.currentScene.subscribe(function (newValue) {
         var id = newValue;
         var the_scene;
         var type = "";
 		 if(id){
 			$.each(_model.scenes(),function(n, value){
 				if(id == value.id()){ 
 					type = value.type();
 					the_scene = value;
 					switch(parseInt(type)){
 					    case 1:
 					    	_model.startScene (value);
 					    	break;
 					    case 2:
 					    	_model.menuScene(value);
 					    	break;
 					    case 3:
 					    	_model.levelScene(value);
 					    	break;
 					    case 4:
 					    	_model.succScene(value);
 					    	break;
 					    case 5:
 					    	_model.failScene (value);
 					    	break;
 					    case 6:
 					    	_model.scoreScene(value);
 					    	break; 
 					}
 					
 				    return;
 				}
 			});
 			//$("#vo_scenceCanvas").show();
 		}else{
 			//$("#vo_scenceCanvas").hide();
 		}
 		 
 		_model.checkScene(type);
 		
 		// clear Canvas
 		_canvas.clear();
 		_canvas.setBackgroundImage("");
 		_canvas.setOverlayImage("");
 		_canvas.renderAll();
 		
 		// use current Scene draw canvas
 		the_scene && the_scene.draw && the_scene.draw(_canvas, _model);
 		
    });
	
	_model.checkScene = ko.observable('');
	
    _model.addLevel = function(){
    	var sels = $("#vo_menuScene select");
        sels.change();
    	
    	var scene = new _levelScene();
    	this.number(this.number()+1);
		var name= $_name.val() ? $_name.val() : this.number() + ". " + $_sceneInfo.level.name; 
		scene.id(this.number());
		scene.name(name);
		scene.type($_sceneInfo.level.type);
		this.levelScenes().push(scene);
		this.levelScenes.valueHasMutated();
		
	    var levelIcon = new _LevelImageModel("levelIcon"+ this.number(),2);
	    this.menuScene().menu.levelMenu.levelItems().push(levelIcon);
	    this.menuScene().menu.levelMenu.levelItems.valueHasMutated();
	    var radioMenu = this.menuScene().radioMenu();
	    levelIcon.pic1.subscribe(function(newValue){
			_drawAndUpdateImage(newValue,levelIcon,radioMenu != "l");
	    });
    };
	
	_model.updateLevel = function(){
		var id= $_levels.val();
		var name = $_name.val() ? $_name.val() : this.number() + ". " + $_sceneInfo.level.name;
		var type = 3;
		$.each(_model.levelScenes(),function(n, value){
			if(id == value.id()){ 
				value.type(type);
				value.name(name);
			    return;
			}
		});
	};
	
	_model.delLevel = function(){
		
		var id= $_levels.val();
		var v = "";
		$.each(_model.levelScenes(),function(n, value){
			if(id == value.id()){ 
				v = value;
			    return;
			}
		});
		if(v) _model.levelScenes.remove(v);
		
		$_levels.change();
		/*var type = "levelIcon"+ id;
		$.each(_model.menuScene().menu.levelMenu.levelItems(),function(n,value){
		    if(type == value.type){
		    	v = value;
		    	return;
		    }
		});*/
		v = _model.menuScene().menu.levelMenu.levelItems()[_model.levelScenes().length];
		if(v)_model.menuScene().menu.levelMenu.levelItems.remove(v);
	};
	
	_model.editLevel = function(){
		if($_levels.val()){
			var sel_options = $("option:selected",$_levels);
			var id= $_levels.val();
			var name = sel_options.text();
			var type="";
			$.each(_model.levelScenes(),function(n, value){
				if(id == value.id()){ 
					type = value.type();
				    return;
				}
			});
			$_type.val(type);
			$_name.val(name);
		}else{
		    $_type.val('');
		    $_name.val('');
		}
	};
	
	_model.getSceneById = function(id){
		var scene;
		$.each(_model.scenes(),function(n, value){
			if(id == value.id()){ 
				scene =value
			    return;
			}
		});
		return scene;
	};
	
	var listScenes = function(){
		$.each(_model.scenes(),function(n, value){
			console.log(n + ": " + value.id() + "," + value.name());
		});
	}
	
	_model.moveUp = function(){
		
		if($_levels.val()){
			
			var index = $_levels[0].selectedIndex;
			if(index < 1 ) return;
			var scenes = _model.levelScenes();
			var curr = scenes[index];
			var prev = scenes[index-1];
		    scenes[index] = prev;
		    scenes[index-1] = curr;
		   
		    this.levelScenes.valueHasMutated();
		}
	};
	
	_model.moveDown = function(){
		if($_levels.val()){
			
			var index = $_levels[0].selectedIndex;
			var scenes = _model.levelScenes();
			
			if(index ==scenes.length-1) return;
			
			var curr = scenes[index];
			var next = scenes[index+1];
		    scenes[index] = next;
		    scenes[index+1] = curr;
		   
		    this.levelScenes.valueHasMutated();
		}
	};
	
	//-----------------------------------------
	
	var _initCanvas = function(){
		console.log("_initCanvas");
		_canvas.setWidth(_model.width());
		_canvas.setHeight(_model.height());
		_canvas.clear();
		
		_canvas.observe('object:moving', function (e) {
			var target = e.memo ? e.memo.target : e.target;
			var  sid = _model.currentScene();
			var scene = _model.getSceneById(sid);
			scene.handleMoving && scene.handleMoving(target);

	    });
		
		_canvas.observe('object:scaling', function (e) {
			var target = e.memo ? e.memo.target : e.target;
			var  sid = _model.currentScene();
			var scene = _model.getSceneById(sid);
			scene.handleScaling && scene.handleScaling(target);

	    });
	};
	
	var _toJSON = function(){
		
        var sels = $("#vo_menuScene select");
        sels.change();
		var _ignore = {
				'_model': ["currentScene", "textArray","levelScene","checkScene","scenes","value"],
				'levelScenes': ['gameQuestions','gameAnswers','gameWords','gameAudios','value'],
			}
		var copy = JSON.parse(ko.toJSON(_model));
		$(copy.levelScenes).each(function(){
			var level = this;
			var words =  $.trim(level.gameWords);
	    	if(words == ','){ 
	    		words = "";
	        } else if(words.substr(words.length-1) == ','){
	        	words = words.substr(0,words.length-1);
	    	}
			var questions = level.gameQuestions;
		    var answers = level.gameAnswers;
		    words = words ? words.split(',') : [];
		    var audios = level.gameAudios;
		    var maxLength =  Math.max(questions.length,answers.length,words.length,audios.length);
		    if(questions.length && questions.length == answers.length 
		    		            && questions.length == words.length 
		    		            && questions.length == audios.length){
		    }else{
		    	alert(level.name + Chidopi.lang.msg.vcb_info1);
		    }
		    
		    if(maxLength){
		    	for(var i = 0; i< maxLength; i++){
		    		var game = new gameObj(
		    				questions[i] ? questions[i]:'',
		    				answers[i] ? answers[i] : '',
		    				words[i] ? words[i] : '',
		    				audios[i] ? audios[i] : ''
		    				);
		    	     level.gameContent[i] = game;
		    	}
		    }
		});
		
		$(_ignore._model).each(function(){
			delete copy[this];
		});
		$(_ignore.levelScenes).each(function(){
		     var key = this;
		     $(copy.levelScenes).each(function(){
		    	    delete this[key]; 
		     });
		});
		
		if(!copy.gameMode.practice){
			delete copy.menuScene;
		}
		console.log(copy);
		return copy;
		
	}
	
	var _initDialog = function(){
		console.log("_initDialog");
		$_dialog.dialog({
			title: Chidopi.lang.title.vocabulary,
			autoOpen: false, 
			width:1140,
			height:1740,/*1850,*/
			modal: true,
			
			buttons: [
			  {
			  text  : Chidopi.lang.btn.ok,
			  click : function() {
				  var id = _model.id();
                  var type = "vocabulary";
                  var title = _model.title();
				  
                  if(!id){                        
                      id=  type + "_" + (++Global.number);
					  if(!title){
					      _model.title(id);
				      }
					  _model.id(id);
					  _model.zIndex(Global.number);
						
					  var json = _toJSON();
					  var value = JSON.stringify(json);
					  _createVocabularyComponent(json, _vars);
                      Global.createComponent(id, type, value, title);
				  } else {
						
					  if(!title){
					      _model.title(id);
					  }
						
					  var json = _toJSON();
				      var value = JSON.stringify(json);						
					  _createVocabularyComponent(json, _vars);
					  Global.updateComponent(id, type, value, title);	
                  }
                  //console.log("model: ");
                  //console.log(JSON.stringify(_toJSON()));
                  $("#vo_sceneList option:first").attr("selected",true).change();
				  $(this).dialog("close");
			  } 
			  },
			  {
			  text  : Chidopi.lang.btn.cancel,
			  click : function() {$("#vo_sceneList option:first").attr("selected",true).change();$(this).dialog("close");}
			  }
			],
			open: function(event, ui) { 
				//$("#vocabulary_outer").width(parseInt(_vars.width)+40)
				//                      .height(parseInt(_vars.height)+40);
				//$("#voTab_dialog").dialog('open');
				
				$("#voTabs").tabs('select', '#voTab-1');
				_initCanvas();
			},
			/*focus: function(event, ui) {
				$(this).dialog("option","zIndex",1001);
				$("#voTab_dialog").dialog("option","zIndex",1000);
				console.log("1: " +  $_dialog.dialog("option","zIndex"));
        	   // $(this).dialog("moveToTop");
				
        	},*/
		}); 
	};
	
	var _initialize = function(){
		
		console.log("_initialize");

		_vars = Chidopi.sys_vars;
		
		console.log(Chidopi.sys_vars);
		
		ko.applyBindings(_model, $_dialog[0]);
		
		_initDialog();
		
		if(!_canvas){
	        _canvas = new fabric.Canvas('vocabulary_canvas',{ selection: true, backgroundImageStretch:false });
		}
		
		// bind event
		$("#voTab-1 input[name='width']",$_dialog).change(function(){
			$("#vocabulary_outer").width(parseInt($(this).val())+40);
			_canvas.setWidth(_model.width());
			
		});
		
		$("#voTab-1 input[name='height']",$_dialog).change(function(){
			$("#vocabulary_outer").height(parseInt($(this).val())+40);
			_canvas.setHeight(_model.height());
		});
		
		$("input[name='sceneSwitchColor'], .mocool_color_picker",$_dialog).each(function(){
			var obj =   $(this)
			obj.ColorPicker({
				color: obj.val(),
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
					//obj.val('#' + hex);
					obj.val(rgb.r + "," + rgb.g + "," + rgb.b);
					obj.change();
				}
			});			
		});
		
		$("#voTabs").tabs();
		
		$("select[name=levels]",$_dialog).change(_model.editLevel);
		
		/*$("input.upload",$_dialog).tooltip({
			bodyHandler: function() {
				return $(this).val();
			}
		});*/
		
    	_inited = true;
    	
	};
	
	if(!_inited){
		_initialize();
	};
	
	var _initCreate = function(){
    	_init_model();
		$_dialog.dialog("open");
	};
	
	var _createVocabularyComponent = function(json, sys_vars){
	    var id = json.id, scene = json.startScene, src = '';
	    $("#" + id).remove();
	    if(scene){
	    	src = scene.bgPic;
	    }
		
	    var url = src ? sys_vars.base_url + sys_vars.user_res_path + '/' + src
		              : sys_vars.base_url + "css/images/link_default_50x50.png";
		
		var style = "left: " + json.x + "px; top: " + json.y + "px;"+ 
		            "z-index: " + json.zIndex + ";";

		var sizeStyle = "width: " + json.width + "px; height: " + json.height + "px;";
	
		if(!src){			
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
			
		sys_vars.cmp_container.append(html);
		var cmp = $("#"+id);
		var pic = $("#pic_" +id);
		var h_id = "cmp_" + id;
		pic.load(function(){					
			var _this = $(this),
			width = parseInt(_this.css("width").replace("px","")),
			height = parseInt(_this.css("height").replace("px",""));
			_this.resizable({
				autoHide: true,
				distance: 20,
				aspectRatio: json.aspectRatio ? json.width / json.height : false,
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
				json['x'] = $(this).css("left").replace("px","");
				json['y'] = $(this).css("top").replace("px","");
				hidden.val(JSON.stringify(json));
			}
		});
		
		// resizable-handle icon z-index
		$("#"+id +" .ui-resizable-handle").css("z-index","auto");
	}
	
	var _createComponent = function(component,sys_vars){
        
        var json = JSON.parse(component);
		
		var id =json.id;
		var title = json.iTitle;
		var type= "vocabulary";
		var value = JSON.stringify(json);
		_createVocabularyComponent(json, sys_vars);
		Global.createComponent(id, type, value, title);
	};
	
	var _init_model = function(json){
		if(json){
		    _model.number(json.number);
			_model.id(json.id);
			_model.title(json.title);
			_model.x(json.x);
			_model.y(json.y);		
			_model.width(json.width);
			_model.height(json.height);
			_model.aspectRatio(json.aspectRatio);
			_model.zIndex(json.zIndex);
			_model.rightAudio(json.rightAudio);
			_model.errorAudio(json.errorAudio);
			_model.finishAudio(json.finishAudio);
			_model.rightScore(json.rightScore);
			_model.errorScore(json.errorScore);
			
			_model.particle.img(json.particle ? json.particle.img : '');
			_model.particle.number(json.particle ? json.particle.number : 10);
			_model.particle.type(json.particle ? json.particle.type : '');
			
			if(json.gameMode){
				_model.gameMode.challenge(json.gameMode.challenge ? json.gameMode.challenge : false);
				_model.gameMode.practice(json.gameMode.practice ? json.gameMode.practice : false);
				_model.gameMode.practiceMode(json.gameMode.practiceMode);
			}else{
				_model.gameMode.challenge(true);
				_model.gameMode.practice(false);
				_model.gameMode.practiceMode('free');
			}
			
			var backIcon = new _ImageModel('back',0);
			
			backIcon.fromJS(json.backIcon);
			_model.backIcon(backIcon);
			_model.sceneSwitchMode(json.sceneSwitchMode);
			_model.sceneSwitchColor(json.sceneSwitchColor);
			
			_model.levelScene(new _levelScene());
			
			//_model.scenes([]);
			_model.levelScenes([]);
			
			var scene = new _startScene();
			scene.fromJS(json.startScene);
			_model.startScene(scene);
			_model.scenes().push(scene);
			
			scene = new _succScene();
			scene.fromJS(json.succScene);
			_model.succScene(scene);
			if(json.succScene.id){
				_model.scenes().push(scene);
			}
			
			scene = new _failScene();
			scene.fromJS(json.failScene);
			_model.failScene(scene);
			if(json.failScene.id){
				_model.scenes().push(scene);
			}
			
			scene = new _scoreScene();
			scene.fromJS(json.scoreScene);
			_model.scoreScene(scene);
			if(json.scoreScene.id){
			    _model.scenes().push(scene);
		    }
			
			scene = new _menuScene();
		    if(json.menuScene){
		    	scene.fromJS(json.menuScene);
		    }else{
		    	_model.number(_model.number()+1);
		    	scene.id(_model.number());
				scene.name($_sceneInfo.menu.name);
				scene.type($_sceneInfo.menu.type);
				//scene.radioMenu('m');
				if(json.levelScenes && json.levelScenes.length>0){
					for(var i=0; i<json.levelScenes.length; i++){
						var id = json.levelScenes[i].id
				        var icon = new _LevelImageModel("levelIcon"+id,2);
						scene.menu.levelMenu.levelItems().push(icon);
//						icon.pic1.subscribe(function(newValue){
//					    	var menu = scene.radioMenu();
//							_drawAndUpdateImage(newValue,icon,menu != "l");
//					    });
					}
				}
				
		    }
		    _model.menuScene(scene);
			_model.scenes().push(scene);
			_model.menuScene().binding();
			_model.menuScene().menu.levelMenu.levelItems.valueHasMutated();
			
			if(json.levelScenes && json.levelScenes.length>0){
				for(var i=0; i<json.levelScenes.length; i++){
				    scene = new _levelScene();
					scene.fromJS(json.levelScenes[i]);
					//console.log(ko.toJSON(scene));
					
					_model.scenes().push(scene);
					_model.levelScenes().push(scene);
				}
				_model.checkScene('');
				_model.checkScene.valueHasMutated();
				_model.currentScene('');
				_model.currentScene.valueHasMutated();
			}
			
			_model.levelScenes.valueHasMutated();
			
		}else{
			_model.number(0);
			_model.id("");
			_model.title("");
			_model.x(0);
			_model.y(0);		
			_model.width(_vars.width);
			_model.height(_vars.height);
			_model.aspectRatio(false);
			_model.zIndex( '' );
			_model.rightAudio( '' );
			_model.errorAudio('');
			_model.finishAudio('');
			_model.rightScore(20);
			_model.errorScore(10);
			_model.particle.img('');
			_model.particle.number(10);
			_model.particle.type('');
			
			_model.gameMode.challenge(true);
			_model.gameMode.practice(false);
			_model.gameMode.practiceMode('free');
			
			_model.backIcon(new _ImageModel('back',0));
			_model.sceneSwitchMode('RL');
			_model.sceneSwitchColor('0,0,0');
			
			//_model.scenes([]);
			_model.levelScenes([]);
			_model.checkScene('');
			
			var scene = new _startScene();
	    	_model.number(_model.number()+1);
			scene.id(_model.number());
			scene.name($_sceneInfo.start.name);
			scene.type($_sceneInfo.start.type);
			_model.startScene(scene);
			
			scene = new _menuScene();
			_model.number(_model.number()+1);
			scene.id(_model.number());
			scene.name($_sceneInfo.menu.name);
			scene.type($_sceneInfo.menu.type);
			_model.menuScene(scene);
			
			_model.levelScene(new _levelScene());
			
			scene = new _succScene();
			_model.number(_model.number()+1);
			scene.id(_model.number());
			scene.name($_sceneInfo.succ.name);
			scene.type($_sceneInfo.succ.type);
			_model.succScene(scene);
			
			scene = new _failScene();
			_model.number(_model.number()+1);
			scene.id(_model.number());
			scene.name($_sceneInfo.fail.name);
			scene.type($_sceneInfo.fail.type);
			_model.failScene(scene);
			
			scene = new _scoreScene();
			_model.number(_model.number()+1);
			scene.id(_model.number());
			scene.name($_sceneInfo.score.name);
			scene.type($_sceneInfo.score.type);
			_model.scoreScene(scene);
			
		}
	};
    
    var _editComponent = function(component){
    	
    	_init_model(component);
    	
    	$_dialog.dialog("open");
	};
	
  
	exports.createComponent = _createComponent;
	
	exports.editComponent = _editComponent;
	
	exports.initCreate = _initCreate;

});