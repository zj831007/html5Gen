
/**
* 時間對象格式化;
*/
Date.prototype.format = function(format){
    /*
  * eg:format="YYYY-MM-dd hh:mm:ss";
  */
    var o = {
        "M+" :  this.getMonth()+1,  //month
        "d+" :  this.getDate(),     //day
        "h+" :  this.getHours(),    //hour
        "m+" :  this.getMinutes(),  //minute
        "s+" :  this.getSeconds(), //second
        "q+" :  Math.floor((this.getMonth()+3)/3),  //quarter
        "S"  :  this.getMilliseconds() //millisecond
    }
  
    if(/(Y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    }
 
    for(var k in o) {
        if(new RegExp("("+ k +")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
        }
    }
    return format;
}
/**
 * 取得路徑最後一部分
 */
function getLastPart(path){
    var array = path.split("\\");
    return array[array.length-1];
}


function createLoading(container){
    // var loading = '<span class="loading"><img src="<?php echo base_url();?>css/images/ui-anim_basic_16x16.gif"></span>';
    var loading = '<span class="loading"><img src="css/images/ui-anim_basic_16x16.gif"></span>';
    $(container).append(loading);
}

function deleteLoading(container){
    $(".loading",container).remove();
}

var Chidopi = Chidopi = Chidopi || {};

function highlight(id){
    $("div.component").removeClass("selected");
    $("#"+id).addClass("selected");
    var table_sub = $("#cmp_table_list .table_sub");
    $("tr", table_sub).removeClass("selected");	
    $("tr[cid="+id+"]").addClass("selected");
    $("span.ui-icon-selected", table_sub).removeClass("ui-icon-selected").addClass("ui-icon");
    $("tr[cid="+id+"] .ui-icon", table_sub).removeClass("ui-icon").addClass("ui-icon-selected");
}

var HexToRGB = function (hex) {
    var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
    return {
        r: hex >> 16, 
        g: (hex & 0x00FF00) >> 8, 
        b: (hex & 0x0000FF)
    };
}

var RGBToHex = function (rgb) {
    var hex = [
    rgb.r.toString(16),
    rgb.g.toString(16),
    rgb.b.toString(16)
    ];
    $.each(hex, function (nr, val) {
        if (val.length == 1) {
            hex[nr] = '0' + val;
        }
    });
    return hex.join('');
}

//function openKCFinder(field, ftype , prefix, mode) {
function openKCFinder(config) {
    var defaults = {
        field:null,
        prefix: '',
        onComplete: function (data) {},
        type: "images",
        mode: "t",
    },
    config = $.extend({}, defaults, config || {});
    if(config.prefix) 
        config.prefix = "&prefix=" + config.prefix;
		
    var div = $("<div style='display:none;'></div>");
	
    var kc_model = "kcfinder_textbox";
    if(config.mode === "m"){
        kc_model = "kcfinder_multiple";
        window.KCFinder = {
            callBackMultiple: function(files) {
                window.KCFinder = null;
                var value = '';				
                for (var i = 0; i < files.length; i++)
                    value += files[i] + ";";
                if(config.field)config.field.value = value;
                config.onComplete.apply(this,[files]);
                $(div).dialog("destory").remove();
            }			
        };
    }
    else {
        window.KCFinder = {
            callBack: function(file,size) {
                if(config.field)config.field.value = file;
                config.onComplete.apply(this,[file,size]);				
                window.KCFinder = null;
                $(div).dialog("destory").remove();
            }
        };
    }
    //alert(window.showModalDialog);
    /*window.open('kcfinder/browse.php?type='+config.type+'&langCode=zh'+ config.prefix, kc_model,
		'status=0, toolbar=0, location=no, menubar=0, ' +
		'directories=0, resizable=1, scrollbars=0, width=800, height=600'
	);*/
	
	
    div.html('<iframe name="'+kc_model+'" src="kcfinder/browse.php?type=' + config.type+'&langCode='+ Chidopi.lang.code2 + config.prefix +'"' + 
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />');
    $("body").append(div);
    /*$(div).dialog({
		    title: '資料庫',
	        height: 550,
			width: 860,
			modal: true});*/
			
    $(div).dialog({
        title: Chidopi.lang.title.library,
        width: 860,
        height: 550,
        resizable: false,
        modal: true,
        open: function (event, ui) {
            var $dialog = $(this);
            var con = $(div).parent();
            var atext = $(".ui-dialog-titlebar-close",con).replaceWith('<p class="ui-xlgwr"><span class="ui-icon ui-icon-extlink">extlink</span><span class="ui-icon ui-icon-closethick">close</span></p>');
            $(".ui-xlgwr>span").click(function () {
                var spantext = $(this).text();
                if (spantext == "extlink") {
                    var status = $(con).data('status');
                    if(status && status == 'max'){
                        $dialog.dialog({
                            width: 860, 
                            height: 550
                        });
                        $(con).data('status','min');
                    }else{
                        var w = screen.availWidth - 24;
                        var h = $(window).height() - $(".ui-dialog-titlebar",con).height() + 4
                        $dialog.dialog({
                            position: ['left', 'top'],
                            width: w, 
                            height: h
                        });
                        $(con).data('status','max');
                    }
                } else if (spantext == "close") {
                    $dialog.dialog("close");
                }
            });
        }
    })
}
/**
 * string Add replaceAll func 
 * ref: http://www.cnblogs.com/aason/archive/2010/12/25/1916211.html
 */
String.prototype.replaceAll = function(reallyDo, replaceWith, ignoreCase) {  
    if (!RegExp.prototype.isPrototypeOf(reallyDo)) {

        return this.replace(new RegExp(reallyDo.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),
            (ignoreCase ? "gi": "g")), replaceWith);  
    } else {  
        return this.replace(reallyDo, replaceWith);  
    }  
}  

//通用文件上传
$("body").delegate(".mocool_audio_upload","click",function(e){
    $this = $(this);
    openKCFinder({
        field:this,
        type: "audio",
        prefix: "audio_",
        onComplete: function (url,size) {	
             $this.change(); 
        }
    });
});

$("body").delegate(".mocool_img_upload","click",function(e){
    $this = $(this);
    openKCFinder({
        field:this,
        prefix: "img_",
        onComplete: function (url,size) {	
             $this.change(); 
        }
    });
});
                
                
$("body").delegate(".mocool_cancel_upload","click",function(e){
    $(this).parent().find("input").val('');
});

$("body").delegate(".mocool_file_cancel","click",function(e){
    $(this).parent().find("input").val('').change();
});

$("body").delegate(".title_bar","click",function(e){
	var parent = $(this).parent();
    $("tr:not([class=title_bar])",parent).toggleClass('hidden');
});