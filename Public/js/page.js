$(function(){



	//service
	;(function(){
		var dialog = $("#serDetaile");

		if ( !dialog.length ) return;

		var dialogTitle = dialog.find(".sdTitle");
		var dialogContent = dialog.find(".sdContent");
		var inner = dialog.find(".sdContentInner");
		var dialogClose = dialog.find(".sdCloseBtn");
		var mask = $("#mask");
		var target = null;
		var content = null;

		dialogContent.mCustomScrollbar();

	})();

})
	
