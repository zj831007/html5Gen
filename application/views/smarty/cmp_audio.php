<script>
$(function(){	
	<{if $a_button}>
	$("#<{$a_button}>").click(function(){
		<{if $button_mode == "pause"}>
		Chidopi.JS.playPauseableAudio('<{$id}>','<{$res_dir}><{$a_file}>',0, '<{$a_play}>');
		<{else}>
		Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$a_file}>',0, '<{$a_play}>');
		<{/if}>
	});
	<{/if}>
       
    <{if $play_on_load}>
    autoPlayAudios[autoPlayAudios.length]='<{$res_dir}><{$a_file}>';
    <{/if}>
});

function soundEnd_<{$id}>(){
    if('<{$a_play}>'){
    	<{if $button_mode == "pause"}>
		Chidopi.JS.playPauseableAudio('<{$id}>','<{$res_dir}><{$a_file}>',0, '<{$a_play}>');
		<{else}>
	    Chidopi.JS.playOneAudio('<{$id}>','<{$res_dir}><{$a_file}>',0, '<{$a_play}>');
	    <{/if}>
	}
	<{if $a_page }>
		location.href="CInAppAction://MoveTo/p<{$a_page}>.html";
	<{/if}>	
}

</script>
