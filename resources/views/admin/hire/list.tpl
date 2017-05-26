<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>租赁<{/block}>

<{block "name"}>hire<{/block}>

<{block "filter"}>
<{include file="admin/hire/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>办公楼</th>
<th>楼层</th>
<th>图片</th>
<th>月租金</th>
<th>每平方租金/天</th>
<th>面积(平方)</th>
<th>工位</th>
<th>状态</th>
<th>备注</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="building" data-orderable="false"><a href="<{'admin/building?f[id][eq]='|url}>{{data.id}}">{{data.building_name}}</a></td>
<td data-from="floor" data-orderable="false">
	<a href="<{'admin/floor?f[id][eq]='|url}>{{full.floor.id}}"><span class="label label-primary">{{data.name}}</span></a>
</td>
<td data-from="pic" data-orderable="false">
	<img src="<{''|attachment}>?id={{data.pic_id}}&width=80&height=80" alt="lou_pic" class="img-rounded">
</td>
<td data-from="rent">{{data}}</td>
<td data-from="per_rent">{{data}}</td>
<td data-from="acreage">{{data}}</td>
<td data-from="">{{full.min_station_cnt}}-{{full.max_station_cnt}}</td>
<td data-from="status_tag">{{data}}</td>
<td data-from="note">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个租赁：{{full.building.building_name}}-{{full.floor.name}}吗？<{/block}>