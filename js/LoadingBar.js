var LoadingBar={
	show:function(msg,ht){
		
		var message=msg||'Loading...';
		if(!document.getElementById("loading_bar"))
			LoadingBar.initalize(message);	    
		this.loadingPanel.style.visibility="visible";
		if(ht&&!isNaN(ht)){
            ht=ht||10000;
			this.timeOutHide(ht);
		}
	},
	hide:function(){	    
	    if(this.loadingPanel)
		    this.loadingPanel.style.visibility="hidden";
	},
	timeOutHide:function(ht){
		window.setTimeout("LoadingBar.hide()",ht);	
	}
	,
	initalize:function(msg){
		this.panelStr='<div id="loading">'+
						'<div class="loading-indicator">'+
						'<span>&nbsp;</span>&nbsp;&nbsp;&nbsp;'+msg+'</div></div>'+(!!(window.attachEvent && !window.opera)?'<iframe></iframe>':'');
		this.loadingPanel=document.createElement("div");
		this.loadingPanel.id="loading_bar";
		this.loadingPanel.innerHTML=this.panelStr;
		this.loadingPanel.style.height=document.documentElement.offsetHeight +'px';
		document.body.appendChild(this.loadingPanel);
	}
}
