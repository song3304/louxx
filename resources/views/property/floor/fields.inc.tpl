<div class="form-group">
	<label class="col-md-3 control-label" for="oid">办公楼</label>
	<div class="col-md-9">
		<select id="oid" name="oid" class="select-model form-control" data-model="property/building" data-text="{{village_name}}-{{building_name}}" data-term="{{village_name}}-{{building_name}}" data-placeholder="请输入该楼名." value="<{$_data.oid}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">层名</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入层名..." value="<{$_data.name}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="description">楼层描述</label>
	<div class="col-md-9">
		<textarea id="description" name="description" class="form-control" placeholder="请输入描述"><{$_data.description}></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="porder">排序</label>
	<div class="col-md-9">
		<input type="text" id="porder" name="porder" class="form-control" placeholder="请输入排序" value="<{$_data.porder|default:0}>">
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>