<script src="<?php echo base_url(); ?>js/components/axismove-cmp.js"></script>
<script>
    $(function(){
        
        
        Chidopi.axismove.init(sys_vars);
        
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
                    
                $("#axismove_succ_finish_sel").html(fragment);
            },
            error: function(jqXHR, textStatus, errorThrown){
                dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
            }
        });
        //生成 options结束
    });
    
    function _axismove_succ_action(obj){
        var selV = $(obj).val();
        if(selV == "page"){
            $("#axismove_succ_finish_lbl").show();
            $("#axismove_succ_finish_sel").show();
        }else{
            $("#axismove_succ_finish_lbl").hide();
            $("#axismove_succ_finish_sel").hide();
        }
    }

</script>

<div id="axismove_dialog" class="cmp_dialog" style="display:none">
    <table style="border:1px solid #CCC;">
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="text" data-bind="value: title" /></td>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td style="border-right:solid 1px #CCC;">&nbsp;X&nbsp;<input type="text" data-bind="value: x" class="short" />
                &nbsp;Y&nbsp;<input type="text" data-bind="value: y" class="short" />
            </td>
            <td class="title"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="text" data-bind="value: width"  class="short" />
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" data-bind="value: height"  class="short" />
            </td>
        </tr>


        <tr  style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.axismove.xrayimg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:xrayimg"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
                
            </td>
            <td class="title"><?php echo lang('label.axismove.overlayimg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:overlayimg"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
                
            </td>
            <td class="title"><?php echo lang('label.axismove.xrayopacity'); ?></td>
            <td >
                <input type="range" data-bind="value: xrayopacity"  step="0.1" min="0" max="1"/>
            </td>
        </tr>   


        <tr style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.axismove.touchAudio'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:touchAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
                
            </td>
            <td class="title"><?php echo lang('label.axismove.btnimg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:btnimg"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
                
            </td>
            <td class="title"><?php echo lang('label.axismove.finish.action'); ?></td>
            <td>
                <select id="axismove_succ_finish_action_sel" onChange="_axismove_succ_action(this)" data-bind="value:succAction" >
                    <option value="0"><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
                <span id="axismove_succ_finish_lbl"><?php echo lang('label.play.ended.pageto'); ?></span> <span id="axismove_succ_finish_sel"><select></select></span>
               <?php echo lang('label.common.jumpText'); ?><input type="text"  data-bind="value:jumpText"  />
            </td>
        </tr>
        <tr style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.axismove.xrayoriention'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <select data-bind="value:xrayoriention" >
                    <option value="x"><?php echo lang('label.axismove.oriention.x'); ?></option>
                    <option value="y"><?php echo lang('label.axismove.oriention.y'); ?></option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <select data-bind="value:btnxposition">
                    <option value="l"><?php echo lang('label.pos.left2'); ?></option>
                    <option value="r"><?php echo lang('label.pos.right2'); ?></option>
                </select>
                <select data-bind="value:btnyposition">
                    <option value="t"><?php echo lang('label.pos.top2'); ?>上</option>
                    <option value="b"><?php echo lang('label.pos.bottom2'); ?>下</option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.axismove.xraysize'); ?></td>
            <td>
                <?php echo lang('label.common.width'); ?>&nbsp;<input type="text" class="short"  data-bind="value:xraywidth"/> 
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" class="short" data-bind="value:xrayheight"/>
            </td>
        </tr>
    </table>

</div>