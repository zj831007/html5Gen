
(function($,Global){
		
    var cmpContainer = null;	
    var Vars  = {};
	
    Chidopi.axismove ={};
    
    Chidopi.axismove.model = {
        zIndex: ko.observable(),
        id:ko.observable(),
        title:ko.observable(),
        x:ko.observable(),
        y:ko.observable(),
        width:ko.observable(),
        height:ko.observable(200),
        
        xrayimg:ko.observable(),
        btnimg:ko.observable(),
        overlayimg:ko.observable(),
        xrayopacity:ko.observable(),
        
        xrayoriention:ko.observable(),
        btnxposition:ko.observable(),
        btnyposition:ko.observable(),
        
        xraywidth:ko.observable(),
        xrayheight:ko.observable(),
        
        touchAudio:ko.observable(),
        
        succAction:ko.observable(),
        succActionPage:ko.observable(),
        jumpText:ko.observable()
    };
   
        
    Chidopi.axismove.init = function(vars){
		
        cmpContainer = vars.cmp_container;
		
        if(vars) Vars = vars;
	
        ko.applyBindings(Chidopi.axismove.model, document.getElementById("axismove_dialog")); //绑定model
        
        _init_dialog();  //初始化弹出框
                 
        $("#bar_axismove").click(function(){
            _init_model();
            $("#axismove_dialog").dialog("open");		
        });
    }
    
    /**
     *初始化对话框
     */  
    function _init_dialog(){
        $("#axismove_dialog").dialog({
            title: Chidopi.lang.title.axismove,
            autoOpen:false,
            //position: 'top',
            width:1100,
            height:300,
            modal: true,
            buttons:[
            	{
            	text  : Chidopi.lang.btn.ok,
            	click : function(){
					
                    var model = Chidopi.axismove.model;
                    
                    var id = model.id();
                    var type = "axismove";
                    var title = model.title();
                    
                  
                   
                    model.succActionPage($("#axismove_succ_finish_sel").find("select").val());
                        
                    var json,value;
                    if(!id){                        
                        id=  type + "_" + (++Global.number);
                        if(!title){
                            model.title(id);
                        }
                        
                        model.id(id);
                        model.zIndex(Global.number);
                        
                        _createAxismoveComponent();
						
                        value = ko.toJSON(model);		
                        Global.createComponent(id, type, value, title);
                    } else {
						
                        if(!title){
                            model.title(id);
                        }
					
                        _createAxismoveComponent();
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
                if(Chidopi.axismove.model.succAction() == undefined || Chidopi.axismove.model.succAction() == 0){
                    $("#axismove_succ_finish_lbl").hide();
                    $("#axismove_succ_finish_sel").hide();
                }else{
                    $("#axismove_succ_finish_lbl").show();
                    $("#axismove_succ_finish_sel").show();
                    $("#axismove_succ_finish_sel").find("select").val(Chidopi.axismove.model.succActionPage());
                }
                
            }		
        });	
    };
    
    /**
     *更新model对象
     */
    Chidopi.axismove.updateModel = function(json){
        return _init_model(json);
    }
    
    /**
     * 用于初始化时创建组件
     */
    Chidopi.axismove.createComponent = function(component, vars){
        var json = JSON.parse(component);
        var model = Chidopi.axismove.updateModel(json);
        var id = model.id();
        var title = model.title();
        var type= "axismove";
		
        var value = JSON.stringify(json);
        _createAxismoveComponent(model, vars);
        Global.createComponent(id, type, value, title);
    }
    //创建组件     
    function _createAxismoveComponent(model, sys_vars){
        var the_vars = sys_vars ? sys_vars : Vars;		
        if(!model) model = Chidopi.axismove.model;
        var id = model.id();
        
        $("#" + id).remove();
        
        var url =  the_vars.base_url + "css/images/axismove.jpg";
        
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
        var model = Chidopi.axismove.model;
        if(json){
            model.zIndex(json.zIndex?json.zIndex:0);
            model.id(json.id);
            model.title(json.title?json.title:'');
            model.x(json.x?json.x:0);
            model.y(json.y?json.y:0);
            model.width(json.width?json.width:0);
            model.height(json.height?json.height:0);
            
            model.xrayimg(json.xrayimg);
            model.overlayimg(json.overlayimg);
            model.xrayopacity(json.xrayopacity?json.xrayopacity:1);
            
            model.xrayoriention(json.xrayoriention);
            
            model.btnimg(json.btnimg);
            model.btnxposition(json.btnxposition);
            model.btnyposition(json.btnyposition);
            
            model.xraywidth(json.xraywidth);
            model.xrayheight(json.xrayheight);
            
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
            model.height(207);
            
            model.xrayimg('');
            model.overlayimg('');
            model.xrayopacity(1);
            
            model.xrayoriention("");
            
            model.btnimg('');
            model.btnxposition("l");
            model.btnyposition('b');
            
            model.xraywidth(50);
            model.xrayheight(50);
            
            model.touchAudio("");
            
            model.succAction(0);
            model.succActionPage(0);
            model.jumpText("Jump");
        }  
        
        return model;
    }    
})(jQuery,Global);




