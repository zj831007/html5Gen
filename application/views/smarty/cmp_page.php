<script>
$(function(){
    $("#pic_<{$id}>").click(function(){
    	var a = $("#<{$id}> a");
		<{if $act_sound }>
        a.attr("href",'javascript:void(0)');
	    Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$act_sound}>');	    
		<{/if}>
		
		if(isPreview) {
			a.attr("href",'javascript:void(0)');
		}
    });
});

function soundEnd_<{$id}>(){
	location.href="CInAppAction://MoveTo/p<{$page}>.html";
}

</script>

<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$act_left}>px; top:<{$act_top}>px;z-index:<{$zIndex}>;" >
   <a href="CInAppAction://MoveTo/p<{$page}>.html"><img id="pic_<{$id}>" 
      src="<{if $act_file}><{$res_dir}><{$act_file}><{else}><{$public_dir}>link_default_50x50.png<{/if}>" 
        style="width:<{$act_width}>px; height:<{$act_height}>px;" /></a>
</div>


