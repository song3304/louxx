<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>门店审核<{/block}>

<{block "name"}>properter-audit<{/block}>

<{block "filter"}>
<{include file="admin/properter_apply/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>物业名</th>
<th>所属用户</th>
<th>地址</th>
<th>电话</th>
<th>状态</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="name" data-orderable="false">{{data}}</td>
<td data-from="user" data-orderable="false">{{data.username}}</td>
<td data-from="full_address">{{data}}</td>
<td data-from="phone">{{data}}</td>
<td data-from="status_tag">{{data}}</td>
<{/block}>

<{block "table-td-options"}>
		<td class="text-center" data-from="" data-orderable="false">
			<div class="btn-group">
				<{block "table-td-options-edit"}>
					{{if full.status==1}}
						已审核
					{{else}}
					<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/{{full.id}}/edit" data-toggle="tooltip" title="审核" class="btn btn-xs btn-default">审核</a>
					{{/if}}
				<{/block}>
			</div>
		</td>
<{/block}>