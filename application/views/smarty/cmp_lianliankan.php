<script src="<{$library_dir}>lianliankan/jquery.lianliankan.js"></script>
<style>
    .pazzle_contain{
        -webkit-background-size: 100% 100%; 
        -o-background-size: 100% 100%; 
        background-size: 100% 100%;
    }
</style>
<script>
    $(function(){
        var mySettings = { 
            baseUrl:"<{$res_dir}>",
            bgpic: "<{$res_dir}><{$bgpic}>",
            lineWidth:'<{$lineWidth}>',
            lineColor:'<{$lineColor}>',
            pointWidth:'<{$pointWidth}>',
            points:<{$points}>,
            lines:<{$lines}>,
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
            errorAduioAct:{
                callback: function(){
                    Chidopi.JS.playOneAudio('erroraudio_<{$id}>','<{$res_dir}><{$errorAudio}>');
                }
            },
            rightImgAct:{
                callback: function(){
                    
                    if("<{$rightImg}>" != ""){
                        $("#lianliankan_<{$id}>_img").attr("src","<{$res_dir}><{$rightImg}>");
                        $("#lianliankan_<{$id}>_img").one("load",function() {
                            $this = $(this);
                            $this.css({width: 'auto', height: 'auto', visibility: 'visible'}); 
                            var imgWidth = $this.width();
                            var imgHeight = $this.height();
                            
                            var canvasWidth = $("#lianliankan_<{$id}>").width();
                            var canvasHeight = $("#lianliankan_<{$id}>").height();
                            
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
            errorImgAct:{
                callback: function(){
                    if("<{$errorImg}>" != ""){
                        $("#lianliankan_<{$id}>_img").attr("src","<{$res_dir}><{$errorImg}>");
                        $("#lianliankan_<{$id}>_img").one('load', function() {
                            $this = $(this);
                            $this.css({width: 'auto', height: 'auto', visibility: 'visible'}); 
                            var imgWidth = $this.width();
                            var imgHeight = $this.height();
                            
                            var canvasWidth = $("#lianliankan_<{$id}>").width();
                            var canvasHeight = $("#lianliankan_<{$id}>").height();
                            
                            var left = canvasWidth/2-imgWidth/2;
                            var top = canvasHeight/2-imgHeight/2;
                            $this.css({left:left,top:top});
                            $this.fadeIn('slow',function(){
                                $this.fadeOut('slow',function(){
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
                        $("#lianliankan_jump_<{$id}>").show();
                        //自动跳页
                       // location.href="CInAppAction://MoveTo/p<{$succActionPage}>.html";
                    }
                    if("<{$finishImg}>" != ""){
                        $("#lianliankan_<{$id}>_img").attr("src","<{$res_dir}><{$finishImg}>");
                        $("#lianliankan_<{$id}>_img").one('load', function() {
                            $this = $(this);
                            $this.css({width: 'auto', height: 'auto', visibility: 'visible'}); 
                            var imgWidth = $this.width();
                            var imgHeight = $this.height();
                            
                            var canvasWidth = $("#lianliankan_<{$id}>").width();
                            var canvasHeight = $("#lianliankan_<{$id}>").height();
                            
                            var left = canvasWidth/2-imgWidth/2;
                            var top = canvasHeight/2-imgHeight/2;
                            $this.css({left:left,top:top});
                            $this.fadeIn('slow',function(){
                                $this.bind("click",function(){
                                    $this.fadeOut('slow',function(){
                                        $this.attr("src","<{$library_dir}>lianliankan/black.png");
                                    });
                                })
                            });
                            //                            $this.css({width: canvasWidth, height:canvasHeight, visibility: 'visible'}); 
                            //                            
                            //                            $this.css({left:0,top:0});
                            //                            $this.fadeIn('slow');
                           
                        });
                    }
                }
            },
        };
        
        $("#lianliankan_<{$id}>").jqLianliankan(mySettings);
     
        $("#lianliankan_c_<{$id}>").delegate("canvas","click", function(e){
            if (e.stopPropagation){
                e.stopPropagation();
            }else{
                e.cancelBubble = true;
            }
        });
    });
    
    
    function lianliankan_loca_finish_o(){
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

<div  id="lianliankan_c_<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$x}>px; top:<{$y}>px;z-index:<{$zIndex}>;">
    <canvas id="lianliankan_<{$id}>" width="<{$width}>" height="<{$height}>" ></canvas>
    <img id="lianliankan_<{$id}>_img" src="<{$library_dir}>lianliankan/black.png" style="position:absolute;left:40px; top:40px;display:block"/>
    <a id="lianliankan_jump_<{$id}>" href="#" class="click_ignore_me" onclick="lianliankan_loca_finish_o()" style="position:relative; left:20px;top:-50px; z-index:5;display:none;font-size:24px"><{$jumpText}></a>
</div>
<div>

</div>