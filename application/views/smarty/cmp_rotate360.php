<style>
#<{$id}> .icon{
	background : url(<{$lib_dir}>arrow.png) no-repeat scroll 0 0  <{$notice_color}>;
}
</style>
<script>
$(function(){
    var images = new Array(0);
	var files = '<{$file}>'.split(";");
	<{if $orientation == 0}> 
	    images = images.concat(files);
	<{else}>
	    images= new Array(<{$number}>);
		images = images.concat(files);
		images[0] = files[0];
		for(i =1; i<files.length; i++){
		    images[i] = '';
		}
	<{/if}>
    $('#pic_<{$id}>').attr("src",'<{$res_dir}>'+images[0]);
	$("#pic_<{$id}>").reel({
		path:'<{$res_dir}>',
		preloader:  0,
		<{if $orientation == 1}> 
		footage:  <{$number}>,
		orbital:  true,
		<{/if}>
		horizontal: <{if $orientation == 0}>true <{else}>false<{/if}>,
		vertical:   <{if $orientation == 1}>true <{else}>false<{/if}>,			
		images:   images
	});
	var component = $("#<{$id}>");
	
<{if $display }>
	var hide_<{$id}> = function(event){       
		var obj = event.data.obj;
		var ev = event ? event : window.event;
		var e = ev.target || ev.srcElement;
		var id = e.getAttribute("id");
		var cls = e.getAttribute("class");
		if ( e != obj && ( id != 'pic_<{$id}>' ) && (id!= '<{$id}>')
		              && ( id != 'icon_pic_<{$id}>') && ( id != 'interface_pic_<{$id}>')
					  && ( id != '<{$button}>' ) && (id != 'pic_<{$button}>')  ) {
			
			component.hide();
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
    <img id="pic_<{$id}>" src="" width="<{$width}>" height="<{$height}>" />
</div>	