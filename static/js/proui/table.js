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
		$('a[method]:not([method="delete"])', obj).query();
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
					l = e.oInstance.fnPagingInfo(),
					r = function(t) {
						t.preventDefault();
						e._iDisplayLength = parseInt(e._iDisplayLength, 10);
						e._iDisplayStart = parseInt(e._iDisplayStart, 10);
						e.oApi._fnPageChange(e, t.data.action) && n(e);
					};
					jQuery(t).append('<ul class="pagination pagination-sm remove-margin"><li class="first disabled"><a href="javascript:void(0)"><i class="glyphicon glyphicon-step-backward"></i> ' + i.sFirst + '</a></li><li class="prev disabled"><a href="javascript:void(0)"><i class="glyphicon glyphicon-chevron-left"></i> ' + i.sPrevious + '</a></li>' + '<li class="next disabled"><a href="javascript:void(0)">' + i.sNext + ' <i class="glyphicon glyphicon-chevron-right"></i></a></li><li class="last disabled"><a href="javascript:void(0)">' + i.sLast + ' <i class="glyphicon glyphicon-step-forward"></i></a></li>' + '<li class="more"><a href="javascript:void(0)"><i class="glyphicon glyphicon-option-horizontal"></i></a></li>' + "</ul>");
					var o = jQuery('a', t);
					jQuery(o[0]).on('click.DT', {
						action: 'first'
					},r);
					jQuery(o[1]).on('click.DT', {
						action: 'previous'
					},r);
					jQuery(o[2]).on('click.DT', {
						action: 'next'
					},r);
					jQuery(o[3]).on('click.DT', {
						action: 'last'
					},r);console.log(l);
					jQuery(o[4]).popover({
						html: true,
						title: '',
						content: '<input type="text" id="datatable-paginate-slider" class="" data-slider-selection="after" data-slider-tooltip="show">',
						placement: 'left',
						trigger: 'focus'
					});
				},
				fnUpdate: function(e, t) {
					var n, i, r, o, a, s = 5,
					l = e.oInstance.fnPagingInfo(),
					c = e.aanFeatures.p,
					u = Math.floor(s / 2);
					for (l.iTotalPages < s ? (o = 1, a = l.iTotalPages) : l.iPage <= u ? (o = 1, a = s) : l.iPage >= l.iTotalPages - u ? (o = l.iTotalPages - s + 1, a = l.iTotalPages) : (o = l.iPage - u + 1, a = o + s - 1), n = 0, iLen = c.length; iLen > n; n++) {
						jQuery('li:not(.first,.prev,.next,.last,.more)', c[n]).remove();
						var $more = jQuery('a:eq(4)', c[n]);
						if (l.iTotalPages > 1)
							$more.off('shown.bs.popover').on('shown.bs.popover',function(){
								if (jQuery.fn.slider) jQuery('#datatable-paginate-slider').slider({
									value: parseInt(l.iPage) + 1,
									max: parseInt(l.iTotalPages),
									min: 1,
									step: 1,
								}).on('slideStop', function(){
									var p = parseInt($(this).slider('getValue').val());
									e._iDisplayStart = (parseInt(p, 10) - 1) * l.iLength,
									t(e);
									$more.popover('hide').blur();
								});
							});
							else
								$more.hide();
						for (i = o; a >= i; i++)
							r = i === l.iPage + 1 ? 'class="active"': '',
							jQuery('<li ' + r + '><a href="javascript:void(0)">' + i + "</a></li>").insertBefore(jQuery('li.next', c[n])[0]).on('click', function(n) {
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
				url: $.baseuri + $.datatable_config.namespace+'/'+$.datatable_config.name+'/data/json',
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
			'displayStart': parseInt($.datatable_config.displayStart, 10),
			'pageLength': parseInt($.datatable_config.pageLength, 10),
			'order': $.datatable_config.order,
			'columns': $.datatable_config.columns,
			'searchDelay': parseInt($.datatable_config.searchDelay, 10),
			'rowCallback': function( row, data, dataIndex ) {
				if ($.datatable_config.onDrawingRow) $.datatable_config.onDrawingRow.call(this, row, data, dataIndex);
			},
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