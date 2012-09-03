<div id="vocabulary_c_<{$id}>" class="chidopi_component3D"
     style="position: absolute; left:<{$x}>px; top:<{$y}>px;z-index:<{$zIndex}>;">
    <canvas id="vocabulary_<{$id}>" class="click_ignore_me" width="<{$width}>" height="<{$height}>"></canvas>
</div>


<script type="text/javascript">
    var cache_key = "vocabulary_<{$id}>";
    var base_dir = "<{$res_dir}>";
    var game_vocab_json = JSON.parse('<{$json}>');
    var startScene = game_vocab_json.startScene;
    var scoreScene = game_vocab_json.scoreScene;
    var succScene = game_vocab_json.succScene;
    var loserScene = game_vocab_json.failScene;
    var levelScenes = game_vocab_json.levelScenes;

    var vocab_bgsound_taggle = true;
    var vocab_bgsound = game_vocab_json.startScene.bgSound;
    if (vocab_bgsound) {
        bgGameSound = "<{$res_dir}>" + vocab_bgsound;
    }

    //图片预加载很重要，写代码时出现过一次返回按钮图片未加载，搞了一下天才找出bug...shit....!!!!!!!!!

    var g_ressources = []; //需要预加载的资源
    if (game_vocab_json.backIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.backIcon.pic1})
    if (game_vocab_json.failScene.bgPic) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.failScene.bgPic});
    if (game_vocab_json.failScene.scoreIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.failScene.scoreIcon.pic1});
    if (game_vocab_json.failScene.scoreIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.failScene.scoreIcon.pic2});
    if (game_vocab_json.failScene.tryAgainIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.failScene.tryAgainIcon.pic1});
    if (game_vocab_json.failScene.tryAgainIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.failScene.tryAgainIcon.pic2});

    _.each(game_vocab_json.levelScenes, function (levelScene) {
        if (levelScene.bgPic) g_ressources.push({type:"image", src:"<{$res_dir}>" + levelScene.bgPic});
        _.each(levelScene.gameContent, function (level) {
            if (level.answer) g_ressources.push({type:"image", src:"<{$res_dir}>" + level.answer});
            if (level.question) g_ressources.push({type:"image", src:"<{$res_dir}>" + level.question});
        })
        if (levelScene.readyGoIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + levelScene.readyGoIcon.pic1});
    });
    if (game_vocab_json.particle.img) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.particle.img});
    if (game_vocab_json.scoreScene.bgPic) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.scoreScene.bgPic});

    if (game_vocab_json.startScene.bgPic) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.bgPic});
    if (game_vocab_json.startScene.bgSoundIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.bgSoundIcon.pic1});
    if (game_vocab_json.startScene.bgSoundIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.bgSoundIcon.pic2});
    if (game_vocab_json.startScene.continueIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.continueIcon.pic1});
    if (game_vocab_json.startScene.continueIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.continueIcon.pic2});
    if (game_vocab_json.startScene.scoreIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.scoreIcon.pic1});
    if (game_vocab_json.startScene.scoreIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.scoreIcon.pic2});
    if (game_vocab_json.startScene.startIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.startIcon.pic1});
    if (game_vocab_json.startScene.startIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.startIcon.pic2});
    if (game_vocab_json.startScene.loadingPic) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.startScene.loadingPic});

    if (game_vocab_json.succScene.bgPic) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.succScene.bgPic});
    if (game_vocab_json.succScene.scoreIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.succScene.scoreIcon.pic1});
    if (game_vocab_json.succScene.scoreIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.succScene.scoreIcon.pic2});
    if (game_vocab_json.succScene.tryAgainIcon.pic1) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.succScene.tryAgainIcon.pic1});
    if (game_vocab_json.succScene.tryAgainIcon.pic2) g_ressources.push({type:"image", src:"<{$res_dir}>" + game_vocab_json.succScene.tryAgainIcon.pic2});


    var cc = cc = cc || {};
    //Cocos2d directory
    cc.Dir = '';//in relate to the html file or use absolute
    cc.loadQue = [];//the load que which js files are loaded
    cc.COCOS2D_DEBUG = 2;
    cc._DEBUG = 1;
    cc._IS_RETINA_DISPLAY_SUPPORTED = 0;
    //html5 selector method
    cc.$ = function (x) {
        return document.querySelector(x);
    };
    cc.$new = function (x) {
        return document.createElement(x);
    };

    cc.loadjs = function (filename) {
        //add the file to the que
        var script = cc.$new('script');
        script.src = cc.Dir + filename;
        script.order = cc.loadQue.length;
        cc.loadQue.push(script);


        script.onload = function () {
            var hasLoaded = 0;
            var loadinterval = null;
            //file have finished loading,
            //if there is more file to load, we should put the next file on the head
            if (this.order + 1 < cc.loadQue.length) {
                cc.$('head').appendChild(cc.loadQue[this.order + 1]);
                //console.log(this.order);
            }
            else {
                cc.setup("vocabulary_<{$id}>");

                //init audio,mp3 or ogg
                //for example:
                // cc.AudioManager.sharedEngine().init("mp3,ogg");
                // cc.AudioManager.sharedEngine().init("mp3");

                //we are ready to run the game
                cc.Loader.shareLoader().onloading = function () {
                    // cc.LoaderScene.shareLoaderScene().draw();
                    if (game_vocab_json.startScene.loadingPic)
                        new DiyLoaderScene(base_dir + game_vocab_json.startScene.loadingPic, parseInt(game_vocab_json.width), parseInt(game_vocab_json.height)).draw();
                };
                cc.Loader.shareLoader().onload = function () {
                    hasLoaded = 1;

                };
                //preload ressources
                cc.Loader.shareLoader().preload(g_ressources);
                loadinterval = setInterval(function () {
                    if (hasLoaded == 1) {
                        clearInterval(loadinterval);
                        cc.AppController.shareAppController().didFinishLaunchingWithOptions();
                    }
                }, 1000);

            }
        };
        if (script.order === 0)//if the first file to load, then we put it on the head
        {
            cc.$('head').appendChild(script);
        }
    };

    cc.loadjs('<{$library_dir}>/cocos2d-html/Cocos2d-html5-canvasmenu-min.js');

    // User files
    cc.loadjs('<{$library_dir}>vocabulary/Classes/DiyLoaderScene.js');

    cc.loadjs('<{$library_dir}>vocabulary/Classes/AppDelegate.js');//17
    cc.loadjs('<{$library_dir}>vocabulary/Classes/Balloon.js');

    cc.loadjs('<{$library_dir}>vocabulary/Classes/BaseScene.js');
    cc.loadjs('<{$library_dir}>vocabulary/Classes/BaseLayer.js');

    cc.loadjs('<{$library_dir}>vocabulary/Classes/Level.js');
    cc.loadjs('<{$library_dir}>vocabulary/Classes/SceneLevel.js');

    cc.loadjs('<{$library_dir}>vocabulary/Classes/Win.js');
    cc.loadjs('<{$library_dir}>vocabulary/Classes/Lose.js');
    cc.loadjs('<{$library_dir}>vocabulary/Classes/ScoreBoard.js');
    cc.loadjs('<{$library_dir}>vocabulary/Classes/SceneMainMenu.js');//19


</script>

