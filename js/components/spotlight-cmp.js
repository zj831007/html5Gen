
(function($,Global){
		
    var cmpContainer = null;	
    var Vars  = {};
	
    Chidopi.spotlight ={};
    
    Chidopi.spotlight.model = {
        zIndex: ko.observable(),
        id:ko.observable(),
        title:ko.observable(),
        x:ko.observable(),
        y:ko.observable(),
        width:ko.observable(),
        height:ko.observable(200),
        
        color:ko.observable(),
        opacity:ko.observable(),
        weight:ko.observable(),
        
        img:ko.observable(),
        imgEffect:ko.observable(),
        
        maskcolor:ko.observable(),
        maskopacity:ko.observable(),
        
        spotShape:ko.observable(),
        spotRadius:ko.observable(),
        spotWidth:ko.observable(),
        spotHeight:ko.observable(),
        
        touchAction:ko.observable(),
        touchAudio:ko.observable(),
        
        succAction:ko.observable(),
        succActionPage:ko.observable(),
        jumpText:ko.observable()
        
    };
   
        
    Chidopi.spotlight.init = function(vars){
		
        cmpContainer = vars.cmp_container;
		
        if(vars) Vars = vars;
	
        ko.applyBindings(Chidopi.spotlight.model, document.getElementById("spotlight_dialog")); //绑定model
        
        _init_dialog();  //初始化弹出框
                 
        $("#bar_spotlight").click(function(){
            _init_model();
            $("#spotlight_dialog").dialog("open");		
        });
    }
    
    /**
     *初始化对话框
     */  
    function _init_dialog(){
        $("#spotlight_dialog").dialog({
            title: Chidopi.lang.title.spotlight,
            autoOpen:false,
            //position: 'top',
            width:1100,
            height:300,
            modal: true,
            buttons:[
                {
            	text  : Chidopi.lang.btn.ok,
            	click : function(){
					
                    var model = Chidopi.spotlight.model;
                    
                    var id = model.id();
                    var type = "spotlight";
                    var title = model.title();
                    
                  
                     model.succActionPage($("#spotlight_succ_finish_sel").find("select").val());
                        
                    var json,value;
                    if(!id){                        
                        id=  type + "_" + (++Global.number);
                        if(!title){
                            model.title(id);
                        }
                        
                        model.id(id);
                        model.zIndex(Global.number);
                        
                        _createSpotlightComponent();
						
                        value = ko.toJSON(model);		
                        Global.createComponent(id, type, value, title);
                    } else {
						
                        if(!title){
                            model.title(id);
                        }
					
                        _createSpotlightComponent();
                        value = ko.toJSON(model);						
                        Global.updateComponent(id, type, value, title);	

                    }
                    //closeUploadDialog();
                    $(this).dialog("close");
                }
                },
                {
                text  : Chidopi.lang.btn.cancel,
                click : function(){$(this).dialog("close");}
                }			
            ],
            open: function(event, ui) {	
                if(Chidopi.spotlight.model.succAction() == undefined || Chidopi.spotlight.model.succAction() == 0){
                    $("#spotlight_succ_finish_lbl").hide();
                    $("#spotlight_succ_finish_sel").hide();
                }else{
                    $("#spotlight_succ_finish_lbl").show();
                    $("#spotlight_succ_finish_sel").show();
                    $("#spotlight_succ_finish_sel").find("select").val(Chidopi.spotlight.model.succActionPage());
                }
                
                if(Chidopi.spotlight.model.spotShape() == undefined || Chidopi.spotlight.model.spotShape() == "cycle"){
                    $("#spotlight_cyle").show();
                    $("#spotlight_squir").hide();
                }else{
                    $("#spotlight_cyle").hide();
                    $("#spotlight_squir").show();
                }
            }		
        });	
    };
    
    /**
     *更新model对象
     */
    Chidopi.spotlight.updateModel = function(json){
        return _init_model(json);
    }
    
    /**
     * 用于初始化时创建组件
     */
    Chidopi.spotlight.createComponent = function(component, vars){
        var json = JSON.parse(component);
        var model = Chidopi.spotlight.updateModel(json);
        var id = model.id();
        var title = model.title();
        var type= "spotlight";
		
        var value = JSON.stringify(json);
        _createSpotlightComponent(model, vars);
        Global.createComponent(id, type, value, title);
    }
    //创建组件     
    function _createSpotlightComponent(model, sys_vars){
        var the_vars = sys_vars ? sys_vars : Vars;		
        if(!model) model = Chidopi.spotlight.model;
        var id = model.id();
        
        $("#" + id).remove();
        
        var url =  the_vars.base_url + "css/images/spotlight.jpg";
        
        var sizeStyle = "width:"+ model.width() + "px; height:" + model.height() + "px;";
        
        var positionStyle = "left: " + model.x() + "px; top: " + model.y() + "px;" + 
        "z-index: " + model.zIndex() + ";";
		 
        var html = '<div id="' + id + '" class="component" style="display:inline-block; position: absolute;' + positionStyle +'" '+
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
            var _this = $(this),
            width = parseInt(_this.css("width").replace("px","")),
            height = parseInt(_this.css("height").replace("px",""));
            $(this).resizable({
                autoHide: true,
                distance: 20,
                aspectRatio: false,
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
                    model.width(width);
                    model.height(height);
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
                model.x($(this).css("left").replace("px",""));
                model.y($(this).css("top").replace("px",""));
                hidden.val(JSON.stringify(json));
            }
        });
    }
    //=====================创建组件结束
    
    /**
     *初始化model
     */
    function _init_model(json){		
        var model = Chidopi.spotlight.model;
        if(json){
            model.zIndex(json.zIndex?json.zIndex:0);
            model.id(json.id);
            model.title(json.title?json.title:'');
            model.x(json.x?json.x:0);
            model.y(json.y?json.y:0);
            model.width(json.width?json.width:0);
            model.height(json.height?json.height:0);
            
            model.color(json.color?json.color:'w');
            model.opacity(json.opacity?json.opacity:255);
            model.weight(json.weight?json.weight:0);
            
            model.img(json.img);
            model.imgEffect(json.imgEffect);
            
            model.maskcolor(json.maskcolor);
            model.maskopacity(json.maskopacity);
            
            model.spotShape(json.spotShape);
            model.spotRadius(json.spotRadius);
            model.spotWidth(json.spotWidth);
            model.spotHeight(json.spotHeight);
            
            model.touchAction(json.touchAction);
            model.touchAudio(json.touchAudio);
            
            model.succAction(json.succAction);
            model.succActionPage(json.succActionPage);
            model.jumpText(json.jumpText);
            
        }else{
            model.zIndex(0);
            model.id(0);
            model.title("");
            model.x(0);
            model.y(0);
            model.width(400);
            model.height(400);
            
            model.color('w');
            model.opacity(255);
            model.weight(0);
            
            model.img("");
            model.imgEffect(0);
            
            model.maskcolor("#000");
            model.maskopacity(1);
            
            model.spotShape("cycle");
            model.spotRadius("50");
            model.spotWidth("50");
            model.spotHeight("50");
            
            model.touchAction(0);
            model.touchAudio("");
            
            model.succAction(0);
            model.succActionPage(0);
            model.jumpText("Jump");
        }  
        
        return model;
    }    
})(jQuery,Global);




