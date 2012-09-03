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
		a.click(function(){
			var x = Math.round(document.body.scrollLeft/<{$b_width}>*100),
		        y = Math.round(document.body.scrollTop/<{$b_height}>*100);
			this.href = 'CInAppAction://<{$act_type}>/'+ x + "," + y;
		});
	}
});
</script>

<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$act_left}>px; top:<{$act_top}>px; z-index:<{$zIndex}>;" >
   <a><img id="pic_<{$id}>" src="<{$res_dir}><{$act_file}>" 
        style="width:<{$act_width}>px; height:<{$act_height}>px;" /></a>
</div>

