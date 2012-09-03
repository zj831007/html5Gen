<script src="<?php echo base_url(); ?>js/components/video-cmp.js"></script>
<script>
var video_display;
$(function(){
video_display = "<?php echo $display ?>";
if(video_display == "show"){
	
    $("#video_dialog").show();	

	var fragment = $("<select/>");
	var sel_page = $("#vPage");
	var page_value = sel_page.val();
	$.ajax({
	    url:'<?php echo base_url();?>motionbox/loadpageInfo',
		data:{ 
		     bookid: '<?php echo $bookid; ?>', 
			 pageid: '<?php echo $pageid; ?>'
		},
		type: "POST",
		dataType: 'json',
		success: function (data, textStatus, jqXHR){
			for (var i in data){
				fragment.append('<option value="' + data[i].id +'">' + data[i].title + '</option>');
			}
			sel_page.append(fragment.html());
			sel_page.val(page_value);
			updateDisplayArea();
			updateActionArea();
		},
		error: function(jqXHR, textStatus, errorThrown){
		    dialog.alert("Error" , jqXHR.responseText);
		}
	});
	
}else{
    Chidopi.Video.init(sys_vars);
}
});



</script>
<div id="video_dialog" class="cmp_dialog" style="display:none">
    <table>
        <?php if( !isset($display) ) {?>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" name="vTitle" id="vTitle"/></td>
        </tr>
        <?php } ?>
        <tr>
            <td class="title"><?php echo lang('label.common.video'); ?></td>
            <td><select name="vFileType" id="vFileType">
                    <option value="file"><?php echo lang('label.video.type.file'); ?></option>
                    <option value="url"><?php echo lang('label.video.type.url'); ?></option>
                </select>
                <?php echo lang('label.video.info'); ?>
            </td>
        </tr>
        <tr id="tr_vFileName">
            <td></td>
            <td>
                <input type="text" readonly="readonly" id="vFileName" name="vFileName" 
                       placeholder="<?php echo lang('label.common.choose.video'); ?>" class="upload"/> 
                <?php if( !isset($display) ) {?> 
                <button id="btn_vCancel"><?php echo lang('label.common.cancel'); ?></button>
                <?php } ?>
            </td>
        </tr>
        <tr id="tr_vUrl">
            <td></td>
            <td><input type="text" id="vUrl" name="vUrl" style="width:200px;"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.video.poster'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="vPFileName" name="vPFileName" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/> 
                <?php if( !isset($display) ) {?> 
                <button id="btn_vPCancel"><?php echo lang('label.common.cancel'); ?></button>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.video.control'); ?></td>
            <td><input id="vControl" name="vControl" type="checkbox"  value="controls"/></td>
        </tr>
        <!--tr>
            <td class="title">音量</td>
            <td><input type="range" onchange='$("#vVolumeInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="0.5" max="1" min="0" step="0.1" id="vVolume" name="vVolume">
                <span id="vVolumeInfo"></span></td>
        </tr-->
        <tr>
             <td class="title"><?php echo lang('label.video.auto'); ?></td>
             <td><input id="vAuto" name="vAuto" type="checkbox" value="autoplay"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.video.window'); ?></td>
            <td><select id="vScreen" name="vScreen">
            <option value=""><?php echo lang('label.video.window.normal'); ?></option>
            <option value="full"><?php echo lang('label.video.window.full'); ?></option>
    		</select></td>
       </tr>
       <tr>
           <td class="title"><?php echo lang('label.common.initial.status'); ?></td>
           <td><select id="vDisplay" name="vDisplay">
            <option value=""><?php echo lang('label.common.status.display'); ?></option>
            <option value="none"><?php echo lang('label.common.status.hidden'); ?></option>
   		   </select></td>
        </tr>
        <tr id="video_area1">
            <td class="title"><?php echo lang('label.common.button.display'); ?></td>
            <?php if( !isset($display) ) {?>
            <td><select id="vButton" name="vButton"></select></td>
            <?php } else {?>
            <td><input type="text" readonly="readonly" id="vButton" placeholder="點擊設定" name="vButton" /></td>
            <?php } ?>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.play.ended'); ?></td>
            <td><select id="vEndAction" name="vEndAction">
                 <option value=""><?php echo lang('label.play.ended.nothing'); ?></option>
                 <option value="hide"><?php echo lang('label.play.ended.hide'); ?></option>
                 <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
               </select>
            </td>
        </tr>
        <tr id="video_area2">
            <td class="title"><?php echo lang('label.play.ended.pageto'); ?></td>
            <td> <select id="vPage" name="vPage"></select></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.animation.setting'); ?></td>
            <td>
                <?php echo lang('label.animation.in'); ?>&nbsp;<input id="vLoadAction" name="loadAction" type="checkbox" value="1"/>&nbsp;&nbsp;&nbsp;
                <?php echo lang('label.animation.out'); ?>&nbsp;<input id="vHideAction" name="hideAction" type="checkbox" value="1"/>                
            </td>
        </tr>
        <tr id="tr_video_load_action" style="border-top:1px dashed #CCC">
            <td class="title"><?php echo lang('label.animation.in'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.in'); ?>
                <select id="vLoadPos" name="loadPos">
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
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="vLoad2D" name="load2D" type="number" min="-1080" max="1080" step="45" />                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="vLoad3DX" name="load3DX" type="number" min="-1080" max="1080" step="45"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="vLoad3DY" name="load3DY" type="number" min="-1080" max="1080" step="45"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="vLoadSpeedInfo"></span>
                <input type="range" onchange='$("#vLoadSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="vLoadSpeed" name="loadSpeed">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="vLoadOpacityInfo"></span>
                <input type="range" onchange='$("#vLoadOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="vLoadOpacity" name="loadOpacity">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="vLoadDelayInfo"></span>
                <input type="range" onchange='$("#vLoadDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="vLoadDelay" name="loadDelay">
            </td>
        </tr>
        <tr id="tr_video_hide_action" style="border-top:1px dashed #CCC">
            <td class="title"><?php echo lang('label.animation.out'); ?></td>
            <td>
                <?php echo lang('label.animation.orientation.out'); ?>
                <select id="vHidePos" name="hidePos">
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
                <?php echo lang('label.animation.rotate.2d'); ?>&nbsp;<input id="vHide2D" name="hide2D" type="number" min="-1080" max="1080" step="45" />                
                <br/>
                <?php echo lang('label.animation.rotate.3d'); ?>&nbsp;
                <?php echo lang('label.animation.top_bottom'); ?><input id="vHide3DX" name="hide3DX" type="number" min="-1080" max="1080" step="45"/> &nbsp;&nbsp;
                <?php echo lang('label.animation.left_right'); ?><input id="vHide3DY" name="hide3DY" type="number" min="-1080" max="1080" step="45"/>
                <br/>
                <?php echo lang('label.animation.speed'); ?>&nbsp;<span id="vHideSpeedInfo"></span>
                <input type="range" onchange='$("#vHideSpeedInfo").html(parseFloat(this.value).toFixed(1) + "s");'
                       max="15.0" min="0" step="0.1" id="vHideSpeed" name="hideSpeed">
                <br/>
                <?php echo lang('label.animation.alpha'); ?><span id="vHideOpacityInfo"></span>
                <input type="range" onchange='$("#vHideOpacityInfo").html(parseFloat(this.value).toFixed(1));' 
                       value="1.0" max="1" min="0" step="0.1" id="vHideOpacity" name="hideOpacity">
                <br/>
                <?php echo lang('label.animation.delay'); ?><span id="vHideDelayInfo"></span>
                <input type="range" onchange='$("#vHideDelayInfo").html(parseFloat(this.value).toFixed(1) + "s");' 
                       value="0" max="10" min="0" step="0.5" id="vHideDelay" name="hideDelay">
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>X&nbsp;<input type="number" id="vPX" name="vPX" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                Y&nbsp;<input type="number" id="vPY" name="vPY" step="1" max="<?php echo $bHeight; ?>" min="0"/>
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="number" id="vWidth" name="vWidth" step="1" max="<?php echo $bWidth; ?>" min="0"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="number" id="vHeight" name="vHeight" step="1" max="<?php echo $bHeight; ?>" min="0"/>
               <br/><?php echo lang('label.common.ratio'); ?>&nbsp;<input id="vAspectRatio" name="aspectRatio" type="checkbox" value="1" checked="checked"/>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" id="video_id"/>
    <input type="hidden" id="video_zindex" name="zIndex" />
</div>