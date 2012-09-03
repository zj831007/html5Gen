<script>
$(function(){
    var eventName = "touchstart mousedown";
	var $text = $('#<{$id}>');
	var $title = $("#title_<{$id}>");
	var offset = 0;
	<{if $t_position == "top" || $t_position == "bottom" }>
	    offset = -<{$t_bodyHeight}>;
	<{else}>
	    offset = -<{$t_bodyWidth}>;
	<{/if}>	

	//$text.hide();
	//$text.animate( { <{$t_position}>:  offset + 'px'}, 10, function(){ $text.show()});	
	$title.bind(eventName, show_<{$id}>);
	function show_<{$id}>(e) {
		
		$text.css('<{$t_position}>', '0');
		$title.unbind(eventName, show_<{$id}>);
		$title.bind(eventName, hide_<{$id}>);	
		e.preventDefault();
	}

	function hide_<{$id}>(e) {
		if ( e.target.localName != "a") {
			$text.css('<{$t_position}>', offset + 'px');
			$title.unbind(eventName, hide_<{$id}>);
			$title.bind(eventName, show_<{$id}>);
			e.preventDefault();
		}
	}
});
</script>

<div id="<{$id}>" class="chidopi_component3D" style=" position:absolute; -webkit-transition: all 0.5s ease-in-out; <{if $t_position =="left" || $t_position == "right"}>top: <{$t_top}>px; <{$t_position}>: -<{$t_bodyWidth}>px;<{else}> left: <{$t_left}>px; <{$t_position}>: -<{$t_bodyHeight}>px;<{/if}> z-index:<{$zIndex}>;">
    <{if $t_position =="top"}>
    
        <div id="body_<{$id}>" style="background: <{if $t_bodyFile}>url(<{$res_dir}><{$t_bodyFile}>)<{/if}> no-repeat 0 0 <{$t_bodyBgColor}>; height:<{$t_bodyHeight}>px; width:<{$t_bodyWidth}>px; overflow:scroll; -webkit-background-size:<{$t_bodyWidth}>px <{$t_bodyHeight}>px; -moz-background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px; background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px;">
            <div style="background:<{if $t_bodyBgFile}>url(<{$res_dir}><{$t_bodyBgFile}>)<{/if}> no-repeat center center ; height:<{$t_bodyFileHeight}>px; width:<{$t_bodyFileWidth}>px; ">
                 <{$t_bodyText}>
            </div>  
        </div>
        
        <div id="title_<{$id}>" style="left: <{$t_left}>px; overflow:hidden; background:<{if $t_titleFile}>url(<{$res_dir}><{$t_titleFile}>)<{/if}> no-repeat center center <{$t_titleBgColor}>; <{if $t_titleColor }> color: <{$t_titleColor}>; <{/if}>  text-align:<{$t_titleAlign}>; height:<{$t_titleHeight}>px; width:<{$t_titleWidth}>px; -webkit-background-size:<{$t_titleWidth}>px <{$t_titleHeight}>px; -moz-background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px; background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px;">
            <{if $t_titleText}>
                <table width="100%" height="100%" style="margin:0; padding:0;"><tr>
                <td valign="middle" style="padding:10px; font-family: <{$t_titleFont}>; font-size: <{$t_titleFontSize}>;"><{$t_titleText}></td>
                </tr></table>
            <{/if}>
        </div>        
        
    <{elseif $t_position =="bottom"}>
    
        <div id="title_<{$id}>" style="left: <{$t_left}>px; overflow:hidden; background:<{if $t_titleFile}>url(<{$res_dir}><{$t_titleFile}>)<{/if}> no-repeat center center <{$t_titleBgColor}>; <{if $t_titleColor }> color: <{$t_titleColor}>; <{/if}> text-align:<{$t_titleAlign}>; height:<{$t_titleHeight}>px; width:<{$t_titleWidth}>px; -webkit-background-size:<{$t_titleWidth}>px <{$t_titleHeight}>px; -moz-background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px; background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px;">
            <{if $t_titleText}>
                <table width="100%" height="100%" style="marin:0; padding:0;"><tr>
                <td valign="middle" style="padding:10px; font-family: <{$t_titleFont}>; font-size: <{$t_titleFontSize}> ;"><{$t_titleText}></td>
                </tr></table>
            <{/if}>
        </div>
        
        <div id="body_<{$id}>" style="background: <{if $t_bodyFile}>url(<{$res_dir}><{$t_bodyFile}>)<{/if}> no-repeat 0 0 <{$t_bodyBgColor}>; height:<{$t_bodyHeight}>px; width:<{$t_bodyWidth}>px; overflow:scroll; -webkit-background-size:<{$t_bodyWidth}>px <{$t_bodyHeight}>px; -moz-background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px; background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px;">
            <div style="background:<{if $t_bodyBgFile}>url(<{$res_dir}><{$t_bodyBgFile}>)<{/if}> no-repeat center center ; height:<{$t_bodyFileHeight}>px; width:<{$t_bodyFileWidth}>px; ">
                 <{$t_bodyText}>
            </div>  
        </div>   
         
    <{elseif $t_position =="left"}>
        
        <div id="body_<{$id}>" style="float:left; background: <{if $t_bodyFile}>url(<{$res_dir}><{$t_bodyFile}>)<{/if}> no-repeat 0 0 <{$t_bodyBgColor}>; height:<{$t_bodyHeight}>px; width:<{$t_bodyWidth}>px; overflow:scroll; -webkit-background-size:<{$t_bodyWidth}>px <{$t_bodyHeight}>px; -moz-background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px; background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px;">
            <div style="background:<{if $t_bodyBgFile}>url(<{$res_dir}><{$t_bodyBgFile}>)<{/if}> no-repeat center center ; height:<{$t_bodyFileHeight}>px; width:<{$t_bodyFileWidth}>px; ">
                 <{$t_bodyText}>
            </div>  
        </div>
        
        <div id="title_<{$id}>" style="float:left; top: <{$t_top}>px; overflow:hidden; background:<{if $t_titleFile}>url(<{$res_dir}><{$t_titleFile}>)<{/if}> no-repeat center center <{$t_titleBgColor}>; <{if $t_titleColor }> color: <{$t_titleColor}>; <{/if}> text-align:<{$t_titleAlign}>; height:<{$t_titleHeight}>px; width:<{$t_titleWidth}>px; -webkit-background-size:<{$t_titleWidth}>px <{$t_titleHeight}>px; -moz-background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px; background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px;">
            <{if $t_titleText}>
                <table width="100%" height="100%" style="marin:0; padding:0;"><tr>
                <td valign="middle" style="padding:10px; font-family: <{$t_titleFont}>; font-size: <{$t_titleFontSize}> ;"><{$t_titleText}></td>
                </tr></table>
            <{/if}>
        </div>
         
    <{elseif $t_position =="right"}>
        
        <div id="title_<{$id}>" style="float:left; top: <{$t_top}>px; overflow:hidden; background:<{if $t_titleFile}>url(<{$res_dir}><{$t_titleFile}>)<{/if}> no-repeat center center <{$t_titleBgColor}>; <{if $t_titleColor }> color: <{$t_titleColor}>; <{/if}> text-align:<{$t_titleAlign}>; height:<{$t_titleHeight}>px; width:<{$t_titleWidth}>px; -webkit-background-size:<{$t_titleWidth}>px <{$t_titleHeight}>px; -moz-background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px; background-size: <{$t_titleWidth}>px <{$t_titleHeight}>px;">
            <{if $t_titleText}>
                <table width="100%" height="100%" style="marin:0; padding:0;"><tr>
                <td valign="middle" style="padding:10px; font-family: <{$t_titleFont}>; font-size: <{$t_titleFontSize}> ;"><{$t_titleText}></td>
                </tr></table>
            <{/if}>
        </div>
        
        <div id="body_<{$id}>" style="float:left; background: <{if $t_bodyFile}>url(<{$res_dir}><{$t_bodyFile}>)<{/if}> no-repeat 0 0 <{$t_bodyBgColor}>; height:<{$t_bodyHeight}>px; width:<{$t_bodyWidth}>px; overflow:scroll; -webkit-background-size:<{$t_bodyWidth}>px <{$t_bodyHeight}>px; -moz-background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px; background-size: <{$t_bodyWidth}>px <{$t_bodyHeight}>px;">
            <div style="background:<{if $t_bodyBgFile}>url(<{$res_dir}><{$t_bodyBgFile}>)<{/if}> no-repeat center center ; height:<{$t_bodyFileHeight}>px; width:<{$t_bodyFileWidth}>px; ">
                 <{$t_bodyText}>
            </div>  
        </div>
        
    <{/if}>
    
</div>
