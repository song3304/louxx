<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>找楼<{/block}>

<{block "name"}>find-building<{/block}>

<{block "filter"}>
<{include file="admin/find_building/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>手机号</th>
<th>租金起</th>
<th>租金止</th>
<th>省</th>
<th>市</th>
<th>区</th>
<th>备注</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="phone">{{data}}</td>
<td data-from="rent_low">{{data}}</td>
<td data-from="rent_high">{{data}}</td>
<td data-from="province_name" data-orderable="false">{{data.area_name}}</td>
<td data-from="city_name" data-orderable="false">{{data.area_name}}</td>
<td data-from="area_name" data-orderable="false">{{data.area_name}}</td>
<td data-from="note" data-orderable="false">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这条找楼信息：{{full.note}}吗？<{/block}>