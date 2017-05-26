<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>公司<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#logo_id').uploader();
<{/block}>

<{block "name"}>company<{/block}>

<{block "fields"}>
<{include file="admin/company/fields.inc.tpl"}>
<{/block}>
