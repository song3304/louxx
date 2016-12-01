(function($){
$().ready(function(){
	var method = {cacheData: {}};
	method.getData = function(url, params) {
		var key = JSON.stringify({url: url, params: params});
		var $dfd = jQuery.Deferred();

		if (typeof method.cacheData[key] != 'undefined')
			$dfd.resolve(method.cacheData[key]);
		else {
			$.POST(url, params).done(function(json, textStatus, jqXHR){
				if (json.result == 'success' || json.result == 'api') {
					var items = json.data.data;
					method.cacheData[key] = items;
					$dfd.resolve(method.cacheData[key]);
				} else {
					var args = arguments;
					$dfd.reject.apply($dfd, args);
				}
			}).fail(function(){
				var args = arguments;
				$dfd.reject.apply($dfd, args);
			});
		}
		return $dfd.promise();
	};
	method.replaceData = function(data, format)
	{
		return format.replace(/\{([\w\.]+)\}/g, function($0, $1){
			var o = $1.split('.');
			var d = data;
			for(var i = 0; i < o.length; ++i)
			{
				var n = o[i];
				if (typeof d[ n ] != 'undefined')
					d = d[n];
				else 
					return null;
			}
			return d;
		});
	};
	method.format = function(items, id, text, pid) {
		var result = [];
		for(var i = 0; i < items.length; ++i) {
			var d = {
				'id': id ? method.replaceData(items[i], id) : items[i].id, 
				'text': text ? method.replaceData(items[i], text) : items[i].text,
				'pid': pid ? method.replaceData(items[i], pid) : items[i].pid
			};
			if (typeof items[i].children == 'object' && typeof items[i].children.length != 'undefined')
				d.children = method.format(items[i].children, id, text);
			result.push(d);
		}
		return result;
	};
	method.recursive = function(items, prefix) {
		prefix = typeof prefix == 'undefined' ? '' : prefix;
		var result = [];
		for(var i = 0; i < items.length; ++i) {
			var v = items[i];
			var _class = 'treeline ';
			if (i === 0 && !prefix) //首节点
				_class += 'top-';
			else if (i == items.length - 1) //尾节点
				_class += 'bottom-';
			else
				_class += 'center-';
			_class += v.children ? 'open' : 'line';

			var d = {
				'id': v.id,
				'selection': v.text,
				'text': prefix + '<span class="'+_class+'"></span>' + v.text
			};
			result.push(d);
			if (v.children)
			{
				var ds = method.recursive(v.children, prefix + (i == items.length - 1 ? '<span class="treeline blank"></span>' : '<span class="treeline blank-line"></span>'));
				for(var j = 0; j < ds.length; ++j)
					result.push(ds[j]);
			}
		}
		return result;
	};
	$('.select-model').each(function(){
		var $this = $(this);
		var id = $this.data('id');
		var text = $this.data('text');
		var params = $this.data('params');
		var value = $this.attr('value');
		var url = $.baseuri + $this.data('model')+'/data/json';
		params = $.extend({}, {all: 'true'}, params);
		method.getData(url, params).done(function(json){
			var data = method.format(json, id, text); 
			$this.select2({language: "zh-CN", data: data, allowClear: true});
			$this.val(value ? value.split(',') : null).trigger("change");
		});
	});
	$('.tree-model').each(function(){
		var $this = $(this);
		var id = $this.data('id');
		var pid = $this.data('pid');
		var text = $this.data('text');
		var params = $this.data('params');
		var value = $this.attr('value');
		var url = $.baseuri + $this.data('model')+'/data/json';
		params = $.extend({}, {all: 'true', tree: 'true'}, params);

		method.getData(url, params).done(function(json){
			var data = method.format(json, id, text, pid);
			data = method.recursive(data);
			$this.select2({
				//theme: "bootstrap",
				language: "zh-CN",data: data, allowClear: true,
				templateResult: function(data){return $('<div>' + data.text + '</div>');},
      			templateSelection: function(data){return data.selection;}
			});
			$this.val(value ? value.split(',') : null).trigger("change");
		});
	});
	$('.suggest-model').each(function(){
		var $this = $(this);
		var id = $this.data('id');
		var text = $this.data('text');
		var selection = $this.data('selection') ? $this.data('selection') : text;

		var term = $this.data('term');
		var params = $this.data('params');
		var value = $this.attr('value');

		var _config = {
			language: "zh-CN",
			ajax: {
				url: $.baseuri + $this.data('model')+'/data/json',
				dataType: 'json',
				type: 'post',
				delay: 250,
				data: function (_params) {
					var v = {page: _params.page, _token: $.crsf, filters: {}};
					v.filters[term] = {'like': _params.term};
					v = $.extend({}, v, params);
					return v;
				},
				processResults: function (json, page) {
					if (json.result != 'success' && json.result != 'api') return {result: []};
					var data = [], items = json.data.data;
					for(var i = 0; i < items.length; ++i)
						data.push({'id': id ? method.replaceData(items[i], id) : items[i].id, 'text': text ? method.replaceData(items[i], text) : items[i].text, 'selection': selection ? method.replaceData(items[i], selection) : items[i].selection});
					return {results: data};
				},
				cache: true
			},
			escapeMarkup: function (markup) {return markup;},
			minimumInputLength: 1,
			allowClear: true,
			templateResult: function(data){return data.text;},
			templateSelection: function(data){return data.selection || data.text;}
		};
		if (value) {
			$.POST($.baseuri + $this.data('model')+'/data/json', {'filters[id][in]': value.split(',')}, function(json){
				if (json.result == 'success' || json.result == 'api') {
					var items = json.data.data;
					for(var i = 0; i < items.length; ++i)
						$('<option value="'+(id ? method.replaceData(items[i], id) : items[i].id)+'" selected="selected">'+(text ? method.replaceData(items[i], text) : items[i].text)+'</option>').appendTo($this);				
				}
				$this.select2(_config);
			}, false);
		} else
			$this.select2(_config);
	});
	$.fn.extend({tags: function(filters){
		return this.each(function(){
			var $this = $(this);
			var _config = {
				language: "zh-CN",
				ajax: {
					url: $.baseuri +'admin/tag/data/json',
					dataType: 'json',
					type: 'post',
					delay: 250,
					data: function (params) {
						var v = {page: params.page, _token: $.crsf, filters: {}};
						v.filters.keywords = {'like': params.term};
						v.filters = $.extend({}, v.filters, filters);
						return v;
					},
					processResults: function (json, page) {
						if (json.result != 'success' && json.result != 'api') return {result: []};
						var data = [], items = json.data.data;
						for(var i = 0; i < items.length; ++i)
							data.push({'id': items[i].keywords, 'text': items[i].keywords + ' <span class="text-muted">('+ (items[i].count || 0) + '次使用)</span>', 'selection': items[i].keywords });
						return {results: data};
					},
					cache: true
				},
				escapeMarkup: function (markup) {return markup;},
				minimumInputLength: 1,
				templateResult: function(data){return data.text;},
				templateSelection: function(data){return data.selection || data.text;},
				createTag: function (params) {
					var term = $.trim(params.term);
					if (term === '') return null;
					return {
						id: term,
						selection: term,
						text: term + ' <span style="color:#f5f5f5">(创建)</span>',
						newTag: true // add additional parameters
					};
				}
			};
			$this.select2($.extend({tags: true}, _config));
		});
	}});
});
})(jQuery);