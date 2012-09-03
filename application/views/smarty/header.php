<!DOCTYPE html>
<html style="background-color:<{$h_color}>;">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta id="viewport" name="viewport" content="width=<{$b_width}>"/>
    <link href="<{$public_dir}>reset.css" rel="stylesheet"/>
    <link href="<{$public_dir}>animate-custom.css" rel="stylesheet"/>
    <{if $css}>
        <{foreach from=$css key=type item=v}>
            <{foreach from=$v item=file}>
    <link href="<{$library_dir}><{$type}>/<{$file}>" rel="stylesheet"/>
            <{/foreach}>
        <{/foreach}>
    <{/if}>
	<script src="<{$public_dir}>jquery-1.4.4.min.js"></script>
    <script src="<{$public_dir}>localStorage.js"></script>
    <script src="<{$public_dir}>public-event.js"></script>
    <script src="<{$public_dir}>fabric.min.js"></script>
    <script src="<{$public_dir}>jsrender.js"></script>
    <script src="<{$public_dir}>underscore-min.js"></script>

     <{if $js}>
        <{foreach from=$js key=type item=v}>
            <{foreach from=$v item=file}>
           <script src="<{$library_dir}><{$type}>/<{$file}>"></script>
            <{/foreach}>
        <{/foreach}>
    <{/if}>
    <style>
		* {
			margin: 0;
			padding: 0;
		}
		body{
			background:<{if $b_file}>url(<{$res_dir}><{$b_file}>)<{/if}> no-repeat scroll center center <{$b_color}>;
		}
	    .container {
			width: <{$b_pageWidth}>px ;
			height:<{$b_pageHeight}>px;			
			position:absolute;
			overflow: hidden;
		}
		.container3D{
		    -webkit-transform-style:preserve-3d;
			-webkit-perspective:500px;
			-webkit-perspective-origin: center 10%;
		}
		#container { -webkit-tap-highlight-color:rgba(0,0,0,0); }
		audio { display:none }
		#bg_sound_div{ display:none;}
		.fullScreen{
			left:0 !important;
			top:0 !important;
			width:100% !important;
			height:100% !important;
			z-index:1000 !important;
		}
        
		<{if $forPreview}>/*for pc chrome*/
		.chidopi_component3D{ -webkit-transform: translate3d(0,0,0px);}
		.chidopi_component3Dvideo{ -webkit-transform: translate3d(0,0,0.1px);}		
		<{/if}>
	</style>
    <script>
	var $bg_sound_div;
	var autoPlay, autoPlayAudios=new Array(0), bgGameSound="";
	var isPreview  = <{if $forPreview}>true<{else}>false;<{/if}>;
	
	if(Chidopi.Device.android() && window.JSInterface && window.JSInterface.getScreenSet){
	    window.JSInterface.getScreenSet();
	}
	
	function countScreen(a, b) {
      var result = <{$b_width}> * (a / b);
      var viewport = document.getElementById("viewport");
      viewport.content = "width=" + result;
    }

	Chidopi.JS.playPausableBgAudio = function(file, delay){
		if(!delay) delay = 0;
		bgGameSound = file;
	    var id = "bg_game";
		<{if $forPreview}>
		var sid = "sound_"+ id;
		var sound = $("#"+sid);

		if(sound.size() == 0 || sound.attr("src") != file){
			var audio = $("<audio/>").attr("id",sid).attr("src",file);
			audio.attr("loop","loop");
			sound[0].pause();
			sound.remove();
			$bg_sound_div.append(audio);
			sound = audio;
		}
                
        if(sound !=undefined && sound[0] != undefined){
            if (sound[0].paused) {
            	sound[0].play();
        	}else{ 
        		sound[0].pause();
        	}
        }			
		<{else}>
        location.href='CInAppAction://pausablebgaudio/' + file + ','+ delay+ ",bg_game";
		<{/if}> 
	}

	function soundEnd_bg_game(){
		location.href='CInAppAction://pausablebgaudio/' + bgGameSound + ',0,bg_game';
	} 
	
	Chidopi.JS.playOneAudio = function(id, file, delay, loop){
           
		if(!delay) delay = 0;
		<{if $forPreview}>
		//var sid = "sound_"+ id;
		//var sound = $("#"+sid);
		//if(sound.size() == 0){
			var audio = $("<audio/>").attr("src",file);              
			if(loop) audio.attr("loop","loop");
			//$bg_sound_div.append(audio);
			sound = audio;
		//}
                
        if(sound !=undefined && sound[0] != undefined)
		sound[0].play();			
		<{else}>
        location.href='CInAppAction://multiaudio/' + file + ','+ delay+ "," +id;
		<{/if}> 
    }

    Chidopi.JS.playPauseableAudio = function(id, file, delay, loop){
    	if(!delay) delay = 0;
		<{if $forPreview}>
		var sid = "sound_"+ id;
		var sound = $("#"+sid);
		
		if(sound.size() == 0){
			var audio = $("<audio/>").attr("id",sid).attr("src",file);
                        
			if(loop) audio.attr("loop","loop");
			$bg_sound_div.append(audio);
			sound = audio;
                       
		}
                
        if(sound !=undefined && sound[0] != undefined){
        	if (sound[0].paused) {
        		sound[0].play();
    		}else{ 
    			sound[0].pause();
    		} 
        }			
		<{else}>
        location.href='CInAppAction://pausableaudio/' + file + ','+ delay+ "," +id;
		<{/if}> 
    }
   
	<{if $forPreview}>
	JS.onReady(function(){
        var html = '';
        <{if $bs_file }>
        html ='<audio id="bg_sound" src="<{$res_dir}><{$bs_file}>" <{$bs_loop}> autoplay></audio>';
        <{/if}>
        if(autoPlayAudios && autoPlayAudios.length){
            for(i = 0; i< autoPlayAudios.length; i++){
                html += '<audio src="'+ autoPlayAudios[i] +'" autoplay></audio>';
            }
        }
        if(bgGameSound){
            html += '<audio id="sound_bg_game" src="'+bgGameSound+'" loop autoplay></audio>';
	    }
		if(html) $("#bg_sound_div").html(html);
	},true);
	<{else}>
	function REX_bgAudio(){
		if(autoPlayAudios && autoPlayAudios.length){
            var path = "CInAppAction://multiaudio/";
		<{if $bs_file }>
			<{if $bs_loop}>
            for(i = 0; i< autoPlayAudios.length; i++){
                if(i == 0) path = path + autoPlayAudios[i] + ',0,temp_0';
                else path = path + "&" + autoPlayAudios[i] + ',0,temp';
            }
			location.href = path;
			<{else}>
			path = path + '<{$res_dir}><{$bs_file}>,0,bg_sound';
            for(i = 0; i< autoPlayAudios.length; i++){
                path = path + '&' + autoPlayAudios[i] + ',0,temp';
            }

			location.href = path;
			<{/if}>
		<{else}>
            for(i = 0; i< autoPlayAudios.length; i++){
               if(i == 0) path = path + autoPlayAudios[i] + ',0,temp';
               else path = path + "&" + autoPlayAudios[i] + ',0,temp';
            }
			location.href = path;
		<{/if}>
		}else{
		<{if $bs_file }>
			<{if $bs_loop}>
			location.href = 'CInAppAction://bgaudio/<{$res_dir}><{$bs_file}>,0,bg_sound';
			<{else}>
			location.href = 'CInAppAction://multiaudio/<{$res_dir}><{$bs_file}>,0,bg_sound';
			<{/if}>
		<{/if}>
		}

		if(bgGameSound){
			setTimeout(function(){ location.href = 'CInAppAction://pausablebgaudio/'+ bgGameSound +',0,bg_game'; },100);
	    }
    }
	function soundBegin_temp_0(){
	<{if $bs_file }>
		<{if $bs_loop}>
		location.href = 'CInAppAction://bgaudio/<{$res_dir}><{$bs_file}>,0,bg_sound';
		<{/if}>
	<{/if}>
	}
    <{/if}>
		
	$(function(){
		$bg_sound_div = $("#bg_sound_div");
		<{if $b_loadAction}>
			//$("html").addClass("fixed_position");
			//$("html").bind("webkitAnimationEnd",function(){		  
			//	$("html").removeClass("fixed_position");
			//});	
		<{/if}>	
		<{if !$forPreview}>
		$("#container").click(function(event){
			
    		var ev = event ? event : window.event;
			var e = ev.target || ev.srcElement;
			var id = e.getAttribute("id");
			if( id && (id.indexOf("link")) < 0 && 
			    (id.indexOf("action") < 0 ) &&
			    (id.indexOf("page") < 0 ) && 
				(id.indexOf("video") < 0 ) && (!$(e).hasClass("click_ignore_me"))){	
			    location.href='CInAppAction://Tap';
			}else{
			}
		});
		<{/if}>
	});

	function auto(){
		if(autoPlay && typeof autoPlay.play == "function") autoPlay.play();
	}
		
	JS.onReady(function(){
		<{if $b_loadAction}>
			$('body').css("visibility","visible").addClass('animated <{$b_loadAction}>');	 
		<{/if}>
	},true);
	
	<{if $b_unLoadAction}>	    
	<{if $forPreview}>
		$(function(){
			$("#container").append('<a style=" background-color: #ccc; position:absolute; left:50px; top:50px; cursor:pointer; font-size:16px; color:#0000CC;" onClick="closePage();">離開本頁</a>');
		});
		function closePage(){
			$('body').removeClass('animated <{$b_loadAction}>').addClass('animated <{$b_unLoadAction}>');
			setTimeout(function(){$('html').hide();window.close();},1000);
		}
	<{else}>
		function app2Html(funcName, args){
			if( funcName == 'goToNextPage' || funcName == 'goToPrevPage' ){
				 $('body').removeClass('animated <{$b_loadAction}>').addClass('animated <{$b_unLoadAction}>');
			}
		}
	<{/if}>
	<{/if}>
	</script>
</head>
<body style="width:<{$b_pageWidth}>px; height: <{$b_pageHeight}>px; <{if $b_loadAction}>visibility:hidden;<{/if}>">
    <div id="bg_sound_div"></div>
    <div id="container" class="container container3D">