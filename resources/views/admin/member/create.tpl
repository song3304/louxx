<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#avatar_aid').uploader();
<{/block}>

<{block "title"}>用户<{/block}>

<{block "name"}>member<{/block}>

<{block "block-title-title"}>
<{include file="admin/member/fields-nav.inc.tpl"}>
<{/block}>

<{block "fields"}>
<{include file="admin/member/fields.inc.tpl"}>
<{/block}>

