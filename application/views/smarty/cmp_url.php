<{if $act_sound }>
<script>
$(function(){
    $("#pic_<{$id}>").click(function(){
        //$("#sound_<{$id}>")[0].play();
		Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$act_sound}>');
    });
});
</script>
<{/if}>
<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$act_left}>px; top:<{$act_top}>px;z-index:<{$zIndex}>;" >
   <a href="<{$url}>"><img id="pic_<{$id}>" src="<{if $act_file}><{$res_dir}><{$act_file}><{else}><{$public_dir}>link_default_50x50.png<{/if}>" 
        style="width:<{$act_width}>px; height:<{$act_height}>px;" /></a>
</div>


