<script src="<?php echo base_url(); ?>js/components/note-cmp.js"></script>
<script>
$(function(){
    Chidopi.Note.init(sys_vars);	
});
</script>
<div id="note_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" id="nTitle" name="nTitle"  size="20"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.note.maxlength'); ?></td>
            <td><input type="text" size="5" id="nMaxlengh" name="nMaxlength"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.font'); ?></td>
            <td><select id="nFont" name="nFont">
                    <option value="Arial">Arial</option>
                    <option value="'Comic Sans MS'">Comic Sans MS</option>
                    <option value="'Courier New'">Courier New</option>
                    <option value="Georgia">Georgia</option>
                    <option value="'Lucida Sans Unicode'">Lucida Sans Unicode</option>
                    <option value="Tahoma">Tahoma</option>
                    <option value="'Times New Roman'">Times New Roman</option>
                    <option value="'Trebuchet MS'">Trebuchet MS</option>
                    <option value="Verdana">Verdana</option>
                </select> 
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.font.size'); ?></td>
            <td><select id="nFontSize" name="nFontSize">
                    <option value="medium"><?php echo lang('label.common.normal'); ?></option>
                    <option value="small"><?php echo lang('label.common.small'); ?></option>
                    <option value="large"><?php echo lang('label.common.large'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
             <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
             <td><select id="nDisplay" name="nDisplay">
                    <option value=""><?php echo lang('label.common.status.display'); ?></option>
                    <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
                 </select>
            </td>
        </tr>
        <tr id="note_area1">
            <td class="title"><?php echo lang('label.common.button.display'); ?></td>
            <td><select id="nButton" name="nButton"></select></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.animation.setting'); ?></td>
            <td>
                <?php echo lang('label.animation.in'); ?>&nbsp;<input id="nLoadAction" name="loadAction" type="checkbox" value="1"/>&nbsp;&nbsp;&nbsp;
                <?php echo lang('label.animation.out'); ?>&nbsp;<input id="nHideAction" name="hideAction" type="checkbox" value="1"/>                
            </td>
        </tr>
        <tr id="tr_note_load_action" style="border-top:1px dashed #CCC">
            <td class="title"><?php echo lang('label.animation.in'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.in'); ?>
                <select id="nLoadPos" name="loadPos">
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
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="nLoad2D" name="load2D" type="number" min="-1080" max="1080" step="45" />                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="nLoad3DX" name="load3DX" type="number" min="-1080" max="1080" step="45"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="nLoad3DY" name="load3DY" type="number" min="-1080" max="1080" step="45"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="nLoadSpeedInfo"></span>
                <input type="range" onchange='$("#nLoadSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="nLoadSpeed" name="loadSpeed">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="nLoadOpacityInfo"></span>
                <input type="range" onchange='$("#nLoadOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="nLoadOpacity" name="loadOpacity">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="nLoadDelayInfo"></span>
                <input type="range" onchange='$("#nLoadDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="nLoadDelay" name="loadDelay">
            </td>
        </tr>
        <tr id="tr_note_hide_action" style="border-top:1px dashed #CCC">
            <td class="title"><?php echo lang('label.animation.out'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.out'); ?>
                <select id="nHidePos" name="hidePos">
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
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="nHide2D" name="hide2D" type="number" min="-1080" max="1080" step="45" />                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="nHide3DX" name="hide3DX" type="number" min="-1080" max="1080" step="45"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="nHide3DY" name="hide3DY" type="number" min="-1080" max="1080" step="45"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="nHideSpeedInfo"></span>
                <input type="range" onchange='$("#nHideSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="nHideSpeed" name="hideSpeed">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="nHideOpacityInfo"></span>
                <input type="range" onchange='$("#nHideOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="nHideOpacity" name="hideOpacity">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="nHideDelayInfo"></span>

                <input type="range" onchange='$("#nHideDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="nHideDelay" name="hideDelay">
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="number" id="nPX" name="nPX" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                &nbsp;Y&nbsp;<input type="number" id="nPY" name="nPY" step="1" max="<?php echo $bHeight; ?>" min="0"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="nWidth" name="nWidth" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="nHeight" name="nHeight" step="1" max="<?php echo $bHeight; ?>" min="0"/>
                <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="nAspectRatio" name="aspectRatio" type="checkbox" value="1" checked="checked"/>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" id="note_id"/>
    <input type="hidden" id="note_zindex" name="zIndex" />
</div>