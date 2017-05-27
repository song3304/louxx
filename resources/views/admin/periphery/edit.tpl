<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-scripts-after"}>
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=062d0707736c31dbc8d66e69c0afc469"></script>
    <script type="text/javascript" src="<{'static/js/GPS.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/location.js'|url}>"></script>
<{/block}>

<{block "title"}>周边<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>periphery<{/block}>

<{block "fields"}>
<{include file="admin/periphery/fields.inc.tpl"}>
<{/block}>
