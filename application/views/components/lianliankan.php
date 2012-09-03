<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>

</style>
<script>
//视图模型对象
lianliankanModel = {
    id:ko.observable(),
    title:ko.observable(),
    x:ko.observable(),
    y:ko.observable(),
    width:ko.observable(),
    height:ko.observable(200),
    rightAudio:ko.observable(),
    rightImg:ko.observable(),
    errorAudio:ko.observable(),
    errorImg:ko.observable(),
    bgpic:ko.observable(),
    finishImg:ko.observable(),
    finishAudio:ko.observable(),
    lineColor:ko.observable(),
    lineWidth:ko.observable(),
    pointColor:ko.observable(),
    pointWidth:ko.observable(),
    succAction:ko.observable(),
    succActionPage:ko.observable(),
    zIndex:ko.observable(),
    jumpText:ko.observable(),
    lines:[],
    points:[]
};
lianliankanModel.width.subscribe(function (newValue) {
    llk_initCanvas();
});
lianliankanModel.height.subscribe(function (newValue) {
    llk_initCanvas();
});
///////////////////// end  /////////////////////////////////

//起始点
var llk_point_id = 1; //全局id计数

var llk_lines = []; //保存所有画线
var llk_canvas = null;
$(function () {
    ko.applyBindings(lianliankanModel, document.getElementById("lianliankan_dialog"));

    $("#lianliankan_dialog").dialog({
        title:Chidopi.lang.title.llk,
        autoOpen:false,
        position:'top',
        width:1200,
        height:1400,
        modal:true,
        buttons:[
            {
                text:Chidopi.lang.btn.ok,
                click:function () {
                    var id = lianliankanModel.id();
                    var type = "lianliankan";
                    var title = lianliankanModel.title();
                    if (!title) {
                        lianliankanModel.title(id);
                    }

                    if (!id) {
                        //创建新的组件
                        id = type + "_" + (++Global.number);
                        lianliankanModel.id(id);   //将id设置到model中
                        lianliankanModel.zIndex(Global.number);
                        lianliankanModel.points = llk_get_all_objecs_from_canvas();
                        lianliankanModel.lines = llk_lines;

                        lianliankanModel.succAction($("#llk_succ_finish_action_sel").val());
                        lianliankanModel.succActionPage($("#llk_succ_finish_sel").find("select").val());


                        var size = {width:lianliankanModel.width(), height:lianliankanModel.height()};
                        var json = ko.toJSON(lianliankanModel);
                        createComponent(id, type, json, title); //在左边列表中添加一个组件项,同时会生成一个隐藏域

                        var src = "";
                        if (!lianliankanModel.bgpic()) {
                            src = "<?php echo base_url() ?>css/images/lianliankan.jpg";
                        } else {
                            src = sys_vars.base_url + sys_vars.user_res_path + "/" + lianliankanModel.bgpic();
                        }
                        title = title ? title : id;
                        createLianliankanComponent(id, src, null, size, title, lianliankanModel.zIndex());

                    } else {

                        lianliankanModel.points = llk_get_all_objecs_from_canvas();
                        lianliankanModel.lines = llk_lines;

                        lianliankanModel.succAction($("#llk_succ_finish_action_sel").val());
                        lianliankanModel.succActionPage($("#llk_succ_finish_sel").find("select").val());

                        var size = {width:lianliankanModel.width(), height:lianliankanModel.height()};
                        var json = ko.toJSON(lianliankanModel);
                        updateComponent(id, type, json, title);
                        var src = "";
                        if (!lianliankanModel.bgpic()) {
                            src = "<?php echo base_url() ?>css/images/lianliankan.jpg";
                        } else {
                            src = sys_vars.base_url + sys_vars.user_res_path + "/" + lianliankanModel.bgpic();
                        }
                        updateLianliankanComponent(id, src, size);

                    }
                    //TODO 将pazzleModel中的值填充入hide input中

                    $(this).dialog("close");
                }
            },
            {
                text:Chidopi.lang.btn.cancel,
                click:function () {
                    $(this).dialog("close");
                }
            }
        ],
        open:function (event, ui) {

            if (lianliankanModel.succAction() == undefined || lianliankanModel.succAction() == 0) {
                $("#llk_succ_finish_lbl").hide();
                $("#llk_succ_finish_sel").hide();
            } else {
                $("#llk_succ_finish_lbl").show();
                $("#llk_succ_finish_sel").show();
                $("#llk_succ_finish_sel").val(lianliankanModel.succActionPage());
            }

            //初始化canvas背景
            llk_initCanvas();
        }

    });
    $("#bar_lianliankan").click(function () {
        //点击工具条按钮时，
        lianliankanModel.id("");
        lianliankanModel.title("");
        lianliankanModel.x(0);
        lianliankanModel.y(0);
        lianliankanModel.width(400);
        lianliankanModel.height(400);
        lianliankanModel.lineColor("#ff0000");
        lianliankanModel.lineWidth(5);
        lianliankanModel.pointColor("#ff0000");
        lianliankanModel.pointWidth(10);
        lianliankanModel.bgpic("");
        lianliankanModel.errorAudio("");
        lianliankanModel.errorImg("");
        lianliankanModel.finishImg("");
        lianliankanModel.finishAudio("");
        lianliankanModel.rightAudio("");
        lianliankanModel.rightImg("");
        lianliankanModel.lines = [];
        lianliankanModel.points = [];
        lianliankanModel.succAction(0);
        lianliankanModel.jumpText("Jump");
        if (llk_canvas != null) {
            llk_canvas.clear();
        }
        lianliankanModel.zIndex("");
        $("#lianliankan_dialog").dialog("open");
    });

    //加载页面id并生成select option
    $.ajax({
        url:'<?php echo base_url(); ?>motionbox/loadpageInfo',
        data:{
            bookid:'<?php echo $bookid; ?>',
            pageid:'<?php echo $pageid; ?>'
        },
        type:"POST",
        dataType:'json',
        success:function (data, textStatus, jqXHR) {
            var fragment = $("<select/>");
            for (var i in data) {
                fragment.append('<option value="' + data[i].id + '">' + data[i].title + '</option>');
            }

            $("#llk_succ_finish_sel").html(fragment);
        },
        error:function (jqXHR, textStatus, errorThrown) {
            dialog.alert(Chidopi.lang.title.error, jqXHR.responseText);
        }
    });
    //生成 options结束


    //上传背景图片start
    $("#lianliankanBgPicFile").click(function () {
        openKCFinder({
            field:this,
            prefix:"img_",
            onComplete:function (url, size) {
                lianliankanModel.bgpic(url);
                var src = sys_vars.base_url + sys_vars.user_res_path + "/" + lianliankanModel.bgpic();
                //$("#lianliankan_canvas").css({"background-image":"url("+src+")","background-repeat":"no-repeat"});
                llk_canvas.backgroundImageStretch = true;
                llk_canvas.setBackgroundImage(src, llk_canvas.renderAll.bind(llk_canvas));
            }
        });
    });

    //上传背景图片end
    //上传连连图片start
    $("#lianliankanIconPicFile").click(function () {
        openKCFinder({
            field:this,
            prefix:"img_",
            onComplete:function (url, size) {
                var src = sys_vars.base_url + sys_vars.user_res_path + "/" + url;
                llk_createImage(src, url);
                $("#lianliankanIconPicFile").val("");
            }
        });
    });
    //上传连连图片end

    ////////////////////canvas画图相关


    //llk_initCanvas();
});

//初始化画布
function llk_initCanvas() {
    if (llk_canvas == null) {
        llk_canvas = new fabric.Canvas('lianliankan_canvas', { selection:true, backgroundImageStretch:true })
    }
    llk_canvas.setWidth(lianliankanModel.width());
    llk_canvas.setHeight(lianliankanModel.height());
    llk_canvas.clear();
    //初使化背景图
    if (lianliankanModel.bgpic() != undefined && lianliankanModel.bgpic() != "") {
        var src = sys_vars.base_url + sys_vars.user_res_path + "/" + lianliankanModel.bgpic();
        llk_canvas.backgroundImageStretch = true;
        llk_canvas.setBackgroundImage(src, llk_canvas.renderAll.bind(llk_canvas));
    }
    //初始化llk_lines
    llk_lines = lianliankanModel.lines;
    var points = lianliankanModel.points;

    if (points != null && points != undefined) {
        var len = points.length;
        for (var i = 0; i < len; i++) {
            var point = points[i];

            switch (point.type) {
                case 'circle':
                    var c = fabric.Circle.fromObject(point);
                    c.uqid = point.uqid;
                    if (point.uqid > llk_point_id) {
                        llk_point_id = point.uqid + 1;
                    }
                    llk_canvas.add(c);
                    break;
                case 'line':
                    var l = fabric.Line.fromObject(point);
                    l.uqid = point.uqid;
                    if (point.uqid > llk_point_id) {
                        llk_point_id = point.uqid + 1;
                    }
                    llk_canvas.add(l);
                    llk_canvas.sendToBack(l);
                    break;
                case 'text':
                    var t = fabric.Text.fromObject(point);
                    llk_canvas.add(t);
                    break;
                case 'image':
                    (function () {
                        var reaUrl = point.src;
                        point.src = sys_vars.base_url + sys_vars.user_res_path + "/" + reaUrl;

                        var i = fabric.Image.fromObject(point, function (obj) {
                            if (obj != undefined && obj != null) {
                                obj.relUrl = reaUrl;
                                llk_canvas.add(obj);
                            }
                        });
                    })();
                    break;
            }
        }
    }
    //点移动时重新画线
    llk_canvas.on('object:moving', function (e) {

        var obj = e.target;
        //type: group,  Circle
        if (obj.type == "group") {
            llk_canvas.deactivateAll()
        }
        if (obj.type == 'circle') {
            llk_update_link(obj.uqid, obj.left, obj.top);
        }
    });
}

//返回canvas 中所有对象
function llk_get_all_objecs_from_canvas() {
    llk_canvas.deactivateAll()
    var objs = [];
    llk_canvas.forEachObject(function (obj) {
        var o = obj.toObject();

        if (o.type == "image" && obj.relUrl != undefined && obj.relUrl != "") {
            o.src = obj.relUrl;
        }

        if (obj.uqid != undefined && obj.uqid != null) {
            o.uqid = obj.uqid;
        }
        objs.push(o);
    });

    return objs;
}
///////////////////////////////click 处理 /////////////////////
function llk_clear_bgimg_click() {
    lianliankanModel.bgpic("");
    $("#lianliankanBgPicFile").val("");
    llk_canvas.setBackgroundImage("", llk_canvas.renderAll.bind(llk_canvas));
}

//画点
function llk_makeCircle_clk() {
    var centerCoord = llk_canvas.getCenter();
    var pWidth = lianliankanModel.pointWidth() ? lianliankanModel.pointWidth() : "10";
    var pColor = lianliankanModel.pointColor() ? lianliankanModel.pointColor() : "#ff0000";
    var c = new fabric.Circle({
        left:centerCoord.left,
        top:centerCoord.top,
        strokeWidth:2,
        radius:pWidth,
        fill:pColor,
        stroke:'#00ff00',
    });
    c.uqid = llk_point_id++;   //设置uqid为唯一id, 之所以用uqid是为了以免更新框架后id属性冲突
    c.hasControls = false;
    c.borderColor = "#ff0000";
    //c.hasBorders = true;
    //c.selectable = true;
    llk_canvas.add(c);
}
//更新画线,找出所有与uqid相关线，并更新坐标
function llk_update_link(uqid, left, top) {
    var len = llk_lines.length;
    for (var i = 0; i < len; i++) {
        var line = llk_lines[i];
        if (line.ps == uqid) {
            //起点更新
            llk_canvas.forEachObject(function (obj) {
                if (line.uqid == obj.uqid) {
                    obj.set({ 'x1':left, 'y1':top });
                }
            });
        } else if (line.pe == uqid) {
            //终点更新
            llk_canvas.forEachObject(function (obj) {
                if (line.uqid == obj.uqid) {
                    obj.set({ 'x2':left, 'y2':top });
                }
            });
        }
    }

}
//画线
function llk_linkCircle_clk() {
    var activeGroup = llk_canvas.getActiveGroup();
    if (null == activeGroup) {
        alert(Chidopi.lang.msg.llk_info1);
    } else if (activeGroup.objects.length != 2) {
        alert(Chidopi.lang.msg.llk_info2);
    } else {
        var objects = activeGroup.objects;
        var obj1 = objects[0];
        var obj2 = objects[1];
        if (obj1.type != "circle" || obj2.type != "circle") {
            alert(Chidopi.lang.msg.llk_info2);
        } else {
            //首先判断两点间是否已经有连线，llk_lines
            if (!llk_check_line_exist(obj1.uqid, obj2.uqid)) {
                var coords = [obj1.originalLeft, obj1.originalTop, obj2.originalLeft, obj2.originalTop];
                var lWidth = lianliankanModel.lineWidth() ? lianliankanModel.lineWidth() : "5";
                var lColor = lianliankanModel.lineColor() ? lianliankanModel.lineColor() : "#ff0000";
                var line = new fabric.Line(coords, {
                    fill:lColor,
                    strokeWidth:lWidth,
                    selectable:false
                });
                line.uqid = llk_point_id++;
                llk_canvas.add(line);
                llk_canvas.sendToBack(line);
                llk_lines.push({"uqid":line.uqid, "ps":obj1.uqid, "pe":obj2.uqid});
            }
        }
    }
}

//从llk_lines删除连线并
function llk_del_line_from_llk_lines(line_id) {
    var len = llk_lines.length;
    for (var i = 0; i < len; i++) {
        var line = llk_lines[i];
        if (line.uqid == line_id) {
            llk_lines.splice(i, 1);
            break;
        }
    }
}
//从画面上删除线对象
function llk_del_line_from_canvas(line_id) {
    llk_canvas.forEachObject(function (obj) {
        if (line_id == obj.uqid) {
            llk_canvas.remove(obj);
        }
    });
}
//判断两点间是否在在连线--llk_lines[{ps:1,pe:2},{...}]
function llk_check_line_exist(id1, id2) {
    var len = llk_lines.length;
    for (var i = 0; i < len; i++) {
        var line = llk_lines[i];
        if ((line.ps == id1 && line.pe == id2) || (line.ps == id2 && line.pe == id1)) {
            return line.uqid;
        }
    }
    return false;
}

//删除连线
function llk_delLinkCircle_click() {
    var activeGroup = llk_canvas.getActiveGroup();
    if (null == activeGroup) {
        alert(Chidopi.lang.msg.llk_info3);
    } else if (activeGroup.objects.length != 2) {
        alert(Chidopi.lang.msg.llk_info4);
    } else {
        var objects = activeGroup.objects;
        var obj1 = objects[0];
        var obj2 = objects[1];
        if (obj1.type != "circle" || obj2.type != "circle") {
            alert(Chidopi.lang.msg.llk_info4);
        } else {
            //在在连线才删除
            var lineID = llk_check_line_exist(obj1.uqid, obj2.uqid);
            if (lineID) {
                llk_del_line_from_llk_lines(lineID); //从数据中删除line
                llk_del_line_from_canvas(lineID); //从画面上删除
            }
        }
    }
}
//文本
function llk_createText_click() {
    var centerCoord = llk_canvas.getCenter();
    var text = new fabric.Text(Chidopi.lang.msg.llk_info5, {
        left:centerCoord.left,
        top:centerCoord.top,
        fontFamily:'Microsoft YaHei',
        fill:'red',
        left:100,
        top:50
    });
    llk_canvas.add(text);
}
/**
 * obj,
 * type:0 文本， 1 字体 ， 2 着色
 */
function llk_text_sty_chage() {
    var text = $("#llk_text_val").val();
    var font = $("#llk_text_font").val();
    var color = $("#llk_text_color").val();


    var activeObj = llk_canvas.getActiveObject();
    if (activeObj != null) {
        if (activeObj.type == "text") {
            if (text != "") {
                activeObj.setText(text);
            }
            if (color != "") {
                activeObj.setColor(color);
            }
            activeObj.set("fontFamily", font);

            llk_canvas.renderAll();
        } else {
            alert(Chidopi.lang.msg.llk_info6);
        }
    } else {
        alert(Chidopi.lang.msg.llk_info6);
    }
}

//上传小图片
function llk_createImage(url, relUrl) {
    var centerCoord = llk_canvas.getCenter();
    fabric.Image.fromURL(url, function (img) {
        oImg = img.set({ left:centerCoord.left, top:centerCoord.top});
        oImg.relUrl = relUrl;
        llk_canvas.add(oImg);

    });
}
//删除选中对象
function llk_delActiveOjb_click() {
    var activeObj = llk_canvas.getActiveObject();
    if (activeObj != null) {
        if (activeObj.type == 'circle') {
            var len = llk_lines.length;
            for (var i = len - 1; i >= 0; i--) {
                var line = llk_lines[i];
                if (line != undefined && (line.ps == activeObj.uqid || line.pe == activeObj.uqid)) {
                    llk_canvas.forEachObject(function (obj) {
                        if (line.uqid == obj.uqid) {
                            llk_canvas.remove(obj);
                        }
                    });
                    llk_lines.splice(i, 1); //首先数组中删除
                }
            }
        }
        llk_canvas.remove(activeObj);
    }
}

function _lianliankan_succ_action(obj) {
    var selV = $(obj).val();
    if (selV == "page") {
        $("#llk_succ_finish_lbl").show();
        $("#llk_succ_finish_sel").show();
    } else {
        $("#llk_succ_finish_lbl").hide();
        $("#llk_succ_finish_sel").hide();
    }
}
</script>
<div id="lianliankan_dialog" class="cmp_dialog" style="display:none">
    <table style="border:1px solid #CCC;">
        <tr>
            <td class="title"><?php echo lang('label.common.title'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="text" data-bind="value: title"/></td>
            <td class="title"><?php echo lang('label.common.position'); ?></td>
            <td style="border-right:solid 1px #CCC;">&nbsp;X&nbsp;<input type="text" data-bind="value: x"
                                                                         class="short"/>
                &nbsp;Y&nbsp;<input type="text" data-bind="value: y" class="short"/>
            </td>
            <td class="title"><?php echo lang('label.common.size'); ?></td>
            <td><?php echo lang('label.common.width'); ?>&nbsp;<input type="text" data-bind="value: width"
                                                                      class="short"/>
                <?php echo lang('label.common.height'); ?>&nbsp;<input type="text" data-bind="value: height"
                                                                       class="short"/>
            </td>
        </tr>

        <tr style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.common.rightImg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:rightImg"
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>
            <td class="title"><?php echo lang('label.common.errorImg'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:errorImg"
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>

            </td>
            <td class="title"><?php echo lang('label.common.finishImg'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:finishImg"
                       placeholder="<?php echo lang('label.common.choose.image'); ?>" class="upload mocool_img_upload"/>
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.common.rightAudio'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:rightAudio"
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>"
                       class="upload mocool_audio_upload"/>
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>

            <td class="title"><?php echo lang('label.common.errorAudio'); ?></td>
            <td style="border-right:solid 1px #CCC;">
                <input type="text" readonly="readonly" data-bind="value:errorAudio"
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>"
                       class="upload mocool_audio_upload"/>
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
            <td class="title"><?php echo lang('label.common.finishAudio'); ?></td>
            <td>
                <input type="text" readonly="readonly" data-bind="value:finishAudio"
                       placeholder="<?php echo lang('label.common.choose.sound'); ?>"
                       class="upload mocool_audio_upload"/>
                <button class="mocool_cancel_upload"><?php echo lang('label.common.cancel'); ?></button>
            </td>
        </tr>
        <tr style=" border-top: 1px solid #CCC;">
            <td class="title"><?php echo lang('label.llk.lineColor'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="color" data-bind="value:lineColor"
                                                            onclick="_qa_color_sel(this)" style="width:45px;"/></td>
            <td class="title"><?php echo lang('label.llk.pointColor'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="color" data-bind="value:pointColor"
                                                            onclick="_qa_color_sel(this)" style="width:45px;"/></td>
            <td class="title"><?php echo lang('label.common.succAction'); ?></td>
            <td>
                <select id="llk_succ_finish_action_sel" onChange="_lianliankan_succ_action(this)"
                        data-bind="value:succAction">
                    <option value="0"><?php echo lang('label.play.ended.nothing'); ?></option>
                    <option value="page"><?php echo lang('label.play.ended.page'); ?></option>
                </select>
                <span id="llk_succ_finish_lbl"><?php echo lang('label.play.ended.pageto'); ?></span>
                <span id="llk_succ_finish_sel"><select></select> </span>
            </td>
        </tr>
        <tr>
            <td class="title"><?php echo lang('label.llk.lineWidth'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="number" data-bind="value:lineWidth" min="1" max="20"
                                                            step="1" value="1" class="short"/></td>
            <td class="title"><?php echo lang('label.llk.pointWidth'); ?></td>
            <td style="border-right:solid 1px #CCC;"><input type="number" data-bind="value:pointWidth" min="1" max="20"
                                                            step="1" value="1" class="short"/></td>
            <td class="title">
                <?php echo lang('label.common.jumpText'); ?>
            </td>
            <td>
                <input type="text" data-bind="value:jumpText"/>
            </td>
        </tr>
    </table>
    <br/>

    <div>

        <div style="margin:5px auto; border: 1px red solid; padding: 5px;">
            <p>
                <?php echo lang('label.common.text'); ?><input type="text" id="llk_text_val"/>
                <?php echo lang('label.common.font'); ?><select id="llk_text_font">
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
                <?php echo lang('label.common.color'); ?><input type="color" id="llk_text_color"
                                                                onclick="_qa_color_sel(this)"
                                                                style="width:45px;" value="#ff0000"/>
                <input type="button" value="<?php echo lang('label.llk.apply.text'); ?>"
                       onclick="llk_text_sty_chage()"></input>
            </p>
            <p>
                <span>
                    <?php echo lang('label.common.icon.pic'); ?><input type="text" readonly="readonly"
                                                                       id="lianliankanIconPicFile"
                                                                       name="lianliankanIconPicFile"
                                                                       placeholder="<?php echo lang('label.common.choose.image'); ?>"
                                                                       class="upload"/>
                </span>
                <span>
                    <?php echo lang('label.common.bg.pic'); ?><input type="text" readonly="readonly"
                                                                     id="lianliankanBgPicFile"
                                                                     name="lianliankanBgPicFile"
                                                                     placeholder="<?php echo lang('label.common.choose.image'); ?>"
                                                                     class="upload"/>
                </span>

            </p>
        </div>


    </div>
    <div id="lianliankan_container" style="display:inline-block;float: left;">
        <canvas id="lianliankan_canvas" style="border:1px solid red; "></canvas>
    </div>
    <div
        style="display:inline-block; padding: 4px;width: 70px; height: 350px; border: 1px solid red; margin-left: 5px; float: left; ">

        <p>
            <input type="button" value="<?php echo lang('label.common.bg.clear'); ?>" style="width:70px;"
                   onclick="llk_clear_bgimg_click()">
        </p>

        <p>
            <input type="button" value="<?php echo lang('label.llk.makeCircle'); ?>" onclick="llk_makeCircle_clk()"
                   style="width:70px; margin: 3px;"></input>
        </p>

        <p>
            <input type="button" value="<?php echo lang('label.llk.delActiveOjb'); ?>"
                   onclick="llk_delActiveOjb_click()" style="width:70px; margin: 3px;"></input>
        </p>

        <p>
            <input type="button" value="<?php echo lang('label.llk.linkCircle'); ?>" onclick="llk_linkCircle_clk()"
                   style="width:70px; margin: 3px;"></input>
        </p>

        <p>
            <input type="button" value="<?php echo lang('label.llk.delLinkCircle'); ?>"
                   onclick="llk_delLinkCircle_click()" style="width:70px; margin: 3px;"></input>
        </p>

        <p>
            <input type="button" value="<?php echo lang('label.llk.createText'); ?>" onclick="llk_createText_click()"
                   style="width:70px; margin: 3px;"/>
        </p>
    </div>
</div>