<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>找楼<{/block}>
<{block "subtitle"}><{$_data.phone}>-<{$_data.note}><{/block}>

<{block "name"}>find-building<{/block}>

<{block "fields"}>
<{include file="admin/find_building/fields.inc.tpl"}>
<{/block}>
