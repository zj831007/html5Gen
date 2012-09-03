<script>
$(function(){
	var component = $("#<{$id}>");
<{if $display }>
	<{if $button}>
	$("#<{$button}>").bind('click',function(event){
		<{if $hide == 'button'}>
			if(component.css("display")=='none'){
			    component.show();			   
			}else{
				component.hide();
			}
	    <{else}>
		    component.show();			
		<{/if}>			
	});
	<{/if}>	
<{/if}>
});
</script>
<div id="<{$id}>" class="chidopi_component3D" style="border:solid 1px #eee;display:<{$display}>; position:absolute; top: <{$top}>px; left: <{$left}>px; z-index:<{$zIndex}>;">
    <{if $hide == 'self'}>
    <a class="closebox" href="#" onclick="$(this).parent().hide();"></a>
    <{/if}>
    <div id="text_<{$id}>" style="height:<{$height}>px; width:<{$width}>px; overflow:scroll; ">
        <{$text}>
    </div>
</div>
