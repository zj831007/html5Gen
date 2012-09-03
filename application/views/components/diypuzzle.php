<script src="<?php echo base_url(); ?>js/components/diypuzzle-cmp.js"></script>
<script>
    $(function(){
        diypuzzleCanvas = null; //global define
        
        //上传背景图片start
        $("#diypuzzleBgPicFile").click(function(){
            openKCFinder({
                field:this,
                prefix: "img_",
                onComplete: function (url,size) {	
                    Chidopi.diypuzzle.model.bgpic(url);
                    var src = sys_vars.base_url + sys_vars.user_res_path + "/"+Chidopi.diypuzzle.model.bgpic();
                    //$("#lianliankan_canvas").css({"background-image":"url("+src+")","background-repeat":"no-repeat"});
                            
                    Chidopi.diypuzzle.model.width(size.w);
                    Chidopi.diypuzzle.model.height(size.h);
                    diypuzzleCanvas.setWidth(size.w);
                    diypuzzleCanvas.setHeight(size.h);
                    diypuzzleCanvas.backgroundImageStretch = false;
                    diypuzzleCanvas.setBackgroundImage(src, diypuzzleCanvas.renderAll.bind(diypuzzleCanvas));
                    
                }
            });
        });
        
        //上传背景图片end
        //上传连连图片start
        $("#diypuzzleIconPicFile").click(function(){
            openKCFinder({
                field:this,
                prefix: "img_",
                onComplete: function (url,size) {	
                    var src = sys_vars.base_url + sys_vars.user_res_path + "/"+url;

                            diypuzzle_createImage(src,url);
                            $("#diypuzzleIconPicFile").val("");
                }
            });
        });
        
        //上传连连图片end
        
        Chidopi.diypuzzle.init(sys_vars);
        
        //加载页面id并生成select option
        $.ajax({
            url:'<?php echo base_url(); ?>motionbox/loadpageInfo',
            data:{ 
                bookid: '<?php echo $bookid; ?>', 
                pageid: '<?php echo $pageid; ?>'
            },
            type: "POST",
            dataType: 'json',
            success: function (data, textStatus, jqXHR){
                var fragment = $("<select/>");
                for (var i in data){
                    fragment.append('<option value="' + data[i].id +'">' + data[i].title + '</option>');
                }
              
                $("#diypuzzle_succ_finish_sel").html(fragment);
            },
            error: function(jqXHR, textStatus, errorThrown){
                dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
            }
        });
        //生成 options结束
    });
    
    function diypuzzle_initCanvas(){
        if(diypuzzleCanvas == null){
            diypuzzleCanvas = new fabric.Canvas('diypuzzle_canvas',{ selection: false,backgroundImageStretch:false })
        }
        diypuzzleCanvas.setWidth(Chidopi.diypuzzle.model.width());
        diypuzzleCanvas.setHeight(Chidopi.diypuzzle.model.height());
        diypuzzleCanvas.clear();
        //初使化背景图
        if(Chidopi.diypuzzle.model.bgpic() != "") {
            var src = sys_vars.base_url + sys_vars.user_res_path + "/"+Chidopi.diypuzzle.model.bgpic();
            diypuzzleCanvas.backgroundImageStretch = false;
            diypuzzleCanvas.setBackgroundImage(src, diypuzzleCanvas.renderAll.bind(diypuzzleCanvas));
        }
        var points = Chidopi.diypuzzle.model.points;
 
        if(points != null && points!= undefined ){
            var len = points.length;
            for(var i=0; i<len; i++){
                var point = points[i];
                   
                switch(point.type){
                    case 'image':
                        (function(){
                            var reaUrl = point.src;
                            point.src= sys_vars.base_url + sys_vars.user_res_path + "/"+reaUrl;

                            var i = fabric.Image.fromObject(point,function(obj){
                                if(obj!=undefined && obj!= null){
                                    obj.hasControls = false;
                                    obj.relUrl = reaUrl;
                                    diypuzzleCanvas.add(obj);
                                }
                            });
                        })();
                        break;
                }
            }
        }
        
    }
    
    //上传小图片
    function diypuzzle_createImage(url, relUrl){
        var centerCoord = diypuzzleCanvas.getCenter();
        fabric.Image.fromURL(url, function(img) {
            oImg = img.set({ left: centerCoord.left, top: centerCoord.top,hasControls:false}) ;
            oImg.relUrl = relUrl;
            diypuzzleCanvas.add(oImg);
        });
    }
    
    function diypuzzle_clear_bgimg_click(){
        Chidopi.diypuzzle.model.bgpic("");
        $("#diypuzzleBgPicFile").val("");
        diypuzzleCanvas.setBackgroundImage("", diypuzzleCanvas.renderAll.bind(diypuzzleCanvas));
    }
    function diypuzzle_remove_click(){
        var activeObj = diypuzzleCanvas.getActiveObject();
        if(activeObj!=null){
            diypuzzleCanvas.remove(activeObj);
        }else{
            alert(Chidopi.lang.msg.diy_info1);
        }
    }
    //返回canvas 中所有对象
    function diypuzzle_get_all_objecs_from_canvas(){
        diypuzzleCanvas.deactivateAll()
        var objs = [];
        diypuzzleCanvas.forEachObject(function(obj) {
            var o = obj.toObject();
            if(o.type=="image" && obj.relUrl != undefined && obj.relUrl !=""){
                o.src = obj.relUrl;
            }
            objs.push(o);
        });

        return objs;
    }
    function _diypuzzle_succ_action(obj){
        var selV = $(obj).val();
        if(selV == "page"){
            $("#diypuzzle_succ_finish_lbl").show();
            $("#diypuzzle_succ_finish_sel").show();
        }else{
            $("#diypuzzle_succ_finish_lbl").hide();
            $("#diypuzzle_succ_finish_sel").hide();
        }
    }
</script>

<div id="diypuzzle_dialog" class="cmp_dialog" style="display:none">
    <table style="border:1px solid #CCC;">
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="text" data-bind="value: title" /></td>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td style="border-right:solid 1px #CCC;">&nbsp;X&nbsp;<input type="text" data-bind="value: x" class="short" />
                &nbsp;Y&nbsp;<input type="text" data-bind="value: y" class="short" />
            </td>
            <td class="title"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="text" data-bind="value: width"  class="short" />
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" data-bind="value: height"  class="short" />
            </td>
        </tr>


        <tr  style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.common.rightText'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" data-bind="value: rightText"></input>
            </td>
            <td class="title"><?php echo lang('label.common.finishText'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text"  data-bind="value: finishText"></input>
            </td>
            <td colspan="2" style=" text-align: center">
                <?php echo lang('label.common.font'); ?>
                <select style="width:70px;" data-bind="value: fontStyle">
                    <option value="Arial"><?php echo lang('label.font.Arial'); ?></option>
                    <option value="'Comic Sans MS'"><?php echo lang('label.font.Comic_Sans_MS'); ?></option>
                    <option value="'Courier New'"><?php echo lang('label.font.Courier_New'); ?></option>
                    <option value="Georgia"><?php echo lang('label.font.Georgia'); ?></option>
                    <option value="'Lucida Sans Unicode'"><?php echo lang('label.font.Lucida_Sans_Unicode'); ?></option>
                    <option value="Tahoma"><?php echo lang('label.font.Tahoma'); ?></option>
                    <option value="'Times New Roman'"><?php echo lang('label.font.Times_New_Roman'); ?></option>
                    <option value="'Trebuchet MS'"><?php echo lang('label.font.Trebuchet_MS'); ?></option>
                    <option value="Verdana"><?php echo lang('label.font.Verdana'); ?></option>
                </select>
                <?php echo lang('label.common.color'); ?>
                <input type="color" onclick="_qa_color_sel(this)"  style="width:45px;" data-bind="value: fontColor"/>
                <?php echo lang('label.common.font.size'); ?><input type="number"  min="1" max="20" step="1" value="24" class="short" data-bind="value: fontSize"></input>px
            </td>
        </tr>   

        <tr>
            <td class="title"><?php echo lang('label.common.rightImg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:rightImg"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
            <td class="title"><?php echo lang('label.common.finishImg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:finishImg"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>

            <td class="title"><?php echo lang('label.diy.blockDis'); ?></td>
            <td>
                <select data-bind="value:blockDis">
                    <option value="rand"><?php echo lang('label.diy.blockDis.rand'); ?></option>
                    <option value="t"><?php echo lang('label.pos.top2'); ?></option>
                    <option value="b"><?php echo lang('label.pos.bottom2'); ?></option>
                    <option value="l"><?php echo lang('label.pos.left2'); ?></option>
                    <option value="r"><?php echo lang('label.pos.right2'); ?></option>
                </select>
                <?php echo lang('label.diy.timeRestart'); ?><input type="checkbox" data-bind="checked: timeRestart"/>
            </td>

        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.rightAudio'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:rightAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>

            <td class="title"><?php echo lang('label.common.finishAudio'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:finishAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>

            <td class="title"><?php echo lang('label.diy.timeLimit'); ?></td>
            <td>
                <input type="number"  min="1" max="20" step="1" value="1" class="short" data-bind="value:timeLimit"></input>
                <?php echo lang('label.common.minute'); ?>
                <?php echo lang('label.diy.scoreShow'); ?><input type="checkbox" data-bind="checked: scoreShow"/>
            </td>

        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.rightEffect'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <select data-bind="value:rightEffect">
                    <option value="0"><?php echo lang('label.diy.effect.none'); ?></option>
                    <option value="flow.gif"><?php echo lang('label.diy.effect.flower'); ?></option>
                    <option value="heart.gif"><?php echo lang('label.diy.effect.heart'); ?></option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.common.finishEffect'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <select data-bind="value:finishEffect">
                    <option value="0"><?php echo lang('label.diy.effect.none'); ?></option>
                    <option value="flow.gif"><?php echo lang('label.diy.effect.flower'); ?></option>
                    <option value="heart.gif"><?php echo lang('label.diy.effect.heart'); ?></option>
                </select>
            </td>
            <td class="title"><?php echo lang('label.common.succAction'); ?></td>
            <td>
                <select id="diypuzzle_succ_finish_action_sel" onChange="_diypuzzle_succ_action(this)" data-bind="value:succAction" >
                    <option value="0"><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
                <span id="diypuzzle_succ_finish_lbl"><?php echo lang('label.play.ended.pageto'); ?></span> <span id="diypuzzle_succ_finish_sel"><select></select></span>
                <?php echo lang('label.diy.retestShow'); ?><input type="checkbox" data-bind="checked: retestShow"/>
                <?php echo lang('label.common.jumpText'); ?><input type="text"  data-bind="value:jumpText"  />
            </td>
        </tr>

    </table>
    <br/>

    <div id="diypuzzle_container" style="display:inline-block;float: left;">
        <canvas id="diypuzzle_canvas" data-bind="attr:{width:width, height:height}"  style="border:1px solid red; "></canvas>
    </div>
    <div style="display:inline-block; padding: 4px;width: 70px; height: 200px; border: 1px solid red; margin-left: 5px; float: left;">

        <p>
            <?php echo lang('label.common.bg.pic'); ?><br/>
            <input type="text" readonly="readonly"  id="diypuzzleBgPicFile"  name="diypuzzleBgPicFile"  
                   placeholder="<?php echo lang('label.common.bg.pic'); ?>" class="upload" style="width:70px"/>    
        </p>
        <p>
            <input type="button" value="<?php echo lang('label.common.bg.clear'); ?>" style="width:70px;" onclick="diypuzzle_clear_bgimg_click()">
        </p>
        <p>
            <?php echo lang('label.common.icon.pic'); ?><br/>
            <input type="text" readonly="readonly"  id="diypuzzleIconPicFile"  name="diypuzzleIconPicFile"  
                   placeholder="<?php echo lang('label.common.icon.pic'); ?>" style="width:70px" class="upload"/>  
        </p>
        <p>
            <input type="button" value="<?php echo lang('label.common.icon.clear'); ?>" style="width:70px;" onclick="diypuzzle_remove_click()">
        </p>
    </div>
</div>