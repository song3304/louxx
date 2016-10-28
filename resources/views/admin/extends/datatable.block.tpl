<{extends file="admin/extends/list.block.tpl"}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'static/css/proui/datatable.min.css'|url}>">
<{/block}>
<{block "head-scripts-common"}>
<script src="<{'static/js/jsencrypt.min.js'|url}>"></script>
<script src="<{'static/js/common.js'|url}>"></script>
<{/block}>
<{block "head-scripts-plus"}>
<link rel="stylesheet" href="<{'static/js/bootstrap-slider/bootstrap-slider.min.css'|url}>">
<script src="<{'static/js/bootstrap-slider/bootstrap-slider.min.js'|url}>"></script>
<script src="<{'static/js/DatePicker/WdatePicker.js'|url}>"></script>
<script src="<{'static/js/datatable/jquery.dataTables.min.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('[name="<{block "name"}><{/block}>/list"]').addClass('active').parents('li').addClass('active');
		
		$.datatable_config = {
			name: '<{block "name"}><{/block}>',
			namespace: '<{block "namespace"}>admin<{/block}>',
			columns: [],
			order: [],
			searchDelay: <{block "datatable-config-searchDelay"}>800<{/block}>,
			displayStart: <{block "datatable-config-displayStart"}>0.0<{/block}>,
			pageLength: <{block "datatable-config-pageLength"}>25<{/block}>
		};
		<{block "datatable-columns-before"}>var columns_before = [];<{/block}>
		<{block "datatable-columns-id"}>
		var columns_id = [
			{'data': 'id', 'render': function(data, type, full){return '<input type="checkbox" name="id[]" value="'+data+'"> ' + data;}}
		];
		<{/block}>
		<{block "datatable-columns-timestamps"}>
			<{block "datatable-columns-timestamps-creatd_at"}>var columns_timestamps_created_at = {'data': 'created_at'};<{/block}>
			<{block "datatable-columns-timestamps-updated_at"}>var columns_timestamps_updated_at = {'data': 'updated_at'};<{/block}>
		var columns_timestamps = [];
		if (columns_timestamps_created_at) columns_timestamps.push(columns_timestamps_created_at);
		if (columns_timestamps_updated_at) columns_timestamps.push(columns_timestamps_updated_at);
		<{/block}>
		<{block "datatable-columns-options"}>
		var columns_options = [{'data': null, orderable: false, 'render': function (data, type, full){
			<{block "datatable-columns-options-before"}>var columns_options_before = [];<{/block}>
			<{block "datatable-columns-options-plus"}>var columns_options_plus = [];<{/block}>
			<{block "datatable-columns-options-after"}>var columns_options_after = [];<{/block}>
			<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这项：'+full['id']+'吗？';<{/block}>
			<{block "datatable-columns-options-edit"}>var columns_options_edit = '<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/'+full['id']+'/edit" data-toggle="tooltip" title="编辑" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';<{/block}>
			<{block "datatable-columns-options-delete"}>var columns_options_delete = '<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/'+full['id']+'" method="delete" confirm="'+(columns_options_delete_confirm ? columns_options_delete_confirm : '')+'" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>';<{/block}>
			
			return '<div class="btn-group">'
				+(columns_options_before ? columns_options_before.join() : '')
				+(columns_options_edit ? columns_options_edit : '')
				+(columns_options_plus ? columns_options_plus.join() : '')
				+(columns_options_delete ? columns_options_delete : '')
				+(columns_options_after ? columns_options_after.join() : '')
				+'</div>';
			}
		}];
		<{/block}>
		<{block "datatable-columns-after"}>var columns_after = [];<{/block}>

		<{block "datatable-columns-plus"}>var columns_plus = [];<{/block}>
		<{block "datatable-order"}>var order = [[0, 'desc']];<{/block}>

		if (columns_before)
			columns_before.forEach(function(v){
				$.datatable_config.columns.push(v);
			});
		if (columns_id)
			columns_id.forEach(function(v){
				$.datatable_config.columns.push(v);
			});
		if (columns_plus)
			columns_plus.forEach(function(v){
				$.datatable_config.columns.push(v);
			});
		if (columns_timestamps)
			columns_timestamps.forEach(function(v){
				$.datatable_config.columns.push(v);
			});
		if (columns_options)
			columns_options.forEach(function(v){
				$.datatable_config.columns.push(v);
			});
		if (columns_after)
			columns_after.forEach(function(v){
				$.datatable_config.columns.push(v);
			});
		if (order)
			order.forEach(function(v){
				$.datatable_config.order.push(v);
			});

		//event
		<{block "datatable-onCreateRow"}>var onCreateRow = null;<{/block}>
		<{block "datatable-onDrawCallback"}>var onDrawCallback = null;<{/block}>
		if (onCreateRow)
			$.datatable_config.onCreateRow = onCreateRow;
		if (onDrawCallback)
			$.datatable_config.onDrawCallback = onDrawCallback;

	});
})(jQuery);
</script>
<script src="<{'static/js/proui/table.js'|url}>"></script>
<{/block}>

<{block "table-tbody"}><{/block}>

<{block "table-foot"}><{/block}>

