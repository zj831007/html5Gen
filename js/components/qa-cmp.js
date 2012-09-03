function createQaComponent(id,title, src, position, size, zIndex){
    var url =  src;
    var style = "";
    if(position){
        style = "left: " + position.left + "px; top: " + position.top + "px;";
    }
	style += "z-index: " + zIndex + ";";
    if(size){
        style += "width: " + size.width + "px; height: " + size.height + "px;";
    }
		
    sizeStyle="";
    if(size){
        sizeStyle = "width: " + size.width + "px; height: " + size.height + "px;";
    }
		
    var html = '<div id="' + id + '" class="component" style=" '+
    'background:no-repeat center center rgba(0,0,0,0.5);' + style +
    'background-size:100% 100%; display:inline-block; position: absolute;" '+
    'onMouseOver="$(\'.closebox\',this).show();" onclick="highlight(\''+id+'\');" '+
    'onMouseOut = "$(\'.closebox\',this).hide();" >';
                   
    html += '<img id="pic_' + id + '" src="' +  url +'" style=" ' + sizeStyle +'" />';
    html+='<span id="title_'+id+'" style="position: absolute; left:0px; top:0px;background-color:#fff">'+title+'</span>';
    html += '<a class="ui-dialog-titlebar-close ui-corner-all" href="#" '+
    'onclick="removeComponent(\''+ id+'\')">' +
    '<span class="closebox"></span></a>' +
    '</div>';
    $("#div-background").append(html);
    var cmp = $("#"+id);
    var h_id = "cmp_" + id;
    var pic = $("#pic_" +id);
    pic.load(function(){
        var _this = $(this),
        width = parseInt(_this.css("width").replace("px","")),
        height = parseInt(_this.css("height").replace("px",""));
        
        $(this).resizable({
            autoHide: true,
            //aspectRatio: 1/ 1,
            grid: [10, 10],
            distance: 20,		
            start: function(event, ui) {
            },
            stop:  function(event, ui) {
                var hidden = $("#"+h_id);
                var json=JSON.parse(hidden.val());
                json["width"] = $(this).css("width").replace("px","");
                json["height"] = $(this).css("height").replace("px","");
                cmp.css("width", $(this).css("width"));
                cmp.css("height", $(this).css("height"));
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
            
function updateQaComponent(id, title,src ,size){
    var url = src;
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
           // aspectRatio : size.width / size.height
        } );
    }
}