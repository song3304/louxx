(function($){
$().ready(function(){
	var options_query = function(obj) {
		$('a[method="delete"]', obj).query(function(json){
			if (json.result == 'success' && json.data.id) {
				if ($.datatable_config && $.datatable_config.datatable)
					$.datatable_config.datatable.ajax.reload(null, true);
				else
					json.data.id.forEach(function(id){
						$('#line-'+id).fadeOut(function(){
							$(this).remove();
						});
					});
			}
		}, {
			layout: 'topCenter',
			modal: false
		});
	};
	options_query.call(this, document.body);
	
	 /* Select/Deselect all checkboxes in tables */
	$('thead input:checkbox').click(function(e) {
		var checkedStatus   = $(this).prop('checked');
		var table           = $(this).closest('table');
		e.stopPropagation();
		$('tbody input:checkbox:visible', table).each(function() {
			$(this).prop('checked', checkedStatus);
		});
	});

	if ($.datatable_config) {
		App.datatables();
		$.datatable_config.datatable = $('#datatable').DataTable({
			'ajax': {
				url: $.baseuri+'admin/'+$.datatable_config.name+'/data/json',
				timeout: 20 * 1000,
				type: 'POST',
				dataSrc: function(json){
					if (json.result == 'success')
					{
						json.recordsTotal = json.data.recordsTotal;
						json.recordsFiltered = json.data.recordsFiltered;
						return json.data.data;
					}
						
					 else 
						$.showtips(json);
					return [];
				}
			},
			'processing': true,
			'deferRender': true, //延时绘制
			'serverSide': true, //服务器端
			'columns': $.datatable_config.columns,
			'createdRow': function( row, data, dataIndex ) {
				//bind option's event
				options_query.call(this, row);
			},
			'order': $.datatable_config.order,
			'searchDelay': $.datatable_config.searchDelay
		});
		$('.dataTables_filter input').attr('placeholder', '检索ID');
	}
});
	
})(jQuery);