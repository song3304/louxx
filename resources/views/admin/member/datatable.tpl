<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>用户<{/block}>

<{block "name"}>member<{/block}>

<{block "head-scripts-after"}>
<script src="<{'static/js/emojione.js'|url}>"></script>
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

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': "avatar_aid", orderable: false, 'render': function(data, type, full){
		return '<img src="<{'attachment/resize'|url}>?id='+data+'&width=80&height=80" alt="avatar" class="img-circle">';
	}},
	{'data': 'username'},
	{'data': 'nickname', 'render': function(data, type, full){
		return '<span class="enable-emoji">'+ data.emojione() +'</span>';
	}},
	{'data': 'realname'},
	{'data': 'gender', 'render': function(data, type, full){
		return '<span class="label label-primary">'+(data ? data.title : '未知')+'</span>';
	}},
	{'data': 'phone'},
	{'data': 'roles', orderable: false, 'render': function(data, type, full){
		var html = '';
		if (data instanceof Array) {
			data.forEach(function(i){
				html += '<span class="label label-info">' + i.display_name + '</span>&nbsp;';
			});
		}
		return html;
	}}
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个用户：'+full['username']+'吗？';<{/block}>
