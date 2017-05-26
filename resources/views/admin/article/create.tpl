<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#pic_id').uploader();
var $editor_content = UE.getEditor('contents',$.ueditor_default_setting.simple);
<{/block}>

<{block "title"}>资讯<{/block}>

<{block "name"}>article<{/block}>

<{block "fields"}>
<{include file="admin/article/fields.inc.tpl"}>
<{/block}>
