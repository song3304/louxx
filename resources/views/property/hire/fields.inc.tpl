<div class="form-group">
	<label class="col-md-3 control-label" for="oid">办公楼</label>
	<div class="col-md-9">
		<select id="oid" name="oid" class="select-model form-control" data-model="property/building" data-text="{{village_name}}-{{building_name}}" data-term="{{village_name}}-{{building_name}}" data-placeholder="请输入该办公楼名." value="<{$_data.oid}>"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="fid">楼层</label>
	<div class="col-md-9">
		<select id="fid" name="fid" class="select-model form-control" data-model="property/floor"<{if $_data.oid}> data-params='{"f[oid][eq]":"<{$_data.oid}>"}'<{/if}> data-text="{{name}}" data-term="{{name}}" data-placeholder="请输入该楼层." value="<{if !empty($_data->floor)}><{$_data->floor->id}><{/if}>"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="rent">租金</label>
	<div class="col-md-9">
		<input type="text" id="rent" name="rent" class="form-control" placeholder="请输入租金(元/月)" value="<{$_data.rent}>">
	</div>
</div>

<div class="form-group">
			<label class="col-md-3 control-label" for="pic_ids">租赁图片</label>
			<div class="col-md-9">
				<select id="pic_ids" name="pic_ids[]" class="form-control hidden" multiple="multiple">
				<{if !empty($_data)}><{foreach $_data->pics as $item}>
					<option value="<{$item->pic_id}>" selected="selected"></option>
				<{/foreach}><{/if}>
				</select>
				<div class="alert alert-info"><i class="fa fa-warning"></i> 可以上传20张图片作为产品的封面</div>
			</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="per_rent">每平方租金</label>
	<div class="col-md-9">
		<input type="text" id="per_rent" name="per_rent" class="form-control" placeholder="请输入每平方租金(元/天)" value="<{$_data.per_rent}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="acreage">面积</label>
	<div class="col-md-9">
		<input type="text" id="acreage" name="acreage" class="form-control" placeholder="面积(平方)" value="<{$_data.acreage}>">
	</div>
</div>


<div class="form-group">
	<label class="col-md-3 control-label" for="min_station_cnt">最小工位</label>
	<div class="col-md-9">
		<input type="text" id="min_station_cnt" name="min_station_cnt" class="form-control" placeholder="最小工位数" value="<{$_data.min_station_cnt}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="max_station_cnt">最大工位</label>
	<div class="col-md-9">
		<input type="text" id="max_station_cnt" name="max_station_cnt" class="form-control" placeholder="最大工位数" value="<{$_data.max_station_cnt}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="status">状态</label>
	<div class="col-md-9">
		<select id="status" name="status" class="form-control" placeholder="请选择租赁状态.">
			<option value="0"<{if empty($_data.status)}> selected="selected"<{/if}>>招租中</option>
			<option value="1"<{if $_data.status==1}> selected="selected"<{/if}>>已租</option>
			<option value="-1"<{if $_data.status==-1}> selected="selected"<{/if}>>已废弃</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="note">租赁描述</label>
	<div class="col-md-9">
		<textarea id="note" name="note" class="form-control" placeholder="请输入租赁描述"><{$_data.note}></textarea>
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
			$('#fid').data('params',{"f[oid][eq]":$('#oid').val()});
			select_change.call($('#fid')[0]);
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