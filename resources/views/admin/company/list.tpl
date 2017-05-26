<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>公司<{/block}>

<{block "name"}>company<{/block}>

<{block "filter"}>
<{include file="admin/company/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>公司名</th>
<th>公司logo</th>
<th>标签</th>
<th>所属楼</th>
<th>楼层</th>
<th>规模</th>
<th>描述</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="name" data-orderable="false">{{data}}</td>
<td data-from="logo_id" data-orderable="false">
	<img src="<{''|attachment}>?id={{data}}&width=80&height=80" alt="avatar" class="img-rounded">
</td>
<td data-from="tags" data-orderable="false">
{{each data as v k}}
<span class="label label-info">{{v.tag_name}}</span>
{{/each}}
</td>
<td data-from="building" data-orderable="false"><a href="<{'admin/building?f[id][eq]='|url}>{{data.id}}">{{data.building_name}}</a></td>
<td data-from="floors" data-orderable="false">
{{each data as v k}}
<a href="<{'admin/floor?f[id][eq]='|url}>{{v.id}}">
<span class="label label-primary">{{v.name}}</span>
</a>
{{/each}}
</td>
<td data-from="people_scale">{{data}}</td>
<td data-from="description">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个楼层：{{full.name}}吗？<{/block}>