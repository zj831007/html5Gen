// JavaScript Document
$(function(){
	$("#bar_dialog").dialog({
		autoOpen:false, 
		width:300,
		height:300,
		buttons:[ 
		    {
				text: Chidopi.lang.btn.ok,
				click : function() { 
			        var options = $("#bar_select option");
			        options.each(function(){
			        	var _this = $(this);
			        	var id =  _this.attr("value");
			        	if( _this.is(":selected")){
			        		$("#"+id).removeClass("hide").addClass("show");
			        	}else{
			        		$("#"+id).removeClass("show").addClass("hide");
			        	}
			        });
			        $(this).dialog("close");
				}
		    },
		    
		    {
				text:  Chidopi.lang.btn.cancel,
				click : function() {$(this).dialog("close");}
		    }
		]
	});
});
function init_bar(bar, ctx){

	$(".button_hide").live("click",{ctx:ctx},showBar);
	$(".button_show").live("click",{ctx:ctx},hideBar);
	
	var nav = $("#nav div");
	var frag = $("<div/>");
	for(var i in bar){
		var item = bar[i];
		if(item.id){
			//if(item.display != "hide"){
            frag.append('<a id="'+ item.id  +'" class="'+ item.display+'"><img src="' + ctx +'css/images/nav/' + item.img + '" title="' + item.title +'" width="32" /></a>' );
		//}
		}else{
		    frag.append('<img class="separator" src="'+ ctx +'css/images/nav/sepline.gif" />');
		}
	}
	nav.append(frag.html());
	
	$("#bar_add").click(function(){
		var select = $("#bar_select");
		$("option",select).remove();
		var menu = $("#.nav_bar div a[class != block]");
		var fragment = $("<select/>");
		//for(var i in menu){
		menu.each(function(){
			var item = $(this);
			var option ;
			if(item.hasClass("show")){
			   option  = $("<option value='"+item.attr("id")+"' selected >"+$("img",item).attr("title") +"</option>");
			}else if(item.hasClass("hide")) {
				option = $("<option value='"+item.attr("id")+"'>"+$("img",item).attr("title") +"</option>");               
			}
			 fragment.append(option);
		});
		//}		
		select.html(fragment.html());
	    select.multiselect({
			header:false,
			multiple: true,
			noneSelectedText:'no item',			
			position: { 
				my: 'top', 
				at: 'top'
			}
		});
		$("#bar_dialog").dialog("open");
	});	
	
}

function showBar(event){
	var ctx = event.data.ctx;
	//$(".navbox ").width("100%");
	$(this).parent().removeClass("hide");
	$("#nav").show("slide", { direction: "left" },300); 
	$("img",this).attr("src", ctx + "css/images/nav/book-open-bookmark.png");

	$(this).addClass("button_show");
	$(this).removeClass("button_hide");	
}


function hideBar(event){

	var ctx = event.data.ctx;
	var obj = $(this);
	$("#nav").hide("slide",{direction:"left"},300,
			function(){
				//$(".navbox ").width("40");
				obj.parent().addClass("hide");
			}
	);
	$("img",this).attr("src", ctx+"css/images/nav/book-bookmark.png");	
	$(this).addClass("button_hide");
	$(this).removeClass("button_show");	

}