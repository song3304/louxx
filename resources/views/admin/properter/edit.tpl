<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>物业<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>properter<{/block}>

<{block "fields"}>
<{include file="admin/properter/fields.inc.tpl"}>
<{/block}>
