<script>
$(function(){
	var component = $("#<{$id}>");
<{if $i_display }>
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
	
	var hide_<{$id}> = function(event){       
		var obj = event.data.obj;
		var type= event.data.type;
		var ev = event ? event : window.event;
		var e = ev.target || ev.srcElement;
		var id = e.getAttribute("id");
		if(type == 'back'){
			if ( e != obj && ( id != 'pic_<{$id}>' ) && (id!= '<{$id}>') 
						  && ( id != '<{$i_button}>' ) && (id != 'pic_<{$i_button}>') ) {
				
				component.removeClass("chidopoi_<{$id}>_load");
				hide_<{$id}>_action();
				
			    $("#container").unbind("click",hide_<{$id}>);
			}
		}else if(type == 'self'){
			if ( id == 'pic_<{$id}>' || id == '<{$id}>' ) {
				component.removeClass("chidopoi_<{$id}>_load");
				hide_<{$id}>_action();
			    $("#container").unbind("click",hide_<{$id}>);
			    if(toggle_<{$i_button}>) toggle_<{$i_button}>();
			}
		}
	}
	<{if $i_button}>
	$("#<{$i_button}>").bind('click',function(event){				
		<{if $i_hide == 'back'}>
		    component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");
		    $('#container').bind("click",{obj:this,type:'<{$i_hide}>'}, hide_<{$id}>);				
		<{elseif $i_hide == 'button'}>
			if(component.css("display")=='none'){
			    component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");			   
			}else{
				component.removeClass("chidopoi_<{$id}>_load");
				hide_<{$id}>_action();
			}
		<{elseif $i_hide == 'self'}>
		 	component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");
		    $('#container').bind("click",{obj:this,type:'<{$i_hide}>'}, hide_<{$id}>);
	    <{else}>
		    component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");			
		<{/if}>			
	});
	<{/if}>	
<{/if}>
});
<{if !$v_display && $loadAction }>
JS.onReady(function(){
	var component = $("#<{$id}>");
	
    component.css('visibility','visible').addClass("chidopoi_<{$id}>_load");
    window.setTimeout(
	   function(){component.removeClass("chidopoi_<{$id}>_load")}, 
	   <{$loadSpeed}>* 1000 + <{$loadDelay}> * 1000 +300); 
},true);
<{/if}>   
</script>
<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$i_left}>px; top:<{$i_top}>px; z-index:<{$zIndex}>; display:<{$i_display}>; <{if $loadAction}>visibility:hidden;<{/if}>" >
    <img id="pic_<{$id}>" src="<{$res_dir}><{$i_file}>" <{if $tap}>class="click_ignore_me"<{/if}>
        style="width:<{$i_width}>px; height:<{$i_height}>px;" />
</div>


