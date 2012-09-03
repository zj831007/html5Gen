<script src="<{$library_dir}>qa/jquery-hcheckbox.js"></script>
<style>
    label.checkbox {
        padding-left: 24px; 
        cursor:pointer;
        background: url(<{$library_dir}>qa/checkbox.png) no-repeat left -21px; 
    line-height:22px; 
    height:21px; 
    display:inline-block; 
    } 
    label.checked {background-position:left 100%;  } 
    label.disabled{background-position:left 0px;}
    .hRadio{
        padding-left: 22px; display: inline-block;
        background: transparent url(<{$library_dir}>qa/radio.png) no-repeat left top;
    height: 19px; line-height:20px;
    cursor:pointer;vertical-align:middle;
    }

    .hRadio_Checked { background-position: left bottom;}
    .pazzle_contain{
        -webkit-background-size: 100% 100%; 
        -o-background-size: 100% 100%; 
        background-size: 100% 100%;
    }
    .qa_topic_contain{
        -moz-border-radius:10px;
        -webkit-border-radius:10px;
        border-radius:10px;
        border:1px solid ddd;
        -webkit-box-shadow:0 0 10px black;
        -moz-box-shadow:0 0 10px black;
        padding:10px;
    }
    .qa_topic_contain ul{
        list-style:inside none ;
    }
    .qa_topic_contain p, ul{
        margin:0px 0px;
        padding:0px;
    }
    .qa_topic_contain li{
        margin:10px auto 10px auto;
    }
</style>
<script>

    $(function(){
        if($.localStorage.loadData("<{$id}>_r")){
                <{$id}>_r = $.localStorage.loadData("<{$id}>_r");
        }
        if($.localStorage.loadData("<{$id}>_r")){
                <{$id}>_w = $.localStorage.loadData("<{$id}>_w");
        }
        if((<{$id}>_r+<{$id}>_w) != 0){
            var r = <{$id}>_r;
            var w = <{$id}>_w;
            var t = r+w;
            $("#<{$id}>_score").html(parseInt(r/t*100));
            $("#<{$id}>_right").html(r);
            $("#<{$id}>_wrong").html(w);
            
            var total = $(".qa_topic_contain").length-1;
            $($(".qa_topic_contain")[total]).show();
            $($(".qa_topic_contain")[0]).hide();
        }
        
        $("#qa_container_<{$id}> .qa_topic_contain").each(function(index){
            if($(this).find(":radio").length>0){
                $(this).hradio();
            }
            if($(this).find(":checkbox").length>0){
                $(this).hcheckbox();
            }
        });
        
        $("#qa_container_<{$id}>").bind("click", function(e){
            if (e.stopPropagation){
                e.stopPropagation();
            }
            else{
                e.cancelBubble = true;
            }
        });
    });
    
    var <{$id}>_r = 0; //正确题数
    var <{$id}>_w = 0; //错误题数
    
    function qa_topic_submit(obj){
        var topicDiv = ($(obj).parent().parent().parent());
        var flag = 1;
        inputs = topicDiv.find("input:checked");
        if(inputs.length>0){
            for(var i=0; i<inputs.length; i++){
                input = inputs[i];
                if($(input).attr("rt") == 0){
                    flag = 0;
                    break;
                }
            }
            
            if(flag == 1){
                    <{$id}>_r++;
                Chidopi.JS.playOneAudio('rightaudio_<{$id}>','<{$res_dir}><{$rightAudio}>');
                
                if($("#<{$id}>_r_pic").length>0){
                    var r_pic_w = $($("#<{$id}>_r_pic")[0]).width();
                    var r_pic_h = $($("#<{$id}>_r_pic")[0]).height();
                    var real_l = <{$x}>+<{$width}>/2-r_pic_w/2;
                    var real_t = <{$y}>+<{$height}>/2-r_pic_h/2;
                    $($("#<{$id}>_r_pic")[0]).css("left",real_l);
                    $($("#<{$id}>_r_pic")[0]).css("top",real_t);
                    $($("#<{$id}>_r_pic")[0]).fadeIn("slow");
                    $($("#<{$id}>_r_pic")[0]).fadeOut("slow");
                }
                
            }else{
                    <{$id}>_w++;
                Chidopi.JS.playOneAudio('erroraudio_<{$id}>','<{$res_dir}><{$errorAudio}>');
                
                if($("#<{$id}>_w_pic").length>0){
                    var r_pic_w = $($("#<{$id}>_w_pic")[0]).width();
                    var r_pic_h = $($("#<{$id}>_w_pic")[0]).height();
                    var real_l = <{$x}>+<{$width}>/2-r_pic_w/2;
                    var real_t = <{$y}>+<{$height}>/2-r_pic_h/2;
                    $($("#<{$id}>_w_pic")[0]).css("left",real_l);
                    $($("#<{$id}>_w_pic")[0]).css("top",real_t);
                    $($("#<{$id}>_w_pic")[0]).fadeIn("slow");
                    $($("#<{$id}>_w_pic")[0]).fadeOut("slow");
                }
            }
        }else{
            alert("请选择一选项！");
            return;
        }
        var r = <{$id}>_r;
        var w = <{$id}>_w;
        var t = r+w;
        var total = $(".qa_topic_contain").length-1;
        if(t == total){
            Chidopi.JS.playOneAudio('finishaudio_<{$id}>','<{$res_dir}><{$finishAudio}>');
            
            //完成操作
            $.localStorage.saveData("<{$id}>_r",r);
            $.localStorage.saveData("<{$id}>_w",w);
            
            $("#qa_succ_location_<{$id}>").show();
        }
        
        $("#<{$id}>_score").html(parseInt(r/t*100));
        $("#<{$id}>_right").html(r);
        $("#<{$id}>_wrong").html(w);
        
        if(<{$flipPage}> == 0){
            topicDiv.hide();
            topicDiv.next().show();
        }
        if(<{$flipPage}> == 1){
            topicDiv.fadeOut("slow");
            topicDiv.next().fadeIn("slow");
        }
        if(<{$flipPage}> == 2){
            topicDiv.slideUp("slow");
            topicDiv.next().slideDown("slow");
        }
    }
    
    function qa_re_test(obj){
            <{$id}>_r = 0;
            <{$id}>_w = 0;
        var resDiv = ($(obj).parent().parent().parent().parent().parent());
        resDiv.hide();
        $($(".qa_topic_contain")[0]).show();
        $("#qa_succ_location_<{$id}>").hide();
    }
    
    function qa_loca_finish_o(){
        if (event.stopPropagation){
            event.stopPropagation();
        }else{
            event.cancelBubble = true;
        }
        if("<{$finishAction}>" == "page"){
            location.href="CInAppAction://MoveTo/p<{$jumpPage}>.html";
        }
    }
    
</script>



<div id="qa_container_<{$id}>" class="chidopi_component3D" style=" position:absolute; z-index:<{$zIndex}>;">

    <{foreach from=$topics item=topic name=topicN}>
    <div class="qa_topic_contain" style="background-color:<{$bgColor}>; <{if $bgPic!= null}>background-image:url(<{$res_dir}><{$bgPic}>); <{/if}>
         background-size:100% 100%; background-repeat:no-repeat;display:inline-block; position: absolute; 
         left:<{$x}>px; top:<{$y}>px; z-index:2;width:<{$width}>px;height:<{$height}>px;
         display:<{if $smarty.foreach.topicN.first}>block<{else}>none<{/if}>;
         ">
        <form onsubmit="return false;">

            <{if $topic.pic != null && $topic.imgP == "0"}>
            <p style="font-size:<{$topic.fSize}>;font-family:<{$topic.font}>;color:<{$topic.color}>;border-bottom:solid 1px #CCC; padding-bottom:5px"><img src="<{$res_dir}><{$topic.pic}>" style="width:<{$topic.imgW}>px;height:<{$topic.imgH}>px"/><{$topic.text}></p>
            <{elseif $topic.pic != null && $topic.imgP == "1"}>
            <p style="font-size:<{$topic.fSize}>;font-family:<{$topic.font}>;color:<{$topic.color}>;border-bottom:solid 1px #CCC; padding-bottom:5px"><{$topic.text}><img src="<{$res_dir}><{$topic.pic}>" style="width:<{$topic.imgW}>px;height:<{$topic.imgH}>px"/></p>
            <{elseif $topic.pic != null && $topic.imgP == "2"}>
            <p style="font-size:<{$topic.fSize}>;font-family:<{$topic.font}>;color:<{$topic.color}>;background-img:url(<{$res_dir}><{$topic.pic}>); background-size:100% 100%;border-bottom:solid 1px #CCC; padding-bottom:5px"><{$topic.text}></p>
            <{else}>
            <p style="font-size:<{$topic.fSize}>;font-family:<{$topic.font}>;color:<{$topic.color}>;border-bottom:solid 1px #CCC; padding-bottom:5px"><{$topic.text}></p>
            <{/if}>
            <ul>

                <{foreach from=$topic.options item=option name=optionN}> 

                <{if $option.pic != null && $option.imgP == "0"}>
                <li style="font-size:<{$option.fSize}>;font-family:<{$option.font}>;color:<{$option.color}>;">
                    <input name="qa_option" rt="<{$option.right}>" type="<{if $topic.type == '0'}>radio<{else}>checkbox<{/if}>" /><label>
                        <img src="<{$res_dir}><{$option.pic}>" style="width:<{$option.imgW}>px;height:<{$option.imgH}>px"/><{$option.text}></label>
                </li>
                <{elseif $option.pic != null && $option.imgP == "1"}>
                <li style="font-size:<{$option.fSize}>;font-family:<{$option.font}>;color:<{$option.color}>;">
                    <input name="qa_option" rt="<{$option.right}>" type="<{if $topic.type == '0'}>radio<{else}>checkbox<{/if}>" />
                    <label><{$option.text}></label><img src="<{$res_dir}><{$option.pic}>" style="width:<{$option.imgW}>px;height:<{$option.imgH}>px"/>
                </li>
                <{elseif $option.pic != null && $option.imgP == "2"}>
                <li style="font-size:<{$option.fSize}>;font-family:<{$option.font}>;color:<{$option.color}>; background-image:url(<{$res_dir}><{$option.pic}>); background-size:100% 100%;">
                    <input name="qa_option" rt="<{$option.right}>" type="<{if $topic.type == '0'}>radio<{else}>checkbox<{/if}>" /><label><{$option.text}></label>
                </li>
                <{else}>
                <li style="font-size:<{$option.fSize}>;font-family:<{$option.font}>;color:<{$option.color}>; ">
                    <input name="qa_option" rt="<{$option.right}>" type="<{if $topic.type == '0'}>radio<{else}>checkbox<{/if}>" /><label><{$option.text}></label>
                </li>
                <{/if}>

                <{/foreach}>
            </ul>
            <center><button style="width:100px; height:30px;font-size:<{$topic.fSize}>; background-image:url(<{$res_dir}><{$confirmPic}>); background-size:100% 100%;" onclick="qa_topic_submit(this)"></button></center>
        </form>
    </div>
    <{/foreach}>   


    <div class="qa_topic_contain" style="background-color:<{$bgColor}>; <{if $bgPic!= null}>background-image:url(<{$res_dir}><{$bgPic}>); <{/if}>
         background-size:100% 100%; background-repeat:no-repeat;display:inline-block; position: absolute; 
         left:<{$x}>px; top:<{$y}>px; z-index:2;width:<{$width}>px;height:<{$height}>px;
         display:none;
         ">
        <table width="<{$width}>" style="font-size:20px;">
            <tr height="2em"><td colspan="2"></td></tr>
            <tr height="2em"><td colspan="2"  align="center"><h1>RESULT</h1></td></tr>
            <{if $scoreType == 0}>
            <tr height="2em"><td width="50%" align="right">Score:</td><td><span id="<{$id}>_score"></span></td></tr>
            <{/if}>
            <{if $scoreType == 1}>
            <tr height="2em"><td width="50%" align="right">Right:</td><td><span id="<{$id}>_right"></span></td></tr>
            <tr height="2em"><td width="50%" align="right">Wrong:</td><td><span id="<{$id}>_wrong"></span></td></tr>
            <{/if}>
            <{if $scoreType == 2}>
            <tr height="2em"><td width="50%" align="right">Score:</td><td><span id="<{$id}>_score"></span></td></tr>
            <tr height="2em"><td width="50%" align="right">Right:</td><td><span id="<{$id}>_right"></span></td></tr>
            <tr height="2em"><td width="50%" align="right">Wrong:</td><td><span id="<{$id}>_wrong"></span></td></tr>
            <{/if}>

            <tr height="2em"><td colspan="2"  align="center"><a onclick="qa_re_test(this)" href="javascript:;">Retest</a></td></tr>
            <tr height="4em"><td colspan="2"  align="center"><a id="qa_succ_location_<{$id}>"  class="click_ignore_me" onclick="qa_loca_finish_o()" href="javascript:;"><{$jumpText}></a></td></tr>
        </table>
    </div>
</div>

<{if $rightPic != null}>
<img id="<{$id}>_r_pic" src="<{$res_dir}><{$rightPic}>" style="position:absolute; top:0px; left:0px"/>
<{/if}>
<{if $errorPic != null}>
<img id="<{$id}>_w_pic" src="<{$res_dir}><{$errorPic}>" style="position:absolute; top:0px; left:0px"/>
<{/if}>