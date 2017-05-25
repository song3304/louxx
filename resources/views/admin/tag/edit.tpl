<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>标签<{/block}>
<{block "subtitle"}><{$_data.tag_name}><{/block}>

<{block "name"}>tag<{/block}>

<{block "fields"}>
<{include file="admin/tag/fields.inc.tpl"}>
<{/block}>
