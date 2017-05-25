<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>楼层<{/block}>

<{block "name"}>floor<{/block}>

<{block "filter"}>
<{include file="admin/floor/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>楼层名</th>
<th>所属楼</th>
<th>公司数</th>
<th>描述</th>
<th>排序</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="name" data-orderable="false">{{data}}</td>
<td data-from="building" data-orderable="false">{{data.building_name}}</td>
<td data-from="" data-orderable="false"><a href="<{'admin/company?q[ofFloor]='|url}>{{full.id}}">{{full.company_cnt}}</a></td>
<td data-from="description">{{data}}</td>
<td data-from="porder">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个楼层：{{full.name}}吗？<{/block}>