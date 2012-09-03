<style>
.chidopoi_<{$id}>_hide{
	-webkit-transform-style:preserve-3d;
	-webkit-animation-timing-function:ease-in-out;
	-webkit-animation-fill-mode:both;
	-webkit-animation-delay: <{$hideDelay}>s;
	-webkit-animation-duration: <{$hideSpeed}>s;
    -webkit-animation-name: <{$id}>_hide;	
}

@-webkit-keyframes <{$id}>_hide {
	0%{
        opacity:1;
		-webkit-transform:rotate(0), rotateX(0), rotateY(0);
	}
	
	100% {
		opacity: <{$hideOpacity}>;
		<{if $hidePos == 'T'}>
		    top: -<{math equation="x + y" x=$height y=$offset_h}>px;
		<{elseif $hidePos == 'B'}>
		    top: <{math equation="x + y" x=$b_pageHeight y=$offset_h}>px;
		<{elseif $hidePos == 'L'}>
		    left: -<{math equation="x + y" x=$width y=$offset_w}>px;
		<{elseif $hidePos == 'R'}>
		    left: <{math equation="x + y" x=$b_pageWidth y=$offset_w}>px;
	    <{elseif $hidePos == 'LT'}>
		    left: -<{math equation="x + y" x=$width y=$offset_w}>px;
			top: -<{math equation="x + y" x=$height y=$offset_h}>px;
		<{elseif $hidePos == 'RT'}>
		    left: <{math equation="x + y" x=$b_pageWidth y=$offset_w}>px;
			top: -<{math equation="x + y" x=$height y=$offset_h}>px;
	    <{elseif $hidePos == 'LB'}>
		    left: -<{math equation="x + y" x=$width y=$offset_w}>px;
			top: <{math equation="x + y" x=$b_pageHeight y=$offset_h}>px;
		<{elseif $hidePos == 'RB'}>
		    left: <{math equation="x + y" x=$b_pageWidth y=$offset_w}>px;
			top: <{math equation="x + y" x=$b_pageHeight y=$offset_h}>px;
		<{/if}>
		
		<{if $hide2D || $hide3DX || $hide3DY}>
		-webkit-transform: rotate(<{if $hide2D}><{$hide2D}>deg<{ else }>0<{/if}>) 
		                   rotateX(<{if $hide3DX}><{$hide3DX}>deg<{ else }>0<{/if}>) 
		                   rotateY(<{if $hide3DY}><{$hide3DY}>deg<{ else }>0<{/if}>);
		<{/if}>
	}
}
</style>
