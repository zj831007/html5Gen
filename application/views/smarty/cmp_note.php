<script>
$(function(){
var textarea = $("#note_<{$id}>");
var component = $("#<{$id}>");

 var hide_<{$id}>_action = function(event){
	    <{if $hideAction}>
			component.addClass("chidopoi_<{$id}>_hide");
	   		window.setTimeout(
			    function(){component.removeClass("chidopoi_<{$id}>_hide");component.hide();}, 
				<{$hideSpeed}> * 1000 + <{$hideDelay}> * 1000 +300);
		<{else}>
		    component.hide();
		<{/if}>
 }
<{ if $n_maxlength}>
	textarea.keyup(function(){
		var num=$(this).val().substr(0,<{$n_maxlength}>);
		$(this).val(num);
    });
<{/if}>

    textarea.blur(function(){ 
	    $.localStorage.saveData("note_<{$book_id}>_<{$page_id}>_<{$id}>", textarea.val());
	}).click(function(event){
	    event.stopPropagation();
	});
	
	textarea.val($.localStorage.loadData("note_<{$book_id}>_<{$page_id}>_<{$id}>"));
	
<{if $n_display }>
	var hide_<{$id}> = function(event){       
		var obj = event.data.obj;
		var ev = event ? event : window.event;
		var e = ev.target || ev.srcElement;
		var id = e.getAttribute("id");
		if ( e != obj && ( id != 'note_<{$id}>' ) && (id!= '<{$id}>') && (id != 'title_<{$id}>')  
		              && ( id != '<{$n_button}>' ) && (id != 'pic_<{$n_button}>') ) {
						  
			component.removeClass("chidopoi_<{$id}>_load");
			hide_<{$id}>_action();
		    $("#container").unbind("click",hide_<{$id}>);
		}
	}
	<{if $n_button}>
	$("#<{$n_button}>").click(function(event){				
		component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");			
		$("#container").bind("click",{obj:this}, hide_<{$id}>);	
		//event.stopPropagation();			
	});
	<{/if}>

<{/if}>
});
<{if !$n_display && $loadAction }>
JS.onReady(function(){
	var component = $("#<{$id}>");
	
	component.css('visibility','visible').addClass("chidopoi_<{$id}>_load");
	window.setTimeout(
	   function(){component.removeClass("chidopoi_<{$id}>_load")}, 
	   <{$loadSpeed}>* 1000 + <{$loadDelay}> * 1000 +300);
},true);
<{/if}>
</script>

<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$n_left}>px; top:<{$n_top}>px; z-index:<{$zIndex}>; display:<{$n_display}>;" >
    <div id="title_<{$id}>" style="font-size:<{$n_fontsize}>; background-color:transparent;"><{$n_title}></div>
    <textarea id="note_<{$id}>" style= "width:<{$n_width}>px; height:<{$n_height}>px; 
               background-color: rgba(255,255,255,1); font-family:<{$n_font}>;
               font-size:<{$n_fontsize}>; line-height:1.5em; resize: none;" >
    </textarea>
</div>
