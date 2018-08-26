<div class="tab-content">
	<div class="tab-pane active" id="form-1">
		<div class="form-group">
			<label class="col-md-3 control-label" for="username">用户名</label>
			<div class="col-md-9">
				<input type="text" id="username" name="username" class="form-control" placeholder="请输入用户名" value="<{$_data.username}>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="password">密码</label>
			<div class="col-md-9">
				<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码" value="">
				<span class="help-block hidden" name="no-password">无需修改，可不填写</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="password_confirmation">密码确认</label>
			<div class="col-md-9">
				<input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="请确认密码" value="">
				<span class="help-block hidden" name="no-password">无需修改，可不填写</span>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="form-2">

		<div class="form-group">
			<label class="col-md-3 control-label" for="avatar_aid">头像</label>
			<div class="col-md-9">
				<input type="hidden" id="avatar_aid" name="avatar_aid" class="form-control" value="<{$_data.avatar_aid|default:0}>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="nickname">昵称</label>
			<div class="col-md-9">
				<input type="text" id="nickname" name="nickname" class="form-control" placeholder="请输入..." value="<{$_data.nickname}>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="realname">真实姓名</label>
			<div class="col-md-9">
				<input type="text" id="realname" name="realname" class="form-control" placeholder="请输入..." value="<{$_data.realname}>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">性别</label>
			<div class="col-md-9">
				<{foreach 'fields.gender.children'|catalogs as $v}>
				<label class="radio-inline">
					<input type="radio" name="gender" value="<{$v.id}>" <{if !empty($_data.gender) && $_data.gender.id == $v.id}>checked="checked"<{/if}> > <{$v.title}>
				</label>
				<{/foreach}>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="phone">手机</label>
			<div class="col-md-9">
				<input type="text" id="phone" name="phone" class="form-control" placeholder="请输入..." value="<{$_data.phone}>">
				<span class="help-block">支持国内手机，如：13912345678</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="email">Email</label>
			<div class="col-md-9">
				<input type="email" id="email" name="email" class="form-control" placeholder="请输入Email" value="<{$_data.email}>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="idcard">身份证</label>
			<div class="col-md-9">
				<input type="text" id="idcard" name="idcard" class="form-control" placeholder="请输入身份证号码" value="<{$_data.idcard}>">
			</div>
		</div>
	</div>
</div>
<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>