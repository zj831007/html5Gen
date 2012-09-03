<script src="<{$library_dir}>qa/jquery-hcheckbox.js"></script>
<script src="<{$library_dir}>qa/jquery.qa.js"></script>
<style>
    label.checkbox {padding-left: 24px;cursor:pointer;background: url('<{$library_dir}>qa/checkbox.png') no-repeat left -21px; line-height:22px; height:21px; display:inline-block; } 
    label.checked {background-position:left 100%; } 
    label.disabled{background-position:left 0px;}
    .hRadio{padding-left: 22px; display: inline-block;background: transparent url(<{$library_dir}>qa/radio.png) no-repeat left top;height: 19px; line-height:20px; cursor:pointer;vertical-align:middle;}

    .hRadio_Checked { background-position: left bottom;}
    .pazzle_contain{-webkit-background-size: 100% 100%;  -o-background-size: 100% 100%;  background-size: 100% 100%;}
    .qa_topic_contain{-moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;border:1px solid ddd;-webkit-box-shadow:0 0 10px black;-moz-box-shadow:0 0 10px black;padding:10px;}
    .qa_topic_contain ul{list-style:inside none ; }
    .qa_topic_contain p, ul{ margin:0px 0px;padding:0px;}
    .qa_topic_contain li{margin:10px auto 10px auto;}
</style>
<script>

    $(function(){
        $("#qa_container_topic_<{$id}>").jqQa({
            blackimg:"<{$library_dir}>qa/black.png",
            imgContiner:"#qa_container_img_<{$id}>",
            topictpl:"#qa_template_<{$id}>",
            topicResultTpl:"#qa_result_template_<{$id}>",
            topicContiner:"#qa_container_topic_<{$id}>",
            topicForm:"#qa_continer_topic_form_<{$id}>",
            resultForm:"#qa_result_<{$id}>",
            baseUrl:"<{$res_dir}>",
            flipPage:<{$flipPage}>, //0 無效果,  1淡入淡出 ,  2 滑動效果
            scoreType:<{$scoreType}>, // 0 100分為滿分  1 對錯題數  2 兩者兼具
            rightEvent:<{$rightEvent}>, // 0 留在原处  1 跳下一页
            rightAudio:"<{$rightAudio}>",
            rightPic:"<{$rightPic}>",
            errorAudio:"<{$errorAudio}>",
            errorPic:"<{$errorPic}>",
            finishAudio:"<{$finishAudio}>",
            
            audioId:"audio<{$id}>",
            currTopic:0, //当前每几题
            topics:<{$topics}>  //题目列表
        });
        
        
        $("#qa_container_submit<{$id}>").bind("click",function(){
            $("#qa_container_topic_<{$id}>").jqQa("submit");
        });
        $("#qa_container_<{$id}>").delegate("div","click",function(e){
            if (event.stopPropagation){
                event.stopPropagation();
            }else{
                event.cancelBubble = true;
            }
        });
    });
        
    function qa_re_test(obj){
        $("#qa_container_topic_<{$id}>").jqQa("reset");   
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

<script id="qa_result_template_<{$id}>" type="text/x-jsrender">
    <table width="<{$width}>" style="font-size:20px;">
        <tr height="2em"><td colspan="2"></td></tr>
        <tr height="2em"><td colspan="2"  align="center"><h1>RESULT</h1></td></tr>
        {{if scoreType == "0"}}
        <tr height="2em"><td width="50%" align="right">Score:</td><td><span>{{>score}}</span></td></tr>
        {{/if}}
        {{if scoreType == "1"}}
        <tr height="2em"><td width="50%" align="right">Right:</td><td><span>{{>rightCount}}</span></td></tr>
        <tr height="2em"><td width="50%" align="right">Wrong:</td><td><span>{{>errCount}}</span></td></tr>
        {{/if}}
        {{if scoreType == "2"}}
        <tr height="2em"><td width="50%" align="right">Score:</td><td><span>{{>score}}</span></td></tr>
        <tr height="2em"><td width="50%" align="right">Right:</td><td><span>{{>rightCount}}</span></td></tr>
        <tr height="2em"><td width="50%" align="right">Wrong:</td><td><span>{{>errCount}}</span></td></tr>
        {{/if}}

        <tr height="2em"><td colspan="2"  align="center"><a onclick="qa_re_test(this)" href="javascript:;">Retest</a></td></tr>
        <tr height="4em"><td colspan="2"  align="center"><a id="qa_succ_location_<{$id}>"  class="click_ignore_me" onclick="qa_loca_finish_o()" href="javascript:;"><{$jumpText}></a></td></tr>
    </table>
</script>

<script id="qa_template_<{$id}>" type="text/x-jsrender">
    <p style='font-size:{{>fSize}};font-family:{{>font}};color:{{>color}};border-bottom:solid 1px #CCC; padding-bottom:5px; margin:5px 0px;
       {{if imgP == "2" && pic != null}} background-image:url("<{$res_dir}>{{>pic}}"); background-size:100% 100%;{{/if}}'>
        {{if imgP == "0" && pic != null}}
        <img src="<{$res_dir}>{{>pic}}" style="width:{{>imgW}}px;height:{{>imgH}}px"/>
        {{/if}}
        <span style="margin-left:5px;">{{>text}}</span>
        {{if imgP == "1" && pic != null}}
        <img src="<{$res_dir}>{{>pic}}" style="width:{{>imgW}}px;height:{{>imgH}}px"/>
        {{/if}}
    </p>

    <ul>
        {{for options}}
        <li style='font-size:{{>fSize}};font-family:{{>font}};color:{{>color}};{{if imgP == "2" && pic != null}} background-image:url("<{$res_dir}>{{>pic}}"); background-size:100% 100%;{{/if}}'>
            <input name="qa_option" data-right="{{>right}}" type="{{if #parent.parent.data.type == '0'}}radio{{else}}checkbox{{/if}}" />
            <label>
                {{if imgP == "0" && pic != null}}
                <img src="<{$res_dir}>{{>pic}}" style="width:{{>imgW}}px;height:{{>imgH}}px"/>
                {{/if}}
                {{>text}}
            </label>
            {{if imgP == "1" && pic != null}}
            <img src="<{$res_dir}>{{>pic}}" style="width:{{>imgW}}px;height:{{>imgH}}px"/>
            {{/if}}                                                         
        </li>
        {{/for}}
    </ul>
</script>

<div id="qa_container_<{$id}>" class="chidopi_component3D qa_topic_contain" style="z-index:<{$zIndex}>;left:<{$x}>px; top:<{$y}>px;width:<{$width}>px;height:<{$height}>px;background-color:<{$bgColor}>; <{if $bgPic!= null}>background-image:url("<{$res_dir}><{$bgPic}>"); <{/if}>
     background-size:100% 100%; background-repeat:no-repeat;display:inline-block; position: absolute; 
     ">
     <div id="qa_continer_topic_form_<{$id}>">
        <div id="qa_container_topic_<{$id}>"></div>
        <center><button id="qa_container_submit<{$id}>" style="width:100px; height:30px;margin-top:5px;font-size:<{$topic.fSize}>; background-image:url(<{$res_dir}><{$confirmPic}>); background-size:100% 100%;"></button></center>
    </div>
     <div id="qa_container_img_<{$id}>" style=" position: absolute; top:10px;left:10px;width:<{$width}>px;height:<{$height}>px;display:none;z-index:999; text-algin:center">
         <img src="<{$library_dir}>qa/black.png"  />
    </div>
    
    <div id="qa_result_<{$id}>" style="display:none">
        Result
    </div>
</div>

