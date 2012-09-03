/*

jquery.sorted - super simple jQuery sorting utility

Copyright (c) 2010 Jacek Galanciak

Dual licensed under the MIT and GPL version 2 licenses.
http://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt
http://github.com/jquery/jquery/blob/master/GPL-LICENSE.txt

Github/docs site: http://github.com/razorjack/jquery.sorted

*/

(function($) {
	$.fn.sorted = function(customOptions) {

		var options = {
			reversed: false,
			by: function(a) { return a.text(); }
		};

		$.extend(options, customOptions);

		$data = $(this);
		arr = $data.get();
		arr.sort(function(a, b) {
			var valA = options.by($(a));
			var valB = options.by($(b));
			if (options.reversed) {
				return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;				
			} else {		
				return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;	
			}
		});
		return $(arr);
	};
})(jQuery);

Global = {
    number:0,
    //hasTapButton:false,
    sounds: {},
    buttons:{},
    pages:{},
    //
    components : {
        img:{},
        link:{},
        video:{},
        audio:{},
        note:{},
        text:{},
        action:{},
        pazzle:{},
        qa:{},
        slider2:{},
        lianliankan:{},
        diypuzzle:{},
        gravity:{},
        spotlight:{},
        axismove:{},
		rotate360:{},
		vocabulary:{},
		text2:{},
    }
};

Global.loadGlobal = function(json){
    loadGlobal(json);
}
Global.createComponent = function(id, type, value, title){
    return createComponent(id, type, value, title);
};
Global.updateComponent = function(id, type, value, title){
    return updateComponent(id, type, value, title);
};
Global.editComponent = function(id, type, url){
    editComponent(id, type, url);
};
Global.removeComponent = function(id){
    removeComponent(id);
};

Global.toggleComponent = function(id){
	
	var table_sub = $("#cmp_table_list .table_sub");
    var td = $("tr[cid="+id+"] td:eq(1)",table_sub);	
	var anch = $("a", td)
	var span = $("span", td);	
	if(span.hasClass("show_eye")){
		$("#"+id).hide();
		span.removeClass("show_eye").addClass("hide_eye");
		anch.attr("title",Chidopi.lang.title.show);
	}else{
	   $("#"+id).show();
		span.removeClass("hide_eye").addClass("show_eye");
		anch.attr("title",Chidopi.lang.title.hide);
	}    
}
Global.checkCmpJson = function(component){
	var json = JSON.parse(component);
    if(!json.zIndex){json.zIndex = json.id.substring(json.id.lastIndexOf("_")+1);};
	return JSON.stringify(json);
}


Global.sortZindex = function(){
	var zindex_list = $("#tb_zindex_list");
	var trs = $("tr",zindex_list).sorted({
		reversed: true,
		by: function(v) {
			return parseInt(v.attr('zindex'));
		}
	});
	
   /* trs.each(function(){
		var id = $(this).attr("cid");
		var zindex = $(this).attr("zindex");
	    $("#"+id).css("z-index",zindex);		
	});*/
	
	$(zindex_list).html(trs)
	    .sortable({
			placeholder: "table_zindex_placeholder",
			forcePlaceholderSize:true,
			cursor:'move',
			containment: 'parent',
			start: function (event, ui) {
				ui.placeholder.html('<td colspan="4" style=""></td>')
			},
			update: function (event, ui){
				trs = $("tr",zindex_list);
				var index = trs.size() + 1;
				trs.each(function(){
					var $_this = $(this);
					var id = $_this.attr("cid");
					$_this.attr("zindex", --index);
					var hidden = $("#cmp_"+id);
					$("#"+id).css("z-index",index);
					var json=JSON.parse(hidden.val());
					json["zIndex"] = index;					
					hidden.val(JSON.stringify(json));
				});
			}
		}).disableSelection();	
}

function loadGlobal(json){
	
    Global.number = json.number;
    //Global.hasTapButton = json.hasTapButton;
	
    if(json.sounds instanceof Array){ 
        Global.sounds = {};
    }else{
        Global.sounds = json.sounds;
    }
	
    if(json.buttons instanceof Array) {
        Global.buttons = {};
    }else{
        Global.buttons = json.buttons;
    }
	
    for( key in Global.components ){
        if( !json.components[key] || json.components[key] instanceof Array ) {
            Global.components[key]={};
        }else{
            Global.components[key] = json.components[key];
        }
    }
}

/*function getZindex(json){	
	
	if(!json.zIndex){json.zIndex = json.id.substring(json.id.lastIndexOf("_")+1);};
	return json.zIndex;
}*/
var calu = 0;
function createComponent(id, type, value, title){
	
    if(!title) title = id;
    var uid = 'cmp_'+id;
	var json = JSON.parse(value);
	var zindex = json.zIndex;//getZindex(json);
	value = JSON.stringify(json);
    var hidden =  $('<input type="hidden" name="'+ uid +'" id="' + uid +'" typeFor="' + type + '" />');
    $(hidden).val(value);
    $("#mainForm").append(hidden);

    // add in list
    var tbody = $("#t_"+type);

    var tr = '<tr cid="'+ id +'"> \n'+
    '<td width="70%"><span class="title">'+title+'</span></td>\n'+
	(type != "audio" ? 
	'<td width="10%"><a href="javascript:void(0);" title="'+ Chidopi.lang.btn.hide +'" onclick="Global.toggleComponent(\''+ id + '\');">\n'+
    '  <span class="show_eye"></span>\n</a></td>\n' : '<td width="10%"><span class="hide_eye"></span></td>') +
    '<td width="10%"><a href="javascript:void(0);" title="'+ Chidopi.lang.btn.edit +'">\n' + // '" onclick="Global.editComponent(\'' + id + '\',\'' + type + '\')">\n'+
    '  <span cid="'+ id +'" data="'+ type+'" class="ui-icon ui-icon-pencil"></span>\n</a></td>\n' +
    '<td width="10%"> <a href="javascript:void(0);" title="'+ Chidopi.lang.btn.del +'" onclick="Global.removeComponent(\''+ id + '\');">\n'+
    '<span class="ui-icon ui-icon-trash"></span>\n</a></td>\n'+
    '</tr>'; 
    tbody.append(tr);	
    Global.components[type][id] = title;
	var zindexTable  = $("#tb_zindex_list");

	if(type != "audio"){		
		tr = '<tr cid="'+ id +'" zindex="'+ zindex +'"> \n'+
		 '<td width="10%"><span class="small_icon small_'+type+'"></span>\n</td>' + 
		 '<td width="70%"><span class="title">'+title+'</span></td>\n' + 
		 '<td width="10%"><a href="javascript:void(0);" title="'+ Chidopi.lang.btn.edit +'" onclick="Global.editComponent(\'' + id + '\',\'' +
		  type + '\')">\n'+
		 '  <span class="ui-icon ui-icon-pencil"></span>\n</a></td>\n' +
		 '<td width="10%"> <a href="javascript:void(0);" title="'+ Chidopi.lang.btn.del +'" onclick="Global.removeComponent(\''+ id + '\');">\n'+
		 '<span class="ui-icon ui-icon-trash"></span>\n</a></td>\n'+
		 '</tr>'; 
		 zindexTable.prepend(tr);
	}
    return $(hidden);
}

function updateComponent(id, type, value, title){
    if(!title) title = id;
    var uid = $('#cmp_'+id);
    uid.val(value);
    $("tr[cid="+ id +"] .title").html(title);
	
    Global.components[type][id] = title;
	return uid;	
}

function editComponent(id, type, url){
    var uid = "cmp_"+id;
    var hidden = $("#"+uid);
    //Justin add,  当用knockout时，在编辑左边列表时，只需要取出 hidden中的值，然后填充到相应视图模型中
    switch(type){
        case "pazzle":
            var data = JSON.parse(hidden.val());
            if(data){
                pazzleModel.id(data.id);
                pazzleModel.title(data.title);
                pazzleModel.x(data.x);
                pazzleModel.y(data.y);
                pazzleModel.row(data.row);
                pazzleModel.col(data.col);
                pazzleModel.width(data.width);
                pazzleModel.height(data.height);
                pazzleModel.succAction(data.succAction);
                pazzleModel.succActionPage(data.succActionPage);
                pazzleModel.jumpText(data.jumpText);
				pazzleModel.zIndex(data.zIndex);
              
                if(data.pazzlePics && data.pazzlePics.length>0){
                    pazzleModel.pazzlePics.removeAll();
                    for(var i=0; i< data.pazzlePics.length; i++)
                        pazzleModel.pazzlePics.push(data.pazzlePics[i]);
                }
                if(data.rewardPics && data.rewardPics.length>0){
                    pazzleModel.rewardPics.removeAll();
                    for(var i=0; i< data.rewardPics.length; i++)
                        pazzleModel.rewardPics.push(data.rewardPics[i]);
                }
                if(data.audios && data.audios.length>0){
                    pazzleModel.audios.removeAll();
                    for(var i=0; i< data.audios.length; i++)
                        pazzleModel.audios.push(data.audios[i]);
                }
                if(data.succAudios && data.succAudios.length>0){
                    pazzleModel.succAudios.removeAll();
                    for(var i=0; i< data.succAudios.length; i++)
                        pazzleModel.succAudios.push(data.succAudios[i]);
                }
            //pazzleModel.picName(data.picName);
            //                pazzleModel = ko.mapping.fromJS(data);
            //                ko.mapping.fromJS(data, pazzleModel);
            }
            break;
        case "qa":
            var data = JSON.parse(hidden.val());
            if(data){
                qaViewModel.id(data.id);
                qaViewModel.title(data.title);
                qaViewModel.x(data.x);
                qaViewModel.y(data.y);
                qaViewModel.width(data.width);
                qaViewModel.height(data.height);
                qaViewModel.bgPic(data.bgPic);
                qaViewModel.bgColor(data.bgColor);
                qaViewModel.flipPage(data.flipPage);
                qaViewModel.scoreType(data.scoreType);
                qaViewModel.rightEvent(data.rightEvent);
                qaViewModel.rightAudio(data.rightAudio);
                qaViewModel.rightPic(data.rightPic);
                qaViewModel.errorAudio(data.errorAudio);
                qaViewModel.errorPic(data.errorPic);
                qaViewModel.finishAudio(data.finishAudio);
                qaViewModel.confirmPic(data.confirmPic);
                qaViewModel.finishAction(data.finishAction);
                qaViewModel.jumpPage(data.jumpPage);
                qaViewModel.jumpText(data.jumpText);
                qaViewModel.zIndex(data.zIndex);
                qaViewModel.topics([]);
                if(data.topics && data.topics.length>0){
                    
                    for(var i=0; i<data.topics.length; i++){
                        var topic = {};
                        topic.type = ko.observable(data.topics[i].type);
                        topic.text = ko.observable(data.topics[i].text);
                        topic.fSize = ko.observable(data.topics[i].fSize);
                        topic.font = ko.observable(data.topics[i].font);
                        topic.color = ko.observable(data.topics[i].color);
                        topic.pic = ko.observable(data.topics[i].pic);
                        topic.imgW = ko.observable(data.topics[i].imgW);
                        topic.imgH = ko.observable(data.topics[i].imgH);
                        topic.imgP = ko.observable(data.topics[i].imgP);
                        topic.options = ko.observableArray([]);
                        
                        var options = data.topics[i].options;
                        if(options && options.length>0 ){
                            for(var j=0; j<options.length; j++){
                                var option ={};
                                option.right=ko.observable(options[j].right);
                                option.text=ko.observable(options[j].text);
                                option.fSize=ko.observable(options[j].fSize);
                                option.font=ko.observable(options[j].font);
                                option.color=ko.observable(options[j].color);
                                option.pic=ko.observable(options[j].pic);
                                option.imgW=ko.observable(options[j].imgW);
                                option.imgH=ko.observable(options[j].imgH);
                                option.imgP=ko.observable(options[j].imgP);
                                topic.options.push(option);
                            }
                        }
                        qaViewModel.topics.push(topic);
                    }
                    
                }
                
            }
            break;
        case "lianliankan":
            var data = JSON.parse(hidden.val());
            if(data){
                lianliankanModel.id(data.id);
                lianliankanModel.title(data.title);
                lianliankanModel.x(data.x);
                lianliankanModel.y(data.y);
                lianliankanModel.width(data.width);
                lianliankanModel.height(data.height);
                lianliankanModel.rightAudio(data.rightAudio);
                lianliankanModel.rightImg(data.rightImg);
                lianliankanModel.errorAudio(data.errorAudio);
                lianliankanModel.errorImg(data.errorImg);
                lianliankanModel.bgpic(data.bgpic);
                lianliankanModel.finishImg(data.finishImg);
                lianliankanModel.finishAudio(data.finishAudio);
                lianliankanModel.succAction(data.succAction);
                lianliankanModel.succActionPage(data.succActionPage);
                lianliankanModel.lineColor(data.lineColor);
                lianliankanModel.lineWidth(data.lineWidth);
                lianliankanModel.pointColor(data.pointColor);
                lianliankanModel.pointWidth(data.pointWidth);
                lianliankanModel.lines = data.lines;
                lianliankanModel.points = data.points;
                lianliankanModel.jumpText(data.jumpText);
				lianliankanModel.zIndex(data.zIndex);
            }
            break;
             
    }

    //-------------------------
    var data = JSON.parse(hidden.val());
    var form = document.getElementById(type+"_dialog");
	if( Chidopi[type] && typeof Chidopi[type].updateModel == "function"){
		Chidopi[type].updateModel(data);
        if(typeof Chidopi[type].editCallBack == "function"){
            Chidopi[type].editCallBack(sys_vars);
        }
    /*if(type=="slider2" || type == "gravity" || type=="rotate360"){
        Chidopi[type].updateModel(data);
        if(typeof Chidopi[type].editCallBack == "function"){
            Chidopi[type].editCallBack(sys_vars);
        }
    }else if(type=="diypuzzle"){
        Chidopi[type].updateModel(data);*/
	}else if(type=="vocabulary" || type =="text2"){
		seajs.use(url, function(module) {
			module.editComponent(data);
        });
    }else{
        js2form(form, data);
    }
    $(form).dialog("open");	
}

function removeComponent(id){
    var uid = "cmp_" + id;
    dialog.confirm(Chidopi.lang.title.confirm, Chidopi.lang.msg.confirmDel ,function(result){
        if(result){
            var type = $("#"+uid).attr("typefor");
            $("#"+ id + ", #"+uid +", tr[cid='"+id +"']").remove();
            //if(id == Global.hasTapButton)Global.hasTapButton =false;
            if(Global.buttons[id]) delete Global.buttons[id] ;
            if(Global.sounds[id]) delete Global.sounds[id];
			
            if(Global.components[type])delete Global.components[type][id];
			
            if(typeof(removeCallBack) == "function"){
                removeCallBack(type);
            }
        }
    });
}


function highlight(id){
    $("div.component").removeClass("selected");
    $("#"+id).addClass("selected");
    var table_sub = $("#cmp_table_list .table_sub, .table_zindex");
    $("tr", table_sub).removeClass("selected");	
    $("tr[cid="+id+"]").addClass("selected");
    $("span.ui-icon-selected", table_sub).removeClass("ui-icon-selected").addClass("ui-icon");
    $("tr[cid="+id+"] .ui-icon", table_sub).removeClass("ui-icon").addClass("ui-icon-selected");
}

