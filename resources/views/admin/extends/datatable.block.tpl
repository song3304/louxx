<{extends file="admin/extends/list.block.tpl"}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'static/css/proui/datatable.css'|url}>">
<{/block}>

<{block "head-scripts-plus"}>
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
			displayStart: <{block "datatable-config-displayStart"}>0<{/block}>,
			pageLength: <{block "datatable-config-pageLength"}>25<{/block}>
		};
		<{block "datatable-columns-id"}>
		var columns_id = [
			{'data': 'id', 'render': function(data, type, full){return '<input type="checkbox" name="id[]" value="'+data+'"> ' + data;}}
		];
		<{/block}>
		<{block "datatable-columns-timestamps"}>
		var columns_timestamps = [{'data': 'created_at'},{'data': 'updated_at'}];
		<{/block}>
		<{block "datatable-columns-options"}>
		var columns_options = [{'data': null, orderable: false, 'render': function (data, type, full){
			<{block "datatable-columns-options-plus"}>var columns_options_plus = [];<{/block}>
			<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这项：'+full['id']+'吗？';<{/block}>
			return '<div class="btn-group">\
				<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/'+full['id']+'/edit" data-toggle="tooltip" title="编辑" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
				+columns_options_plus.join()
				+'<a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>/'+full['id']+'" method="delete" confirm="'+(columns_options_delete_confirm ? columns_options_delete_confirm : '')+'" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div>';
			}
		}];
		<{/block}>
		<{block "datatable-columns-plus"}>var columns_plus = [];<{/block}>
		<{block "datatable-order"}>var order = [[0, 'desc']];<{/block}>

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

