<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>办公楼<{/block}>

<{block "name"}>building<{/block}>

<{block "filter"}>
<{include file="admin/building/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>楼名</th>
<th>所属物业</th>
<th>地址</th>
<th>小区名</th>
<th>经度</th>
<th>纬度</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="building_name" data-orderable="false">{{data}}</td>
<td data-from="properter" data-orderable="false">{{data.name}}</td>
<td data-from="full_address">{{data}}</td>
<td data-from="village_name">{{data}}</td>
<td data-from="longitude">{{data}}</td>
<td data-from="latitude">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个物业：{{full.building_name}}吗？<{/block}>