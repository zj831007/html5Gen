<script src="<?php echo base_url(); ?>js/components/rotate360-cmp.js"></script>
<style>
#r_sortable { list-style-type: none; margin: 0; padding: 0; }
#r_sortable li { list-style-type:none; float:left ;margin: 3px 3px 3px 0; padding: 1px; width: 100px; /*height: 90px;*/ text-align: center; }
#r_sortable li .cancel { float:right;}

.rotateIcon{
	  background:url(<?php echo base_url();?>css/images/arrow.png) no-repeat 0 0  rgba(0, 255, 0, 1); 
	  position:relative; 
	  border: 1px solid #dedede; 
	  -moz-border-radius: 25px; 
	  -webkit-border-radius: 25px; 
	  width:50px; 
	  height:50px; 
	  margin: 0 auto;
}
.arrow_updown{
	bottom:70%;
}
.arrow_leftright{
	bottom:40%;
	-moz-transform: rotate(90deg);
	-webkit-transform: rotate(90deg);
	-o-transform: rotate(90deg) ;
	-ms-transform: rotate(90deg);
	transform: rotate(90deg);
}
</style>
<script>
$(function(){
	Chidopi.Rotate360.init(sys_vars);
});
</script>

<div id="rotate360_dialog" class="cmp_dialog" style="display:none">
<div id="rotateTabs" style="height:97%;">
	<UL>										
        <LI><A href="#rotateTab-1"><?php echo lang('label.tab.params.setting'); ?></A></LI>
        <LI><A href="#rotateTab-2"><?php echo lang('label.tab.image.management'); ?></A></LI>
    </UL>
    <div id="rotateTab-1">
        <table>
            <tr>
                <td class="title"><?php echo lang('label.common.title'); ?></td>
                <td><input type="text" id="rTitle" name="title" data-bind="value: title"/></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
                <td><select id="rDisplay" name="display" data-bind = "value: display">
                        <option value=""><?php echo lang('label.common.status.display'); ?></option>
                        <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
                    </select>
                </td>
            </tr>
            <tbody id="div_rotate_display" data-bind="visible: display"> 
            <tr>
                <td class="title"><?php echo lang('label.common.button.display'); ?></td>
                <td><select id="rButton" name="button" 
                            data-bind="enable:display, value: button, options: linkButtons, 
                            optionsText: 'title', optionsValue: 'id',  optionsCaption: '  --  '"></select>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.hide.mode'); ?></td>
                <td><select id="rHide" name="hideMode" data-bind = "enable:display, value:hideMode">
                        <option value=""><?php echo lang('label.common.hide.mode.nothing'); ?></option>
                        <option value="back"><?php echo lang('label.common.hide.mode.other'); ?></option>
                        <option value="button"><?php echo lang('label.common.hide.mode.button'); ?></option>
                    </select>
                </td>
            </tr>
            </tbody>
            <!--tr>
                <td class="title">圖片数目</td>
                <td><select name="number" id="rNumber" data-bind="value: number" >
                        <option value="12">12</option><option value="18">18</option>
                        <option value="24">24</option><option value="36">36</option>
                   </select></td>
            </tr-->
            <tr>
                <td class="title"><?php echo lang('label.360.rotate.orientation'); ?></td>
                <td><select name="orientation" id="rOrientation" data-bind="value: orientation">
                        <option value="0"><?php echo lang('label.360.rotate.orientation.h'); ?></option>
                        <option value="1"><?php echo lang('label.360.rotate.orientation.v'); ?></option>
                </select></td>
            </tr>
			<tr>
                <td class="title"><?php echo lang('label.360.notice.bg.color'); ?></td>
                <td><input type="text" readonly id="noticeColor" name="noticeColor" class="short"
                           data-bind="value: noticeColor, style:{ backgroundColor: noticeColor() }" value="0,255,0"/>
                </td>
            </tr>           	
            <tr>
                <td class="title"><?php echo lang('label.common.position'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" id="rPX" name="x" step="1" 
                                    max="<?php echo $bWidth; ?>" min="0" data-bind="value: x"/>
                    &nbsp;Y&nbsp;<input type="number" id="rPY" name="y"  step="1"
                                    max="<?php echo $bHeight; ?>" min="0" data-bind="value: y"/>
                </td>
            </tr>
            <tr>
                <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
                <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="rWidth" name="width" step="1" 
                               max="<?php echo $bWidth; ?>" min="0" data-bind="value: width"/>
                    <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="rHeight" name="height" step="1"
                               max="<?php echo $bHeight; ?>" min="0" data-bind="value: height"/>
                    <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="rAspectRatio" name="aspectRatio" type="checkbox" 
                                               value="true" data-bind="checked: aspectRatio"/>
                    <br/><button id="rRstoreSize" type="button"><?php echo lang('label.common.size.restore'); ?></button>
                </td>
            </tr>
        </table>
        <input type="hidden" id="rFileName" name="fileName" data-bind="value: fileName" />
        <input type="hidden" id="rotate360_id" name="id" data-bind="value: id"/>
        <input type="hidden" id="rotate360_zindex" name="zIndex" data-bind="value: zIndex"/>
        <input type="hidden" id="r_origin_width" name="originWidth" data-bind="value: originWidth"/>
        <input type="hidden" id="r_origin_height" name="originHeight" data-bind="value: originHeight"/>
    </div>
    <div id="rotateTab-2">
        <button type="button" id="btnRSelImg"><?php echo lang('label.common.choose.image'); ?></button>
        <p><?php echo lang('label.360.change.sort'); ?></p>
        <div id="rotateTab-2-preview" style="text-align: center;">
            <img id="r_upload_previewImg" width="500px;"/>
        </div>
        <div style="width:520px; overflow-x:scroll;">
            <UL id='r_sortable'>									  
            
            </UL>
        </div>
    </div>
</div>
</div>