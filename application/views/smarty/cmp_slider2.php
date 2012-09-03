<style>
<{if $dock}>
#<{$id}> .nivo-controlNav a{
	background:<{$dockColor}>;
	<{if $dockShowText}> color: <{$dockTextColor}><{/if}>;
}

#<{$id}> .nivo-controlNav a.active {			
	background: <{$dockColorCurrent}>;
	<{if $dockShowText}> color: <{$dockTextColorCurrent}><{/if}>;
}

#<{$id}> .nivo-controlNav a:link, #<{$id}> .nivo-controlNav a:visited {
	background:<{$dockColor}>;
	<{if $dockShowText}> color: <{$dockTextColor}><{/if}>;
}

#<{$id}> .nivo-controlNav a:hover {
	background: <{$dockColorCurrent}>;
	<{if $dockShowText}> color: <{$dockTextColorCurrent}><{/if}>;
}
<{/if}>
<{if $arrow}>
#<{$id}> .nivo-directionNav a , #<{$id}>_wrapper .nivo-directionNav a{			
	/*width:30px;height:30px;*/
	<{if $arrowFileName}>background:url(<{$res_dir}><{$arrowFileName}>) no-repeat;<{/if}>
}
<{/if}>
</style>
<script>
$(function(){
	var component = $("#<{$id}>_wrapper");
	var <{$id}> = $('#<{$id}>').nivoSlider({
		effect:'<{$changeMode}>', 
		animSpeed: 500,
		transparent: <{$transPic}>,
		<{if $dock}> controlNav: true,		
		controlNavAlign:'<{$dockAlign}>', 
		controlNavPosition:'<{$dockPosition}>',
		<{if $dockShowText}>controlNavText: true,<{/if}>
		<{/if}>
		<{if $arrow}>directionNav: true, 
		directionNavPos:<{$arrowPosition}>,<{/if}>
		<{if $touch}>supportTouch: true,<{/if}>
		<{if $auto}>autoRun: true,<{/if}>
	});

	<{if $button}>
	$("#<{$button}>").bind('click',function(event){				
		<{if $hideMode == 'back'}>		
			component.css('visibility','visible').addClass("chidopoi_<{$id}>_load")	;
		    $('#container').bind("click",{obj:this}, hide_<{$id}>);				
		<{elseif $hideMode == 'button'}>		
		     var style = component.css("visibility");
			 if(style == 'hidden'){
			     component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");
			 }else{				 
				 hide_<{$id}>_action();				
			 }			 
	    <{else}>
		     component.show().css('visibility','visible').addClass("chidopoi_<{$id}>_load");	
		<{/if}>
			
	});
	
	var hide_<{$id}> = function(event){       
		var obj = event.data.obj;
		var ev = event ? event : window.event;
		var e = ev.target || ev.srcElement;
		var id = e.getAttribute("id") ? e.getAttribute("id") :'';
		var clazz = e.getAttribute("class") ? e.getAttribute("class") : '';
		if ( e != obj && ( id != '<{$id}>_wrapper' ) && (id!= '<{$id}>') 
		              && ( id != '<{$button}>' ) && (id != 'pic_<{$button}>') 
					  && clazz.indexOf("nivo-slice") < 0 && clazz.indexOf("nivo-control") < 0
					  && clazz.indexOf("nivo-nextNav") < 0 && clazz.indexOf("nivo-prevNav") < 0 
					  && clazz.indexOf("nivo_show") < 0 ) {
						  
    		hide_<{$id}>_action();			
		    $("#container").unbind("click",hide_<{$id}>);
		}
	}
	
	var hide_<{$id}>_action = function(event){
		var sub = $("#<{$id}>_wrapper .nivo_subcontainer");
		sub.removeClass("nivo_subcontainer");
		component.removeClass("chidopoi_<{$id}>_load");
	    <{if $hideAction}>
			component.addClass("chidopoi_<{$id}>_hide");
	   		window.setTimeout(
			    function(){component.removeClass("chidopoi_<{$id}>_hide");component.css("visibility", "hidden");
				setTimeout(function(){sub.addClass("nivo_subcontainer");},500);}, 
				<{$hideSpeed}> * 1000 + <{$hideDelay}> * 1000 +300);
		<{else}>
		    component.css("visibility", "hidden");
			setTimeout(function(){sub.addClass("nivo_subcontainer");},500);
		<{/if}>
	}
	<{/if}>	
});
<{if !$display && $loadAction }>
JS.onReady(function(){
	var component = $("#<{$id}>_wrapper");	
   component.css('visibility','visible').addClass("chidopoi_<{$id}>_load");
   window.setTimeout(
	   function(){component.removeClass("chidopoi_<{$id}>_load")}, 
	   <{$loadSpeed}>* 1000 + <{$loadDelay}> * 1000 +300);
	   
},true);
<{/if}> 
</script>
<div id="<{$id}>_wrapper" class="chidopi_component3D" style="position:absolute; width: <{$width}>px; height: <{$height}>px; 
         top:<{$top}>px; left:<{$left}>px; z-index:<{$zIndex}>; <{if $display || $loadAction}>visibility:hidden;<{/if}>">
	<div id="<{$id}>_slider-wrapper" class="slider-wrapper">
		<div id="<{$id}>" class="nivoSlider">
        	<{section name=index loop = $file}>
			<div><img width="<{$width}>px" height="<{$height}>px" src ="<{$res_dir}><{$file[index]}>"/></div>
            <{/section}>
		</div>		
	</div>
</div>
