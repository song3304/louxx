<div class="form-group">
	<label class="col-md-3 control-label" for="name">标签名</label>
	<div class="col-md-9">
		<input type="text" id="tag_name" name="tag_name" class="form-control" placeholder="请输入标签名..." value="<{$_data.tag_name}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="description">类型</label>
	<div class="col-md-9">
		<select id="type" name="type" class="form-control" placeholder="请选择标签类型.">
			<option value="0"<{if $_data.type == 0}> selected="selected"<{/if}>>办公楼</option>
			<option value="1"<{if $_data.type == 1}> selected="selected"<{/if}>>公司</option>
			<option value="2"<{if $_data.type == 2}> selected="selected"<{/if}>>楼层</option>
		</select>
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>