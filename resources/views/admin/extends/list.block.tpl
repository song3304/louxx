<{extends file="admin/extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script src="<{'static/js/proui/table.js'|url}>"></script>
<script src="<{'static/js/DatePicker/WdatePicker.js'|url}>"></script>

<script>
(function($){
	$().ready(function(){
		$('[name="<{block "name"}><{/block}>-list"]').addClass('active').parents('li').addClass('active');
		<{block "inline-script-plus"}><{/block}>
	});
})(jQuery);
</script>
<{/block}>

<{block "header"}>
<!-- Form Header -->
<div class="content-header">
	<div class="header-section">
		<h1>
			<i class="fa fa-table"></i><{block "title"}><{/block}>管理<br><small>检索、新增、修改、删除<{block "title"}><{/block}>!</small>
		</h1>
	</div>
</div>
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{'admin'|url}>"><{$_site.title}></a></li>
	<li><a href="<{'admin'|url}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li class="active">列表</li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-title"}>
<!-- DataTable Title -->
<div class="block-title">
	<h2 class="pull-left"><strong><{block "title"}><{/block}>列表</strong> 检索</h2>
	<div class="block-options pull-right">
		<{if $_base}>
		<a href="<{'admin'|url}>/<{block "name"}><{/block}>" class="btn btn-alt btn-sm btn-warning enable-tooltip" title="点击切换到「功能视图」，可排序、选择行数等" data-original-title="点击切换到「功能视图」，可排序、选择行数等">功能视图</a>
		<{else}>
		<a href="<{'admin'|url}>/<{block "name"}><{/block}>?base=1" class="btn btn-alt btn-sm btn-primary enable-tooltip" title="数据读取失败时，请点击切换到「基本视图」" data-original-title="数据读取失败时，请点击切换到「基本视图」">基本视图</a>
		<{/if}>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
		<!-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary" data-toggle="block-hide"><i class="fa fa-times"></i></a> -->
		<div class=" btn-group btn-group-sm">
			<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-info dropdown-toggle enable-tooltip" data-toggle="dropdown" title="操作" data-original-title="操作"><span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
			<{block "menu-option"}>
				<li class="dropdown-header">操作<i class="fa fa-cog pull-right"></i></li>
				<li>
				
					<{block "menu-option-plus"}><{/block}>
					<{block "menu-option-delete"}>
					<a href="<{'admin'|url}>/<{block "name"}><{/block}>/0" method="delete" selector="#datatable [name='id[]']:checked" confirm="<{block "menu-option-delete-confirm"}>您确定删除这%L项？此操作不可恢复！<{/block}>" class=""><span class="text-danger"><i class="fa fa-times pull-right "></i>删除所选</span></a>
					<{/block}>
				
				</li>
			<{/block}>
			<{block "menu-export"}>
				<li class="dropdown-header">导出<i class="fa fa-share pull-right"></i></li>
				<li>
					<a href="javascript:void(0)"><i class="fa fa-print pull-right"></i> 打印</a>
					<a href="<{'admin'|url}>/<{block 'name'}><{/block}>/export/csv" target="_blank"><i class="fi fi-csv pull-right"></i> CSV </a>
					<a href="<{'admin'|url}>/<{block 'name'}><{/block}>/export/pdf" target="_blank"><i class="fi fi-pdf pull-right"></i> PDF</a>
					<a href="<{'admin'|url}>/<{block 'name'}><{/block}>/export/xls" target="_blank"><i class="fi fi-xls pull-right"></i> Excel 2003</a>
					<a href="<{'admin'|url}>/<{block 'name'}><{/block}>/export/xlsx" target="_blank"><i class="fi fi-xlsx pull-right"></i> Excel 2007+</a>
				</li>
			<{/block}>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<!-- END DataTable Title -->
<{/block}>

<{block "block-content"}>
<div class="block-content">
<!-- DataTable Content -->
<{block "filter"}><{/block}>
<!-- END DataTable Content -->
</div>
<div class="clearfix"></div>
<div class="table-responsive">
	<table id="datatable" class="table table-vcenter table-condensed table-bordered table-striped table-hover">
		<thead>
			<tr>
			<{block "table-th"}>
				<{block "table-th-id"}><th class="text-left"><input type="checkbox" id="checkAll" > #</th><{/block}>
				<{block "table-th-plus"}><{/block}>
				<{block "table-th-timestamps"}>
				<th>添加时间</th>
				<th>最后更新</th>
				<{/block}>
				<{block "table-th-options"}>
				<th class="text-center">操作</th>
				<{/block}>
			<{/block}>
			</tr>
		</thead>
		<tbody>
			<{block "table-tbody"}>
			<{foreach $_table_data as $item}>
			<tr id="line-<{$item->id}>">
			<{block "table-td"}>
				<{block "table-td-id"}><td class="text-left"><input type="checkbox" name="id[]" value="<{$item->id}>">	<{$item->id}></td><{/block}>
				<{block "table-td-plus"}><{/block}>
				<{block "table-td-timestamps"}>
				<td><{$item->created_at->format('Y-m-d H:i')}></td>
				<td><{$item->updated_at->format('Y-m-d H:i')}></td>
				<{/block}>
				<{block "table-td-options"}>
				<td class="text-center">
					<div class="btn-group">
						<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->id}>/edit" data-toggle="tooltip" title="编辑" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
						<{block "table-td-options-plus"}><{/block}>
						<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->id}>" method="delete" confirm="<{block "table-td-options-delete-confirm"}>您确定删除这项：<{$item->id}>吗？<{/block}>" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
					</div>
				</td>
				<{/block}>
			<{/block}>
			</tr>
			<{/foreach}>
			<{/block}>
		</tbody>
	</table>
	<{block "table-foot"}>
	<div class="row">
		<div class="col-sm-5 hidden-xs">
			<span><{$_table_data->firstItem()}> - <{$_table_data->lastItem()}> / <{$_table_data->total()}></span>
		</div>
		<div class="col-sm-7 col-xs-12 clearfix"><{$_table_data->render() nofilter}></div>
	</div>
	<{/block}>
</div>
<div class="clearfix"></div>
<{/block}>