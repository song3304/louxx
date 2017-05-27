<div class="form-group">
	<label class="col-md-3 control-label" for="oid">办公楼</label>
	<div class="col-md-9">
		<select id="oid" name="oid" class="select-model form-control" data-model="admin/building" data-text="{{village_name}}-{{building_name}}" data-term="{{village_name}}-{{building_name}}" data-placeholder="请输入该楼名." value="<{$_data.oid}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">场所名</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入场所名." value="<{$_data.name}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="type">类型</label>
	<div class="col-md-9">
		<select id="type" name="type" class="form-control" placeholder="请选择场所类型.">
			<option value="0"<{if empty($_data.type)}> selected="selected"<{/if}>>餐厅</option>
			<option value="1"<{if $_data.type==1}> selected="selected"<{/if}>>酒店</option>
			<option value="2"<{if $_data.type==2}> selected="selected"<{/if}>>健身</option>
			<option value="3"<{if $_data.type==3}> selected="selected"<{/if}>>银行</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="longitude">经度</label>
	<div class="col-md-9">
		<input type="text" id="longitude" name="longitude" class="form-control" placeholder="请输入经度..." value="<{$_data.longitude}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="latitude">纬度</label>
	<div class="col-md-9">
		<input type="text" id="latitude" name="latitude" class="form-control" placeholder="请输入纬度..." value="<{$_data.latitude}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="latitude">地图</label>
	<div class="col-md-9">
		<input type="hidden" id="full_address" name="full_address" value="<{$_data.full_address}>"/>
		<div id="map" style="height:550px;border:#ccc solid 1px;"></div>
	</div>
</div>


<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>