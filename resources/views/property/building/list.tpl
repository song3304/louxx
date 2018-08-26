<{extends file="property/extends/list.block.tpl"}>

<{block "title"}>办公楼<{/block}>

<{block "name"}>building<{/block}>

<{block "filter"}>
<{include file="property/building/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th class="text-center"><i class="gi gi-globe"></i></th>
<th>楼名</th>
<th>所属物业</th>
<th>地址</th>
<th>小区名</th>
<th>标签</th>
<th>楼层数</th>
<th>租赁数</th>
<th>周边</th>
<th>经度</th>
<th>纬度</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="pic" data-orderable="false">
	<img src="<{''|attachment}>?id={{data.pic_id}}&width=80&height=80" alt="lou_pic" class="img-rounded">
</td>
<td data-from="building_name" data-orderable="false">{{data}}</td>
<td data-from="properter" data-orderable="false">{{data.name}}</td>
<td data-from="full_address">{{data}}</td>
<td data-from="village_name">{{data}}</td>
<td data-from="tags" data-orderable="false">
{{each data as v k}}
<span class="label label-info">{{v.tag_name}}</span>
{{/each}}
</td>
<td data-from="floors" data-orderable="false" class="text-center"><a href="<{'property/floor'|url}>?f[oid][in][]={{full.id}}">{{data.length}}</a></td>
<td data-from="hires" data-orderable="false" class="text-center"><a href="<{'property/hire'|url}>?f[oid][in][]={{full.id}}">{{data.length}}</a></td>
<td data-from="peripheries" data-orderable="false" class="text-center"><a href="<{'property/periphery'|url}>?f[oid][in][]={{full.id}}">{{data.length}}</a></td>
<td data-from="longitude">{{data}}</td>
<td data-from="latitude">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这幢大楼信息：{{full.building_name}}吗？<{/block}>