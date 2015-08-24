(function($){
$().ready(function(){
	$('a[method="delete"]').query(function(json){
		if (json.result == 'success' && json.data.id)
		{
			json.data.id.forEach(function(id){
				$('#line-'+id).fadeOut(function(){
					$(this).remove();
				})
			});
		}
	}, {
		layout: 'topCenter',
		modal: false
	});
	 /* Select/Deselect all checkboxes in tables */
	$('thead input:checkbox').click(function() {
		var checkedStatus   = $(this).prop('checked');
		var table           = $(this).closest('table');

		$('tbody input:checkbox', table).each(function() {
			$(this).prop('checked', checkedStatus);
		});
	});
});
	
})(jQuery);