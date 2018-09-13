<{extends file="admin/extends/edit.block.tpl"}>


<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#pic_ids').uploader(undefined, undefined, undefined, undefined, 20);
<{/block}>

<{block "head-scripts-after"}>
    <!--script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=062d0707736c31dbc8d66e69c0afc469"></script>
    <script type="text/javascript" src="<{'static/js/GPS.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/location.js'|url}>"></script-->
    
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.9&key=879a6e897959d23c7638450d40cc75e0"></script>
    <script type="text/javascript" src="<{'static/js/location_gaode.js'|url}>"></script>
    <script src="<{'js/DatePicker/WdatePicker.js'|static}>"></script>
<{/block}>

<{block "title"}>办公楼<{/block}>
<{block "subtitle"}><{$_data.building_name}><{/block}>

<{block "name"}>building<{/block}>

<{block "block-title-title"}>
<{include file="admin/building/fields-nav.inc.tpl"}>
<{/block}>

<{block "fields"}>
<{include file="admin/building/fields.inc.tpl"}>
<{/block}>
