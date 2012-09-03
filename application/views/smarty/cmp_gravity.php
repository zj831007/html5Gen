<style>
#cube_<{$id}> > div:first-child  {
	-webkit-transform: rotateX(90deg) translateZ(<{$translateZ}>px);
}

#cube_<{$id}> > div:nth-child(2) {
	-webkit-transform: translateZ(<{$translateZ}>px);
}

#cube_<{$id}> > div:nth-child(3) {
	-webkit-transform: rotateY(90deg) translateZ(<{$translateZ}>px);
}

#cube_<{$id}> > div:nth-child(4) {
	-webkit-transform: rotateY(180deg) translateZ(<{$translateZ}>px);
}

#cube_<{$id}> > div:nth-child(5) {
	-webkit-transform: rotateY(-90deg) translateZ(<{$translateZ}>px);
}

#cube_<{$id}> > div:nth-child(6) {
	-webkit-transform: rotateX(-90deg) rotate(180deg) translateZ(<{$translateZ}>px) ;
}

#cube_<{$id}>{
	height: <{$height}>px;
	width:  <{$width}>px;
	-webkit-transform: rotateX(-12deg) rotateY(44deg);
}

#cube_<{$id}> > div {
	position: absolute;
	height: <{$height}>px;
	width:  <{$width}>px;
	border: <{$bdWidth}>px solid <{$bdColor}>;	
	-webkit-border-radius: 3px;
	overflow:hidden;
	-webkit-backface-visibility: hidden;
}

</style>

<script>
$(function(){
    $("#<{$id}>").chdp_gravity();
	var component = $("#<{$id}>");
	
	if(isPreview) {
		$("#cube_<{$id}> a").attr("href",'javascript:void(0)');
		//$("#cube_<{$id}> a").attr("href",'javascript:alert(0)');
	}	  
	
<{if $display }>
	var hide_<{$id}> = function(event){       
		var obj = event.data.obj;
		var ev = event ? event : window.event;
		var e = ev.target || ev.srcElement;
		var id = e.getAttribute("id");
		var cls = e.getAttribute("class");
		if ( e != obj && ( id != 'cube_<{$id}>' ) && (id!= '<{$id}>') 
					  && ( id != '<{$button}>' ) && (id != 'pic_<{$button}>') 
					  && (cls != 'face_<{$id}>') && (cls != 'pic_<{$id}>') ) {
			
			component.hide();
			$('.cube',component).css("webkitTransform",'rotateX(0deg) rotateY(0deg)');
		    $("#container").unbind("click",hide_<{$id}>);
		}
	}
	
	<{if $button}>
	$("#<{$button}>").bind('click',function(event){				
		<{if $hideMode == 'back'}>
		    component.show();
		    $('#container').bind("click",{obj:this}, hide_<{$id}>);				
		<{elseif $hideMode == 'button'}>
			if(component.css("display")=='none'){
			    component.show();
			}else{
				$('.cube',component).css("webkitTransform",'rotateX(0deg) rotateY(0deg)');
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

<div id="<{$id}>" class="chidopi_component3D viewport" style="position:absolute; left:<{$left}>px; top:<{$top}>px; z-index:<{$zIndex}>; display:<{$display}>; ">
    <div id="cube_<{$id}>" class="cube">
   		<{section name=index loop = $file}>
        <div class="face_<{$id}>" style="background:rgba(<{$bgColor}>);">            
           <{if $page[index]}>
           <a href="CInAppAction://MoveTo/p<{$page[index]}>.html">
                <{if $file[index]}>               
                <img class="pic_<{$id}>" src="<{$res_dir}><{$file[index]}>" width="<{$width}>" height="<{$height}>"/>
                <{else}>
                <div style="display:block;width:<{$width}>px;height:<{$height}>px;"></div>
                <{/if}>
            </a>
            <{else}>
                <{if $file[index]}>               
                <img class="pic_<{$id}>" src="<{$res_dir}><{$file[index]}>" width="<{$width}>" height="<{$height}>"/>
                <{else}>
                <div style="display:block;width:<{$width}>px;height:<{$height}>px;"></div>
                <{/if}>
            <{/if}>
        </div>
        <{/section}>
    </div>	
</div>	