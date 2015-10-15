(function($){
$().ready(function(){
	var replaceData = function(data, format)
	{
		return format.replace(/\{([\w]+)\}/g, function($0, $1){
			return data[$1];
		});
	}
	$('.select-model').each(function(){
		var $this = $(this);
		var id = $this.data('id');
		var text = $this.data('text');
		var value = $this.attr('value');
		$.POST($.baseuri + $this.data('model')+'/data/json', {all: 'true'}, function(json){
			var data = [];
			if (json.result == 'success') {
				var items = json.data.data;
				for(var i = 0; i < items.length; ++i)
					data.push({'id': id ? replaceData(items[i], id) : items[i].id, 'text': text ? replaceData(items[i], text) : items[i].text});
				
			} 
			$this.select2({language: "zh-CN", data: data});
			if (value) $this.val(value.split(',')).trigger("change");
		}, false);
	});
	$('.suggest-model').each(function(){
		var $this = $(this);
		var id = $this.data('id');
		var text = $this.data('text');
		var selection = $this.data('selection') ? $this.data('selection') : text;

		var filter = $this.data('filter');
		var value = $this.attr('value');

		var _config = {
			language: "zh-CN",
			ajax: {
				url: $.baseuri + $this.data('model')+'/data/json',
				dataType: 'json',
				type: 'post',
				delay: 250,
				data: function (params) {
					var v = {page: params.page, _token: $.crsf};
					v['filters['+filter+'][like]'] = params.term;
					return v;
				},
				processResults: function (json, page) {
					var data = [], items = json.data.data;
					for(var i = 0; i < items.length; ++i)
						data.push({'id': id ? replaceData(items[i], id) : items[i].id, 'text': text ? replaceData(items[i], text) : items[i].text, 'selection': selection ? replaceData(items[i], selection) : items[i].selection});
					return {results: data};
				},
				cache: true
			},
			escapeMarkup: function (markup) {return markup;},
			minimumInputLength: 1,
			templateResult: function(data){return data.text;},
			templateSelection: function(data){return data.selection || data.text;}
		};
		if (value) {
			$.POST($.baseuri + namespace + '/'+$this.data('model')+'/data/json', {'filters[id][in]': value.split(',')}, function(json){
				if (json.result == 'success') {
					var items = json.data.data;
					for(var i = 0; i < items.length; ++i)
						$('<option value="'+(id ? replaceData(items[i], id) : items[i].id)+'" selected="selected">'+(text ? replaceData(items[i], text) : items[i].text)+'</option>').appendTo($this);				
				}
				$this.select2(_config);
			}, false);
		} else
			$this.select2(_config);
	});
});
})(jQuery);