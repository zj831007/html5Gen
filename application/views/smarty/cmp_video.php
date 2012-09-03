<script>
$(function(){
	var component = $("#<{$id}>");
	
	var video = $("#video_<{$id}>")[0];
	
	<{if $v_EndAction == "hide" }>
	var hide_<{$id}>_action = function(event){
	    <{if $hideAction}>
			component.addClass("chidopoi_<{$id}>_hide");
	   		window.setTimeout(
			    function(){
					//component.removeClass("chidopoi_<{$id}>_hide").css("visibility", "hidden");
					component.removeClass("chidopoi_<{$id}>_hide").hide();
				}, 
				<{$hideSpeed}> * 1000 + <{$hideDelay}> * 1000 +300);
		<{else}>
		    //component.css("visibility", "hidden");
			component.hide();
		<{/if}>
	}
	<{/if}>
	
	<{if $v_display && $v_button }>
		$("#<{$v_button}>").click(function(event){
			//component.css('visibility','visible');
			
			<{if $loadAction}>		
			component.addClass("chidopoi_<{$id}>_load");
			window.setTimeout(
			   function(){component.removeClass("chidopoi_<{$id}>_load")}, 
			   <{$loadSpeed}>* 1000 + <{$loadDelay}> * 1000 +300); 
			<{/if}>
			component.show();
			video.play();
			//event.stopPropagation();
		});
	<{/if}>
	<{if $v_screen}>
		 video.addEventListener("playing",
		     function(){
				 /*try{
				      video.webkitEnterFullscreen();
				 }catch(err){
				     console.log( err.message );
				 }*/
				 $(video).css("-webkit-transform",'translateX(0px)').addClass("fullScreen");
				 component.css("background-color","transparent").addClass("fullScreen");
		     }, false); 
	<{/if}>

    $(video).bind('ended', function() {
		// cancel fullscreen
		video.webkitExitFullScreen();
		video.currentTime = 0;
		video.pause();
		$(video).removeClass("fullScreen");
		component.removeClass("fullScreen");
		<{if $v_EndAction == "hide" }>		    
		    component.removeClass("chidopoi_<{$id}>_load");
			hide_<{$id}>_action();
			
		<{elseif $v_EndAction == "page" }>
	        location.href="CInAppAction://MoveTo/p<{$v_page}>.html";
		<{/if}>
	});
	
	if(isPreview){ // for safari full screen style;
	    video.addEventListener("webkitfullscreenchange",function(){
			console.log(document.webkitIsFullScreen);
			if(document.webkitIsFullScreen){
				component.removeClass("chidopi_component3Dvideo");
				$("#container").removeClass("container3D");
				
			}else{
				component.addClass("chidopi_component3Dvideo");
				$("#container").addClass("container3D");			
			}
		}, false);
	}
	
	<{if $v_auto}>autoPlay = video;<{/if}>
});

JS.onReady(function(){
	<{if !$v_display && $loadAction }>
	var component = $("#<{$id}>");
	
    component .addClass("chidopoi_<{$id}>_load").show();
	         //.css('visibility','visible')
			
    window.setTimeout(
	   function(){component.removeClass("chidopoi_<{$id}>_load")}, 
	   <{$loadSpeed}>* 1000 + <{$loadDelay}> * 1000 +300); 
	<{/if}>

	<{if $v_auto}>var video = $("#video_<{$id}>")[0]; video.play();<{/if}>
},true);
 
</script>

<div id="<{$id}>" class="chidopi_component3Dvideo" style="background-color:#000; position: absolute; left:<{$v_left}>px; top:<{$v_top}>px; z-index:<{$zIndex}>; <{if $v_display || $loadAction}>display:none;<{/if}>">
<video id="video_<{$id}>" src="<{if $v_fileType=='url'}><{$v_url}><{else}><{$res_dir}><{$v_file}><{/if}>" <{if $v_poster}>poster="<{$res_dir}><{$v_poster}>"<{/if}>
	   <{$v_control}> width="<{$v_width}>" height="<{$v_height}>" 
       <{if $v_screen}>style="-webkit-transform:translateX(-<{$b_width}>px);"<{/if}> ></video>
</div>