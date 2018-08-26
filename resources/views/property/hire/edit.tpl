<{extends file="property/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#pic_ids').uploader(undefined, undefined, undefined, undefined, 20);
<{/block}>

<{block "title"}>租赁<{/block}>
<{block "subtitle"}><{$_data.building.building_name}>-<{$_data.floor.name}><{/block}>

<{block "name"}>hire<{/block}>

<{block "fields"}>
<{include file="property/hire/fields.inc.tpl"}>
<{/block}>
