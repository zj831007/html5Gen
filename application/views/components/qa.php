<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .qa_table_style{
        border: #666 1px solid;
        margin-bottom: 3px;
    }
    .qa_table_style tr{
        border: #666 1px solid;
    }
    .qa_table_style td{
        padding-left: 4px;
    }
</style>
<script>
      
    //视图模型对象
    qaViewModel = {
        id:ko.observable(),
        title:ko.observable(),
        x:ko.observable(),
        y:ko.observable(),
        width:ko.observable(),
        height:ko.observable(),
        bgPic:ko.observable(), //背景图片
        bgColor:ko.observable(),//北京颜色
        flipPage:ko.observable(),//翻页效果
        scoreType:ko.observable(),//计分方式
        rightEvent:ko.observable(),//答对事件 留在 跳到下一页
        rightAudio:ko.observable(),//答对音效
        rightPic:ko.observable(),//答对图片
        errorAudio:ko.observable(), //答错音效
        errorPic:ko.observable(),//答错图片
        finishAudio:ko.observable(),//完成音效
        confirmPic:ko.observable(),//确认图片
        finishAction:ko.observable("0"),//完成动作
        jumpPage:ko.observable(),//转页到
        jumpText:ko.observable(),
        topics:ko.observableArray([]),
        zIndex:ko.observable(),
        addTopic:function(){
            qaViewModel.topics.push({
                type:ko.observable(), //题目类型：单选 复选
                text:ko.observable(""), 
                fSize:ko.observable("medium"),
                font:ko.observable(),
                color:ko.observable(),
                pic:ko.observable(), 
                imgW:ko.observable(),
                imgH:ko.observable(),
                imgP:ko.observable(),
                options:ko.observableArray([])
            });
        },
        removeTopic:function(topic){
            qaViewModel.topics.remove(topic);
        },
        addOption:function(topic){
            topic.options.push({
                right:ko.observable(0),
                text:ko.observable(),
                fSize:ko.observable(),
                font:ko.observable(),
                color:ko.observable(),
                pic:ko.observable(),
                imgW:ko.observable(),
                imgH:ko.observable(),
                imgP:ko.observable()
            })
        },
        removeOption:function(option){
            $.each(qaViewModel.topics(),function(){
                this.options.remove(option);
            })
        }
    };

    
    
    $(function(){
        ko.applyBindings(qaViewModel, document.getElementById("qa_dialog"));
        
        $("#qa_dialog").dialog({
            title: Chidopi.lang.title.qa,
            autoOpen:false,
            width:1100,
            height:600,
            modal: true,
            buttons:[
                {
            	text  :  Chidopi.lang.btn.ok,
            	click : function(){
                    var id = qaViewModel.id();
                    var type = "qa";
                    var title = qaViewModel.title();
                    if(!title){
                        qaViewModel.title(id);
                    }
                    
                    if(!id){
                        //创建新的组件
                        id=  type + "_" + (++Global.number);	
                        qaViewModel.id(id);   //将id设置到model中
                        qaViewModel.zIndex(Global.number);
                        
                        
                        var json = ko.toJSON(qaViewModel);
                        
                        createComponent(id, type,json, title); //在左边列表中添加一个组件项,同时会生成一个隐藏域
                       
                        var src = "";
                        if(!qaViewModel.bgPic()){
                            src = "<?php echo base_url() ?>css/images/qa.jpg";
                        }else{
                            src = sys_vars.base_url + sys_vars.user_res_path + "/"+qaViewModel.bgPic();
                        }
                        createQaComponent(id,title, src,"","", qaViewModel.zIndex());
                    }else{
                        //修改组件
                        var size = {width:qaViewModel.width(),height: qaViewModel.height()};
			
                        var json = ko.toJSON(qaViewModel);
                        updateComponent(id, type, json, title);
                        
                        var src = "";
                        if(!qaViewModel.bgPic()){
                            src = "<?php echo base_url() ?>css/images/qa.jpg";
                        }else{
                            src = sys_vars.base_url + sys_vars.user_res_path + "/"+qaViewModel.bgPic();
                        }
                        updateQaComponent(id, title, src,size)
                        
                    }
                    $(this).dialog("close");
                }
                },
                {
                text  : Chidopi.lang.btn.cancel,
                click : function(){$(this).dialog("close");}			
                }
            ],
            open: function(event, ui) {
                if(qaViewModel.finishAction() == 0){
                    $("#qa_succ_action_page").hide();
                }else{
                    $("#qa_succ_action_page").show();
                    $("#qa_succ_action_page").find("select").val(qaViewModel.finishAction());
                }
            }

        });
        $("#bar_qa").click(function(){
            //点击工具条按钮时，初始化pazzleModel
            qaViewModel.id("");
            qaViewModel.title("");
            qaViewModel.x(0);
            qaViewModel.y(0);
            qaViewModel.width(100);
            qaViewModel.height(100);
            qaViewModel.bgPic("");
            qaViewModel.bgColor("");
            qaViewModel.flipPage("");
            qaViewModel.scoreType(0);
            qaViewModel.rightEvent(0);
            qaViewModel.rightAudio("");
            qaViewModel.rightPic("");
            qaViewModel.errorAudio("");
            qaViewModel.errorPic("");
            qaViewModel.finishAudio("");
            qaViewModel.confirmPic("");
            qaViewModel.finishAction(0);
            qaViewModel.jumpPage(0);
            qaViewModel.jumpText("Jump");
            qaViewModel.zIndex("");
            qaViewModel.topics([]);
            $("#qa_dialog").dialog("open");		
        });
        
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
                $("#qa_succ_action_page").find("select").append(fragment.html());
            },
            error: function(jqXHR, textStatus, errorThrown){
                dialog.alert(Chidopi.lang.title.error , jqXHR.responseText);
            }
        });
        //生成 options结束
    });
    
    function _qa_color_sel(obj){
        var obj = $(obj);
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
        $(this).change();
    }
    
    //选择完成音效
    function _qa_succ_action(obj){
        var selV = $(obj).val();
        if(selV == "page"){
            $("#qa_succ_action_page").show();
        }else{
            $("#qa_succ_action_page").hide();
        }
    }
</script>
<div id="qa_dialog" class="cmp_dialog" style="display:none">
    <table>
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td><input type="text" data-bind="value: title" /></td>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td>&nbsp;X&nbsp;<input type="text" data-bind="value: x" class="short" />
                &nbsp;Y&nbsp;<input type="text" data-bind="value: y" class="short" />
            </td>
            <td class="title"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="text" data-bind="value: width"  class="short" />
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" data-bind="value: height"  class="short" />
            </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td class="title"><?php echo lang('label.qa.flip'); ?></td>
            <td><select data-bind="value:flipPage">
                    <option value="0"><?php echo lang('label.qa.flip.none'); ?></option>
                    <option value="1"><?php echo lang('label.qa.flip.fade'); ?></option>
                    <option value="2"><?php echo lang('label.qa.flip.slide'); ?></option>
                </select></td>
            <td class="title"><?php echo lang('label.qa.bg.color'); ?></td>
            <td><input type="color" data-bind="value:bgColor" onclick="_qa_color_sel(this)"  style="width:45px;"/></td>
            <td class="title"><?php echo lang('label.qa.bg.pic'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:bgPic"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.qa.score'); ?></td>
            <td><select data-bind="value:scoreType">
                    <option value="0"><?php echo lang('label.qa.score.percent'); ?></option>
                    <option value="1"><?php echo lang('label.qa.score.number'); ?></option>
                    <option value="2"><?php echo lang('label.qa.score.both'); ?></option>
                </select></td>
            <td class="title"><?php echo lang('label.qa.right.event'); ?></td>
            <td><select data-bind="value:rightEvent">
                    <option value="0"><?php echo lang('label.qa.right.none'); ?></option>
                    <option value="1"><?php echo lang('label.qa.right.jump'); ?></option>
                </select></td>
            <td class="title"><?php echo lang('label.common.rightAudio'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:rightAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>

        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.errorAudio'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:errorAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>
            <td class="title"><?php echo lang('label.common.rightImg'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:rightPic"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
            <td class="title"><?php echo lang('label.common.errorImg'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:errorPic"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.finishAudio'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:finishAudio"  
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>" class="upload mocool_audio_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>
            <td class="title"><?php echo lang('label.common.succAction'); ?></td>
            <td>
                <select data-bind="value:finishAction" onchange="_qa_succ_action(this)">
                    <option value="0"><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
                <div id="qa_succ_action_page" style="display:inline">
                    <?php echo lang('label.play.ended.pageto'); ?><select data-bind="value:jumpPage"></select>
                </div>
                <p><?php echo lang('label.common.jumpText'); ?><input type="text"  data-bind="value:jumpText"  /></p>
            </td>
            <td class="title"><?php echo lang('label.common.confirmPIc'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:confirmPic"  
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>
        </tr>
        <tr>
            <td colspan="6"><input type="button" data-bind="click:addTopic" value="<?php echo lang('label.qa.addTopic'); ?>"/></td>
        </tr>
        <tr>
            <td colspan="6">
                <table width="100%" class="qa_table_style">
                    <thead>
                        <tr>
                            <td><?php echo lang('label.common.type'); ?></td>
                            <td><?php echo lang('label.common.text'); ?></td>
                            <td><?php echo lang('label.common.font.size'); ?></td>
                            <td><?php echo lang('label.common.font'); ?></td>
                            <td><?php echo lang('label.common.color'); ?></td>
                            <td width="260"><?php echo lang('label.common.image'); ?></td>
                            <td><?php echo lang('label.qa.pic.widht'); ?></td>
                            <td><?php echo lang('label.qa.pic.height'); ?></td>
                            <td><?php echo lang('label.qa.pic.pos'); ?></td>
                            <td><?php echo lang('label.qa.operating'); ?></td>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach:topics"/>
                    <tr style="border-top:0px;">
                        <td> <select data-bind="value:type">
                                <option value="0"><?php echo lang('label.qa.choice.single'); ?></option>
                                <option value="1"><?php echo lang('label.qa.choice.multiple'); ?></option></select></td>
                        <td><input type="text" data-bind="value:text"/></td>
                        <td><select data-bind="value:fSize">
                                <option value="medium"><?php echo lang('label.common.normal'); ?></option>
                                <option value="small"><?php echo lang('label.common.small'); ?></option>
                                <option value="large"><?php echo lang('label.common.large'); ?></option>
                            </select></td>
                        <td><select data-bind="value:font">
                                <option value="Arial">Arial</option>
                                <option value="'Comic Sans MS'">Comic Sans MS</option>
                                <option value="'Courier New'">Courier New</option>
                                <option value="Georgia">Georgia</option>
                                <option value="'Lucida Sans Unicode'">Lucida Sans Unicode</option>
                                <option value="Tahoma">Tahoma</option>
                                <option value="'Times New Roman'">Times New Roman</option>
                                <option value="'Trebuchet MS'">Trebuchet MS</option>
                                <option value="Verdana">Verdana</option>
                            </select></td>
                        <td><input type="color" onclick="_qa_color_sel(this)" data-bind="value:color" style="width:45px;"/></td>
                        <td>
                            <input type="text" readonly="readonly" data-bind="value:pic"  
                                   placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                            <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

                        </td>
                        <td><input type="text" data-bind="value:imgW" style="width:30px;"/>px</td>
                        <td><input type="text" data-bind="value:imgH" style="width:30px;"/>px</td>
                        <td><select data-bind="value:imgP">
                                <option value="0"><?php echo lang('label.align.left'); ?></option>
                                <option value="1"><?php echo lang('label.align.right'); ?></option>
                                <option value="2"><?php echo lang('label.common.background'); ?></option>
                            </select></td>
                        <td><input type="button" value="<?php echo lang('label.qa.removeTopic'); ?>" data-bind="click:$root.removeTopic"/>
                            <input type="button" value="<?php echo lang('label.qa.option.add'); ?>" data-bind="click:$root.addOption"/></td>
                    </tr>

                    <tr>
                        <td><?php echo lang('label.qa.option'); ?></td>
                        <td colspan="9" style="border:0px;" valign="top">

                            <table width="100%" height="100%" style="margin-top:0px; border: 0px; border-left: 1px;">
                                <thead>
                                    <tr style="border-top:1px;border-right: 0px">
                                        <td><?php echo lang('label.qa.right'); ?></td>
                                        <td><?php echo lang('label.common.text'); ?></td>
			                            <td><?php echo lang('label.common.font.size'); ?></td>
			                            <td><?php echo lang('label.common.font'); ?></td>
			                            <td><?php echo lang('label.common.color'); ?></td>
			                            <td width="260"><?php echo lang('label.common.image'); ?></td>
			                            <td><?php echo lang('label.qa.pic.widht'); ?></td>
			                            <td><?php echo lang('label.qa.pic.height'); ?></td>
			                            <td><?php echo lang('label.qa.pic.pos'); ?></td>
			                            <td><?php echo lang('label.qa.operating'); ?></td>
                                    </tr>
                                </thead>
                                <tbody data-bind="foreach:options">
                                    <tr style="border-bottom:1px;border-right: 0px">
                                        <td> <input type="checkbox" data-bind="checked: right"/></td>
                                        <td><input type="text" data-bind="value:text"/></td>
                                        <td><select data-bind="value:fSize">
                                                <option value="medium"><?php echo lang('label.common.normal'); ?></option>
				                                <option value="small"><?php echo lang('label.common.small'); ?></option>
				                                <option value="large"><?php echo lang('label.common.large'); ?></option>
                                            </select></td>
                                        <td><select data-bind="value:font">
                                                <option value="Arial">Arial</option>
                                                <option value="'Comic Sans MS'">Comic Sans MS</option>
                                                <option value="'Courier New'">Courier New</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="'Lucida Sans Unicode'">Lucida Sans Unicode</option>
                                                <option value="Tahoma">Tahoma</option>
                                                <option value="'Times New Roman'">Times New Roman</option>
                                                <option value="'Trebuchet MS'">Trebuchet MS</option>
                                                <option value="Verdana">Verdana</option>
                                            </select></td>
                                        <td><input type="color" onclick="_qa_color_sel(this)" data-bind="value:color" style="width:45px;"/></td>
                                        <td>
                                            <input type="text" readonly="readonly" data-bind="value:pic"  
                                                   placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>              
                                            <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
                                        </td>
                                        <td><input type="text" data-bind="value:imgW" style="width:30px;"/>px</td>
                                        <td><input type="text" data-bind="value:imgH" style="width:30px;"/>px</td>
                                        <td><select data-bind="value:imgP">
                                                <option value="0"><?php echo lang('label.align.left'); ?></option>
				                                <option value="1"><?php echo lang('label.align.right'); ?></option>
				                                <option value="2"><?php echo lang('label.common.background'); ?></option>
                                            </select></td>
                                        <td><input type="button" value="<?php echo lang('label.qa.option.remove'); ?>" data-bind="click:$root.removeOption"/></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

</div>





