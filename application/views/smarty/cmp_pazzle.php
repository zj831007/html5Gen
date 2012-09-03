<script src="<{$library_dir}>pazzle/jquery.jqpuzzle.full.js"></script>
<link href="<{$library_dir}>pazzle/jquery.jqpuzzle.css" rel="stylesheet"/>

<style>
    .pazzle_contain{
        -webkit-background-size: 100% 100%; 
        -o-background-size: 100% 100%; 
        background-size: 100% 100%;
    }
</style>
<script>
    var pazzlePics = [
            <{foreach from=$pazzlePics item=pazzlePic name=pazzlePicN}>
            "<{$pazzlePic}>"
            <{if !$smarty.foreach.pazzlePicN.last}>
            ,
            <{/if}>
            <{/foreach}>
        ];
    var pazzleRewardPics = [
            <{foreach from=$rewardPics item=rewardPic name=rewardPicN}>
            "<{$rewardPic}>"
            <{if !$smarty.foreach.rewardPicN.last}>
            ,
            <{/if}>
            <{/foreach}>
        ];

    $(function(){
        var mySettings = { 
            rows: <{$row}>, 
            cols: <{$col}>, 
            success: { 
                callback: function(results) {
                    var audios = [
                            <{foreach from=$succAudios item=audio name=audioN}>
                            '<{$res_dir}><{$audio}>',
                            <{/foreach}>];
                    var r =parseInt(Math.random()*audios.length);
               
                    if(audios[r] != undefined)
                        Chidopi.JS.playOneAudio('succaudio_<{$id}>',audios[r]);
                    
                   
                    if("<{$succAction}>" == "page"){
                         $("#puzzle_jump_<{$id}>").show();
                        //location.href="CInAppAction://MoveTo/p<{$succActionPage}>.html";
                    }
                } 
            },
            moveAct:{
                callback:function(results){
                    var audios = [
                            <{foreach from=$audios item=audio name=audioN}>
                            '<{$res_dir}><{$audio}>',
                            <{/foreach}>];
                    var r =parseInt(Math.random()*audios.length);
               
                    if(audios[r] != undefined)
                        Chidopi.JS.playOneAudio('moveact_<{$id}>',audios[r]);
                    
                    //                    var autios = $("#pazzle_move_audio").find("audio");
                    //                    if(autios.length>0){
                    //                        var r =parseInt(Math.random()*autios.length);
                    //                        if(autios[r].play)
                    //                        autios[r].play();
                    //                    }
                }
            },
            getRewardImg:{
                callback:function(){
                    var r =parseInt(Math.random()*pazzleRewardPics.length);
                    if(pazzleRewardPics[r] != undefined)
                        return "<{$res_dir}>"+pazzleRewardPics[r];
                }
            }
        }; 
        // define your own texts 
        var myTexts = { 
            secondsLabel: 'Sek.' 
        }; 
       
        if(pazzlePics.length>0){
        
            var r =parseInt(Math.random()*pazzlePics.length);
            if(pazzlePics[r] != undefined)
                $("#pazzle_<{$id}>").attr("src","<{$res_dir}>"+pazzlePics[r]);
        }
        // call jqPuzzle with mySettings and myTexts on images with class 'myPics' 
        $("#pazzle_<{$id}>").jqPuzzle(mySettings, myTexts); 
    });


    function puzzle_loca_finish_o(){
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


<div class="chidopi_component3D" style="position: absolute; left:<{$x}>px; top:<{$y}>px; z-index:<{$zIndex}>;" >
    <img id="pazzle_<{$id}>" src="<{$res_dir}><{$picName}>"  style="width:<{$width}>px; height:<{$height}>px;"/>
    <a id="puzzle_jump_<{$id}>" href="#" class="click_ignore_me" onclick="puzzle_loca_finish_o()" style="position:relative; left:20px;top:-50px; z-index:9999;display:none;font-size:24px"><{$jumpText}></a>
</div>
