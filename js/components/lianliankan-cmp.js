


function createLianliankanComponent(id, src, position, size,title, zIndex){
                
    var url =  src;
	
    var style = "";
    if(position){
        style = "left: " + position.left + "px; top: " + position.top + "px;";
    }
	style += "z-index: " + zIndex + ";";
    var sizeStyle = "";
    if(size){
        sizeStyle = "width: " + size.width + "px; height: " + size.height + "px;";
    }else{
        size = {
            width:"200px", 
            height:"200px"
        }
    }
				
    var html = '<div id="' + id + '" class="component" style="background:none no-repeat center center rgba(0,0,0,0.1);display:inline-block; position: absolute;' + style +'" '+
    'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
    'onMouseOut = "$(\'.closebox\',this).hide();" >';
    html += '<img id="pic_' + id + '" src="' +  url +'" style="opacity:1; ' + sizeStyle +'" />';
    html+='<span id="title_'+id+'" style="position: absolute; left:0px; top:0px;background-color:#fff">'+title+'</span>'+
    
    '<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
    'onclick="removeComponent(\''+ id+'\')">' +
    '<span class="closebox"></span></a>';
                
    html+= '</div>';

    $("#div-background").append(html);
    var cmp = $("#"+id);
    var pic = $("#pic_" +id);
    var h_id = "cmp_" + id;
	
    pic.load(function(){
        var _this = $(this),
        width = parseInt(_this.css("width").replace("px","")),
        height = parseInt(_this.css("height").replace("px",""));
                    
        //图片原始尺寸：
        // _this.css({width: 'auto', height: 'auto', visibility: 'visible'})
        // $("#title_"+id).html("原圖大小：W:"+_this.css("width")+" H:"+height);
        $(this).resizable({
            autoHide: true,
            distance: 20,
            //aspectRatio: width / height,
            start: function(event, ui) {
                $("#table_"+id).hide();
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

function updateLianliankanComponent(id, src, size){
    var url =  src;
    var pic = $("#pic_" +id);
    pic.attr('src',url);
    if(size){
        pic.css("width", size.width + "px");
        pic.css("height", size.height + "px");
        pic.parent().css({
            width: size.width + "px", 
            height:size.height + "px"
        });
        pic.resizable( "option" , {
            aspectRatio : size.width / size.height
        } );
    }
   
}

/***
 * canvas操作插件
 */
