<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>用户<{/block}>

<{block "name"}>member<{/block}>

<{block "head-scripts-after"}>
<script src="<{'static/js/emojione.js'|url}>"></script>
<script>
(function($){
$().ready(function(){
	$('.enable-emoji').each(function(){
		var html = $(this).html();
		$(this).html(html.emojione());
	});
});
})(jQuery);
</script>
<{/block}>

<{block "filter"}>
<{include file="admin/member/filters.inc.tpl"}>
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

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->avatar_aid}>&width=80&height=80" alt="avatar" class="img-circle"></td>
<td><{$item->username}></td>
<td><span class="enable-emoji"><{$item->nickname}></span></td>
<td><{$item->realname}></td>
<td><span class="label label-primary"><{$item->_gender->title}></span></td>
<td><{$item->phone}></td>
<td><{foreach $item->roles as $role}><span class="label label-info"><{$role->display_name}></span>&nbsp;<{/foreach}></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个用户：<{$item->username}>吗？<{/block}>
