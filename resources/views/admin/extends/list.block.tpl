<{extends file="admin/extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script src="<{'static/js/proui/table.js'|url}>"></script>
<script src="<{'static/js/DatePicker/WdatePicker.js'|url}>"></script>

<script>
(function($){
	$().ready(function(){
		$('[name="<{block "name"}><{/block}>/list"]').addClass('active').parents('li').addClass('active');
		<{block "inline-script-plus"}><{/block}>
	});
})(jQuery);
</script>
<{/block}>

<{block "header"}>
<!-- Form Header -->
<!-- <div class="content-header">
	<div class="header-section">
		<h1>
			<i class="fa fa-table"></i><{block "title"}><{/block}>管理<br><small>检索、新增、修改、删除<{block "title"}><{/block}>!</small>
		</h1>
	</div>
</div> -->
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>"><{$_site.title}></a></li>
	<li><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li class="active">列表</li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-title"}>
<!-- DataTable Title -->
<div class="block-title">
	<{block "block-title-title"}><h2 class="pull-left"><strong><{block "title"}><{/block}>列表</strong> 检索</h2><{/block}>
	
	<{block "block-title-options"}>
	<div class="block-options pull-right">
		<!-- <{if $_base}>
		<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>" class="btn btn-alt btn-sm btn-warning enable-tooltip" title="点击切换到「功能视图」，可排序、选择行数等" data-original-title="点击切换到「功能视图」，可排序、选择行数等">功能视图</a>
		<{else}>
		<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>?base=1" class="btn btn-alt btn-sm btn-primary enable-tooltip" title="数据读取失败时，请点击切换到「基本视图」" data-original-title="数据读取失败时，请点击切换到「基本视图」">基本视图</a>
		<{/if}> -->
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
		<!-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary" data-toggle="block-hide"><i class="fa fa-times"></i></a> -->
		<div class=" btn-group btn-group-sm">
			<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-info dropdown-toggle enable-tooltip" data-toggle="dropdown" title="操作" data-original-title="操作"><span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
			<{block "menu-before"}><{/block}>
			<{block "menu-option"}>
				<li class="dropdown-header">操作<i class="fa fa-cog pull-right"></i></li>
				<li>
					<{block "menu-option-before"}><{/block}>
					<{block "menu-option-plus"}><{/block}>
					<{block "menu-option-delete"}>
					<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/0" method="delete" selector="#datatable [name='id[]']:checked" confirm="<{block "menu-option-delete-confirm"}>您确定删除这%L项？此操作不可恢复！<{/block}>" class=""><span class="text-danger"><i class="fa fa-times pull-right "></i>删除所选</span></a>
					<{/block}>
					<{block "menu-option-after"}><{/block}>
				</li>
			<{/block}>
			<{block "menu-export"}>
				<li class="dropdown-header">导出<i class="fa fa-share pull-right"></i></li>
				<li>
					<a href="javascript:void(0)"><i class="fa fa-print pull-right"></i> 打印</a>
					<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block 'name'}><{/block}>/export/csv?<{'filters'|query_string nofilter}>" target="_blank"><i class="fi fi-csv pull-right"></i> CSV </a>
					<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block 'name'}><{/block}>/export/pdf?<{'filters'|query_string nofilter}>" target="_blank"><i class="fi fi-pdf pull-right"></i> PDF</a>
					<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block 'name'}><{/block}>/export/xls?<{'filters'|query_string nofilter}>" target="_blank"><i class="fi fi-xls pull-right"></i> Excel 2003</a>
					<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block 'name'}><{/block}>/export/xlsx?<{'filters'|query_string nofilter}>" target="_blank"><i class="fi fi-xlsx pull-right"></i> Excel 2007+</a>
				</li>
			<{/block}>
			<{block "menu-after"}><{/block}>
			</ul>
		</div>
	</div>
	<{/block}>
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
<{block "block-content-table"}>
<div class="table-responsive">
	<table id="datatable" class="table table-vcenter table-condensed table-bordered table-striped table-hover">
		<thead>
			<{block "table-thead-before"}><{/block}>
			<tr>
			<{block "table-th"}>
				<{block "table-th-before"}><{/block}>
				<{block "table-th-id"}><th class="text-left"><input type="checkbox" id="checkAll" > #</th><{/block}>
				<{block "table-th-plus"}><{/block}>
				<{block "table-th-timestamps"}>
					<{block "table-th-timestamps-created_at"}><th>添加</th><{/block}>
					<{block "table-th-timestamps-updated_at"}><th>更新</th><{/block}>
				<{/block}>
				<{block "table-th-options"}>
				<th class="text-center">操作</th>
				<{/block}>
				<{block "table-th-after"}><{/block}>
			<{/block}>
			</tr>
			<{block "table-thead-plus"}><{/block}>
			<{block "table-thead-after"}><{/block}>
		</thead>
		<tbody>
			<{block "table-tbody-before"}><{/block}>
			<{block "table-tbody"}>
			<{foreach $_table_data as $item}>
			<tr id="line-<{$item->getKey()}>">
			<{block "table-td"}>
				<{block "table-td-before"}><{/block}>
				<{block "table-td-id"}><td class="text-left"><input type="checkbox" name="id[]" value="<{$item->getKey()}>">	<{$item->getKey()}></td><{/block}>
				<{block "table-td-plus"}><{/block}>
				<{block "table-td-timestamps"}>
					<{block "table-td-timestamps-created_at"}><td><{$item->created_at->format('Y-m-d H:i')}></td><{/block}>
					<{block "table-td-timestamps-updated_at"}><td><{$item->updated_at->format('Y-m-d H:i')}></td><{/block}>
				<{/block}>
				<{block "table-td-options"}>
				<td class="text-center">
					<div class="btn-group">
						<{block "table-td-options-before"}><{/block}>
						<{block "table-td-options-edit"}><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/<{$item->getKey()}>/edit" data-toggle="tooltip" title="编辑" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><{/block}>
						<{block "table-td-options-plus"}><{/block}>
						<{block "table-td-options-delete"}><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/<{$item->getKey()}>" method="delete" confirm="<{block "table-td-options-delete-confirm"}>您确定删除这项：<{$item->getKey()}>吗？<{/block}>" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a><{/block}>
						<{block "table-td-options-after"}><{/block}>
					</div>
				</td>
				<{/block}>
				<{block "table-td-after"}><{/block}>
			<{/block}>
			</tr>
			<{block "table-tbody-plus"}><{/block}>
			<{block "table-tbody-after"}><{/block}>
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
<{/block}>