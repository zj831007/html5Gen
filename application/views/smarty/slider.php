<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=<{$b_width}>, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" href="<{$slider_dir}>reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<{$slider_dir}>coda-slider.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<{$public_dir}>jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<{$slider_dir}>jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<{$slider_dir}>jquery.coda-slider-2.0.js"></script>
	<style>
	    #container { -webkit-tap-highlight-color:rgba(0,0,0,0); }
	    .container {
			width: <{$b_width}>px ;
			height:<{$b_height}>px;
			background:url(<{$image_dir}><{$b_file}>) no-repeat scroll center center #fff;
			position:relative;
		}
	    .coda-slider-wrapper {
			position:absolute;
		    width: <{$s_width}>px;
			padding: 0 <{if $s_arrowPosition == "1"}>0<{else}>30<{/if}>px;
			left: <{$s_left}>px;
			top: <{$s_top}>px;
		}		
		.coda-slider, .coda-slider .panel { 
		    width: <{$s_width}>px;
		}		 
        .coda-slider-wrapper.arrows .coda-slider, .coda-slider-wrapper.arrows .coda-slider .panel { 
		    width: <{$s_width}>px; 
		}		
		.coda-nav-left { left: 0; top:50%;}
		.coda-nav-right { right: 0; top: 50%;}
		.coda-nav-left a{ 
			background:none no-repeat scroll 0 0 ; 
		}
		.coda-nav-right a{ 
			background:none no-repeat scroll 0 0 ; 
		}

		.coda-nav ul li a {
		    -moz-border-radius: 17px;
			-khtml-border-radius: 17px;
			-webkit-border-radius: 17px;
			border-radius: 17px;

			-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5); 
			-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5); 
			text-shadow: 0 -1px 1px rgba(0,0,0,0.25); 
			border-bottom: 1px solid rgba(0,0,0,0.25);
		}
		.coda-nav ul li a.current {
		   	background: <{$s_dockColorCurrent}>;
			color: <{$s_dockTextColorCurrent}>;
		}
		.coda-slider .panel-wrapper {
			height: <{$s_height}>px;
		}
		
		.coda-nav li a:link, .coda-nav li a:visited {
			background: <{$s_dockColor}>;
			color: <{$s_dockTextColor}>;
		}

		.coda-nav li a:over {
		   	background: <{$s_dockColorCurrent}>;
			color: <{$s_dockTextColorCurrent}>;
		}

		h2.title{ 
		    display:none; 
		}

		.normal {
			height: 15px;			
			width: 15px;
			padding: 2px !important;
		}
		.small {
			height: 13px;
			width: 13px;
			padding: 0px !important;
			font-size: 11px;
		}
		.large {
			height: 17px;			
			width: 17px;
			padding: 4px !important;
		}
	
		.the_right{
			-moz-transform: rotate(180deg);
			-webkit-transform: rotate(180deg);
			-o-transform: rotate(180deg) ;
			-ms-transform: rotate(180deg);
			transform: rotate(180deg);
		}

        #showImg {
			position:absolute;
			left:<{$l_left}>px;
			top:<{$l_top}>px; 
			z-index:1;	
		}
	</style>
	<script>
	    $(function(){
		    $('#coda-slider-1').codaSlider({
			    dynamicTabsPosition:"<{$s_dockPosition}>",
				dynamicTabsAlign: "<{$s_dockAlign}>",
				dynamicTabs: <{$s_dock}>,
				dynamicArrows: false,
				supportTouchMove:<{$s_touch}>,
				<{if $s_auto }>
				autoSlideInterval:3000,
				autoSlideStopWhenClicked: false,
				<{/if}>
				autoSlide:<{$s_auto}>
			});
			
            <{if $s_dock and $s_dockShowText}>
			    $("#coda-nav-1 a").addClass("<{$s_dockSize}>");
			<{/if}>
			
			<{if $s_display }>
			$("#container").click(function(event){
			    var id = $(event.target).attr("id");
				//alert(id);
				if("container" == id){
					$("#coda-slider-wrapper-1").css("visibility","hidden");
				}
		    });
			
			$("#showImg").click(function(event){				
			    $("#coda-slider-wrapper-1").css("visibility","visible");
				event.stopPropagation();
			});
			<{/if}>
		});
	    
	</script>
</head>
<body>
<div id="container" class="container" <{if !$forPreview}>onclick="location.href='CInAppAction://Tap'"<{/if}>>
    <{if $s_display }>
        <img id="showImg" src ="<{$image_dir}><{$l_file}>" />
    <{/if}>
	<div id="coda-slider-wrapper-1" class="coda-slider-wrapper" <{if $s_display}>style="visibility:hidden;"<{/if}> >       
        <{if $s_arrow == "true" }>
		<div id="coda-nav-left-1" class="coda-nav-left">
            <{if $s_arrowFileName }>
			    <a href="#"><img width="30" height="30" src ="<{$image_dir}><{$s_arrowFileName}>" /></a>
            <{else}>
                <a href="#"><img width="30" height="30" src ="<{$slider_dir}>arrow_left.png" /></a>
            <{/if}>
		</div>
        <{/if}>
		<div class="coda-slider preload" id="coda-slider-1">
            <{section name=file loop = $s_files}>
                <div class="panel">
                    <div class="panel-wrapper">
                        <h2 class="title">
                           <{if $s_dockShowText}><{$smarty.section.file.iteration + 1}><{/if}>
                        <h2>
                        <img width="<{$s_width}>" height="<{$s_height}>" 
                             src ="<{$image_dir}><{$s_files[file]}>"/>
                     </div>
                 </div>
            <{/section}>
		</div>
        <{if $s_arrow == 'true' }>
		<div id="coda-nav-right-1" class="coda-nav-right the_right">
            <{if $s_arrowFileName }>
			    <a href="#"><img width="30" height="30" src ="<{$image_dir}><{$s_arrowFileName}>" /></a>
            <{else}>
                <a href="#"><img width="30" height="30" src ="<{$slider_dir}>arrow_left.png" /></a>
            <{/if}>
		</div>
        <{/if}>
	</div>	
</div>
</body>
</html>