<script src="<?php echo base_url(); ?>js/components/action-cmp.js"></script>
<script>
$(function(){
    Chidopi.Action.init(sys_vars);
});
</script>
<div id="action_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" name="actTitle" id="actTitle"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.action.type'); ?></td>
            <td><select id="sel_action_type" name="actionType" style="width:100px;">
                   <option value="url"><?php echo lang('label.action.type.url'); ?></option>
                   <option value="page"><?php echo lang('label.action.type.page'); ?></option>
                   <option value="area"><?php echo lang('label.action.type.area'); ?></option>
                   <option value="prev"><?php echo lang('label.action.type.prev'); ?></option>
                   <option value="next"><?php echo lang('label.action.type.next'); ?></option>                  
                   <option value="speedpaging"><?php echo lang('label.action.type.speedpaging'); ?></option>
                   <option value="addBookmark"><?php echo lang('label.action.type.addbookmark'); ?></option>
                   <option value="bookmark"><?php echo lang('label.action.type.bookmark'); ?></option>
                   <option value="share"><?php echo lang('label.action.type.share'); ?></option>
                   <option value="search"><?php echo lang('label.action.type.search'); ?></option>
                   <option value="record"><?php echo lang('label.action.type.record'); ?></option>
                   <option value="coloring"><?php echo lang('label.action.type.coloring'); ?></option>
                   <option value="print"><?php echo lang('label.action.type.print'); ?></option>
                   <option value="mapaddress"><?php echo lang('label.action.type.map.address'); ?></option>
                   <option value="mapgcs"><?php echo lang('label.action.type.map.gcs'); ?></option>                   
                </select>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.sound'); ?></td>
            <td><input type="text" readonly="readonly" id="actSound" name="actSound" 
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload"/>              
                <button id="btn_sCancel"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tbody id="action_edit_area1">
        <tr>
            <td class="title"><?php echo lang('label.common.image'); ?></td>
            <td><input type="text" readonly="readonly" id="actFileName" name="actFileName" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>              
                <button id="btn_actCancel"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        </tbody>
        <tr id="action_edit_url" class="sub_action">
            <td class="title"><?php echo lang('label.action.type.url'); ?></td>
            <td><input type="text" id="actUrl" name="url"/></td>
        </tr>
        <tr id="action_edit_page" class="sub_action">
            <td class="title"><?php echo lang('label.action.type.page'); ?></td>
            <td>
                <select id="actPage" name="page">
                </select>
            </td>
        </tr>
        <tr id="action_edit_jump" class="sub_action">
            <td class="title">跳頁</td>
            <td>
                <select id="actJump" name="jump">
                </select>
            </td>
        </tr>
        <tr id="action_edit_coloring" class="sub_action">
            <td class="title"><?php echo lang('label.action.type.coloring'); ?></td>
            <td>
                <select id="actColoring" name="coloring">
                    <option value="0"><?php echo lang('label.action.coloring.normal'); ?></option>
                    <option value="1"><?php echo lang('label.action.coloring.children'); ?></option>
                </select>
            </td>
        </tr>
        <tr id="action_edit_mapaddress" class="sub_action">
            <td class="title"><?php echo lang('label.action.type.map.address'); ?></td>
            <td>
                <?php echo lang('label.action.type.map.title'); ?>&nbsp;&nbsp; <input type="text" name="map_title" size="30" maxlength="50"/><br/>
                <?php echo lang('label.action.type.map.addr'); ?>&nbsp;&nbsp; <input type="text" name="map_address" size="30" maxlength="50"/>
            </td>
        </tr>
        <tr id="action_edit_mapgcs" class="sub_action">
            <td class="title"><?php echo lang('label.action.type.map.gcs'); ?></td>
                <td>
                    <?php echo lang('label.action.type.map.title'); ?>&nbsp;&nbsp; <input type="text" name="map_title2" size="30" maxlength="50"/><br/>
                    <?php echo lang('label.action.type.map.latitude'); ?>&nbsp;&nbsp; <input type="text" name="map_latitude" size="10" maxlength="10"/>
                    &nbsp;<?php echo lang('label.action.type.map.longitude'); ?>&nbsp;&nbsp; <input type="text" name="map_longitude" size="10" maxlength="10"/>
                </td>
            </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="number" id="actPX" name="actPX" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                &nbsp;Y&nbsp;<input type="number" id="actPY" name="actPY" step="1" max="<?php echo $bHeight; ?>" min="0"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="actWidth" name="actWidth" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="actHeight" name="actHeight" step="1" max="<?php echo $bHeight; ?>" min="0"/>
             <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="actAspectRatio" name="aspectRatio" type="checkbox" value="1" checked="checked"/>
             <br/><button id="actRstoreSize" type="button"><?php echo lang('label.common.size.restore'); ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" id="action_id"/>
    <input type="hidden" id="act_zindex" name="zIndex" />
    <input type="hidden" id="act_origin_width" name="originWidth">
    <input type="hidden" id="act_origin_height" name="originHeight">
</div>