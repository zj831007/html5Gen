<script src="<?php echo base_url(); ?>js/components/link-cmp.js"></script>
<script>
$(function(){   
    Chidopi.Link.init(sys_vars);	
});
</script>
<div id="link_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" name="lTitle" id="lTitle"/></td>
        </tr>
            <td class="title"><?php echo lang('label.common.image'); ?></td>
            <td><input type="text" readonly="readonly" id="lFileName" name="lFileName" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>              
                <button id="btn_lCancel"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <td class="title"><?php echo lang('label.common.image2'); ?></td>
            <td><input type="text" readonly="readonly" id="lFileName2" name="lFileName2" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>              
                <button id="btn_lCancel2"><?php echo lang('label.common.cancel'); ?></button>                            
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.sound'); ?></td>
            <td><input type="text" readonly="readonly" id="lSound" name="lSound" 
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload"/>              
                <button id="btn_lsCancel"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tr> 
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="number" id="lPX" name="lPX" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                &nbsp;Y&nbsp;<input type="number" id="lPY" name="lPY" step="1" max="<?php echo $bHeight; ?>" min="0"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="lWidth" name="lWidth" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="lHeight" name="lHeight" step="1" max="<?php echo $bHeight; ?>" min="0"/>
                <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="lAspectRatio" name="aspectRatio" type="checkbox" value="1" checked="checked"/>
                <br/><button id="lRstoreSize" type="button"><?php echo lang('label.common.size.restore'); ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" id="link_id"/>
    <input type="hidden" name="linkType" id="sel_link_type" value="button"/>
    <input type="hidden" id="link_zindex" name="zIndex" />
    <input type="hidden" id="l_origin_width" name="originWidth">
    <input type="hidden" id="l_origin_height" name="originHeight">
</div>