<style>
.chidopoi_<{$id}>_load{
	-webkit-transform-style:preserve-3d;
	-webkit-animation-timing-function:ease-in-out;
	-webkit-animation-fill-mode:both;
	-webkit-animation-delay:<{$loadDelay}>s;
	-webkit-animation-duration: <{$loadSpeed}>s;
    -webkit-animation-name: <{$id}>_load;	
}

@-webkit-keyframes <{$id}>_load {
	0% {
		opacity: <{$loadOpacity}>;
		<{if $loadPos == 'T'}>
		    top: -<{math equation="x + y" x=$height y=$offset_h}>px;
		<{elseif $loadPos == 'B'}>
		    top: <{math equation="x + y" x=$b_pageHeight y=$offset_h}>px;
		<{elseif $loadPos == 'L'}>
		    left: -<{math equation="x + y" x=$width y=$offset_w}>px;
		<{elseif $loadPos == 'R'}>
		    left: <{math equation="x + y" x=$b_pageWidth y=$offset_w}>px;
	    <{elseif $loadPos == 'LT'}>
		    left: -<{math equation="x + y" x=$width y=$offset_w}>px;
			top: -<{math equation="x + y" x=$height y=$offset_h}>px;
		<{elseif $loadPos == 'RT'}>
		    left: <{math equation="x + y" x=$b_pageWidth y=$offset_w}>px;
			top: -<{math equation="x + y" x=$height y=$offset_h}>px;
	    <{elseif $loadPos == 'LB'}>
		    left: -<{math equation="x + y" x=$width y=$offset_w}>px;
			top: <{math equation="x + y" x=$b_pageHeight y=$offset_h}>px;
		<{elseif $loadPos == 'RB'}>
		    left: <{math equation="x + y" x=$b_pageWidth y=$offset_w}>px;
			top: <{math equation="x + y" x=$b_pageHeight y=$offset_h}>px;
		<{/if}>
		<{if $load2D || $load3DX || $load3DY}>
		-webkit-transform: rotate(<{if $load2D}><{$load2D}>deg<{ else }>0<{/if}>) 
		                   rotateX(<{if $load3DX}><{$load3DX}>deg<{ else }>0<{/if}>) 
		                   rotateY(<{if $load3DY}><{$load3DY}>deg<{ else }>0<{/if}>);
		<{/if}>
	}
	/* <{$b_width}>|<{$offset_w + 10}>*/
	100%{
        opacity:1;
		-webkit-transform:rotate(0), rotateX(0), rotateY(0);
	}
}
</style>
