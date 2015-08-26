<{extends file="admin/extends/datatable.block.tpl"}>

<{block "title"}>用户<{/block}>

<{block "name"}>member<{/block}>

<{block "searcher"}>
<{include file="admin/member/searcher.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th class="text-center"><i class="gi gi-user"></i></th>
<th>用户名</th>
<th>昵称</th>
<th>姓名</th>
<th>性别</th>
<th>手机</th>
<th>用户组</th>
<{/block}>

<{block "table-td-plus"}>
<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->avatar_aid}>&width=80&height=80" alt="avatar" class="img-circle"></td>
<td><{$item->username}></td>
<td><{$item->nickname}></td>
<td><{$item->realname}></td>
<td><span class="label label-primary"><{$item->gender|hook:field|og:text}></span></td>
<td><{$item->phone}></td>
<td></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个用户：<{$item->username}>吗？<{/block}>