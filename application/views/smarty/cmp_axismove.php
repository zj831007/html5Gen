<script src="<{$library_dir}>axismove/jquery.axismove.js"></script>
<script>
    $(function(){
        var mySettings = {
            baseUrl:"<{$res_dir}>",
            canvasbg:"axismove_<{$id}>",
            canvasbtn:"axismove_btn_<{$id}>",
            
            xrayimg:"<{$xrayimg}>",
            xrayopacity:"<{$xrayopacity}>",
            
            xrayoriention:"<{$xrayoriention}>",
            btnimg:'<{$btnimg}>',
            btnxposition:'<{$btnxposition}>',
            btnyposition:"<{$btnyposition}>",
            
            xraywidth:"<{$xraywidth}>",
            xrayheight: "<{$xrayheight}>",
            
            touchAudioAct:{
                callback: function(){
                    if("<{$touchAudio}>" != ""){
                        Chidopi.JS.playOneAudio('touchaudio_<{$id}>','<{$res_dir}><{$touchAudio}>');
                    }
                }
            }
            
        };
        
        
        $("#axismove_<{$id}>").axismove(mySettings);
    
        $("#axismove_c_<{$id}>").delegate("canvas","click", function(e){
            if (e.stopPropagation){
                e.stopPropagation();
            }else{
                e.cancelBubble = true;
            }
        });
        
        if("<{$succAction}>" == "page"){
            $("#axismove_jump_<{$id}>").show();
            $("#axismove_jump_<{$id}>").bind("click",function(){
                if("<{$succAction}>" == "page"){
                    location.href="CInAppAction://MoveTo/p<{$succActionPage}>.html";
                }
            });
        }
        
    });
    function axismove_loca_finish_o(){
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

<div  id="axismove_c_<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$x}>px; top:<{$y}>px;z-index:<{$zIndex}>; ">
    <canvas id="axismove_<{$id}>" width="<{$width}>" height="<{$height}>" style="background-image: url(<{$res_dir}><{$overlayimg}>);background-size:100% 100%;"></canvas>
    <div style="position:absolute; left:0px; top:0px;">
        <canvas id="axismove_btn_<{$id}>" width="<{$width}>" height="<{$height}>" style="position:absolute; left:0px; top:0px;"></canvas>
    </div>

    <a id="axismove_jump_<{$id}>" href="#" class="click_ignore_me" onclick="axismove_loca_finish_o()" style="position:relative; left:25px;top:-25px; z-index:5;display:none;font-size:24px;color:#000;"><{$jumpText}></a>
</div>
