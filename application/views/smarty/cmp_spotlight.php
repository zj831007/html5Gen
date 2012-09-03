<script src="<{$library_dir}>spotlight/jquery.spotlight.js"></script>
<script>
    $(function(){
        var mySettings = {
            baseUrl:"<{$res_dir}>",
            img:"<{$img}>",
            imgEffect:"<{$imgEffect}>",
            
            color:"<{$color}>",
            opacity:'<{$opacity}>',
            weight:'<{$weight}>',
            
            spotShape:"<{$spotShape}>",
            spotRadius:"<{$spotRadius}>",
            spotWidth: "<{$spotWidth}>",
            spotHeight:"<{$spotHeight}>",
            
            touchAction:"<{$touchAction}>",
            
            touchAudioAct:{
                callback: function(){
                    //Chidopi.JS.playOneAudio('touchaudio_<{$id}>','<{$res_dir}><{$touchAudio}>');
                }
            }
            
        };
        
        
        $("#spotlight_<{$id}>").jqSpotlight(mySettings);
    
        $("#spotlight_c_<{$id}>").delegate("canvas","click", function(e){
            if (e.stopPropagation){
                e.stopPropagation();
            }else{
                e.cancelBubble = true;
            }
        });
        
        if("<{$succAction}>" == "page"){
            $("#spotlight_jump_<{$id}>").show();
        }
    });
    
    function spolight_loca_finish_o(){
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

<div  id="spotlight_c_<{$id}>" class="chidopi_component3D" style="position: absolute; left:<{$x}>px; top:<{$y}>px;z-index:<{$zIndex}>; ">
    <canvas id="spotlight_<{$id}>" width="<{$width}>" height="<{$height}>" style="background-color:<{$maskcolor}>;opacity:<{$maskopacity}>;"></canvas>
    <a id="spotlight_jump_<{$id}>" href="#" class="click_ignore_me" onclick="spolight_loca_finish_o()" style="position:relative; left:25px;top:-25px; z-index:5;display:none;font-size:24px;color:#fff;"><{$jumpText}></a>
</div>
