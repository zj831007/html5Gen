<script>
$(function(){
	<{if $act_sound }>
    $("#pic_<{$id}>").click(function(){
        //$("#sound_<{$id}>")[0].play();
	    Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$act_sound}>');		
    });
	<{/if}>
	
	var a = $("#<{$id}> a");
	if(isPreview) {
		a.attr("href",'javascript:void(0)');
	}else{
		<{if $act_args eq null }>
	    a.attr("href",'CInAppAction://<{$act_type}>');
		<{else}>
		a.attr("href",'CInAppAction://<{$act_type}>/<{$act_args}>');
		<{/if}>
	}
});
</script>

<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$act_left}>px; top:<{$act_top}>px; z-index:<{$zIndex}>;" >
   <a><img id="pic_<{$id}>" src="<{if $act_file}><{$res_dir}><{$act_file}><{else}><{$public_dir}>link_default_50x50.png<{/if}>" 
        style="width:<{$act_width}>px; height:<{$act_height}>px;" /></a>
</div>


