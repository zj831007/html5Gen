<style>
.cmp_dialog .title{ width:100px;}
</style>
<script>
var bg_display;

$(function(){
	
bg_display = "<?php echo $display ?>";

if(bg_display == "show"){
	
    $("#bg_dialog").show();	
	$("#tmp_bWidth").val($("#bWidth").val());
	$("#tmp_bHeight").val($("#bHeight").val());
	$("#tmp_bSize, #tmp_bColor").change(function(){
		if(typeof(updateBackgroundArea) == "function"){
		    updateBackgroundArea();
		}
	});
	
}else{
		
	$("#bar_background").click(function(){
		$("#bg_dialog").dialog("open");
	});
		
	$("#bg_dialog").dialog({
		autoOpen: false, 
		title: Chidopi.lang.title.background,
		width:400,
		height:400,
		modal: true,
		buttons: [
		    {
			text  : Chidopi.lang.btn.ok,
			click : function() { 
			  // set value and call update
			  $("#bFileName").val($("#tmp_bFileName").val()).attr("title",$("#tmp_bFile").val());
			  //$("#bSize").val($("#tmp_bSize").val());
			  $("#bColor").val($("#tmp_bColor").val());
			  $("#hColor").val($("#tmp_hColor").val());
			  $("#bsFileName").val($("#tmp_bsFileName").val()).attr("title",$("#tmp_bsFile").val());
			  $("#bsLoop").val($("#tmp_bsLoop").attr("checked"));
			  $("#bLoadAction").val($("#tmp_bLoadAction").val());
			  $("#bUnLoadAction").val($("#tmp_bUnLoadAction").val());
			  $("#bPageWidth").val($("#tmp_bPageWidth").val());
			  $("#bPageHeight").val($("#tmp_bPageHeight").val());
			  $("#bPageScale").val($("#tmp_bPageScale").val());
			  if(typeof(updateBackgroundArea) == "function"){
				  updateBackgroundArea();
			  }
			  
			  $(this).dialog("close");
		  } 
		  },
		  {
		  text  : Chidopi.lang.btn.cancel,
		  click : function() {$(this).dialog("close");}
		  }
		],
		
		open: function(){
			// init
			if($("#bFileName").attr("title"))
			    $("#tmp_bFile").val($("#bFileName").attr("title"));
			else 
			    $("#tmp_bFile").val($("#bFileName").val());
				
			if( $("#bsFileName").attr("title") )
 			    $("#tmp_bsFile").val($("#bsFileName").attr("title"));
		    else 
			    $("#tmp_bsFile").val($("#bsFileName").val());
				
			$("#tmp_bFileName").val($("#bFileName").val());
			//$("#tmp_bSize").val($("#bSize").val());
			$("#tmp_bWidth").val($("#bWidth").val());
			$("#tmp_bHeight").val($("#bHeight").val());
			$("#tmp_bPageWidth").val($("#bPageWidth").val());
			$("#tmp_bPageHeight").val($("#bPageHeight").val());
			$("#tmp_bPageScale").val($("#bPageScale").val());
			$("#tmp_bColor").val($("#bColor").val());
			$("#tmp_hColor").val($("#hColor").val());
			$("#tmp_bsFileName").val($("#bsFileName").val());
			$("#tmp_bsLoop").attr( "checked", ( $("#bsLoop").val() === 'true' ) );
			$("#tmp_bLoadAction").val( $("#bLoadAction").val() );
			$("#tmp_bUnLoadAction").val( $("#bUnLoadAction").val() );
		}
	});
}
	/* ------------------- Background Upload -----------------------  */
	$("#tmp_bFileName").click(function(){
	    openKCFinder({
			field:this,
			prefix: sys_vars.bookid+"_"+sys_vars.pageid+"_bg_"
		});
	});
	
	$("#btn_bCancel").click(function(){
		$("#tmp_bFileName").val('');
		if(bg_display == "show" && typeof(updateBackgroundArea) == "function"){
			updateBackgroundArea();
		}
	});
	/* ------------------- Background Upload End -----------------------  */
	
	/* ------------------- Background Sound Upload -----------------------  */
	$("#tmp_bsFileName").click(function(){
		 openKCFinder({
			field:this,
			type: "audio",
			prefix: sys_vars.bookid+"_"+sys_vars.pageid+"_bgSound_"
		});	
	});
	
	$("#btn_bsCancel").click(function(){
		$("#tmp_bsFileName").val('');
	});
	/* ------------------- Background Sound Upload End  -----------------------  */
	
	
	$("#tmp_bColor, #tmp_hColor").each(function(){
		var obj =   $(this)
		obj.ColorPicker({
			livePreview: false,
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				$(colpkr).css("z-index","99999");
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				$(colpkr).css("z-index","auto");
				obj.change();
				return false;
			},
			onChange: function (hsb, hex, rgb) {					
				obj.css('backgroundColor', '#' + hex);
				obj.val('#' + hex);
			}
		});			
	
	});


	$("#tmp_bPageScale").change(function(){
        var $_this = $(this);
        var scale = $_this.val().split(":");
        $("#tmp_bPageWidth").val($("#tmp_bWidth").val() * scale[0]);
        $("#tmp_bPageHeight").val($("#tmp_bHeight").val() * scale[1]);
    });
});
</script>

<div id="bg_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.background.device.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?><input type="text" readonly="readonly" class="short" id="tmp_bWidth" />
                <?php echo lang('label.common.height'); ?><input type="text" readonly="readonly" class="short" id="tmp_bHeight" />
                   <!--select id="tmp_bSize" name="tmp_bSize">
                    <option value="0">1024x768</option>
                    <option value="1">&nbsp;&nbsp;854x480</option>
                    <option value="2">1024x600</option>
                    <option value="3">&nbsp;&nbsp;800x600</option>
                </select-->
            </td>
        </tr>
        <tr>
            <td class="title" valign="top"><?php echo lang('label.background.page.size'); ?></td>
            <td><select id="tmp_bPageScale">
                    <option value="1:1"><?php echo lang('label.background.size.1x1'); ?></option>
                    <option value="2:1"><?php echo lang('label.background.size.2x1'); ?></option>
                    <option value="1:2"><?php echo lang('label.background.size.1x2'); ?></option>
                    <option value="2:2"><?php echo lang('label.background.size.2x2'); ?></option>
                </select><br/>
                <?php echo lang('label.common.width'); ?><input type="text" readonly="readonly" class="short" id="tmp_bPageWidth" />
                <?php echo lang('label.common.height'); ?><input type="text" readonly="readonly" class="short" id="tmp_bPageHeight" />
            </td>
        </tr>
        <tr>        
            <td width="80" class="title"><?php echo lang('label.background.picture'); ?></td>
            <td><input type="text" readonly="readonly" id="tmp_bFileName" name="tmp_bFileName" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>
                <input type="button" id="btn_bCancel" value="<?php echo lang('label.common.cancel'); ?>"/>               
           </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.bgcolor'); ?></td>
            <td><input type="text" readonly="readonly" id="tmp_bColor" name="tmp_bColor" value="#FFFFFF"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.background.html.color'); ?></td>
            <td><input type="text" readonly="readonly" id="tmp_hColor" name="tmp_hColor" value="#000000"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.background.sound'); ?></td>
            <td><input type="text" readonly="readonly" id="tmp_bsFileName" name="tmp_bsFileName" 
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload"/>
                <input type="button" id="btn_bsCancel" value="<?php echo lang('label.common.cancel'); ?>"/>               
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.background.sound.loop'); ?></td>
            <td><input type="checkbox" value="loop" id="tmp_bsLoop" name="tmp_bsLoop"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.animation.load'); ?></td>
            <td>
                <select id="tmp_bLoadAction" name="tmp_bLoadAction">
                    <option value="">--</option>
                    <option value="flash"><?php echo lang('label.animation.load.flash'); ?></option>
                    <optgroup label="<?php echo lang('label.animation.load.group.flip'); ?>">
                    <option value="flip"><?php echo lang('label.animation.load.flip'); ?></option>
                    <option value="flipInX"><?php echo lang('label.animation.load.flipInX'); ?></option>
                    <option value="flipInY"><?php echo lang('label.animation.load.flipInY'); ?></option>
                    </optgroup>
                    <optgroup label="<?php echo lang('label.animation.load.group.fadeIn'); ?>">
                    <option value="fadeIn"><?php echo lang('label.animation.load.fadeIn'); ?></option>
                    <option value="fadeInUpBig"><?php echo lang('label.animation.load.fadeInUpBig'); ?></option>
                    <option value="fadeInDownBig"><?php echo lang('label.animation.load.fadeInDownBig'); ?></option>
                    <option value="fadeInLeftBig"><?php echo lang('label.animation.load.fadeInLeftBig'); ?></option>
                    <option value="fadeInRightBig"><?php echo lang('label.animation.load.fadeInRightBig'); ?></option>
                    </optgroup>
                    <optgroup label="<?php echo lang('label.animation.load.group.rotate'); ?>">
                    <option value="rotateIn"><?php echo lang('label.animation.load.rotateIn'); ?></option>
                    <option value="rotateInDownLeft"><?php echo lang('label.animation.load.rotateInDownLeft'); ?></option>
                    <option value="rotateInDownRight"><?php echo lang('label.animation.load.rotateInDownRight'); ?></option>
                    <option value="rotateInUpLeft"><?php echo lang('label.animation.load.rotateInUpLeft'); ?></option>
                    <option value="rotateInUpRight"><?php echo lang('label.animation.load.rotateInUpRight'); ?></option>
                    <option value="rollIn"><?php echo lang('label.animation.load.rollIn'); ?></option>
                    </optgroup>
                </select>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.animation.unload'); ?></td>
            <td>
                <select id="tmp_bUnLoadAction" name="tmp_bUnLoadAction">
                    <option value="">--</option>
                    <optgroup label="<?php echo lang('label.animation.unload.group.filpOut'); ?>">
                    <option value="flipOutX"><?php echo lang('label.animation.unload.flipOutX'); ?></option>
                    <option value="flipOutY"><?php echo lang('label.animation.unload.flipOutY'); ?></option>
                    </optgroup>
                    <optgroup label="<?php echo lang('label.animation.unload.group.fadeOut'); ?>">
                    <option value="fadeOut"><?php echo lang('label.animation.unload.fadeOut'); ?></option>
                    <option value="fadeOutUpBig"><?php echo lang('label.animation.unload.fadeOutUpBig'); ?></option>
                    <option value="fadeOutDownBig"><?php echo lang('label.animation.unload.fadeOutDownBig'); ?></option>
                    <option value="fadeOutLeftBig"><?php echo lang('label.animation.unload.fadeOutLeftBig'); ?></option>
                    <option value="fadeOutRightBig"><?php echo lang('label.animation.unload.fadeOutRightBig'); ?></option>
                    </optgroup>
                    <optgroup label="<?php echo lang('label.animation.unload.group.rotateOut'); ?>">
                    <option value="rotateOut"><?php echo lang('label.animation.unload.rotateOut'); ?></option>
                    <option value="rotateOutDownLeft"><?php echo lang('label.animation.unload.rotateOutDownLeft'); ?></option>
                    <option value="rotateOutDownRight"><?php echo lang('label.animation.unload.rotateOutDownRight'); ?></option>
                    <option value="rotateOutUpLeft"><?php echo lang('label.animation.unload.rotateOutUpLeft'); ?></option>
                    <option value="rotateOutUpRight"><?php echo lang('label.animation.unload.rotateOutUpRight'); ?></option>
                    <option value="rollOut"><?php echo lang('label.animation.unload.rollOut'); ?></option>
                    </optgroup>
                </select>
            </td>
        </tr>
    </table>   
</div>
