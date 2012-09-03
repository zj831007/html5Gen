<script>
$(function(){
    $("#<{$id}>").bind("click",function(event){
		<{if $act_sound }>
        	//$("#sound_<{$id}>")[0].play();
			Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$act_sound}>');
		<{/if}>
		if(!isPreview) {
			location.href='CInAppAction://Tap';	
		    event.stopPropagation();
		}
    });
});
</script>

<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$act_left}>px; top:<{$act_top}>px; width:<{$act_width}>px; height:<{$act_height}>px; z-index:<{$zIndex}>;">
</div>


