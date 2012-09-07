<style>
   /*.canvas-container .upper-canvas{margin:20px;}*/
</style>
<div id="vocabulary_dialog" class="cmp_dialog" style="display:none">
		<div id="vo_scenceCanvas" >
		<!--div style="width:100%;/*height:450px;overflow:scroll;*/">
		<div id="vocabulary_outer" style="background-color:#d6d7d6;overflow:hidden;margin-left:auto;margin-right:auto;"> -->
		<canvas id="vocabulary_canvas" style="/*margin:20px;*/" data-bind="style:{ backgroundColor: 'rgba(' + sceneSwitchColor() + ',1)' }"></canvas>
		<!--/div>
		</div>-->
		</div>
<div id="voTab_dialog">
<div id="voTabs" style="/*height:97%; */">
	<UL>										
        <LI><A href="#voTab-1"><?php echo lang('label.tab.misc.setting'); ?></A></LI>
        <LI><A href="#voTab-2"><?php echo lang('label.tab.scene.setting'); ?></A></LI>
        <!-- LI><A href="#voTab-3"><?php echo lang('label.tab.scene.preview'); ?></A></LI> -->
    </UL>
    <div id="voTab-1">
        <table>
            <tr>
                <td class="title"><?php echo lang('label.common.title'); ?></td>
            	<td><input type="text" data-bind="value: title" /></td>
            	<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
            </tr>
            <tr>
                <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
                <td valign="top">
                <?php echo lang('label.common.width'); ?>&nbsp;<input type="number" name="width" step="1" 
                           max="<?php echo $bWidth; ?>" min="0" data-bind="value: width"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" name="height" step="1"
                           max="<?php echo $bHeight; ?>" min="0" data-bind="value: height"/>
                </td>
             	<td class="title"><?php echo lang('label.common.rightScore'); ?></td>
	            <td>
	                <input type="number" data-bind="value: rightScore" min="0" max="30"/>
	                &nbsp;<?php echo lang('label.common.errorScore'); ?>&nbsp;<input type="number" data-bind="value: errorScore" min="0" max="30"/>
	            </td>
	            <td></td>
	            <td><?php echo lang('label.common.scene.setting'); ?></td>
            </tr>
            <tr>
                <td class="title" valign="top"><?php echo lang('label.common.position'); ?></td>
	            <td valign="top">&nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: y"/>
	                <br/><?php echo lang('label.common.ratio'); ?>&nbsp;
	                     <input name="aspectRatio" type="checkbox" value="true" data-bind="checked: aspectRatio"/>
	            </td>
	            <td class="title"><?php echo lang('label.common.img.back'); ?></td>
	            <td><div><input type="text" readonly="readonly" data-bind="value: backIcon().pic1, attr:{'title': backIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" data-bind="value: backIcon().pic2, attr:{'title': backIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel" ><?php echo lang('label.common.cancel'); ?></button></div></td>
	            <td class="title"><?php echo lang('label.common.level.name'); ?></td>
                <td valign="top">
                    <input name="sceneName"/><br/>
                    <input type="button" value="<?php echo lang('label.button.scene.add'); ?>" data-bind="click: addLevel"/>
                    <input type="button" value="<?php echo lang('label.button.scene.edit'); ?>" data-bind="click: updateLevel"/>
                    <input type="button" value="<?php echo lang('label.button.scene.del'); ?>" data-bind="click: delLevel"/>
                </td>
            </tr>
            <tr>
	            <td class="title"><?php echo lang('label.common.rightAudio'); ?></td>
	            <td>
	                <input type="text" readonly="readonly" data-bind="value: rightAudio, attr:{'title': rightAudio}"  
	                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: backIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: backIcon().y"/>
	            </td>
	            <td class="title"><?php echo lang('label.common.level.list'); ?></td>
                <td rowspan="5">
                    <input type="button" data-bind="click: moveUp" value="<?php echo lang('label.button.up'); ?>"/>
                    <input type="button" data-bind="click: moveDown" value="<?php echo lang('label.button.down'); ?>"/><br/>
                    <!--select size="7" name="scenes" style="width:200px;" data-bind="options: scenes, optionsText: 'name',optionsValue:'id'"></select>  -->
                    <select size="7" name="levels" style="width:200px;" data-bind="options: levelScenes, optionsText: 'name',optionsValue:'id'"></select>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.errorAudio'); ?></td>
                <td>
                    <input type="text" readonly="readonly" data-bind="value: errorAudio, attr:{'title': errorAudio}"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                    <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>

                </td>
                <td class="title"><?php echo lang('label.common.scene.bgColor'); ?></td>
	            <td valign="top"><input type="text" readonly class="short"  name="sceneSwitchColor" 
                           data-bind="value: sceneSwitchColor, style:{ backgroundColor: 'rgba(' + sceneSwitchColor + ',1)' }"/>
	            </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.finishAudio'); ?></td>
	            <td>
	                <input type="text" readonly="readonly" data-bind="value: finishAudio, attr:{'title': finishAudio}"  
	                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
	            <td class="title"><?php echo lang('label.common.scene.switch'); ?></td>
                <td><select name="sceneSwitchMode" data-bind="value: sceneSwitchMode">
                    <option value="LR"><?php echo lang('label.common.direction.lr'); ?></option>
                    <option value="RL"><?php echo lang('label.common.direction.rl'); ?></option>
                    <option value="TB"><?php echo lang('label.common.direction.tb'); ?></option>
                    <option value="BT"><?php echo lang('label.common.direction.bt'); ?></option>
                </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>&nbsp;</td>
                <td class="title"><?php echo lang('label.game.mode'); ?></td>
                <td><input type="checkbox" data-bind="enable: gameMode.practice, checked: gameMode.challenge" /><?php echo lang('label.game.mode.challenge'); ?><br/>
                    <input type="checkbox" data-bind="checked: gameMode.practice" /><?php echo lang('label.game.mode.practice'); ?>&nbsp;
                    <label><input type="radio" value="free" data-bind="enable: gameMode.practice, checked: gameMode.practiceMode"/><?php echo lang('label.game.level.free'); ?>&nbsp;
                           <input type="radio" value="order" data-bind="enable: gameMode.practice, checked: gameMode.practiceMode"/><?php echo lang('label.game.level.sort'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.particle.pic'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value:particle.img, attr:{'title': particle.img}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.particle.number'); ?></td>
                <td><input type="number" step="1" max="20" min="1" data-bind="value: particle.number"/></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.particle.type'); ?></td>
                <td>
                    <select data-bind="value: particle.type">
                        <option value="">----</option>
                        <option value="ParticleFlower">Flower</option>
                        <option value="ParticleGalaxy">Galaxy</option>
                        <option value="ParticleExplosion">Explosion</option>
                    </select>
                </td>
                
                <!-- td colspan="3" data-bind="foreach: menuScene().menu.levelMenu.levelItems">
                    <select data-bind="value: action, options: $root.levelScenes, optionsText: 'name',optionsValue:'id'"></select>
	                <div></div>
                </td> -->
            </tr>
        </table>
    </div>
    <!-- ========================================== Tab 2 ======================================== -->
    <div id="voTab-2">
        <table>
            <tr>
                <td class="title"><?php echo lang('label.common.scene.list'); ?></td>
                <td colspan="5">
                    <select id="vo_sceneList" style="width:200px;" data-bind="value: currentScene, options: scenes, optionsText: 'name',optionsValue:'id',optionsCaption: '------'"></select>
                </td>
            </tr>
            <tbody id="vo_scenceCanvas">
            <tr>
                <td colspan="6" >
                    <!--  div style="width:100%;/*height:450px;overflow:scroll;*/">
                    <div id="vocabulary_outer" style="background-color:#d6d7d6;overflow:hidden;margin-left:auto;margin-right:auto;">>
                    <canvas id="vocabulary_canvas" style="/*margin:20px;*/" data-bind="style:{ backgroundColor: sceneSwitchColor }"></canvas>
                    </div>
                    </div-->
                </td>
            </tr>
            </tbody>
            <!-- ========================= 首页场景 ======================== -->
            <tbody id="vo_startScene" data-bind="visible: checkScene() == '1'">
            <tr class="title_bar"  style="height:10px; background-color:#ccc;cursor:pointer;">
                <td class="title"><?php echo lang('label.common.scene.name'); ?></td>
                <td><span data-bind="text: startScene().name"></span></td>
                <td colspan="4" align="right" style="padding-right:30px;"><span class="ui-icon ui-icon-extlink"></span></td>
            </tr>
            <tr>
                
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: startScene().bgPic, attr:{'title': startScene().bgPic}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
	            <td class="title"><?php echo lang('label.game.loading.image'); ?></td>
                <td colspan="2"><input type="text" readonly="readonly" name="loadingPic" 
                          data-bind="value: startScene().loadingPic, attr:{'title': startScene().loadingPic}"
                          placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	                &nbsp;<?php echo lang('label.common.status.display'); ?><input type="checkbox" data-bind="checked: startScene().showOverlay" />
                </td>
	            <td></td>
	            <td></td>
	            <td></td>
            </tr>
            <tr>
	            <td class="title"><?php echo lang('label.game.button.bgsound'); ?></td>
                <td><div><input type="text" readonly="readonly" 
                           data-bind="value: startScene().bgSoundIcon().pic1, attr:{'title': startScene().bgSoundIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel" ><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: startScene().bgSoundIcon().pic2, attr:{'title': startScene().bgSoundIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel" ><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: startScene().bgSoundIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: startScene().bgSoundIcon().y"/>
	            </td>
	            <td class="title"><?php echo lang('label.background.sound'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: startScene().bgSound, attr:{'title': startScene().bgSound}"  
	                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.button.start'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: startScene().startIcon().pic1, attr:{'title': startScene().startIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel" ><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly"  
	                       data-bind="value: startScene().startIcon().pic2, attr:{'title': startScene().startIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel" ><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: startScene().startIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: startScene().startIcon().y"/>
	            </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.button.continue'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: startScene().continueIcon().pic1, attr:{'title': startScene().continueIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: startScene().continueIcon().pic2, attr:{'title': startScene().continueIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td valign="top">
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: startScene().continueIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: startScene().continueIcon().y"/>
	            </td>
            </tr>
            
            <tr>
                <td class="title"><?php echo lang('label.game.button.score'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: startScene().scoreIcon().pic1, attr:{'title': startScene().scoreIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: startScene().scoreIcon().pic2, attr:{'title': startScene().scoreIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: startScene().scoreIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: startScene().scoreIcon().y"/><br/>
	            </td>
            </tr>
            </tbody>
            <!-- ========================= 选关场景 ======================== -->
            <tbody id="vo_menuScene" data-bind="visible: checkScene() == '2'">
            <tr class="title_bar"  style="height:10px; background-color:#ccc;cursor:pointer;">
                <td class="title"><?php echo lang('label.common.scene.name'); ?></td>
                <td><span data-bind="text: menuScene().name"></span></td>
                <td colspan="2" align="right" style="padding-right:30px;"><span class="ui-icon ui-icon-extlink"></span></td>
            </tr>
            <tr><td colspan="4"><table>
            <tr>
                <td colspan="4"><?php echo lang('label.common.background'); ?>
                    &nbsp;<input type="text" readonly="readonly" data-bind="value: menuScene().bgPic, attr:{'title': menuScene().bgPic}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>&nbsp;&nbsp;
	                <input type="radio" value="m" data-bind="enable: gameMode.challenge, checked: menuScene().radioMenu" />
	                <?php echo lang('label.game.menu.mode'); ?>&nbsp;&nbsp;
                    <input type="radio" value="l" data-bind="checked: menuScene().radioMenu" /><?php echo lang('label.game.menu.level'); ?>
                </td>
            </tr>
            <tr style="border-bottom:1px solid #ccc;" data-bind="visible: gameMode.challenge">
                <td colspan="4" align="center"><?php echo lang('label.game.menu.mode'); ?></td>
            </tr>
            <tr data-bind="visible: gameMode.challenge">
                <td align="right" style="padding-right:10px;"><?php echo lang('label.game.menu.bg'); ?></td>
                <td valign="top">
                    <input type="text" readonly="readonly" 
                           data-bind="value: menuScene().menu.modeMenu.menuPic().pic1, attr:{'title': menuScene().menu.modeMenu.menuPic().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                min="0" data-bind="value: menuScene().menu.modeMenu.menuPic().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                min="0" data-bind="value: menuScene().menu.modeMenu.menuPic().y"/></td>
                
                <td align="right" style="padding-right:10px;"><?php echo lang('label.game.back.area'); ?></td>
	            <td valign="top">
	                <?php echo lang('label.common.width'); ?>&nbsp;<input type="number" step="1" 
	                                min="0" data-bind="value: menuScene().menu.modeMenu.menuBack().width"/>
	                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" step="1"
	                                min="0" data-bind="value: menuScene().menu.modeMenu.menuBack().height"/>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                min="0" data-bind="value: menuScene().menu.modeMenu.menuBack().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                min="0" data-bind="value: menuScene().menu.modeMenu.menuBack().y"/>
                </td>
            </tr>
            <tr data-bind="visible: gameMode.challenge">
                <td align="right" style="padding-right:10px;"><?php echo lang('label.game.button.challenge'); ?></td>  
                <td valign="top">
                    <div style="display:inline;"><input type="text" readonly="readonly" 
                           data-bind="value: menuScene().menu.modeMenu.callengeIcon().pic1, attr:{'title': menuScene().menu.modeMenu.callengeIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                min="0" data-bind="value: menuScene().menu.modeMenu.callengeIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                min="0" data-bind="value: menuScene().menu.modeMenu.callengeIcon().y"/>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: menuScene().menu.modeMenu.callengeIcon().pic2, attr:{'title': menuScene().menu.modeMenu.callengeIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td align="right" style="padding-right:10px;"><?php echo lang('label.game.button.practice'); ?></td>  
                <td valign="top">
                    <div style="display:inline;"><input type="text" readonly="readonly" 
                           data-bind="value: menuScene().menu.modeMenu.practiceIcon().pic1, attr:{'title': menuScene().menu.modeMenu.practiceIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                min="0" data-bind="value: menuScene().menu.modeMenu.practiceIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                min="0" data-bind="value: menuScene().menu.modeMenu.practiceIcon().y"/>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: menuScene().menu.modeMenu.practiceIcon().pic2, attr:{'title': menuScene().menu.modeMenu.practiceIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	           </td>
            </tr>
            <tr style="border-bottom:1px solid #ccc;">
                <td colspan="4" align="center"><?php echo lang('label.game.menu.level'); ?></td>
            </tr>
            <tr> 
                <td align="right" style="padding-right:10px;"><?php echo lang('label.game.menu.bg'); ?></td>
                <td valign="top">
                    <input type="text" readonly="readonly" 
                           data-bind="value: menuScene().menu.levelMenu.menuPic().pic1, attr:{'title': menuScene().menu.levelMenu.menuPic().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>&nbsp;
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                min="0" data-bind="value: menuScene().menu.levelMenu.menuPic().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                min="0" data-bind="value: menuScene().menu.levelMenu.menuPic().y"/>
	            </td>
	            <td align="right" style="padding-right:10px;"><?php echo lang('label.game.back.area'); ?></td>
                <td valign="top"><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" step="1" 
	                                min="0" data-bind="value: menuScene().menu.levelMenu.menuBack().width"/>
	                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" step="1"
	                                min="0" data-bind="value: menuScene().menu.levelMenu.menuBack().height"/>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                min="0" data-bind="value: menuScene().menu.levelMenu.menuBack().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                min="0" data-bind="value: menuScene().menu.levelMenu.menuBack().y"/>
	               </td>
            </tr>
            <tr>
               <td align="right" style="padding-right:10px;"><?php echo lang('label.game.button.level'); ?></td>
               <td colspan="3" data-bind="foreach: menuScene().menu.levelMenu.levelItems">
                    <div style="display:inline"><?php echo lang('label.game.button.pic1'); ?><input type="text" readonly="readonly" data-bind="value: pic1, attr:{'title':pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>&nbsp;
	                <div style="display:inline"><?php echo lang('label.game.button.pic2'); ?><input type="text" readonly="readonly" data-bind="value: pic2, attr:{'title':pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                     &nbsp;X&nbsp;<input type="number" name="x" step="1" min="0" data-bind="value: x"/>
	                     &nbsp;Y&nbsp;<input type="number" name="y"  step="1"min="0" data-bind="value: y"/>
	                     &nbsp;<?php echo lang('label.game.button.enter'); ?>&nbsp;
	                     <select data-bind="value: action, options: $root.levelScenes, optionsText: 'name',optionsValue:'id'"></select>
	                <div></div>
                </td>
            </tr>
            </table></td></tr>
            </tbody>
            <!-- ========================= 关卡场景 ======================== -->
            <tbody id="vo_levelScene" data-bind="visible: checkScene() == '3'">
             <tr class="title_bar"  style="height:10px; background-color:#ccc;cursor:pointer;">
                <td class="title"><?php echo lang('label.common.scene.name'); ?></td>
                <td><span data-bind="text: levelScene().name"></span></td>
                <td colspan="4" align="right" style="padding-right:30px;"><span class="ui-icon ui-icon-extlink"></span></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: levelScene().bgPic, attr:{'title': levelScene().bgPic}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
	            <td class="title"><?php echo lang('label.background.sound'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: levelScene().bgSound, attr:{'title': levelScene().bgSound}"  
	                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></td>
	            
	            <td class="title"><?php echo lang('label.game.quest.time'); ?></td>
                <td><input type="number" step="1" min="0" data-bind="value: levelScene().timeStay"/>s</td>
            </tr>
            <tr>
           	    <td class="title"><?php echo lang('label.game.readygo.image'); ?></td>
                <td ><div style="display:inline-block"><input type="text" readonly="readonly" 
                           data-bind="value: levelScene().readyGoIcon().pic1, attr:{'title': levelScene().readyGoIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
                </td>
                <td class="title"><?php echo lang('label.game.total.time'); ?></td>
                <td><input type="number" step="1" min="0" data-bind="value: levelScene().timeLimit"/>s</td>
                <td class="title"><?php echo lang('label.game.direction'); ?></td>
                <td><select data-bind="value: levelScene().direction">
                    <option value="LR"><?php echo lang('label.common.direction.lr'); ?></option>
                    <option value="RL"><?php echo lang('label.common.direction.rl'); ?></option>
                    <option value="TB"><?php echo lang('label.common.direction.tb'); ?></option>
                    <option value="BT"><?php echo lang('label.common.direction.bt'); ?></option>
                </select></td>
            </tr>
            <tr>
               <td class="title"><?php echo lang('label.game.readyImg.width'); ?></td>
               <td><input type="number" step="1" min="0" data-bind="value: levelScene().readyWidth"/></td>
               <td class="title"><?php echo lang('label.game.quest.number'); ?></td>
	           <td><input type="number" step="1" min="0" data-bind="value: levelScene().gameRounds"/></td>
	           <td class="title"><?php echo lang('label.game.column'); ?></td>
               <td><input type="number" step="1" max="7" min="3" data-bind="value: levelScene().gameColomn"/></td>
            </tr>
            <tr style="border-top: 1px solid #ccc;">
                <td rowspan="4" class="title" valign="top"><?php echo lang('label.game.wordArea'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: levelScene().wordRect().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: levelScene().wordRect().y"/>
	            </td>
                <td rowspan="4" class="title" valign="top"><?php echo lang('label.game.timeArea'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: levelScene().timeText().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: levelScene().timeText().y"/></td>
                <td rowspan="4" class="title" valign="top"><?php echo lang('label.game.scoreArea'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: levelScene().scoreText().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: levelScene().scoreText().y"/></td>
            </tr>
            <tr>
                <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: levelScene().wordRect().width"/>
	                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: levelScene().wordRect().height"/></td>
            </tr>
            <tr>
                <td><?php echo lang('label.common.font'); ?>&nbsp;<select data-bind="options: textArray, value: levelScene().wordText().fontFamily"></select></td>
                <td><?php echo lang('label.common.font'); ?>&nbsp;<select data-bind="options: textArray,value: levelScene().timeText().fontFamily"></select></td>
                <td><?php echo lang('label.common.font'); ?>&nbsp;<select data-bind="options: textArray,value: levelScene().scoreText().fontFamily"></select></td>
            </tr>
            <tr>
                <td><?php echo lang('label.common.color'); ?>&nbsp;<input class="short mocool_color_picker" data-bind="value: levelScene().wordText().rgb, style:{ backgroundColor: 'rgba(' + levelScene().wordText().rgb() + ',1)', }"/>
                    &nbsp;<?php echo lang('label.common.font.size'); ?><input type="number" step="1"  min="0" data-bind="value: levelScene().wordText().size"/>
                </td>
                
                <td><?php echo lang('label.common.color'); ?>&nbsp;<input class="short mocool_color_picker" data-bind="value: levelScene().timeText().rgb, style:{ backgroundColor: 'rgba(' + levelScene().timeText().rgb() + ',1)', }"/>
                    &nbsp;<?php echo lang('label.common.font.size'); ?><input type="number" step="1"  min="0" data-bind="value: levelScene().timeText().size"/>
                </td>
                <td><?php echo lang('label.common.color'); ?>&nbsp;<input class="short mocool_color_picker" data-bind="value: levelScene().scoreText().rgb, style:{ backgroundColor: 'rgba(' + levelScene().scoreText().rgb() + ',1)' }"/>
                    &nbsp;<?php echo lang('label.common.font.size'); ?><input type="number" step="1"  min="0" data-bind="value: levelScene().scoreText().size"/>
                </td>
            </tr>
            <tr style="border-top: 1px solid #ccc;">
                <td class="title" rowspan="2" valign="top"><?php echo lang('label.game.gameArea'); ?></td>
                <td>&nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: levelScene().gameRect().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: levelScene().gameRect().y"/></td>
	            <td class="title"><?php echo lang('label.game.answer.frames'); ?></td>
	            <td>
	                <?php echo lang('label.puzzle.col'); ?>&nbsp;<input type="number" step="1" min="1" data-bind="value: levelScene().gameAnswerSize.col"/>
	            </td>
	            <td class="title" rowspan="2"><?php echo lang('label.game.wordList'); ?></td>
	            <td rowspan="2"><textarea rows="3" cols="30"  data-bind="value: levelScene().gameWords"></textarea></td>
            </tr>
            <tr>
                <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: levelScene().gameRect().width"/>
	                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: levelScene().gameRect().height"/></td>
	           <td></td>
	           <td></td>
	           
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.quest.imageList'); ?></td>
                <td rowspan="3">
                    <input type="button" value="<?php echo lang('label.button.add'); ?>" data-bind="click: function() { levelScene().addOption('images','gameQuestions')}"/>
                    <input type="button" value="<?php echo lang('label.button.del'); ?>" data-bind="click: function() { levelScene().delOption('gameQuestions','gameQuestions')}"/>
                    <input type="button" data-bind="click: function() { levelScene().moveUp('gameQuestions','gameQuestions')}" value="<?php echo lang('label.button.up'); ?>"/>
                    <input type="button" data-bind="click: function() { levelScene().moveDown('gameQuestions','gameQuestions')}" value="<?php echo lang('label.button.down'); ?>"/><br/>
	                <select size="7" name="gameQuestions" style="width:170px;" data-bind="options: levelScene().gameQuestions, optionsTitle: 'value'"></select>
                </td>
	            <td class="title"><?php echo lang('label.game.answer.imageList'); ?></td>
                <td rowspan="3">
                    <input type="button" value="<?php echo lang('label.button.add'); ?>" data-bind="click: function() { levelScene().addOption('images','gameAnswers')}"/>
                    <input type="button" value="<?php echo lang('label.button.del'); ?>" data-bind="click: function() { levelScene().delOption('gameAnswers','gameAnswers')}"/>
                    <input type="button" data-bind="click: function() { levelScene().moveUp('gameAnswers','gameAnswers')}" value="<?php echo lang('label.button.up'); ?>"/>
                    <input type="button" data-bind="click: function() { levelScene().moveDown('gameAnswers','gameAnswers')}" value="<?php echo lang('label.button.down'); ?>"/><br/>
	                <select size="7" name="gameAnswers" style="width:170px;" data-bind="options: levelScene().gameAnswers, optionsTitle: 'value'"></select>
                </td>
	            <td class="title"><?php echo lang('label.game.sound.list'); ?></td>
	            <td rowspan="3">
	                <input type="button" value="<?php echo lang('label.button.add'); ?>" data-bind="click: function() { levelScene().addOption('audio','gameAudios')}"/>
                    <input type="button" value="<?php echo lang('label.button.del'); ?>" data-bind="click: function() { levelScene().delOption('gameAudios','gameAudios')}"/>
                    <input type="button" data-bind="click: function() { levelScene().moveUp('gameAudios','gameAudios')}" value="<?php echo lang('label.button.up'); ?>"/>
                    <input type="button" data-bind="click: function() { levelScene().moveDown('gameAudios','gameAudios')}" value="<?php echo lang('label.button.down'); ?>"/><br/>
	                <select size="7" name="gameAudios" style="width:170px;" data-bind="options: levelScene().gameAudios, optionsTitle: 'value'"></select>
	            </td>
            </tr>
            </tbody>
            
            <!-- ========================= 通关场景 ======================== -->
            <tbody id="vo_succScene" data-bind="visible: checkScene() == '4'">
            <tr class="title_bar"  style="height:10px; background-color:#ccc;cursor:pointer;">
                <td class="title"><?php echo lang('label.common.scene.name'); ?></td>
                <td><span data-bind="text: succScene().name"></span></td>
                <td colspan="4" align="right" style="padding-right:30px;"><span class="ui-icon ui-icon-extlink"></span></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: succScene().bgPic, attr:{'title': succScene().bgPic}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.button.try'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: succScene().tryAgainIcon().pic1, attr:{'title': succScene().tryAgainIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: succScene().tryAgainIcon().pic2, attr:{'title': succScene().tryAgainIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: succScene().tryAgainIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: succScene().tryAgainIcon().y"/>
	            </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.button.score'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: succScene().scoreIcon().pic1, attr:{'title': succScene().scoreIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: succScene().scoreIcon().pic2, attr:{'title': succScene().scoreIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: succScene().scoreIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: succScene().scoreIcon().y"/>

	            </td>
            </tr>
            </tbody>
            
            <!-- ========================= 失败场景 ======================== -->
            <tbody id="vo_failScene" data-bind="visible: checkScene() == '5'">
            <tr class="title_bar"  style="height:10px; background-color:#ccc;cursor:pointer;">
                <td class="title"><?php echo lang('label.common.scene.name'); ?></td>
                <td><span data-bind="text: failScene().name"></span></td>
                <td colspan="4" align="right" style="padding-right:30px;"><span class="ui-icon ui-icon-extlink"></span></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: failScene().bgPic, attr:{'title': failScene().bgPic}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.button.try'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: failScene().tryAgainIcon().pic1, attr:{'title': failScene().tryAgainIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: failScene().tryAgainIcon().pic2, attr:{'title': failScene().tryAgainIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: failScene().tryAgainIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: failScene().tryAgainIcon().y"/>
	            </td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.game.button.score'); ?></td>
	            <td><div><input type="text" readonly="readonly" 
	                       data-bind="value: failScene().scoreIcon().pic1, attr:{'title': failScene().scoreIcon().pic1}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	                <div><input type="text" readonly="readonly" 
	                       data-bind="value: failScene().scoreIcon().pic2, attr:{'title': failScene().scoreIcon().pic2}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button></div>
	            </td>
	            <td class="title"><?php echo lang('label.axismove.btnposition'); ?></td>
	            <td>
	                &nbsp;X&nbsp;<input type="number" name="x" step="1" 
	                                max="<?php echo $bWidth; ?>" min="0" data-bind="value: failScene().scoreIcon().x"/>
	                &nbsp;Y&nbsp;<input type="number" name="y"  step="1"
	                                max="<?php echo $bHeight; ?>" min="0" data-bind="value: failScene().scoreIcon().y"/><br/>
	            </td>
            </tr>
            </tbody>
            
            <!-- ========================= 成绩场景 ======================== -->
            <tbody id="vo_scoreScene" data-bind="visible: checkScene() == '6'">
            <tr>
                <td class="title"><?php echo lang('label.common.scene.name'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: scoreScene().name"/></td>
            </tr>
            <tr>
                <td class="title"><?php echo lang('label.common.background'); ?></td>
                <td><input type="text" readonly="readonly" data-bind="value: scoreScene().bgPic, attr:{'title': scoreScene().bgPic}"  
	                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
	                <button class="mocool_file_cancel"><?php echo lang('label.common.cancel'); ?></button>
	            </td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <!-- div id="voTab-3">
    </div> -->
</div>
</div>
</div>