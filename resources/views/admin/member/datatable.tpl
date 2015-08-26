<{extends file="admin/extends/datatable.block.tpl"}>

<{block "title"}>用户<{/block}>

<{block "name"}>member<{/block}>

<{block "head-scripts-after"}>
<script type="text/javascript">
(function($){
	$().ready(function(){
		$('.dataTables_filter input').attr('placeholder', '检索用户昵称');
	});
})(jQuery);
</script>
<{/block}>


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

<{block "table-tbody"}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': "avatar_aid", 'render': function(data, type, full){
		return '<img src="<{'attachment/resize'|url}>?id='+data+'&width=80&height=80" alt="avatar" class="img-circle">';
	}},
	{'data': 'username'},
	{'data': 'nickname'},
	{'data': 'realname'},
	{'data': 'gender', 'render': function(data, type, full){
		return '<span class="label label-primary">'+data+'</span>';
	}},
	{'data': 'phone'},
	{'data': null}
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个用户：'+full['username']+'吗？';<{/block}>