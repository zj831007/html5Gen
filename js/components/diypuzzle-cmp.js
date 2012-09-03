
(function($,Global){
		
    var cmpContainer = null;	
    var Vars  = {};
	
    Chidopi.diypuzzle ={};
    
    Chidopi.diypuzzle.model = {
        zIndex: ko.observable(),
        id:ko.observable(),
        title:ko.observable(),
        x:ko.observable(),
        y:ko.observable(),
        width:ko.observable(),
        height:ko.observable(200),
        bgpic:ko.observable(),
        
        rightAudio:ko.observable(),
        rightImg:ko.observable(),
        rightText:ko.observable(),
        rightEffect:ko.observable(),
        
        finishImg:ko.observable(),
        finishAudio:ko.observable(),
        finishText:ko.observable(),
        finishEffect:ko.observable(),
        
        fontStyle:ko.observable(),
        fontColor:ko.observable(),
        fontSize:ko.observable(),
        
        blockDis:ko.observable(),
        timeLimit:ko.observable(),
        scoreShow:ko.observable(),
        retestShow:ko.observable(),
        succAction:ko.observable(),
        succActionPage:ko.observable(),
        jumpText:ko.observable(),
        
        inEffect:ko.observable(),
        outEffect:ko.observable(),
        useEffect:ko.observable(),
        
        timeRestart:ko.observable(),
        points:[]  
    };
   
        
    Chidopi.diypuzzle.init = function(vars){
		
        cmpContainer = vars.cmp_container;
		
        if(vars) Vars = vars;
	
        ko.applyBindings(Chidopi.diypuzzle.model, document.getElementById("diypuzzle_dialog")); //绑定model
        
        _init_dialog();  //初始化弹出框
                 
        $("#bar_diypuzzle").click(function(){
            _init_model();
            $("#diypuzzle_dialog").dialog("open");		
        });
    }
    
    /**
     *初始化对话框
     */  
    function _init_dialog(){
        $("#diypuzzle_dialog").dialog({
            title: Chidopi.lang.title.diypuzzle,
            autoOpen:false,
            position: 'top',
            width:1200,
            height:1400,
            modal: true,
            buttons:[
            	{
            	text  : Chidopi.lang.btn.ok,
            	click : function(){
					
                    var model = Chidopi.diypuzzle.model;
                    
                    var id = model.id();
                    var type = "diypuzzle";
                    var title = model.title();
                    
                    model.points = diypuzzle_get_all_objecs_from_canvas();
                    model.succAction($("#diypuzzle_succ_finish_action_sel").val());
                    model.succActionPage($("#diypuzzle_succ_finish_sel").find("select").val());
                        
                    var json,value;
                    if(!id){                        
                        id=  type + "_" + (++Global.number);
                        if(!title){
                            model.title(id);
                        }
                        
                        model.id(id);
                        model.zIndex(Global.number);
                        
                        _createDiypuzzleComponent();
						
                        value = ko.toJSON(model);		
                        Global.createComponent(id, type, value, title);
                    } else {
						
                        if(!title){
                            model.title(id);
                        }
					
                        _createDiypuzzleComponent();
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
                diypuzzle_initCanvas();
                
                if(Chidopi.diypuzzle.model.succAction() == undefined || Chidopi.diypuzzle.model.succAction() == 0){
                    $("#diypuzzle_succ_finish_lbl").hide();
                    $("#diypuzzle_succ_finish_sel").hide();
                }else{
                    $("#diypuzzle_succ_finish_lbl").show();
                    $("#diypuzzle_succ_finish_sel").show();
                    
                    $("#diypuzzle_succ_finish_sel").find("select").val(Chidopi.diypuzzle.model.succActionPage());
                }
            }		
        });	
    };
    
    /**
     *更新model对象
     */
    Chidopi.diypuzzle.updateModel = function(json){
        return _init_model(json);
    }
    
    /**
     * 用于初始化时创建组件
     */
    Chidopi.diypuzzle.createComponent = function(component, vars){
        var json = JSON.parse(component);
        var model = Chidopi.diypuzzle.updateModel(json);
        var id = model.id();
        var title = model.title();
        var type= "diypuzzle";
		
        var value = JSON.stringify(json);
        _createDiypuzzleComponent(model, vars);
        Global.createComponent(id, type, value, title);
    }
    //创建组件     
    function _createDiypuzzleComponent(model, sys_vars){
        var the_vars = sys_vars ? sys_vars : Vars;		
        if(!model) model = Chidopi.diypuzzle.model;
        var id = model.id();
        
        $("#" + id).remove();
        var src = model.bgpic();
        var url =  src ? the_vars.base_url + the_vars.user_res_path + "/" + src: the_vars.base_url + "css/images/diypuzzle.jpg";
        
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
        var model = Chidopi.diypuzzle.model;
        if(json){
            model.zIndex(json.zIndex?json.zIndex:0);
            model.id(json.id);
            model.title(json.title?json.title:'');
            model.x(json.x?json.x:0);
            model.y(json.y?json.y:0);
            model.width(json.width?json.width:0);
            model.height(json.height?json.height:0);
            model.bgpic(json.bgpic?json.bgpic:'');
            
            model.rightAudio(json.rightAudio);
            model.rightImg(json.rightImg);
            model.rightText(json.rightText);
            model.rightEffect(json.rightEffect);
            
            model.finishImg(json.finishImg);
            model.finishAudio(json.finishAudio);
            model.finishText(json.finishText);
            model.finishEffect(json.finishEffect);
            
            model.fontStyle(json.fontStyle);
            model.fontColor(json.fontColor);
            model.fontSize(json.fontSize);
            
            model.blockDis(json.blockDis);
            model.timeLimit(json.timeLimit);
            model.scoreShow(json.scoreShow);
            model.retestShow(json.retestShow);
            
            model.succAction(json.succAction);
            model.succActionPage(json.succActionPage);
            model.jumpText(json.jumpText);
            
            model.inEffect(json.inEffect);
            model.outEffect(json.outEffect);
            model.useEffect(json.useEffect);
           
            model.timeRestart(json.timeRestart);
            model.points = json.points;        
        }else{
            model.zIndex(0);
            model.id(0);
            model.title("");
            model.x(0);
            model.y(0);
            model.width(400);
            model.height(400);
            model.bgpic("");
            
            model.rightAudio("");
            model.rightImg("");
            model.rightText("");
            model.rightEffect("");
            
            model.finishImg("");
            model.finishAudio("");
            model.finishText("");
            model.finishEffect("");
            
            model.fontStyle("Arial");
            model.fontColor("#ff0000");
            model.fontSize(24);
            
            model.blockDis(0);
            model.timeLimit(10);
            model.scoreShow(false);
            model.retestShow(false);
            
            model.succAction(0);
            model.succActionPage(1);
            model.jumpText("Jump");
            
            model.inEffect(0);
            model.outEffect(0);
            model.useEffect(0);
           
           model.timeRestart(false)
            model.points = [];
        }  
        
        return model;
    }    
})(jQuery,Global);




/***
 * canvas操作插件
 */
