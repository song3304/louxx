<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>楼层<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>floor<{/block}>

<{block "fields"}>
<{include file="admin/floor/fields.inc.tpl"}>
<{/block}>
