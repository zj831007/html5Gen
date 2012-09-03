<div id="text2_dialog" class="cmp_dialog" style="display:none">
<table>
    <tr>
        <td class="title"><?php echo lang('label.common.title'); ?></td>
        <td><input type="text" data-bind="value: title"/></td>
    </tr>
    <tr>
        <td class="title"><?php echo lang('label.common.position'); ?></td>
        <td>&nbsp;X&nbsp;<input type="number" step="1" max="<?php echo $bWidth; ?>" min="0" data-bind="value: x"/>
            &nbsp;Y&nbsp;<input type="number" step="1" max="<?php echo $bHeight; ?>" min="0" data-bind="value: y"/>
        </td>
        <td class="title"><?php echo lang('label.spotlight.spotSize'); ?></td>
        <td><?php echo lang('label.common.width'); ?>&nbsp;
            <input type="number" step="1" max="<?php echo $bWidth; ?>" min="0" data-bind="value: width"/>
            <?php echo lang('label.common.height'); ?>&nbsp;
            <input type="number" step="1" max="<?php echo $bHeight; ?>" min="0" data-bind="value: height"/>
        </td>
    </tr>
    <tr>
        <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
        <td><select data-bind = "value: display">
                <option value=""><?php echo lang('label.common.status.display'); ?></option>
                <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
            </select>
        </td>
        <td></td>
        <td><?php echo lang('label.common.ratio'); ?>&nbsp;
            <input type="checkbox" value="true" data-bind="checked: aspectRatio"/></td>
    </tr>
    <tr data-bind="visible: display">
        <td class="title"><?php echo lang('label.common.button.display'); ?></td>
        <td><select data-bind="enable:display, value: button, options: linkButtons, 
                        optionsText: 'title', optionsValue: 'id',  optionsCaption: '  --  '">
        </select></td>
        <td class="title"><?php echo lang('label.common.hide.mode'); ?></td>
        <td><select data-bind = "enable:display, value: hideMode">
                <option value=""><?php echo lang('label.common.hide.mode.nothing'); ?></option>
                <option value="button"><?php echo lang('label.common.hide.mode.button'); ?></option>
                <option value="self"><?php echo lang('label.common.hide.mode.self'); ?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="title"><?php echo lang('label.text.content'); ?></td>
        <td colspan="3"><textarea id="t2BodyText" name="t2BodyText" data-bind="value: text"></textarea></td>
    </tr>      
</table>
</div>