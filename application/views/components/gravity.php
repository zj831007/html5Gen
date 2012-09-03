<style>
#cubePreview1{width:100px; height:120px; position:absolute; top:5px; right:12px; margin:10px;
              background:url(<?php echo base_url();?>css/images/cube1.png) center center no-repeat;}
#cubePreview2{width:90px; height:120px; position:absolute; top:5px; right:150px; margin:10px;}

#cubePreview3{width:200px; height:200px; position:absolute; bottom:0px; right:12px; margin:10px;
              background:none center center no-repeat ; border: solid 1px #555; background-size:200px 200px; }
			  
.face{width:28px;  height:28px; background-color:#ccc; font-size:18px; text-align:center; line-height:30px; padding:0; border: 1px solid #666;}
.face>span{line-height:30px !important; padding:0 !important;}
.faceActive{
	border: 1px solid #fbd850 !important; 
	background: none #ffffff  50% 50% repeat-x !important;
	font-weight: bold !important; 
	color: #eb8f00 !important;
	outline: none !important;
}
#face1,#face2, #face6, #face4{margin:0 30px;}
#face3{margin:-90px 0px 0px 60px;}
#face5{margin:-90px 0px 0px 0px;}
</style>
<script src="<?php echo base_url(); ?>js/components/gravity-cmp.js"></script>
<script>
$(function(){
    Chidopi.Gravity.init(sys_vars);
	
});
</script>
<div id="gravity_dialog" class="cmp_dialog" style="display:none;">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" name="title" id="gTitle" data-bind="value: title"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.bgcolor'); ?></td>
            <td><input type="text" readonly id="gBgColor" class="short"  name="bgColor" 
                       value="#000000" data-bind="value: bgColor, style:{ backgroundColor: bgColor() }"/>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.border.color'); ?></td>
            <td><input type="text" readonly id="gBdColor" class="short"  name="bdColor" 
                       value="#555555" data-bind="value: bdColor, style:{ backgroundColor: bdColor() }"/>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.image'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="gFileTitle"placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>                <button id="btn_gCancel">取消</button>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.page'); ?></td>
            <td>
                <select id="gSelPage"></select>
            </td>
        </tr>
         <tr>
            <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
            <td><select id="gDisplay" name="display" data-bind = "value: display">
                    <option value=""><?php echo lang('label.common.status.display'); ?></option>
                    <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
                </select>
            </td>
        </tr>
        <tbody id="div_gravity_display" data-bind="visible: display"> 
        <tr>
            <td class="title"><?php echo lang('label.common.button.display'); ?></td>
            <td><select id="gButton" name="button" 
                        data-bind="enable:display, value: button, options: linkButtons, 
                        optionsText: 'title', optionsValue: 'id',  optionsCaption: '  --  '"></select>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.hide.mode'); ?></td>
            <td><select id="gHide" name="hideMode" data-bind = "enable:display, value:hideMode">
                    <option value=""><?php echo lang('label.common.hide.mode.nothing'); ?></option>
                    <option value="back"><?php echo lang('label.common.hide.mode.other'); ?></option>
                    <option value="button"><?php echo lang('label.common.hide.mode.button'); ?></option>
                </select>
            </td>
        </tr>
        </tbody>
        <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="number" id="gPX" name="x" step="1" 
                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: x"/>
                &nbsp;Y&nbsp;<input type="number" id="gPY" name="y"  step="1"
                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: y"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><input type="number" id="gWidth" name="width" step="1" 
                           max="<?php echo $bWidth; ?>" min="0" data-bind="value: width"/>                           
                <br/><button id="gRstoreSize" type="button"><?php echo lang('label.common.size.restore'); ?></button>
            </td>
        </tr>
    </table>
    <div id="cubePreview1" ></div>
    
    <div id="cubePreview2">
        <div id="face1" class="face faceActive" uid="1">1</div>
        <div id="face2" class="face" uid="2">2</div>
        <div id="face6" class="face" uid="6">6</div>
        <div id="face4" class="face" uid="4">4</div>
        <div id="face3" class="face" uid="3">3</div>
        <div id="face5" class="face" uid="5">5</div>
    </div>
    
    <div id="cubePreview3" ></div>
    
    <input type="hidden" id="gFileName" name="fileName" data-bind="value: fileName"/>
    <input type="hidden" name="movePage" data-bind="value: movePage"/>
    <input type="hidden" id="gravity_id"  name="id" data-bind="value: id"/>
    <input type="hidden" id="g_zindex" name="zIndex" data-bind="value: zIndex"/>
    <input type="hidden" id="gHeight" name="height" data-bind="value: height"/>  
    <input type="hidden" id="g_origin_width" name="originWidth" data-bind="value: originWidth"/>
    <input type="hidden" id="g_origin_height" name="originHeight" data-bind="value: originHeight"/>
    <input type="hidden" id="gAspectRatio" name="aspectRatio" value="true" data-bind="value: aspectRatio"/>
    <input type="hidden" id="gBgColorAlpha" name="bgColorAlpha" value="0.5" data-bind="value: bgColorAlpha"/>
    <input type="hidden" id="gBdWidth" name="bdWidth" value="1" data-bind="value: bdWidth"/>
    <input type="hidden" id="gravity_type" name="type" value="cube" data-bind="value: type"/>
    <input type="hidden" id="gFileName1" class="tmp_file"/>
    <input type="hidden" id="gFileName2" class="tmp_file"/>
    <input type="hidden" id="gFileName3" class="tmp_file"/>
    <input type="hidden" id="gFileName4" class="tmp_file"/>
    <input type="hidden" id="gFileName5" class="tmp_file"/>
    <input type="hidden" id="gFileName6" class="tmp_file"/>
    
    <input type="hidden" id="gMovePage1" class="tmp_page"/>
    <input type="hidden" id="gMovePage2" class="tmp_page"/>
    <input type="hidden" id="gMovePage3" class="tmp_page"/>
    <input type="hidden" id="gMovePage4" class="tmp_page"/>
    <input type="hidden" id="gMovePage5" class="tmp_page"/>
    <input type="hidden" id="gMovePage6" class="tmp_page"/>
</div>