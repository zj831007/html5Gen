<script>
$(function(){
	 <{if $l_file2}>
		 var flag = true;
		 $("#pic_<{$id}>").click(function(){
			 <{if $l_sound }>
			     Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$l_sound}>');			
		 	 <{/if}>
		 	toggle_<{$id}>();
		 });
	<{else}>
	    <{if $l_sound }>
 		$("#pic_<{$id}>").click(function(){
			Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$l_sound}>');			
		});
 		<{/if}>
	<{/if}>
});
<{if $l_file2}>
	var flag_<{$id}> = true;
    function toggle_<{$id}>(){
    	if(flag_<{$id}>){
            $("#pic_<{$id}>").attr('src', '<{$res_dir}><{$l_file2}>');				  
		}else{
		    $("#pic_<{$id}>").attr('src', '<{$res_dir}><{$l_file}>'); 
		}
    	flag_<{$id}> = !flag_<{$id}>;
    }
<{/if}>
</script>
<div id="<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$l_left}>px; top:<{$l_top}>px; z-index:<{$zIndex}>;" >
    <{if $l_file}>
        <img id="pic_<{$id}>" src="<{$res_dir}><{$l_file}>" 
            style="width:<{$l_width}>px; height:<{$l_height}>px;" />
    <{else}>
        <img id="pic_<{$id}>" src="<{$public_dir}>link_default_50x50.png" 
            style="width:<{$l_width}>px; height:<{$l_height}>px;" />
    <{/if}>
</div>
