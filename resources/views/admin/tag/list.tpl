<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>标签<{/block}>

<{block "name"}>tag<{/block}>

<{block "filter"}>
<{include file="admin/tag/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>标签名</th>
<th>类型</th>
<th>个数</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="tag_name">{{data}}</td>
<td data-from="type_name" data-orderable="false">{{data}}</td>
<td data-from="" data-orderable="false">
{{if full.type==0}}
<a href="<{'admin/building?q[ofTag]='|url}>{{full.id}}">{{full.building_cnt}}</a>
{{else}}
<a href="<{'admin/company?q[ofTag]='|url}>{{full.id}}">{{full.company_cnt}}</a>
{{/if}}
</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个标签：{{full.tag_name}}吗？<{/block}>