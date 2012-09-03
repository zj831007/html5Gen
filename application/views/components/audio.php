<script src="<?php echo base_url(); ?>js/components/audio-cmp.js"></script>
<script>
$(function(){
	Chidopi.Audio.init(sys_vars);	
});
</script>
<div id="audio_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" name="aTitle" id="aTitle"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.sound'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="aFileName" name="aFileName" 
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload"/>              
                <button id="btn_aCancel"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.button.play'); ?></td>
            <td><select id="aButton" name="aButton"></select></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.button.mode'); ?></td>
            <td><select id="aButtonMode" name="buttonMode">
                    <option value="multiple"><?php echo lang('label.button.mode.multiple'); ?></option>
                    <option value="pause"><?php echo lang('label.button.mode.pause'); ?></option>
            </select></td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.play.mode'); ?></td>
            <td>
                <select id="aPlay" name="aPlay">
                    <option value=""><?php echo lang('label.play.mode.single'); ?></option>
                    <option value="loop"><?php echo lang('label.play.mode.loop'); ?></option>
                </select>
                <br/><?php echo lang('label.common.autoplay.once'); ?><input type="checkbox" value="1" id="aPlayOnLoad" name="playOnLoad"/>
            </td>
        </tr>
        <tr id="audio_area2">
            <td class="title"><?php echo lang('label.common.play.ended'); ?></td>
            <td>
                <select id="aEndAction" name="aEndAction">
                    <option value=""><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
            </td>
        </tr>
        <tr id="audio_area1">
            <td class="title"><?php echo lang('label.play.ended.pageto'); ?></td>
            <td>
                <select id="aPage" name="aPage"></select>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" id="audio_id"/>
</div>