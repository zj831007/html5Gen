<script src="<?php echo base_url(); ?>js/components/spotlight-cmp.js"></script>
<script>
    $(function(){
        
        
        Chidopi.spotlight.init(sys_vars);
        
        //加载页面id并生成select option
        $.ajax({
            url:'<?php echo base_url(); ?>motionbox/loadpageInfo',
            data:{ 
                bookid: '<?php echo $bookid; ?>', 
                pageid: '<?php echo $pageid; ?>'
            },
            type: "POST",
            dataType: 'json',
            success: function (data, textStatus, jqXHR){
                var fragment = $("<select/>");
                for (var i in data){
                    fragment.append('<option value="' + data[i].id +'">' + data[i].title + '</option>');
                }
                    
                $("#spotlight_succ_finish_sel").html(fragment);
            },
            error: function(jqXHR, textStatus, errorThrown){
                dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
            }
        });
        //生成 options结束
    });
    
    function _spotlight_succ_action(obj){
        var selV = $(obj).val();
        if(selV == "page"){
            $("#spotlight_succ_finish_lbl").show();
            $("#spotlight_succ_finish_sel").show();
        }else{
            $("#spotlight_succ_finish_lbl").hide();
            $("#spotlight_succ_finish_sel").hide();
        }
    }
    function _spotlight_shape_sel(obj){
         var selV = $(obj).val();
        if(selV == "cycle"){
            $("#spotlight_cyle").show();
            $("#spotlight_squir").hide();
        }else{
            $("#spotlight_cyle").hide();
            $("#spotlight_squir").show();
        }
    }
</script>

<div id="spotlight_dialog" class="cmp_dialog" style="display:none">
    <table style="border:1px solid #CCC;">
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="text" data-bind="value: title" /></td>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td style="border-right:solid 1px #CCC;">&nbsp;X&nbsp;<input type="text" data-bind="value: x" class="short" />
                &nbsp;Y&nbsp; <input type="text" data-bind="value: y" class="short" readonly="readonly"/>
            </td>
            <td class="title"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="text" data-bind="value: width"  class="short" />
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" data-bind="value: height"  class="short" />
            </td>
        </tr>


        <tr  style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.spotlight.img'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                 <input type="text" readonly="readonly" data-bind="value:img"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
            <td class="title"><?php echo lang('label.spotlight.maskcolor'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="color" onclick="_qa_color_sel(this)"  style="width:45px;" data-bind="value: maskcolor"/>
            </td>
            <td class="title"><?php echo lang('label.spotlight.spotShape'); ?></td>
            <td >
                <select data-bind="value: spotShape" onChange="_spotlight_shape_sel(this)">
                    <option value="cycle"><?php echo lang('label.spotlight.cycle'); ?></option>
                    <option value="squire"><?php echo lang('label.spotlight.squire'); ?></option>
                </select>
            </td>
        </tr>   

        <tr>
            <td class="title"><?php echo lang('label.spotlight.imgEffect'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <select data-bind="value: imgEffect">
                    <option value="none"><?php echo lang('label.spotlight.effect.none'); ?></option>
                    <option value="invert"><?php echo lang('label.spotlight.invert'); ?></option>
                    <option value="gray"><?php echo lang('label.spotlight.gray'); ?></option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.spotlight.maskopacity'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="number" data-bind="value: maskopacity" class="short" step="0.1" min="0" max="1"/>[0-1]
            </td>

            <td class="title"><?php echo lang('label.spotlight.spotSize'); ?></td>
            <td>
                <span id="spotlight_cyle">
                    <?php echo lang('label.spotlight.spotRadius'); ?><input type="number" class="short" data-bind="value: spotRadius"/>px 
                </span>
                <span id="spotlight_squir">
                    <?php echo lang('label.common.width'); ?>&nbsp;<input type="number" class="short" data-bind="value: spotWidth"/>px 
                    <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" class="short" data-bind="value: spotHeight"/>px 
                </span>
            </td>

        </tr>
        <tr style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.spotlight.color'); ?></td>
            <td style="border-right:solid 1px #CCC;">
               <select data-bind="value: color">
                    <option value="w"><?php echo lang('label.color.write'); ?></option>
                    <option value="r"><?php echo lang('label.color.red'); ?></option>
                    <option value="g"><?php echo lang('label.color.green'); ?></option>
                    <option value="b"><?php echo lang('label.color.blue'); ?></option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.spotlight.touchAction'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <select data-bind="value: touchAction">
                    <option value="none"><?php echo lang('label.spotlight.effect.none'); ?></option>
                    <option value="eseinout"><?php echo lang('label.spotlight.action.eseinout'); ?></option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.spotlight.succAction'); ?></td>
            <td>
                <select id="spotlight_succ_finish_action_sel" onChange="_spotlight_succ_action(this)" data-bind="value:succAction" >
                    <option value="0"><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
                <span id="spotlight_succ_finish_lbl"><?php echo lang('label.play.ended.pageto'); ?></span> <span id="spotlight_succ_finish_sel"><select></select></span>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.spotlight.weight'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="range" data-bind="value: weight" min="0" max="255"/><span data-bind="text: weight"></span>
            </td>
            <td class="title"><?php echo lang('label.spotlight.touchAudio'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:touchAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
            <td class="title"><?php echo lang('label.common.jumpText'); ?></td>
            <td>
                <input type="text"  data-bind="value:jumpText"  />
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.spotlight.opacity'); ?></td>
            <td style="border-right:solid 1px #CCC;">
               <input type="range"  data-bind="value: opacity" min="0" max="255"/><span data-bind="text: opacity"></span>
            </td>
            <td class="title"> </td>
            <td style="border-right:solid 1px #CCC;">
            </td>
            <td class="title"></td>
            <td>
            </td>
        </tr>
    </table>

</div>