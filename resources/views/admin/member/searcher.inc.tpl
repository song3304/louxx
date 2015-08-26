<!-- Form Content -->
<form action="<{'admin'|url}>/<{block "name"}><{/block}>/" method="GET" class="form-bordered">
	<div class="form-group col-sm-6">
		<label for="username">用户名</label>
		<input type="email" id="username" name="username" class="form-control" placeholder="请输入关键词..">
	</div>
	<div class="form-group col-sm-6">
		<label for="example-nf-password">Password</label>
		<input type="password" id="example-nf-password" name="example-nf-password" class="form-control" placeholder="Enter Password..">
	</div>
	<div class="form-group form-actions">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> 搜索</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
	</div>
</form>
<!-- END Form Content -->