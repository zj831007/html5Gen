<script src="<?php echo base_url(); ?>js/components/image-cmp.js"></script>
<script>
$(function(){
	Chidopi.Image.init(sys_vars);
});
</script>
<div id="img_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" name="iTitle" id="iTitle"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.image'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="iFileName" name="iFileName" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>              
                <button id="btn_iCancel"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
            <td><select id="iDisplay" name="iDisplay">
                    <option value=""><?php echo lang('label.common.status.display'); ?></option>
                    <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
                </select>
            </td>
        </tr>
        <tbody id="div_img_display">
        <tr>
            <td class="title"><?php echo lang('label.common.button.display'); ?></td>
            <td><select id="iButton" name="iButton"></select></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.hide.mode'); ?></td>
            <td><select id="iHide" name="iHide">
                    <option value=""><?php echo lang('label.common.hide.mode.nothing'); ?></option>
                    <option value="back"><?php echo lang('label.common.hide.mode.other'); ?></option>
                    <option value="button"><?php echo lang('label.common.hide.mode.button'); ?></option>
                    <option value="self"><?php echo lang('label.common.hide.mode.self'); ?></option>
                </select>
            </td>
        </tr>
        </tbody>
        <tr>
            <td class="title"><?php echo lang('label.animation.setting'); ?></td>
            <td>
                <?php echo lang('label.animation.in'); ?>&nbsp;<input id="iLoadAction" name="loadAction" type="checkbox" value="1"/>&nbsp;&nbsp;&nbsp;
                <?php echo lang('label.animation.out'); ?>&nbsp;<input id="iHideAction" name="hideAction" type="checkbox" value="1"/>                
            </td>
        </tr>
        <tr id="tr_img_load_action" style="border-top:1px dashed #CCC">
            <td class="title"><?php echo lang('label.animation.in'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.in'); ?>
                <select id="iLoadPos" name="loadPos">
                    <option value="">---</option>
                    <option value="T"><?php echo lang('label.animaton.top'); ?></option>
                    <option value="B"><?php echo lang('label.animation.bottom'); ?></option>
                    <option value="L"><?php echo lang('label.animation.left'); ?></option>
                    <option value="R"><?php echo lang('label.animation.right'); ?></option>
                    <option value="LT"><?php echo lang('label.animation.lefttop'); ?></option>
                    <option value="RT"><?php echo lang('label.animation.righttop'); ?></option>
                    <option value="LB"><?php echo lang('label.animation.leftbottom'); ?></option>
                    <option value="RB"><?php echo lang('label.animation.rightbottom'); ?></option>
                </select><br/>
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="iLoad2D" name="load2D" type="number" min="-1080" max="1080" step="45" />                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="iLoad3DX" name="load3DX" type="number" min="-1080" max="1080" step="45"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="iLoad3DY" name="load3DY" type="number" min="-1080" max="1080" step="45"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="iLoadSpeedInfo"></span>
                <input type="range" onchange='$("#iLoadSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="iLoadSpeed" name="loadSpeed">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="iLoadOpacityInfo"></span>
                <input type="range" onchange='$("#iLoadOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="iLoadOpacity" name="loadOpacity">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="iLoadDelayInfo"></span>
                <input type="range" onchange='$("#iLoadDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="iLoadDelay" name="loadDelay">
            </td>
        </tr>
        <tr id="tr_img_hide_action" style="border-top:1px dashed #CCC">
            <td class="title"><?php echo lang('label.animation.out'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.out'); ?>
                <select id="iHidePos" name="hidePos">
                    <option value="">---</option>
                    <option value="T"><?php echo lang('label.animaton.top'); ?></option>
                    <option value="B"><?php echo lang('label.animation.bottom'); ?></option>
                    <option value="L"><?php echo lang('label.animation.left'); ?></option>
                    <option value="R"><?php echo lang('label.animation.right'); ?></option>
                    <option value="LT"><?php echo lang('label.animation.lefttop'); ?></option>
                    <option value="RT"><?php echo lang('label.animation.righttop'); ?></option>
                    <option value="LB"><?php echo lang('label.animation.leftbottom'); ?></option>
                    <option value="RB"><?php echo lang('label.animation.rightbottom'); ?></option>
                </select><br/>
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="iHide2D" name="hide2D" type="number" min="-1080" max="1080" step="45" />                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="iHide3DX" name="hide3DX" type="number" min="-1080" max="1080" step="45"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="iHide3DY" name="hide3DY" type="number" min="-1080" max="1080" step="45"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="iHideSpeedInfo"></span>
                <input type="range" onchange='$("#iHideSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="iHideSpeed" name="hideSpeed">
                <br/>
                <?php echo lang('label.animation.alpha'); ?>&nbsp;<span id="iHideOpacityInfo"></span>
                <input type="range" onchange='$("#iHideOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="iHideOpacity" name="hideOpacity">
                <br/>
                <?php echo lang('label.animation.delay'); ?>&nbsp;<span id="iHideDelayInfo"></span>
                <input type="range" onchange='$("#iHideDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="iHideDelay" name="hideDelay">
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="number" id="iPX" name="iPX" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                &nbsp;Y&nbsp;<input type="number" id="iPY" name="iPY" step="1" max="<?php echo $bHeight; ?>" min="0"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="iWidth" name="iWidth" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="iHeight" name="iHeight" step="1" max="<?php echo $bHeight; ?>" min="0"/>
                <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="iAspectRatio" name="aspectRatio" type="checkbox" value="1" checked="checked"/>
                <br/><button id="iRstoreSize" type="button"><?php echo lang('label.common.size.restore'); ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" id="img_id" name="id"/>
    <input type="hidden" id="img_zindex" name="zIndex" />
    <input type="hidden" id="i_origin_width" name="originWidth">
    <input type="hidden" id="i_origin_height" name="originHeight">
</div>