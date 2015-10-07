(function($){
$().ready(function(){
	var options_query = function(obj) {
		$('a[method="delete"]', obj).query(function(json){
			if (json.result == 'success' && json.data.id) {
				if ($.datatable_config && $.datatable_config.datatable)
					$.datatable_config.datatable.ajax.reload(null, false);
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
		// Datatables Bootstrap Pagination Integration
		jQuery.fn.dataTableExt.oApi.fnPagingInfo = function(e) {
			return {
				iStart: e._iDisplayStart,
				iEnd: e.fnDisplayEnd(),
				iLength: e._iDisplayLength,
				iTotal: e.fnRecordsTotal(),
				iFilteredTotal: e.fnRecordsDisplay(),
				iPage: Math.ceil(e._iDisplayStart / e._iDisplayLength),
				iTotalPages: Math.ceil(e.fnRecordsDisplay() / e._iDisplayLength)
			}
		};
		jQuery.extend(jQuery.fn.dataTableExt.oPagination, {
			bootstrap: {
				fnInit: function(e, t, n) {
					var i = e.oLanguage.oPaginate,
					r = function(t) {
						t.preventDefault(),
						e.oApi._fnPageChange(e, t.data.action) && n(e);
					};
					jQuery(t).append('<ul class="pagination pagination-sm remove-margin"><li class="first disabled"><a href="javascript:void(0)"><i class="fa fa-step-backward"></i> ' + i.sFirst + '</a></li><li class="prev disabled"><a href="javascript:void(0)"><i class="fa fa-chevron-left"></i> ' + i.sPrevious + '</a></li>' + '<li class="next disabled"><a href="javascript:void(0)">' + i.sNext + ' <i class="fa fa-chevron-right"></i></a></li><li class="last disabled"><a href="javascript:void(0)">' + i.sLast + ' <i class="fa fa-step-forward"></i></a></li>' + "</ul>");
					var o = jQuery('a', t);
					jQuery(o[0]).bind('click.DT', {
						action: 'first'
					},r);
					jQuery(o[1]).bind('click.DT', {
						action: 'previous'
					},r);
					jQuery(o[2]).bind('click.DT', {
						action: 'next'
					},r);
					jQuery(o[3]).bind('click.DT', {
						action: 'last'
					},r);
				},
				fnUpdate: function(e, t) {
					var n, i, r, o, a, s = 5,
					l = e.oInstance.fnPagingInfo(),
					c = e.aanFeatures.p,
					u = Math.floor(s / 2);
					for (l.iTotalPages < s ? (o = 1, a = l.iTotalPages) : l.iPage <= u ? (o = 1, a = s) : l.iPage >= l.iTotalPages - u ? (o = l.iTotalPages - s + 1, a = l.iTotalPages) : (o = l.iPage - u + 1, a = o + s - 1), n = 0, iLen = c.length; iLen > n; n++) {
						for (jQuery('li:not(.first,.prev,.next,.last)', c[n]).remove(), i = o; a >= i; i++)
							r = i === l.iPage + 1 ? 'class="active"': '',
							jQuery('<li ' + r + '><a href="javascript:void(0)">' + i + "</a></li>").insertBefore(jQuery('li.next', c[n])[0]).bind('click', function(n) {
								n.preventDefault(),
								e._iDisplayStart = (parseInt(jQuery("a", this).text(), 10) - 1) * l.iLength,
								t(e)
							});
						0 === l.iPage ? jQuery('li.first,li.prev', c[n]).addClass('disabled') : jQuery('li.first,li.prev', c[n]).removeClass('disabled'),
						l.iPage === l.iTotalPages - 1 || 0 === l.iTotalPages ? jQuery('li.last,li.next', c[n]).addClass('disabled') : jQuery('li.last,li.next', c[n]).removeClass('disabled')
					}
				}
			}
		});
		$.extend(true, $.fn.dataTable.defaults, {
			'dom': "<'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7 search-filter text-right'f><'clearfix'>r>t<'row'<'col-sm-5 hidden-xs'i><'col-sm-7 col-xs-12 clearfix'p>>",
			'pagingType': 'bootstrap',
			'language': {
				'lengthMenu': '_MENU_',
				'search': '<div class="input-group">_INPUT_<span class="input-group-addon"><i class="fa fa-search"></i></span></div>',
				'info': '<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>',
				'infoEmpty': '<strong>0</strong>-<strong>0</strong> of <strong>0</strong>',
				'infoFiltered': '(from <strong>_MAX_</strong>)',
				'paginate': {
					'previous': '',
					'next': '',
					'first': '',
					'last': ''
				},
				'processing': '<div class="alert text-center"><i class="gi gi-refresh"></i> Loading...</div>'
			},
			'column': {
				'asSorting': [ 'desc', 'asc' ]  //first sort desc, then asc
			}
		});
		$.extend($.fn.dataTableExt.oStdClasses, {
			'sWrapper': 'dataTables_wrapper form-inline',
			'sFilterInput': 'form-control',
			'sLengthSelect': 'form-control'
		});

		$.datatable_config.encode = function(settings){
			var json = {
				displayStart: settings._iDisplayStart,
				pageLength: settings._iDisplayLength,
				order: []
			};
			settings.aLastSort.forEach(function(v){
				json.order.push([v['col'], v['dir']]);
			});
			$.bbq.pushState(json);
			return true;
		};

		$.datatable_config.decode = function(){
			var json = $.bbq.getState();
			if (json)			
				$.datatable_config = $.extend($.datatable_config, json);
			return true;
		};

		$.datatable_config.decode();

		$.datatable_config.datatable = $('#datatable').DataTable({
			'ajax': {
				url: $.baseuri+'admin/'+$.datatable_config.name+'/data/json',
				timeout: 20 * 1000,
				type: 'POST',
				data: function(d){
					return $.extend({}, d, {
						filters: window.location.query('filters')
					});
				},
				dataSrc: function(json){
					if (json.result == 'success') {
						json.recordsTotal = json.data.recordsTotal;
						json.recordsFiltered = json.data.recordsFiltered;
						json.data.data.forEach(function(v, k){v['DT_RowId'] = 'line-' + (v['id'] ? v['id'] : k);});
						return json.data.data;
					}
					 else 
						$.showtips(json);
					return [];
				}
			},
			'autoWidth': false,
			'searching': false,
			'processing': true,
			'deferRender': true, //延时绘制
			'serverSide': true, //服务器端
			'displayStart': $.datatable_config.displayStart,
			'pageLength': $.datatable_config.pageLength,
			'order': $.datatable_config.order,
			'columns': $.datatable_config.columns,
			'searchDelay': $.datatable_config.searchDelay,
			'createdRow': function( row, data, dataIndex ) {
				//bind option's event
				options_query.call(this, row);
				if ($.datatable_config.onCreateRow) $.datatable_config.onCreateRow.call(this, row, data, dataIndex);
			},
			'drawCallback': function( settings ) {
				$.datatable_config.encode(settings);
				if ($.datatable_config.onDrawCallback) $.datatable_config.onDrawCallback.call(this, settings);
			}/*,
			'stateSave': true,
			'stateDuration': -1*/
		});
		$('.dataTables_filter input', $.datatable_config.datatable).attr('placeholder', '检索ID');
		$('<a href="javascript:void(0);" class="btn btn-link"><i class="glyphicon glyphicon-refresh"></i> 重新加载</a>').appendTo('.search-filter').on('click', function(){
			$.datatable_config.datatable.ajax.reload(null, false);
		});
	}
});
	
})(jQuery);