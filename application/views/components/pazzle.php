<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>

</style>
<script>
      
    //视图模型对象
    pazzleModel = {
        id:ko.observable(),
        title:ko.observable(),
        x:ko.observable(),
        y:ko.observable(),
        row:ko.observable(),
        col:ko.observable(),
        width:ko.observable(),
        height:ko.observable(),
        pazzlePics:ko.observableArray(),
        audios:ko.observableArray(),
        rewardPics:ko.observableArray(),
        succAudios:ko.observableArray(),
        succAction:ko.observable(),
        succActionPage:ko.observable(),
        jumpText:ko.observable(),
        zIndex:ko.observable()
    };
    
    $(function(){
        ko.applyBindings(pazzleModel, document.getElementById("pazzle_dialog"));
        
        $("#pazzle_dialog").dialog({
            title: Chidopi.lang.title.puzzle,
            autoOpen:false,
            width:500,
            height:600,
            modal: true,
            buttons:[
                {
            	text  : Chidopi.lang.btn.ok,
            	click : function(){
                    var id = pazzleModel.id();
                    var type = "pazzle";
                    var title = pazzleModel.title();
                    if(!title){
                        pazzleModel.title(id);
                    }
                    
                    if(!id){
                        //创建新的组件
                        id=  type + "_" + (++Global.number);	
                        pazzleModel.id(id);   //将id设置到model中
                        if(!title){
                            pazzleModel.title(id);
                        }
                        pazzleModel.zIndex(Global.number);
                        pazzleModel.succAction($("#pazzle_succ_action").find("select").val());
                        pazzleModel.succActionPage($("#pazzle_succ_action_page").find("select").val());
                        
                        var json = ko.toJSON(pazzleModel);
                        createComponent(id, type, json, title); //在左边列表中添加一个组件项,同时会生成一个隐藏域
                        //随机取一图片
                       
                        var picName = pazzleModel.pazzlePics()[0];
                        createPazzleComponent(id,  sys_vars.base_url + sys_vars.user_res_path + "/"  +picName,"","",pazzleModel.row(), pazzleModel.col(),pazzleModel.title(),pazzleModel.zIndex());
                    }else{
                        pazzleModel.succAction($("#pazzle_succ_action").find("select").val());
                        pazzleModel.succActionPage($("#pazzle_succ_action_page").find("select").val());
                        
                        //修改组件
                        var size = {width:pazzleModel.width(),height: pazzleModel.height()};
			
                        var json = ko.toJSON(pazzleModel);
                        updateComponent(id, type, json, title);	
                        var picName = pazzleModel.pazzlePics()[0];
                        updatePazzleComponent(id,   sys_vars.base_url + sys_vars.user_res_path + "/"  +picName, size, pazzleModel.row(), pazzleModel.col());
                        
                    }
                    //TODO 将pazzleModel中的值填充入hide input中
                    
                    
                    $(this).dialog("close");
                }
                },
                {
                text  : Chidopi.lang.btn.cancel,
                click : function(){$(this).dialog("close");}			
                }
            ],
            open: function(event, ui) {
                if(pazzleModel.succAction() == 0){
                    $("#pazzle_succ_action_page").hide();
                }else{
                    $("#pazzle_succ_action_page").show();
                    $("#pazzle_succ_action_page").find("select").val(pazzleModel.succActionPage());
                }
            }

        });
        $("#bar_pazzle").click(function(){
            //点击工具条按钮时，初始化pazzleModel
            pazzleModel.id("");
            pazzleModel.title("");
            pazzleModel.x(0);
            pazzleModel.y(0);
            pazzleModel.row(3);
            pazzleModel.col(3);
            pazzleModel.width(100);
            pazzleModel.height(100);
            
            pazzleModel.pazzlePics([]);
            pazzleModel.audios([]);
            pazzleModel.rewardPics([]);
            pazzleModel.succAudios([]);
            pazzleModel.succAction(0);
            pazzleModel.jumpText("Jump");
            pazzleModel.zIndex("");
            $("#pazzle_dialog").dialog("open");		
        });
	
        //上传拼图图片
        $("#pazzlePicFile").click(function(){
            $this = $(this);
            openKCFinder({
                field:this,
                prefix: "img_",
                onComplete: function (url,size) {					
                    pazzleModel.width(size.w);
                    pazzleModel.height(size.h);
                    pazzleModel.pazzlePics.push(url);
                    $this.val("");
                }
            });
        });
        
        //上传拼图图片end 
        
        
        //上传奖励图片
        $("#pazzleRewardPicFile").click(function(){
            $this = $(this);
            openKCFinder({
                field:this,
                prefix: "img_",
                onComplete: function (url,size) {					
                    pazzleModel.width(size.w);
                    pazzleModel.height(size.h);
                    pazzleModel.rewardPics.push(url);
                    $this.val("");
                }
            });
        });
        
        //上传奖励图片end
        
        //上传移动音效
        $("#pazzleMoveAudioFile").click(function(){
            $this = $(this);
            openKCFinder({
                field:this,
                type: "audio",
                prefix: "audio_",
                onComplete: function (url,size) {					
                    pazzleModel.audios.push(url);
                    $this.val("");
                }
            });
        });
        
        //上传移动音效end
        
        //上传完成音效
        $("#pazzleSuccAudioFile").click(function(){
            $this = $(this);
            openKCFinder({
                field:this,
                type: "audio",
                prefix: "audio_",
                onComplete: function (url,size) {					
                    pazzleModel.succAudios.push(url);
                    $this.val("");
                }
            });
        });
        
        //上传完成音效end
        
        //完成动作相关dom元素操作
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
                $("#pazzle_succ_action_page").find("select").append(fragment.html());
            },
            error: function(jqXHR, textStatus, errorThrown){
                dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
            }
        });
        //生成 options结束
        
    });
    //删除拼图列表中的选中项
    function _pazzle_del_pazzlepic(obj){
        var sel = $(obj).parent().find("select").val();
        if(sel){
            pazzleModel.pazzlePics.remove(sel);
        }
    }
    //删除奖励拼图列表中的选中项
    function _pazzle_del_pazzlerewardpic(obj){
        var sel = $(obj).parent().find("select").val();
        if(sel){
            pazzleModel.rewardPics.remove(sel);
        }
    }
    //删除移动音效列表中的选中项
    function _pazzle_del_pazzlemoveaudio(obj){
        var sel = $(obj).parent().find("select").val();
        if(sel){
            pazzleModel.audios.remove(sel);
        }
    }
    
    //删除完成音效列表中的选中项
    function _pazzle_del_pazzlesuccaudio(obj){
        var sel = $(obj).parent().find("select").val();
        if(sel){
            pazzleModel.succAudios.remove(sel);
        }
    }
    //选择完成音效
    function _pazzle_succ_action(obj){
        var selV = $(obj).val();
        if(selV == "page"){
            $("#pazzle_succ_action_page").show();
        }else{
            $("#pazzle_succ_action_page").hide();
        }
    }
</script>
<div id="pazzle_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" data-bind="value: title" /></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.pic'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="pazzlePicFile" name="pazzlePicFile" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>

            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.pics'); ?></td>
            <td><select size="3" style="width:200px;" data-bind="options: pazzlePics"></select>
            <input type="button" value="<?php echo lang('label.common.delete'); ?>" onclick="_pazzle_del_pazzlepic(this)"/> </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.reward.pic'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="pazzleRewardPicFile" name="pazzleRewardPicFile" 
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload"/>

            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.reward.pics'); ?></td>
            <td><select size="3" style="width:200px;" data-bind="options: rewardPics"></select>
            <input type="button" value="<?php echo lang('label.common.delete'); ?>" onclick="_pazzle_del_pazzlerewardpic(this)" /></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.move.audio'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="pazzleMoveAudioFile" name="pazzleMoveAudioFile" 
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload"/>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.move.audios'); ?></td>
            <td><select size="3" style="width:200px;" data-bind="options: audios"></select>
            <input type="button" value="<?php echo lang('label.common.delete'); ?>" onclick="_pazzle_del_pazzlemoveaudio(this)"/></td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.succ.audio'); ?></td>
            <td>
                <input type="text" readonly="readonly" id="pazzleSuccAudioFile" name="pazzleSuccAudioFile" 
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload"/>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.succ.audios'); ?></td>
            <td><select size="3" style="width:200px;" data-bind="options: succAudios"></select>
            <input type="button" value="<?php echo lang('label.common.delete'); ?>" onclick="_pazzle_del_pazzlesuccaudio(this)"/></td>
        </tr>
        <tr id="pazzle_succ_action">
            <td class="title"><?php echo lang('label.common.succAction'); ?></td>
            <td>
                <select onChange="_pazzle_succ_action(this)" data-bind="value:succAction">
                    <option value="0"><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
            </td>
        </tr>
        <tr id="pazzle_succ_action_page">
            <td class="title"><?php echo lang('label.play.ended.pageto'); ?></td>
            <td>
                <select></select>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.jumpText'); ?></td>
            <td><input type="text" data-bind="value: jumpText"  class="short" />
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.puzzle.split'); ?></td>
            <td><?php echo lang('label.puzzle.row'); ?>&nbsp;<input type="number" min="3" max="9" step="1" data-bind="value: row"  class="short" />
                <?php echo lang('label.puzzle.col'); ?>&nbsp;<input type="number" min="3" max="9" step="1" data-bind="value: col"  class="short" />
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="text" data-bind="value: x" class="short" readonly="readonly"/>
                &nbsp;Y&nbsp;<input type="text" data-bind="value: y" class="short" readonly="readonly"/>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="text" data-bind="value: width"  class="short" readonly="readonly"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" data-bind="value: height"  class="short" readonly="readonly"/>
            </td>
        </tr>
    </table>

</div>