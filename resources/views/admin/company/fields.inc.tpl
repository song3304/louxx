<div class="form-group">
	<label class="col-md-3 control-label" for="oid">办公楼</label>
	<div class="col-md-9">
		<select id="oid" name="oid" class="select-model form-control" data-model="admin/building" data-text="{{village_name}}-{{building_name}}" data-term="{{village_name}}-{{building_name}}" data-placeholder="请输入该楼名." value="<{$_data.oid}>"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="tag_ids">标签</label>
	<div class="col-md-9">
		<select type="text" id="tag_ids" name="tag_ids[]" class="form-control select-model" data-params='{"f[type]":"1"}' data-model="admin/tag" data-text="{{tag_name}}" data-term="{{tag_name}}" data-placeholder="请输入标签..." value="<{if !empty($_data->tags)}><{$_data->tags->pluck('id')->toArray()|implode:','}><{/if}>" multiple="multiple"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="fids">楼层</label>
	<div class="col-md-9">
		<select id="fids" name="fids[]" class="select-model form-control" data-model="admin/floor"<{if $_data.oid}> data-params='{"f[oid][eq]":"<{$_data.oid}>"}'<{/if}> data-text="{{name}}" data-term="{{name}}" data-placeholder="请输入该楼名." value="<{if !empty($_data->floors)}><{$_data->floors->pluck('id')->toArray()|implode:','}><{/if}>" multiple="multiple"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">公司名</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入公司名" value="<{$_data.name}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="logo_id">公司logo</label>
	<div class="col-md-9">
		<input type="hidden" id="logo_id" name="logo_id" class="form-control" placeholder="请输入..." value="<{$_data.logo_id|default:0}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="logo_id">公司规模</label>
	<div class="col-md-9">
		<select id="people_cnt" name="people_cnt" class="form-control" placeholder="请选择公司规模.">
			<option value="0"<{if empty($_data.people_cnt)}> selected="selected"<{/if}>>1-10人</option>
			<option value="1"<{if $_data.people_cnt==1}> selected="selected"<{/if}>>10-50人</option>
			<option value="2"<{if $_data.people_cnt==2}> selected="selected"<{/if}>>50-100人</option>
			<option value="3"<{if $_data.people_cnt==3}> selected="selected"<{/if}>>100-500人</option>
			<option value="4"<{if $_data.people_cnt==4}> selected="selected"<{/if}>>500-1000人</option>
			<option value="5"<{if $_data.people_cnt==5}> selected="selected"<{/if}>>1000人以上</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="description">公司描述</label>
	<div class="col-md-9">
		<textarea id="description" name="description" class="form-control" placeholder="请输入公司"><{$_data.description}></textarea>
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>

<script>
(function($){
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
		return format.replace(/\{\{([\w\.]+)\}\}/g, function($0, $1){
			var o = $1.split('.');
			var d = data;
			for(var i = 0; i < o.length; ++i)
			{
				var n = o[i];
				if (typeof d != 'undefined' && typeof d[ n ] != 'undefined')
					d = d[n];
				else 
					return null;
			}
			return d;
		});
	};
	method.format = function(items, id, selection, text, pid) {
		var result = [];
		for(var i = 0; i < items.length; ++i) {
			var d = {
				'id': id ? method.replaceData(items[i], id) : items[i].id, 
				'text': text ? method.replaceData(items[i], text) : items[i].text,
				'selection': selection ? method.replaceData(items[i], selection) : items[i].selection,
				'pid': pid ? method.replaceData(items[i], pid) : items[i].pid
			};
			if (typeof items[i].children == 'object' && typeof items[i].children.length != 'undefined')
				d.children = method.format(items[i].children, id, selection, text, pid);
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
				'selection': v.selection,
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

	$(function(){
		$("#oid").on('change',function(){
			$('#fids').data('params',{"f[oid][eq]":$('#oid').val()});
			select_change.call($('#fids')[0]);
		});
		
		function select_change(){
			var $this = $(this);
				var id = $this.data('id');
				var text = $this.data('text');
				var selection = $this.data('selection') ? $this.data('selection') : text;
				var params = $this.data('params');
				var values = $this.attr('value') ? $this.attr('value').split(',') : $this.val();
				var url = $.baseuri + $this.data('model')+'/data/json';
				params = $.extend(true, {}, {all: 'true'}, params);
				method.getData(url, params).done(function(json){
					var data = method.format(json, id, selection, text); 
					$this.html('');
					$this.select2($.extend(true, {}, {language: "zh-CN", data: data, allowClear: true}));
					//初始值
					$this.val(values ? values : null).trigger("change");
				});
		}
	});
})(jQuery);	
</script>