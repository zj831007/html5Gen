<?php //$this->load->library('Editor');
//echo "editor: " . $this->editor ." d";
// $this->editor->LoadEditor('tBodyText','',540,200);?>

<script src="<?php echo base_url();?>ckeditor/ckeditor.js" ></script>
<script src="<?php echo base_url();?>ckeditor/fixed.js" ></script>
<script src="<?php echo base_url(); ?>js/components/text-cmp.js"></script>
<script>
$(function(){
	sys_vars.user_files_tpl  = "<{$user_res_path}>";
	Chidopi.Text.init(sys_vars);
});
</script>
<div id="text_dialog" class="cmp_dialog" style="display:none">
    <div id="tabs-text-dialog" style="height:500px;">
        <UL>										
            <LI><A href="#tabs-text-1"><?php echo lang('label.tab.title.setting'); ?></A></LI>
            <LI><A href="#tabs-text-2"><?php echo lang('label.tab.content.setting'); ?></A> </LI>
        </UL>
        <div id="tabs-text-1">
        <table>
            <!--tr>
                <th colspan="2" align="center">標題設定</th>
            </tr-->
            <tr>
                <td class="title"><?php echo lang('label.common.title'); ?></td>
                <td><input type="text" id="tTitleText" name="tTitleText"  size="20"/></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" name="tTitleFileName" id="tmp_tTitleFile" 
                           placeholder="<?php echo lang('label.common.choose.image'); ?>點擊選擇圖片" class="upload"/>                
                    <!--input type="text" readonly="readonly" id="tmp_tTitleFile" placeholder="點擊上傳圖片" class="upload"/-->
                    <button id="btn_tTitleCancel"><?php echo lang('label.common.cancel'); ?></button>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.bgcolor'); ?></td>
                <td><input type="text" readonly="readonly" id="tTitleBgColor" name="tTitleBgColor" value="#FFFFFF"/></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.title.color'); ?></td>
                <td><input type="text" readonly="readonly" id="tTitleColor" name="tTitleColor" value="#FFFFFF"/></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.font'); ?></td>
                <td><select id="tTitleFont" name="tTitleFont">
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
                <td><select id="tTitleFontSize" name="tTitleFontSize">
                        <option value="medium"><?php echo lang('label.common.normal'); ?></option>
                        <option value="small"><?php echo lang('label.common.small'); ?></option>
                        <option value="large"><?php echo lang('label.common.large'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.align'); ?></td>
                <td><select id="tTitleAlign" name="tTitleAlign">
                        <option value="left"><?php echo lang('label.align.left'); ?></option>
                        <option value="center"><?php echo lang('label.align.center'); ?></option>
                        <option value="right"><?php echo lang('label.align.right'); ?></option>
                    </select>
                </td>
            </tr>   
            <tr>
                <td class="title"><?php echo lang('label.spotlight.spotSize'); ?></td>
                <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="tTitleWidth" name="tTitleWidth" 
                               step="1" max="<?php echo $bWidth; ?>" min="0"/>
                    <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="tTitleHeight" name="tTitleHeight" 
                               step="1" max="<?php echo $bHeight; ?>" min="0"/>
                    &nbsp;&nbsp;<?php echo lang('label.common.ratio'); ?>&nbsp;
                    <input id="tAspectRatioTitle" name="aspectRatioTitle" type="checkbox" value="1" checked="checked"/>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.text.pisition'); ?></td>
                <td><select id="tPosition" name="tPosition">
                        <option value="top"><?php echo lang('label.pos.top'); ?></option>
                        <option value="bottom"><?php echo lang('label.pos.bottom'); ?></option>
                        <option value="left"><?php echo lang('label.pos.left'); ?></option>
                        <option value="right"><?php echo lang('label.pos.right'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.position'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" id="tPX" name="tPX" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                    &nbsp;Y&nbsp;<input type="number" id="tPY" name="tPY" step="1" max="<?php echo $bHeight; ?>" min="0"/>
                </td>
            </tr>
        </table>
        </div>
		<div id="tabs-text-2">
        <table>
            <!--tr>
                <th colspan="2" align="center">內容設定</th>
            </tr-->
            <tr>
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" name="tBodyFileName" id="tmp_tBodyFile" 
                           placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>
                    <!--input type="text" readonly="readonly" id="tmp_tBodyFile" placeholder="點擊上傳圖片" class="upload/"-->
                    <button id="btn_tBodyCancel"><?php echo lang('label.common.cancel'); ?></button>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.bgcolor'); ?></td>
                <td><input type="text" readonly="readonly" id="tBodyBgColor" name="tBodyBgColor" value="#FFFFFF"/></td>
            </tr>
             <tr>
                <td class="title"><?php echo lang('label.text.content.image'); ?></td>
                <td>
                    <input type="text" readonly="readonly" name="tBodyBgFileName" id="tmp_tBodyBgFile" 
                           placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>
                   <!--input type="text" readonly="readonly" id="tmp_tBodyBgFile" placeholder="點擊上傳圖片" class="upload"/-->
                    <button id="btn_tBodyBgCancel"><?php echo lang('label.common.cancel'); ?></button>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.text.content'); ?></td>
                <td>
                    <textarea id="tBodyText" name="tBodyText" ></textarea>
                </td> 
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.spotlight.spotSize'); ?></td>
                <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="tBodyWidth" name="tBodyWidth" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                    <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="tBodyHeight" name="tBodyHeight" step="1" max="<?php echo $bHeight; ?>" min="0"/>
                    &nbsp;&nbsp;<?php echo lang('label.common.ratio'); ?>&nbsp;
                    <input id="tAspectRatioBody" name="aspectRatioBody" type="checkbox" value="1" checked="checked"/>
                </td>
            </tr>        
        </table>
        </div>
    </div>
    
    <input type="hidden" name="id" id="text_id"/>
    <input type="hidden" name="tBodyFileWidth" id="tBodyFileWidth" />
    <input type="hidden" name="tBodyFileHeight" id="tBodyFileHeight" />
    <input type="hidden" id="text_zindex" name="zIndex" />
</div>