<link href="<?php echo base_url(); ?>css/slider2/slider2.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>js/components/slider2-cmp.js"></script>
<style>
#s2_sortable { list-style-type: none; margin: 0; padding: 0; }
#s2_sortable li { list-style-type:none; float:left ;margin: 3px 3px 3px 0; padding: 1px; width: 100px; /*height: 90px;*/ text-align: center; }
#s2_sortable li .cancel { float:right;}

</style>
<script>
$(function(){
	Chidopi.Slider2.init(sys_vars);
});

</script>
<style>
.cmp_dialog table .sub_table { width:400px;}
.cmp_dialog table table td.title { text-align: left; width:59px;}
</style>
<div id="slider2_dialog" class="cmp_dialog" style="display:none">
<!--div id="div_slider2Tabs" style="width:100%;"-->
<div id="s2Tabs" style="height:97%; ">
	<UL>										
        <LI><A href="#s2Tab-1"><?php echo lang('label.tab.params.setting'); ?></A></LI>
        <LI><A href="#s2Tab-2"><?php echo lang('label.tab.image.management'); ?></A></LI>
    </UL>
    <div id="s2Tab-1">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" id="s2Title" name="title" data-bind="value: title"/></td>
        </tr>
        <!--tr>
            <td class="title">圖片上傳</td>
            <td>               
            </td>
        </tr-->
        <tr>
            <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
            <td><select id="s2Display" name="display" data-bind = "value: display">
                    <option value=""><?php echo lang('label.common.status.display'); ?></option>
                    <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
                </select>
            </td>
        </tr>
        <tbody id="div_slider2_display" data-bind="visible: display"> 
        <tr>
            <td class="title"><?php echo lang('label.common.button.display'); ?></td>
            <td><select id="s2Button" name="button" 
                        data-bind="enable:display, value: button, options: linkButtons, 
                        optionsText: 'title', optionsValue: 'id',  optionsCaption: '  --  '"></select>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.hide.mode'); ?></td>
            <td><select id="s2Hide" name="hideMode" data-bind = "enable:display, value:hideMode">
                    <option value=""><?php echo lang('label.common.hide.mode.nothing'); ?></option>
                    <option value="back"><?php echo lang('label.common.hide.mode.other'); ?></option>
                    <option value="button"><?php echo lang('label.common.hide.mode.button'); ?></option>
                </select>
            </td>
        </tr>
        </tbody>
        <tr>
            <td class="title"><?php echo lang('label.slider2.mode'); ?></td>
            <td><?php echo lang('label.slider2.touch'); ?><input type="checkbox" id="s2Touch" name="touch" value="true" data-bind="checked: touch"/>&nbsp;&nbsp;
                <?php echo lang('label.slider2.auto'); ?><input type="checkbox" id="s2Auto" name="auto" value="true" data-bind="checked: auto"/>&nbsp;&nbsp;
                <?php echo lang('label.slider2.dock'); ?><input type="checkbox" id="s2Dock" name="dock" value="true" data-bind="checked: dock"/>&nbsp;&nbsp;
                <?php echo lang('label.slider2.arrow'); ?><input type="checkbox" id="s2Arrow" name="arrow" value="true" data-bind="checked: arrow"/>						
            </td>
        </tr> 
        <tr>
            <td class="title"><?php echo lang('label.slider2.change.mode'); ?></td>
            <td><select id="s2ChangeMode" name="changeMode" data-bind="value: changeMode" >
                    <option value='sliceDown'><?php echo lang('label.slider2.change.sliceDown'); ?></option>
                    <option value='sliceDownRight'><?php echo lang('label.slider2.change.sliceDownRight'); ?></option>
                    <option value='sliceDownLeft'><?php echo lang('label.slider2.change.sliceDownLeft'); ?></option>
                    <option value='sliceUp'><?php echo lang('label.slider2.change.sliceUp'); ?></option>
                    <option value='sliceUpRight'><?php echo lang('label.slider2.change.sliceUpRight'); ?></option>
                    <option value='sliceUpLeft'><?php echo lang('label.slider2.change.sliceUpLeft'); ?></option>
                    <option value='sliceUpDown'><?php echo lang('label.slider2.change.sliceUpDown'); ?></option>
                    <option value='sliceUpDownLeft'><?php echo lang('label.slider2.change.sliceUpDownLeft'); ?></option>
                    <option value='fold'><?php echo lang('label.slider2.change.fold'); ?></option>
                    <option value='fade'><?php echo lang('label.slider2.change.fade'); ?></option>
                    <option value='flip'><?php echo lang('label.slider2.change.flip'); ?></option>
                    <option value='slideInRight'><?php echo lang('label.slider2.change.slideInRight'); ?></option>
                    <option value='slideInLeft'><?php echo lang('label.slider2.change.slideInLeft'); ?></option>
                    <option value='boxRandom'><?php echo lang('label.slider2.change.boxRandom'); ?></option>
                    <option value='boxRain'><?php echo lang('label.slider2.change.boxRain'); ?></option>
                    <option value='boxRainReverse'><?php echo lang('label.slider2.change.boxRainReverse'); ?></option>
                    <option value='boxRainGrow'><?php echo lang('label.slider2.change.boxRainGrow'); ?></option>
                    <option value='boxRainGrowReverse'><?php echo lang('label.slider2.change.boxRainGrowReverse'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.slider2.misc'); ?></td>
            <td><?php echo lang('label.slider2.transparent'); ?><input type="checkbox" id="s2TransPic" name="transPic" value="true" data-bind="checked: transPic"/></td>
        </tr>
        <tr data-bind="visible: dock" style="margin-top: 10px;">
        	<td class="title" style="font-weight:bold;border-top:1px dashed #CCC"><?php echo lang('label.slider2.dock.setting'); ?></td>
            <td style="border-top:1px dashed #CCC"">
                <table id="tb_s2dock" class="sub_table">
                    <tr>
                        <td class="title"><?php echo lang('label.slider2.dock.position'); ?></td>
                        <td>
                          <?php echo lang('label.slider2.horizontal'); ?>&nbsp;<select id="s2DockAlign" name="dockAlign" 
                                       data-bind="value: dockAlign,enable: supportDock">
                                    <option value="left"><?php echo lang('label.slider2.left'); ?></option>
                                    <option value="center"><?php echo lang('label.slider2.center'); ?></option>
                                    <option value="right"><?php echo lang('label.slider2.right'); ?></option>
                               </select>&nbsp;
                              
                          <?php echo lang('label.slider2.vertical'); ?>&nbsp;<select id="s2DockPosition" name="dockPosition" 
                                       data-bind="value: dockPosition,enable: supportDock">
                                    <option value="top"><?php echo lang('label.slider2.top'); ?></option>
                                    <option value="bottom"><?php echo lang('label.slider2.bottom'); ?></option>
                               </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="title"><?php echo lang('label.slider2.dock.color'); ?></td>
                        <td>
                            <?php echo lang('label.slider2.color.normal'); ?>&nbsp;<input type="text" readonly id="s2DockColor" class="short"  name="dockColor" 
                                            value="#1e5a47" data-bind="value: dockColor, enable: supportDock , 
                                            style:{ backgroundColor: dockColor() }"/>&nbsp;&nbsp;
                            <?php echo lang('label.slider2.color.current'); ?>&nbsp;<input type="text" readonly id="s2DockColorCurrent"  class="short"  name="dockColorCurrent" 
                                            value="#f0a017" data-bind="value: dockColorCurrent, enable: supportDock, 
                                            style:{ backgroundColor: dockColorCurrent() }"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="title"><?php echo lang('label.slider2.dock.text'); ?></td>
                        <td><input type="checkbox" id="s2DockShowText" name="dockShowText" value="true" 
                                   data-bind="checked: dockShowText, enable: supportDock"/></td>           
                    </tr>
                    <tr id="tr_s2DockColor" data-bind="visible: dockShowText" > 
                        <td class="title"><?php echo lang('label.slider2.dock.text.color'); ?></td>
                        <td> 
                            <?php echo lang('label.slider2.dock.text.color'); ?>&nbsp;<input type="text" readonly id="s2DockTextColor"  class="short"  name="dockTextColor" 
                                            value="#FFFFFF"  data-bind="value: dockTextColor, enable: dockShowText,
                                            style:{ backgroundColor: dockTextColor() }"/>&nbsp;&nbsp;
                            <?php echo lang('label.slider2.color.current'); ?>&nbsp;<input type="text" readonly id="s2DockTextColorCurrent"  class="short"  
                                            name="dockTextColorCurrent" value="#FFFFFF"  
                                            data-bind="value: dockTextColorCurrent, enable: dockShowText, 
                                            style:{ backgroundColor: dockTextColorCurrent() }"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="title"><?php echo lang('label.slider2.dock.size'); ?></td>
                        <td>
                            <select id="s2DockSize" name="dockSize"  data-bind="value: dockSize,  enable: supportDock">
                                <option value="normal"><?php echo lang('label.common.normal'); ?></option>
                                <option value="small"><?php echo lang('label.common.small'); ?></option>
                                <option value="large"><?php echo lang('label.common.large'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr data-bind="visible: arrow" style="margin-top: 10px;"> 
        	<td class="title" style="font-weight:bold; border-top:1px dashed #CCC"><?php echo lang('label.slider2.arrow.setting'); ?></td>
            <td style="border-top:1px dashed #CCC">
                <table id="tb_s2arrow" >
                 <tr>
                    <td class="title"><?php echo lang('label.slider2.arrow.position'); ?></td>
                    <td>
                        <select id="s2ArrowPosition" name="arrowPosition"  
                                data-bind="value: arrowPosition, enable: arrow">
                           <option value="1"><?php echo lang('label.slider2.arrow.inside'); ?></option>
                           <option value="2"><?php echo lang('label.slider2.arrow.outside'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="title"><?php echo lang('label.slider2.arrow.change'); ?><br/>&nbsp;</td>
                    <td> <input type="text" readonly="readonly" id="s2ArrowFileName" name="arrowFileName" 
                               placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload" 
                               data-bind="value: arrowFileName, enable: arrow"/>            
                        <button id="btn_s2aCancel"  data-bind="enable: arrow"><?php echo lang('label.common.cancel'); ?></button><br/>
                        <?php echo lang('label.slider2.arrow.info'); ?>    
                    </td>
                </tr>
                </table>
            </td>            
        </tr>
         <tr>
            <td class="title"><?php echo lang('label.animation.setting'); ?></td>
            <td>
                <?php echo lang('label.animation.in'); ?>&nbsp;<input id="s2LoadAction" name="loadAction" type="checkbox" value="true" data-bind="checked: loadAction"/>&nbsp;&nbsp;&nbsp;
                <?php echo lang('label.animation.out'); ?>&nbsp;<input id="s2HideAction" name="hideAction" type="checkbox" value="true" data-bind="checked: hideAction"/>                
            </td>
        </tr>
        <tr id="tr_slider2_load_action" style="border-top:1px dashed #CCC" data-bind="visible: loadAction">
            <td class="title"><?php echo lang('label.animation.in'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.in'); ?>
                <select id="s2LoadPos" name="loadPos" data-bind="value: loadPos, enable: loadAction">
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
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="s2Load2D" name="load2D" type="number" min="-1080" max="1080" 
                                      step="45" data-bind="value: load2D, enable: loadAction"/>                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="s2Load3DX" name="load3DX" type="number" min="-1080" max="1080" 
                          step="45" data-bind="value: load3DX, enable: loadAction" /> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="s2Load3DY" name="load3DY" type="number" min="-1080" max="1080" 
                          step="45" data-bind="value: load3DY, enable: loadAction"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="s2LoadSpeedInfo"></span>
                <input type="range" onchange='$("#s2LoadSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="s2LoadSpeed" name="loadSpeed" 
                       data-bind="value: loadSpeed, enable: loadAction">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="s2LoadOpacityInfo"></span>
                <input type="range" onchange='$("#s2LoadOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="s2LoadOpacity" name="loadOpacity" 
                       data-bind="value: loadOpacity, enable: loadAction">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="s2LoadDelayInfo"></span>
                <input type="range" onchange='$("#s2LoadDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="s2LoadDelay" name="loadDelay"
                       data-bind="value: loadDelay, enable: loadAction">
            </td>
        </tr>
        <tr id="tr_slider2_hide_action" style="border-top:1px dashed #CCC" data-bind="visible: hideAction">
            <td class="title"><?php echo lang('label.animation.out'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.out'); ?>
                <select id="s2HidePos" name="hidePos" data-bind="value: hidePos, enable: hideAction">
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
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="s2Hide2D" name="hide2D" type="number" min="-1080" max="1080" 
                                      step="45" data-bind="value: hide2D, enable: hideAction"/>                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="s2Hide3DX" name="hide3DX" type="number" min="-1080" max="1080" 
                           step="45" data-bind="value: hide3DX, enable: hideAction"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="s2Hide3DY" name="hide3DY" type="number" min="-1080" max="1080" 
                           step="45" data-bind="value: hide3DY, enable: hideAction"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="s2HideSpeedInfo"></span>
                <input type="range" onchange='$("#s2HideSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="s2HideSpeed" name="hideSpeed" 
                       data-bind="value: hideSpeed, enable: hideAction">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="s2HideOpacityInfo"></span>
                <input type="range" onchange='$("#s2HideOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="s2HideOpacity" name="hideOpacity" 
                       data-bind="value: hideOpacity, enable: hideAction">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="s2HideDelayInfo"></span>
                <input type="range" onchange='$("#s2HideDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="s2HideDelay" name="hideDelay"
                       data-bind="value: hideDelay, enable: hideAction">
            </td>
        </tr>
         <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="number" id="s2PX" name="x" step="1" 
                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: x"/>
                &nbsp;Y&nbsp;<input type="number" id="s2PY" name="y"  step="1"
                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: y"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="s2Width" name="width" step="1" 
                           max="<?php echo $bWidth; ?>" min="0" data-bind="value: width"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="s2Height" name="height" step="1"
                           max="<?php echo $bHeight; ?>" min="0" data-bind="value: height"/>
                <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="s2AspectRatio" name="aspectRatio" type="checkbox" 
                                           value="true" data-bind="checked: aspectRatio"/>
                <br/><button id="s2RstoreSize" type="button"><?php echo lang('label.common.size.restore'); ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" id="s2FileName" name="fileName" data-bind="value: fileName" />
    <input type="hidden" id="slider2_id" name="id" data-bind="value: id"/>
    <input type="hidden" id="slider2_zindex" name="zIndex" data-bind="value: zIndex"/>
    <input type="hidden" id="s2_origin_width" name="originWidth" data-bind="value: originWidth"/>
    <input type="hidden" id="s2_origin_height" name="originHeight" data-bind="value: originHeight"/>
    </div>
    <div id="s2Tab-2">
        <!--form id="slider2Form" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>?upload/index">
            <input id="s2Upload" type="file" value="" name="Filedata">
        </form-->
        <!--input type="button" onclick="javascript: $('#s2Upload').uploadifyUpload();" value="upload"/-->
        <button type="button" id="btnSelImg"><?php echo lang('label.common.choose.image'); ?></button>
        <p><?php echo lang('label.360.change.sort'); ?></p>
        <div id="s2Tab-2-preview" style="">
            <img id="s2_upload_previewImg" width="500px;"/>
        </div>
        <div style="width:520px; overflow-x:scroll;">
            <UL id='s2_sortable'>									  
            
            </UL>
        </div>
    </div>
</div>
</div>