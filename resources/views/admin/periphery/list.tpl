<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>周边<{/block}>

<{block "name"}>periphery<{/block}>

<{block "filter"}>
<{include file="admin/periphery/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>场所名</th>
<th>所属楼</th>
<th>类型</th>
<th>经度</th>
<th>纬度</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="name" data-orderable="false">{{data}}</td>
<td data-from="building" data-orderable="false"><a href="<{'admin/building?f[id][eq]='|url}>{{data.id}}">{{data.building_name}}</a></td>
<td data-from="type_tag" data-orderable="false">{{data}}</td>
<td data-from="longitude">{{data}}</td>
<td data-from="latitude">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个周边：{{full.name}}吗？<{/block}>