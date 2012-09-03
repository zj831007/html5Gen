<?php $theVersion = '?ver='.time(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="expires" content="Wed, 23 Aug 2010 12:40:27 UTC" />
        <title></title>
        <link href="<?php echo base_url(); ?>css/elastic.css" rel="stylesheet"/>	
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/colorpicker.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>css/LoadingBar.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>js/uploadify/uploadify.css" rel="stylesheet"/>

        <script src="<?php echo base_url(); ?>js/lang/<?php echo $language;?>.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-1.4.4.min.js" ></script>
        <script src="<?php echo base_url(); ?>js/jquery-ui-1.8.16.custom.min.js" ></script>
        <script src="<?php echo base_url(); ?>js/jquery.ui.position.js" ></script>
        <script src="<?php echo base_url(); ?>js/common.js" ></script>
        <script src="<?php echo base_url(); ?>js/jquery.form.js" ></script>
        <script src="<?php echo base_url(); ?>js/elastic.js" ></script>
        <script src="<?php echo base_url(); ?>js/dialog.js" ></script>	
        <script src="<?php echo base_url(); ?>js/jquery.multiselect.min.js"></script>
        <script src="<?php echo base_url(); ?>js/colorpicker/colorpicker.js"></script>
        <script src="<?php echo base_url(); ?>js/colorpicker/eye.js"></script>
        <script src="<?php echo base_url(); ?>js/colorpicker/utils.js" ></script>
        <script src="<?php echo base_url(); ?>js/nav.js"></script>
        <script src="<?php echo base_url(); ?>js/json_form/form2js.js"></script>
        <script src="<?php echo base_url(); ?>js/json_form/js2form.js"></script>
        <script src="<?php echo base_url(); ?>js/json_form/json2.js"></script>
        <script src="<?php echo base_url(); ?>js/json_form/jquery.toObject.js"></script>
        <script src="<?php echo base_url(); ?>js/components.js"></script>
        <script src="<?php echo base_url(); ?>js/LoadingBar.js"></script>
        <script src="<?php echo base_url(); ?>js/knockout-2.0.0.js"></script>
        <script src="<?php echo base_url(); ?>js/knockout.mapping-latest.js"></script>

        <script src="<?php echo base_url(); ?>js/fabric.min.js"></script>

        <script src="<?php echo base_url(); ?>js/components/pazzle-cmp.js"></script>
        <script src="<?php echo base_url(); ?>js/components/qa-cmp.js"></script>
        <script src="<?php echo base_url(); ?>js/components/lianliankan-cmp.js"></script>
        
        <script src="<?php echo base_url(); ?>js/sea.js"></script>
        
        <script>
            var dialog = window.chidopi;
            var bar = [
                {id: 'bar_add' ,      title:'<?php echo lang('label.nav.setting'); ?>',  img:'wrench.png', display: 'hide', order:'' },
                {id: 'bar_save' ,     title:'<?php echo lang('label.nav.save'); ?>',      img:'floppy-disk.png', display: 'block', order:'' },
                {id: 'bar_preview',   title:'<?php echo lang('label.nav.preview'); ?>',      img:'preview.png',     display: 'block', order:'' },
                {id: '',              title:'',         img:'sepline.gif',    display: 'block', order:'' },
                {id: 'bar_background',title:'<?php echo lang('label.nav.background'); ?>',  img:'desktop.png',    display: 'block', order:'' },
                {id: 'bar_img',       title:'<?php echo lang('label.nav.image'); ?>', img:'image.png',     display: 'show', order:'' },
                {id: 'bar_link',      title:'<?php echo lang('label.nav.link'); ?>',  img:'link.png',      display: 'show', order:'' },
                {id: 'bar_action',    title:'<?php echo lang('label.nav.action'); ?>', img:'anchor.png',   display: 'show', order:'' },
                {id: 'bar_video',     title:'<?php echo lang('label.nav.video'); ?>',img:'camcorder.png',   display: 'show', order:'' },
                {id: 'bar_audio',     title:'<?php echo lang('label.nav.audio'); ?>',img:'music.png',       display: 'show', order:'' },
                {id: 'bar_text',      title:'<?php echo lang('label.nav.text'); ?>', img:'document.png',    display: 'show', order:'' },
                {id: 'bar_note',      title:'<?php echo lang('label.nav.note'); ?>', img:'document-edit.png',display: 'show', order:'' }, // hide
                {id: 'bar_pazzle',      title:'<?php echo lang('label.nav.puzzle'); ?>', img:'puzzle.png',display: 'show', order:'' },
                {id: 'bar_qa',      title:'<?php echo lang('label.nav.qa'); ?>', img:'question-balloon.png',display: 'show', order:'' },
                {id: 'bar_slider2',   title:'<?php echo lang('label.nav.slider2'); ?>', img:'chart_bar.png',display: 'show', order:'' },
                {id: 'bar_lianliankan',   title:'<?php echo lang('label.nav.llk'); ?>', img:'shapes.png',display: 'show', order:'' },
                {id: 'bar_gravity',   title:'<?php echo lang('label.nav.gravity'); ?>', img:'compass.png',display: 'show', order:'' },
                {id: 'bar_diypuzzle',   title:'<?php echo lang('label.nav.diypuzzle'); ?>', img:'diypuzzle.png',display: 'show', order:'' },
                {id: 'bar_spotlight',   title:'<?php echo lang('label.nav.spotlight'); ?>', img:'light-bulb.png',display: 'show', order:'' },
                {id: 'bar_axismove',   title:'<?php echo lang('label.nav.axismove'); ?>', img:'axismove.png',display: 'show', order:'' },
				{id: 'bar_rotate360',   title:'<?php echo lang('label.nav.rotate360'); ?>', img:'rotate360.png',display: 'show', order:'' },
				{id: 'bar_vocabulary',   title:'<?php echo lang('label.nav.vocabulary'); ?>', img:'vocabulary.png',display: 'show', order:'',type:'vocabulary' },
				{id: 'bar_text2',        title:'<?php echo lang('label.nav.text2'); ?>', img:'text2.png',display: 'show', order:'',type:'text2' }
            ];
            var previewContainer;
            var sys_vars = {
                base_url  : '<?php echo base_url(); ?>' ,
                user_temp : '<?php echo $user_temp; ?>' ,
                pageid    : '<?php echo $pageid; ?>',
                bookid    : '<?php echo $bookid; ?>',
                cmp_container : '',
				user_files_path : '<?php echo $user_files_path; ?>',
				user_res_path   : '../<?php echo $user_files_path; ?>resource/',
				language  :  '<?php echo $language; ?>',
				width     :  '<?php echo $bWidth; ?>',
				height    :  '<?php echo $bHeight; ?>',
				version   :  '<?php echo $theVersion;?>',
            }
            Chidopi.sys_vars = sys_vars;
            
            function loadData(){

                var settings = <?php echo $settings ?>;
                var cmp_settings = <?php echo $cmp_settings ?>;
                loadGlobal(<?php echo $Global ?>);

                $("#bFileName").val( settings.bFileName ); 
                $("#bOrientation").val(settings.bOrientation );
                $("#bColor").val( settings.bColor );
                $("#bsFileName").val( settings.bsFileName );
                $("#bsLoop").val( settings.bsLoop );
                $("#bLoadAction").val( settings.bLoadAction );
                $("#bUnLoadAction").val( settings.bUnLoadAction );
                $("#bPageWidth").val(settings.bPageWidth ? settings.bPageWidth : settings.bWidth);
                $("#bPageHeight").val(settings.bPageHeight ? settings.bPageHeight : settings.bHeight);
                $("#bPageScale").val(settings.bPageScale ? settings.bPageScale : "1:1");
                updateBackgroundArea();
	
              /*  var sel = $("#lSound");
                for(key in Global.sounds){
                    var option = '<option value="' + key + '">'+Global.sounds[key] + '</option>';
                    sel.append(option);
                }*/
	
                var imgs = Global.components.img;
                if(imgs){
                    for(var id in imgs){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Image.createComponent(component, sys_vars);
                    }
                }
	
                var links = Global.components.link;
                if(links){
                    for(var id in links){						
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Link.createComponent(component, sys_vars);                      
                    }
                }
	
                var actions = Global.components.action;
                if(actions){
                    for(var id in actions){						
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Action.createComponent(component, sys_vars);
                    }
                }
	
                var videos = Global.components.video;
                if(videos){
                    for(var id in videos){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Video.createComponent(component, sys_vars);
                    }
                }
	
                var notes = Global.components.note;
                if(notes){
                    for(var id in notes){
						
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Note.createComponent(component, sys_vars);
                    }
                }
	
                var audios = Global.components.audio;
                if(audios){
                    for(var id in audios){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Audio.createComponent(component, sys_vars);
                    }
                }
	
                var texts = Global.components.text;
                if(texts){
                    for(var id in texts){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.Text.createComponent(component, sys_vars);  
                    }
                }
                
                var pazzles = Global.components.pazzle;
                if(pazzles){
                    for(var id in pazzles){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        var json =JSON.parse(component);
                        var title = json["title"];
                        
                        var position = {left:json["x"], top: json["y"]};
                        var size = {width: json["width"], height: json["height"]};
                        
                        createComponent(id, "pazzle", component, title);
                        createPazzleComponent(id,  "<?php echo base_url()?>"+ sys_vars.user_res_path + json.pazzlePics[0],position,size, json.row, json.col,title, json.zIndex);
                    }
                }
                var qa = Global.components.qa;
                if(qa){
                    for(var id in qa){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        var json =JSON.parse(component);
                        var title = json["title"];
                        
                        var position = {left:json["x"], top: json["y"]};
                        var size = {width: json["width"], height: json["height"]};
                        
                        createComponent(id, "qa", component, title);
                        
                        var src ="";
                        if(!json['bgPic']){
                            src = "<?php echo base_url() ?>css/images/qa.jpg";
                        }else{
                            src = "<?php echo base_url()?>"+ sys_vars.user_res_path + json['bgPic'];
                        }
                        
                        createQaComponent(id,title, src, position, size, json.zIndex)
                    }
                }
                var lianliankan = Global.components.lianliankan;
                if(lianliankan){
                    for(var id in lianliankan){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        var json =JSON.parse(component);
                        var title = json["title"];
						
                        
                        var position = {left:json["x"], top: json["y"]};
                        var size = {width: json["width"], height: json["height"]};
                        createComponent(id, "lianliankan", component, title);
                        
                        if(!json.bgpic || json.bgpic==""){
                            src = "<?php echo base_url() ?>css/images/lianliankan.jpg";
                        }else{
                            src = "<?php echo base_url()?>"+ sys_vars.user_res_path + json['bgpic'];
                        }
                        createLianliankanComponent(id, src, position, size,title, json.zIndex);
                    }
                }
		
                var slider2s = Global.components.slider2;
                if(slider2s){
                    for(var id in slider2s){
                        var uid = "cmp_" + id;
                        var component = Global.checkCmpJson(cmp_settings[uid]);
                        Chidopi.slider2.createComponent(component, sys_vars);
                    }
                }
				
                var gravity = Global.components.gravity;
                if(gravity){
                    for(var id in gravity){
                        var uid = "cmp_" + id;
                        var component = cmp_settings[uid];
                        Chidopi.Gravity.createComponent(component, sys_vars);
                    }
                }
                
                var diypuzzle = Global.components.diypuzzle;
                if(diypuzzle){
                    for(var id in diypuzzle){
                        var uid = "cmp_" + id;
                        var component = cmp_settings[uid];
                        Chidopi.diypuzzle.createComponent(component, sys_vars);
                    }
                }
                
                var spotlight = Global.components.spotlight;
                if(spotlight){
                    for(var id in spotlight){
                        var uid = "cmp_" + id;
                        var component = cmp_settings[uid];
                        Chidopi.spotlight.createComponent(component, sys_vars);
                    }
                }
                var axismove = Global.components.axismove;
                if(axismove){
                    for(var id in axismove){
                        var uid = "cmp_" + id;
                        var component = cmp_settings[uid];
                        Chidopi.axismove.createComponent(component, sys_vars);
                    }
                }
				
				var rotate360 = Global.components.rotate360;
                if(rotate360){
                    for(var id in rotate360){
                        var uid = "cmp_" + id;
                        var component = cmp_settings[uid];
                        Chidopi.rotate360.createComponent(component, sys_vars);
                    }
                }

                var vocabulary = Global.components.vocabulary;
                if(vocabulary){
                	seajs.use('<?php echo base_url(); ?>js/components/vocabulary-mod.js', function(module) {
                	    for(var id in vocabulary){
                            var uid = "cmp_" + id;
                            var component = cmp_settings[uid];
                        	module.createComponent(component,sys_vars);
                        }
                	});
                }

                var ids = Global.components.text2;
                if(ids){
                	seajs.use('<?php echo base_url(); ?>js/components/text2-mod.js', function(module) {
	                	for(var id in ids){
	                        var uid = "cmp_" + id;
	                        var component = cmp_settings[uid];
	                        module.createComponent(component,sys_vars);
	                    }
                	});
                }
                
	        	Global.sortZindex();
            } 
			
            function initVariable(){
                previewContainer = $("#div-background");
                sys_vars.cmp_container =  previewContainer;	
            }

            // init
            $(function(){
                initVariable ();
                if('<?php echo $isAdd ?>' != '1'){		
                    loadData();
                }else{
                    //updatePreviewArea1();
                }
	
                var ctx = "<?php echo base_url(); ?>";
                init_bar(bar,ctx);				
				
				
                $("#start_button").click();
						
                $("#bar_preview").click(function(){
                    doPreview();
                });
	
                $("#bar_save").click(function(){
                    $("#global").val(JSON.stringify(Global));

                    var queryString = $('#mainForm').formSerialize();	
                    
                    $.ajax({
                        type: "post",
                        url: '<?php echo base_url(); ?>motionbox/save', 
                        data :queryString,
                        dataType : 'json',
                        success : function (data, textStatus){
                            window.top.LoadingBar.hide();
                            if(data=="1"){
                                dialog.alert(Chidopi.lang.title.save,Chidopi.lang.msg.saveSucc);
                            }else{
                                dialog.alert(Chidopi.lang.title.error,Chidopi.lang.msg.saveFail);
                            }			  
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown){
                            window.top.LoadingBar.hide();
                            dialog.alert(Chidopi.lang.title.error,errorThrown);
                        }
                    });
                    window.top.LoadingBar.show();
						
                    //$('#mainForm').attr("target","_blank");
                    //$('#mainForm').attr("action","<?php //echo base_url();      ?>motionbox/save");
                    //$("#mainForm").submit();
                });
	
                $("#div-background .component").live("dblclick", function(){
                    var id = $(this).attr("id");
                    var type = id.split("_")[0];
                    
                    if(type=="vocabulary" || type =="text2"){
                    	Global.editComponent(id,type,'components/'+type+'-mod.js');
                    }else{
                        Global.editComponent(id,type);
                    }
                });
                
                $("#cmp_table_list .ui-icon-pencil").live("click", function(){
                    var type = $(this).attr("data");
                    var id = $(this).attr("cid");
                    if(type=="vocabulary" || type =="text2"){
                    	Global.editComponent(id,type,'components/'+type+'-mod.js');
                    }else{
                        Global.editComponent(id,type);
                    }
                });

				
				$(".table_sub>tbody>tr, .table_zindex>tbody>tr").live("click",function(){
					var id = $(this).attr("cid");
				    highlight(id);
				});
				
				$("#tabs-list").tabs();	

				$("#bar_vocabulary").click(function(){
					seajs.use('components/vocabulary-mod.js', function(vocabulary) {
                    	vocabulary.initCreate();
                    });
				});

				$("#bar_text2").click(function(){
					seajs.use('components/text2-mod.js', function(text2) {
                    	text2.initCreate();
                    });
				});
	
            });


            function doPreview(){
              //  var url = "<?php echo base_url(); ?>motionbox/preview";
				var url = "<?php echo base_url(); ?>index.php?c=motionbox&m=preview";
                $("#global").val(JSON.stringify(Global));
                $("#mainForm").attr("action",url);
                $("#mainForm").attr("target","Preview");
                $("#mainForm").submit(function(){
                    var width = parseInt($("#bWidth").val());
                    var height = parseInt($("#bHeight").val());
                    var newwin = window.open('','Preview','location=yes,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no,width=' + width + ', height=' + height );
                    newwin.opener = null;
                });
                $("#mainForm").submit();
                $("#mainForm").unbind("submit");
            }

        </script>
    </head>

    <body>
        <!-- nav bar -->
        <div id="div_nav" class="unit html5editor" ><div class="container">
            <div class="navbox" >
                <div class="start hide">
                    <a id="start_button" class="button_hide"><img src="css/images/nav/book-bookmark.png" width="32"/></a>
                </div>
                <div id="nav" class="nav_bar" style="display:none;">
                    <div style="margin-top:5px;">       
                    </div>
                </div>
            </div>
        </div></div> <!-- nav bar end-->

        <!-- main Area -->
        <script>
            function updateBackgroundArea(){
                var background = $("#div-background");
                var bFileName = $("#bFileName").val();
                var url = "";
                if(bFileName){
                    url=  'url(' + "<?php echo base_url()?>"+ sys_vars.user_res_path + bFileName + ")";
                }else{
                    url= "none";
                }
                background.css("background-color",$("#bColor").val());
                background.css("background-image", url );
		
                var width = $("#bPageWidth").val();
                var height = $("#bPageHeight").val();
                background.width(width).height(height);
                Elastic.refresh();
                // TODO save to db ?
            }
        </script>
        <div id="div_main" class="columns on-2 same-height  html5editor" style="width:100%">
            <div class="column fixed sidebar" style="width: 200px; background-color:#f0f0f0;">
                <div class="container full-height">
                <div id="tabs-list" style="height:99%">
                    <UL style="background:#F0F0F0;border-width:0;">										
                        <LI><A href="#tabs-list-1"><?php echo lang('label.tab.list'); ?></A></LI>
                        <LI><A href="#tabs-list-2"><?php echo lang('label.tab.zindex'); ?></A></LI>
                    </UL>
                    <div id="tabs-list-1" style="padding:5px 0;">
                    <!--h3>元件列表</h3-->
                    <table id="cmp_table_list" class="table_list">
                        <!-- Image 元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_img').toggleClass('hidden');"><?php echo lang('label.nav.image'); ?></a></th></tr>
                        <tr id="tr_img"><td>
                                <table id="t_img" class="table_sub" >

                                </table>
                            </td></tr><!-- Image 元件列表 End-->

                        <!-- Link 元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_link').toggleClass('hidden');"><?php echo lang('label.nav.link'); ?></a></th></tr>
                        <tr id="tr_link"><td>
                                <table id="t_link" class="table_sub" >                  
                                </table>
                            </td></tr><!-- Link 元件列表 End-->

                        <!-- App動作元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_action').toggleClass('hidden');"><?php echo lang('label.nav.action'); ?></a></th></tr>
                        <tr id="tr_action"><td>
                                <table id="t_action" class="table_sub" >                  
                                </table>
                            </td></tr><!-- App動作元件列 End-->

                        <!-- 視頻元件列表  -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_video').toggleClass('hidden');"><?php echo lang('label.nav.video'); ?></a></th></tr>
                        <tr id="tr_video"><td>
                                <table id="t_video" class="table_sub" >               
                                </table>
                            </td></tr><!-- 視頻元件列表 End-->

                        <!-- 音頻元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_audio').toggleClass('hidden');"><?php echo lang('label.nav.audio'); ?></a></th></tr>
                        <tr id="tr_audio"><td>
                                <table id="t_audio" class="table_sub" >               
                                </table>
                            </td></tr><!-- 音頻元件列表 End-->

                        <!-- 文本元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_text').toggleClass('hidden');"><?php echo lang('label.nav.text'); ?></a></th></tr>
                        <tr id="tr_text"><td>
                                <table id="t_text" class="table_sub" >               
                                </table>
                            </td></tr><!-- 文本元件列表 End-->

                        <!-- 筆記元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_note').toggleClass('hidden');"><?php echo lang('label.nav.note'); ?></a></th></tr>
                        <tr id="tr_note"><td>
                                <table id="t_note" class="table_sub" >               
                                </table>
                            </td></tr><!-- 文本元件列表 End-->

                        <!-- 拼圖元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_pazzle').toggleClass('hidden');"><?php echo lang('label.nav.puzzle'); ?></a></th></tr>
                        <tr id="tr_pazzle"><td>
                                <table id="t_pazzle" class="table_sub" >               
                                </table>
                            </td></tr><!-- 拼圖元件列表 End-->

                        <!-- QA元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_qa').toggleClass('hidden');"><?php echo lang('label.nav.qa'); ?></a></th></tr>
                        <tr id="tr_qa"><td>
                                <table id="t_qa" class="table_sub" >               
                                </table>
                            </td></tr><!-- QA元件列表 End-->

                        <!-- 幻燈片元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_slider2').toggleClass('hidden');"><?php echo lang('label.nav.slider2'); ?></a></th></tr>
                        <tr id="tr_slider2"><td>
                                <table id="t_slider2" class="table_sub" >               
                                </table>
                            </td></tr><!-- 幻燈片元件列表 End-->
                        <!-- 連連看元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_lianliankan').toggleClass('hidden');"><?php echo lang('label.nav.llk'); ?></a></th></tr>
                        <tr id="tr_lianliankan"><td>
                                <table id="t_lianliankan" class="table_sub" >               
                                </table>
                            </td></tr><!-- 連連看元件列表 End-->

                        <!-- 體感元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_gravity').toggleClass('hidden');"><?php echo lang('label.nav.gravity'); ?></a></th></tr>
                        <tr id="tr_gravity"><td>
                                <table id="t_gravity" class="table_sub" >               
                                </table>
                            </td></tr><!-- 文本元件列表 End-->


                        <!-- 自定拼图元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_diypuzzle').toggleClass('hidden');"><?php echo lang('label.nav.diypuzzle'); ?></a></th></tr>
                        <tr id="tr_diypuzzle"><td>
                                <table id="t_diypuzzle" class="table_sub" >               
                                </table>
                            </td></tr><!-- 自定拼图元件列表 End-->
                        
                        <!-- 按照灯元件列表 -->
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_spotlight').toggleClass('hidden');"><?php echo lang('label.nav.spotlight'); ?></a></th></tr>
                        <tr id="tr_spotlight"><td>
                                <table id="t_spotlight" class="table_sub" >               
                                </table>
                            </td></tr><!-- 按照灯元件列表 End-->
                            
                        <!-- 滚动轴元件列表 -->                        
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_axismove').toggleClass('hidden');"><?php echo lang('label.nav.axismove'); ?></a></th></tr>
                        <tr id="tr_axismove"><td>
                                <table id="t_axismove" class="table_sub" >               
                                </table>
                            </td></tr><!-- 滚动轴元件列表 End-->
                        
                        <!-- 360度元件列表 -->                        
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_rotate360').toggleClass('hidden');"><?php echo lang('label.nav.rotate360'); ?></a></th></tr>
                        <tr id="tr_rotate360"><td>
                                <table id="t_rotate360" class="table_sub" >               
                                </table>
                            </td></tr><!-- 360度元件列表 End-->
                            
                        <!-- 语法游戏列表 -->                        
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_vocabulary').toggleClass('hidden');"><?php echo lang('label.nav.vocabulary'); ?></a></th></tr>
                        <tr id="tr_vocabulary"><td>
                                <table id="t_vocabulary" class="table_sub" >               
                                </table>
                            </td></tr><!-- 语法游戏列表 End-->
                            
                        <!-- html编辑列表 -->                        
                        <tr><th><a href="javascript:void(0);" onclick="$('#t_text2').toggleClass('hidden');"><?php echo lang('label.nav.text2'); ?></a></th></tr>
                        <tr id="tr_text2"><td>
                            <table id="t_text2" class="table_sub" >               
                            </table>
                        </td></tr><!-- html编辑列表 End-->
                                
                        <tr style="height:1px; border-bottom:1px solid #333;"><th></th></tr>
                    </table>
                    </div>
                    <div id="tabs-list-2" style="padding:5px 0;">
                         <table id="cmp_table_zindex" class="table_list table_zindex">                            
                             <tr>
                                 <th colspan="4"></th>                                                              
                             </tr>
                             <tbody id="tb_zindex_list"></tbody>                            
                         </table>
                    </div>
                </div>   
                </div>
            </div>
            <div class="column elastic content">
                <div class="container full-height">
                    <div id="div-background" style="width:<?php echo $bWidth; ?>px;height:<?php echo $bHeight; ?>px;">
                    </div>
                </div>
            </div>
        </div><!-- main Area end -->
        <!-- main Form -->
        <div id="form_area" style="display:none">
            <form name="mainForm" id="mainForm" method="post">
                <input type="hidden" name="global" id="global" />
                <input type="hidden" name="bOrientation" id="bOrientation" value="<?php echo $bOrientation; ?>"/>
                <input type="hidden" name="bWidth" id="bWidth" value="<?php echo $bWidth; ?>"/>
                <input type="hidden" name="bHeight" id="bHeight" value="<?php echo $bHeight; ?>"/>
                <input type="hidden" name="bPageWidth" id="bPageWidth" value="<?php echo (isset($bPageWidth) ? $bPageWidth : $bWidth); ?>"/>
                <input type="hidden" name="bPageHeight" id="bPageHeight" value="<?php echo (isset($bPageHeight) ? $bPageHeight : $bHeight); ?>"/>
                <input type="hidden" name="bPageScale" id="bPageScale" value="<?php echo (isset($bPageScale) ? $bPageScale : '1:1'); ?>"/>
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>"/>
                <input type="hidden" name="book_id" id="book_id" value="<?php echo $bookid; ?>"/>
                <input type="hidden" name="page_id" id="page_id" value="<?php echo $pageid; ?>"/>							
                <input type="hidden" name="user_temp" id="user_temp" value="<?php echo $user_temp; ?>" />
                <input type="hidden" name="ownerPath" id="ownerPath" value="<?php echo $ownerPath ?>"/>
                <input type="hidden" name="user_res_path" id="user_res_path" 
                       value="../<?php echo $user_files_path; ?>resource/"/>
                <input type="hidden" name="bFileName" id="bFileName" title=""/ >
                <input type="hidden" name="bColor" id="bColor" value="#ffffff"/>
                <input type="hidden" name="hColor" id="hColor" value="#000000"/>
                <input type="hidden" name="bsFileName" id="bsFileName" title=""/>
                <input type="hidden" name="bsLoop" id="bsLoop" />
                <input type="hidden" name="bLoadAction" id="bLoadAction" />
                <input type="hidden" name="bUnLoadAction" id="bUnLoadAction" />
            </form>
        </div><!-- main Form end -->

        <div id="bar_dialog" style="display:none">
            <select multiple="true" id="bar_select"></select>
        </div>
        <!-- background dialog -->
        <?php $this->load->view("components/background"); ?>
        <!-- background dialog end -->

        <!-- image dialog -->
        <?php $this->load->view("components/image"); ?>
        <!-- image dialog end -->

        <!-- link dialog -->
        <?php $this->load->view("components/link"); ?>
        <!-- link dialog end -->

        <!-- action dialog -->
        <?php $this->load->view("components/action"); ?>
        <!-- action dialog end -->

        <!-- video dialog -->
        <?php $this->load->view("components/video"); ?>
        <!-- video dialog end -->

        <!-- audio dialog -->
        <?php $this->load->view("components/audio"); ?>
        <!-- audio dialog end-->

        <!-- note dialog -->
        <?php $this->load->view("components/note"); ?>
        <!-- note dialog end-->

        <!-- text dialog -->
        <?php $this->load->view("components/text"); ?>
        <!-- text dialog end-->

        <!-- pazzle dialog -->
        <?php $this->load->view("components/pazzle"); ?>
        <!-- pazzle dialog end-->

        <!-- qa dialog -->
        <?php $this->load->view("components/qa"); ?>
        <!-- qa dialog end-->

        <!-- slider2 dialog -->
        <?php $this->load->view("components/slider2"); ?>
        <!-- slider2 dialog end-->

        <!-- lianliankan dialog -->
        <?php $this->load->view("components/lianliankan"); ?>
        <!-- lianliankan dialog end-->

        <!-- gravity dialog -->
        <?php $this->load->view("components/gravity"); ?>
        <!-- gravity dialog end-->

        <!-- lianliankan dialog -->
        <?php $this->load->view("components/lianliankan"); ?>
        <!-- lianliankan dialog end-->

        <!-- diy puzzle dialog -->
        <?php $this->load->view("components/diypuzzle"); ?>
        <!-- diy puzzle dialog end-->
        
        <!-- spotlight dialog -->
        <?php $this->load->view("components/spotlight"); ?>
        <!-- spotlight dialog end-->
        
        <!-- axismove dialog -->
        <?php $this->load->view("components/axismove"); ?>
        <!-- axismove dialog end-->
        
        <!-- rotate360 dialog -->
        <?php $this->load->view("components/rotate360"); ?>
        <!-- rotate360 dialog end-->
        
        <!-- vocabulary dialog -->
        <?php $this->load->view("components/vocabulary"); ?>
        <!-- vocabulary dialog end-->
        
        <!-- text2 dialog -->
        <?php $this->load->view("components/text2"); ?>
        <!-- text2 dialog end-->
        
    </body>
</html>
