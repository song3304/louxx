<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>门店<{/block}>

<{block "name"}>properter<{/block}>

<{block "filter"}>
<{include file="admin/properter/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>物业名</th>
<th>所属用户</th>
<th>地址</th>
<th>电话</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="name" data-orderable="false">{{data}}</td>
<td data-from="user" data-orderable="false">{{data.username}}</td>
<td data-from="full_address">{{data}}</td>
<td data-from="phone">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个物业：{{full.name}}吗？<{/block}>