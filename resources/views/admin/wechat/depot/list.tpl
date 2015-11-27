<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>素材库<{/block}>

<{block "name"}>wechat/depot<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'static/css/admin/wechat.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
<{include file="common/uploader.inc.tpl"}>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/ui-bootstrap-tpls-0.14.3.min.js'|url}>"></script>
<script src="<{'static/js/angular/angular-input-modified.min.js'|url}>"></script>
<script src="<{'static/js/angular/common.js'|url}>"></script>
<script src="<{'static/js/admin/wechat.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('[name="wechat/depot/list"]').addClass('active').parents('li').addClass('active');
	});
})(jQuery);
</script>
<{/block}>

<{block "block-container"}>

<div depot-controller="text" mode="edit"></div>

<{include file="admin/wechat/depot/ng-template/depot-controller.tpl"}>
<{include file="admin/wechat/depot/ng-template/depot-list.tpl"}>
<{include file="admin/wechat/depot/ng-template/depot-edit.tpl"}>


<{/block}>