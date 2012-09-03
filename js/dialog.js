document.write('<div id="chidopiDialogDiv" style="display:none;z-index:10000;">');
document.write('<p id="msgBody" ></p>');
document.write('</div>');

window.chidopi = {};

window.chidopi.alert = function(title,msg) {

    msgopts = {
        title: title,
        autoOpen:false,
        resizable:false,
        bgiframe:true,
        width:400,
        height:150,
        modal:true,
        buttons: [{text:Chidopi.lang.btn.ok, click:alertOK,}]
    };
    $('#chidopiDialogDiv').dialog('destroy');
    $('#chidopiDialogDiv').dialog(msgopts);
    $('#msgBody').html(msg);      
    $('#chidopiDialogDiv').dialog('open');    
}

alertOK = function(){
  $(this).dialog("close");
}

window.chidopi.blockMsg = function(title,msg){
	msgopts = {
        //title: title,
        autoOpen:false,
        resizable:false,
        width:400,
        bgiframe:true,
        height:150,
        modal:true,
        open: function(event, ui) {  
		    //hide close button. 
		    $(this).parent().children().children('.ui-dialog-titlebar-close').hide(); 
		},
		close:function(event,ui){
		    $(this).parent().children().children('.ui-dialog-titlebar-close').show(); 
		}
    };
    
    $('#chidopiDialogDiv').dialog('destroy');
    $('#chidopiDialogDiv').dialog(msgopts);
    $('#msgBody').html(msg);
    $('#chidopiDialogDiv').dialog('open');   
}
window.chidopi.blockMsg.close = function () {   
     $('#chidopiDialogDiv').dialog('close');
};

var mDialogCallback;
window.chidopi.confirm = function(title, msg, fun){
    if(fun!= null) mDialogCallback = fun;
    msgopts = {
        title: title,
        autoOpen:false,
        resizable:false,
        bgiframe:true,
        width:400,
        height:150,
        modal:true,
        buttons:[{text:Chidopi.lang.btn.no, click: confirmNo},
                 {text:Chidopi.lang.btn.yes, click: confirmYes }]
    };    
    $('#chidopiDialogDiv').dialog('destroy');
    $('#chidopiDialogDiv').dialog(msgopts);
    $('#msgBody').html(msg);    
    $('#chidopiDialogDiv').dialog('open'); 
}
confirmYes= function(){
    $(this).dialog('close');
    if(mDialogCallback) mDialogCallback(true);
}

confirmNo = function(){    
    $(this).dialog('close'); 
    if(mDialogCallback) mDialogCallback(false);
}

window.chidopi.closeWindow= function(){
	$('#chidopiDialogDiv').dialog('destroy');
	$('#chidopiDialogDiv').dialog('close');
}
