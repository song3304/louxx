<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#pic_ids').uploader(undefined, undefined, undefined, undefined, 20);
<{/block}>

<{block "head-scripts-after"}>
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=062d0707736c31dbc8d66e69c0afc469"></script>
    <script type="text/javascript" src="<{'static/js/GPS.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/location.js'|url}>"></script>
<{/block}>

<{block "title"}>办公楼<{/block}>

<{block "name"}>building<{/block}>

<{block "fields"}>
<{include file="admin/building/fields.inc.tpl"}>
<{/block}>
