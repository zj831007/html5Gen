/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.baseFloatZIndex = 9000;
	config.filebrowserBrowseUrl = 'kcfinder/browse.php?type=files';
    config.filebrowserUploadUrl = 'kcfinder/upload.php?type=files';
    config.filebrowserVideoBrowseUrl = "kcfinder/browse.php?type=video"
	//config.filebrowserImageBrowseUrl = 'kcfinder/browse.php?type=images';
    //config.filebrowserImageUploadUrl = 'kcfinder/upload.php?type=images';
    config.extraPlugins='video';
	config.toolbar = 'MyToolbar';
	config.toolbar_MyToolbar =
	[
		{ name: 'document', items : [ 'Source','-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','Find','Replace','-','SelectAll' ] },			
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		'/',
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Video','Image','Table','HorizontalRule','SpecialChar','PageBreak'] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	];
};
