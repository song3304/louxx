<!-- Form Content -->
<form action="<{'admin'|url nofilter}>/<{block "name"}><{/block}>" method="GET" class="form-bordered form-horizontal">
	<input type="hidden" name="base" value="<{$_base}>">
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="tag_name">标签名</label>
		<div class="col-md-9">
			<div class="input-group">
				<input type="text" id="tag_name" name="f[tag_name][like]" class="form-control" placeholder="请输入标签名..." value="<{$_filters.tag_name.like}>">
				<span class="input-group-addon"><i class="gi gi-user"></i></span>
			</div>
		</div>
	</div>
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="type">类型</label>
		<div class="col-md-9">
				<select id="type" name="f[type][eq]" class="form-control" placeholder="请选择标签类型.">
					<option value=""<{if $_filters.type.eq === ""}> selected="selected"<{/if}>>请选择标签类型</option>
					<option value="0"<{if $_filters.type.eq === "0"}> selected="selected"<{/if}>>办公楼</option>
					<option value="1"<{if $_filters.type.eq == 1}> selected="selected"<{/if}>>公司</option>
				</select>
		</div>
	</div>
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="created_at-min">加入时间</label>
		<div class="col-md-9">
			<div class="input-group input-daterange">
				<input type="text" id="created_at-min" name="f[created_at][min]" class="form-control text-center" placeholder="开始时间" value="<{$_filters.created_at.min}>">
				<span class="input-group-addon">～</span>
				<input type="text" id="created_at-max" name="f[created_at][max]" class="form-control text-center" placeholder="结束时间" value="<{$_filters.created_at.max}>">
			</div>
		</div>
	</div>
	<div class="form-group col-sm-12 text-right">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> 检索</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重置</button>
	</div>
	<div class="clearfix"></div>
</form>
<!-- END Form Content -->
<script>
(function($){
	$().ready(function(){
		$('#created_at-min').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd',
				isShowOthers:false,
				maxDate: '#F{$dp.$D(\'created_at-max\')}'
			});
		});
		$('#created_at-max').on('focus',function(){
			WdatePicker({
				skin: 'twoer',
				isShowClear:true,
				readOnly:true,
				dateFmt:'yyyy-MM-dd',
				isShowOthers:false,
				minDate: '#F{$dp.$D(\'created_at-min\')}'
			});
		});
	});
})(jQuery);
</script>