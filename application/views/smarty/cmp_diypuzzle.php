<link type="text/css" href="<{$library_dir}>diypuzzle/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<script src="<{$library_dir}>diypuzzle/jquery.mousewheel.js"></script>
<script src="<{$library_dir}>diypuzzle/jquery.jscrollpane.js"></script>
<script src="<{$library_dir}>diypuzzle/jquery.diypuzzle.js"></script>
<style>
    .scroll-paneV{position: absolute;width: 110px;height: 500px;overflow: auto;}
    .scroll-paneV img{margin-bottom: 2px;cursor: pointer}
    .scroll-paneH{position: absolute;width: 500px;height: 106px;overflow: auto;height: 106px;max-height: 200px;}
    .scroll-paneH img{margin-right: 2px;cursor: pointer}
    .finish-div{background-color:#000; font-size:24px;opacity:0.6;color:#fff;position:absolute; width:200px; height:100px;padding:40px;z-index: 5;}
    .finish-div p{opacity: 1;padding-top: 5px;}
</style>
<script>
    $(function(){
        //区块分布：t b l r:  上下左右 rand随机，根据区块分布定位滑动块位置
       
        if("<{$blockDis}>" == "t"){
            $("#scholl_pane_<{$id}>").css("top", (<{$y}>-110)+"px").css("left","<{$x}>px").css("width","<{$width}>px");
        }
        if("<{$blockDis}>" == "b"){
            $("#scholl_pane_<{$id}>").css("top", (<{$y}>+<{$height}>+5)+"px").css("left","<{$x}>px").css("width","<{$width}>px");
        }
        if("<{$blockDis}>" == "l"){
            $("#scholl_pane_<{$id}>").css("top","<{$y}>px").css("left", (<{$x}>-106)+"px").css("height","<{$height}>px");
        }
        if("<{$blockDis}>" == "r"){
            $("#scholl_pane_<{$id}>").css("top","<{$y}>px").css("left", (<{$y}>+<{$width}>+117)+"px").css("height","<{$height}>px");
        }
        
        $('.scroll-paneV').jScrollPane({showArrows: false,isScrollableV:true});
        $('.scroll-paneH').jScrollPane({showArrows: false,isScrollableV:true});
      
        if("<{$scoreShow}>" == 1){
            $("#diypuzzle_timer_<{$id}>").show();
        }else{
            $("#diypuzzle_timer_<{$id}>").hide();
        }
       
        var mySettings = {
            timeLimit:<{$timeLimit}>,
            scoreShow:'<{$scoreShow}>',
            retestShow:'<{$retestShow}>',
            scrollid:"scholl_pane_<{$id}>",
            blockDis:"<{$blockDis}>",
            baseUrl:"<{$res_dir}>",
            bgpic: "<{$res_dir}><{$bgpic}>",
            points:<{$points}>,
            timeRestart:"<{$timeRestart}>",
            timeerOnAct:{
                callback: function(t){
                    var h = parseInt(t/60/60, 10);
                   
                    var m = parseInt((t-h*60*60)/60,10);
                    var s = t-h*60*60-m*60;
                    
                    if(h<10) h="0"+h;
                    if(m<10) m="0"+m;
                    if(s<10) s="0"+s;
                    $("#diypuzzle_timer_<{$id}>").html(h+":"+m+":"+s);
                    
                }
            },
            finishAudioAct:{
                callback: function(){
                    Chidopi.JS.playOneAudio('finishaudio_<{$id}>','<{$res_dir}><{$finishAudio}>');
                    
                }
            },
            rightAduioAct:{
                callback: function(){
                    Chidopi.JS.playOneAudio('rightaudio_<{$id}>','<{$res_dir}><{$rightAudio}>');
                    
                }
            },
            rightImgAct:{
                callback: function(){
                    if("<{$rightImg}>" != ""){
                        $("#diypuzzle_<{$id}>_img").attr("src","<{$res_dir}><{$rightImg}>");
                        $("#diypuzzle_<{$id}>_img").one("load",function() {
                            $this = $(this);
                            $this.css({width: 'auto', height: 'auto', visibility: 'visible'}); 
                            var imgWidth = $this.width();
                            var imgHeight = $this.height();
                            
                            var canvasWidth = $("#diypuzzle_<{$id}>").width();
                            var canvasHeight = $("#diypuzzle_<{$id}>").height();
                            
                            var left = canvasWidth/2-imgWidth/2;
                            var top = canvasHeight/2-imgHeight/2;
                            $this.css({left:left,top:top});
                            $this.fadeIn('slow',function(){
                                $this.fadeOut('slow', function(){
                                    $this.attr("src","<{$library_dir}>lianliankan/black.png");
                                });
                            });
                           
                        });
                    }
                }
            },
            finishImgAct:{
                callback: function(){
                    if("<{$succAction}>" == "page"){
                        $("#diypuzzle_jump_<{$id}>").show();
                    }
                    if("<{$finishImg}>" != ""){
                        $("#diypuzzle_<{$id}>_img").attr("src","<{$res_dir}><{$finishImg}>");
                        $("#diypuzzle_<{$id}>_img").one('load', function() {
                            $this = $(this);
                            $this.css({width: 'auto', height: 'auto', visibility: 'visible'}); 
                            var imgWidth = $this.width();
                            var imgHeight = $this.height();
                            
                            var canvasWidth = $("#diypuzzle_<{$id}>").width();
                            var canvasHeight = $("#diypuzzle_<{$id}>").height();
                            
                            var left = canvasWidth/2-imgWidth/2;
                            var top = canvasHeight/2-imgHeight/2;
                            $this.css({left:left+"px",top:top+"px"});
                            $this.fadeIn('slow',function(){
                                if('<{$scoreShow}>' == '1'){
                                    $this.fadeOut('slow',function(){
                                        $this.attr("src","<{$library_dir}>lianliankan/black.png");
                                    });
                                    
                                }else{
                                    $this.one('click', function(e) {
                                         e.stopPropagation();
                                        $this.fadeOut('slow',function(){
                                            $this.attr("src","<{$library_dir}>lianliankan/black.png");
                                        });
                                    });
                                }
                                
                            });
                        });
                    }
                }
            
            },
            rightTextAct:{
                callback: function(x,y){
               
                    $("#diypuzzle_text_<{$id}>").css({position: "absolute",left:x+"px",top:y+"px"});
                    $("#diypuzzle_text_<{$id}>").html("<{$rightText}>");
                    $("#diypuzzle_text_<{$id}>").fadeIn('slow',function(){
                        $("#diypuzzle_text_<{$id}>").fadeOut('slow', function(){});
                    });
                }
            },
            finishTextAct:{
                callback: function(x, y){
                
                    $("#diypuzzle_text_<{$id}>").css({position: "absolute",left:x+"px",top:y+"px"});
                    $("#diypuzzle_text_<{$id}>").html("<{$finishText}>");
                    $("#diypuzzle_text_<{$id}>").fadeIn('slow',function(){
                        $("#diypuzzle_text_<{$id}>").fadeOut('slow', function(){});
                    });
                }
            },
            rightEffectAct:{
                callback: function(x,y){
                    if("<{$rightEffect}>" !=0){
                        $("#diypuzzle_effect_<{$id}>").css({position: "absolute",left:x-20+"px",top:y-20+"px"});
                        $("#diypuzzle_effect_<{$id}>").attr("src","<{$library_dir}>diypuzzle/<{$rightEffect}>");
                        $("#diypuzzle_effect_<{$id}>").fadeIn('slow',function(){
                            $("#diypuzzle_effect_<{$id}>").fadeOut('slow', function(){
                                $("#diypuzzle_effect_<{$id}>").attr("src","<{$library_dir}>diypuzzle/black.png");
                            });
                        });
                    }
                }
            },
            finishEffectAct:{
                callback: function(x,y){
                    if("<{$rightEffect}>" !=0){
                        $("#diypuzzle_effect_<{$id}>").css({position: "absolute",left:x-20+"px",top:y-20+"px"});
                        $("#diypuzzle_effect_<{$id}>").attr("src","<{$library_dir}>diypuzzle/<{$finishEffect}>");
                        $("#diypuzzle_effect_<{$id}>").fadeIn('slow',function(){
                            $("#diypuzzle_effect_<{$id}>").fadeOut('slow', function(){
                                $("#diypuzzle_effect_<{$id}>").attr("src","<{$library_dir}>diypuzzle/black.png");
                            });
                        });
                    }
                }
            },
        };
        
        //显示分数div
        
        $("#diypuzzle_<{$id}>").jqDiypuzzle(mySettings);
     
        $("#diypuzzle_c_<{$id}>").delegate("canvas","click", function(e){
            if (e.stopPropagation){
                e.stopPropagation();
            }else{
                e.cancelBubble = true;
            }
        });
        
    });
        
   function diypuzzle_loca_finish_o(){
      if (event.stopPropagation){
            event.stopPropagation();
        }else{
            event.cancelBubble = true;
        }
        if("<{$succAction}>" == "page"){
            location.href="CInAppAction://MoveTo/p<{$succActionPage}>.html";
        }
    }     
      
</script>
<{if $blockDis=='l' || $blockDis =='r'}>
<div class="scroll-paneV" id="scholl_pane_<{$id}>">
</div>
<{/if}>
<{if $blockDis=='t' || $blockDis =='b'}>
<div class="scroll-paneH" id="scholl_pane_<{$id}>">
    <p style="width: 3000px;">
    </p>
</div>
<{/if}>
<div  id="diypuzzle_c_<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$x}>px; top:<{$y}>px;z-index:<{$zIndex}>; ">
    <span id="diypuzzle_timer_<{$id}>" style="position: absolute; left:10px; top:0px;z-index:<{$zIndex}>; "></span>
    <canvas id="diypuzzle_<{$id}>" width="<{$width}>" height="<{$height}>" ></canvas>
    <img id="diypuzzle_<{$id}>_img" src="<{$library_dir}>diypuzzle/black.png" style="position:absolute;left:40px; top:40px;display:block"/>
    <span id="diypuzzle_text_<{$id}>" style="position:absolute; font-family:<{$fontStyle}>;font-size:<{$fontSize}>px;color:<{$fontColor}>;display:none;"></span>
    <img id="diypuzzle_effect_<{$id}>" src="<{$library_dir}>diypuzzle/black.png" style="position:absolute;display:block;width:40px;height:40px"/>
    <a id="diypuzzle_jump_<{$id}>" href="#" class="click_ignore_me" onclick="diypuzzle_loca_finish_o()" style="position:relative; left:20px;top:-5px; z-index:5;display:none;font-size:24px"><{$jumpText}></a>
</div>
