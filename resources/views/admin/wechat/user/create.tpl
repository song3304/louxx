<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#qr_aid').uploader();
<{/block}>

<{block "title"}>微信用户<{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "fields"}>
<{include file="admin/wechat/user/fields.inc.tpl"}>
<{/block}>
