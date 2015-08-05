<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<{include file="common/title.inc.tpl"}>
	<meta name="renderer" content="webkit">
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	
	<{include file="common/script.inc.tpl"}>
	<{include file="common/style.inc.tpl"}>
</head>
<body>
<div class="container">
	<h1 class="page-header">注册</h1>

	<form action="<{'member'|url nofilter}>" method="POST">
		<input type="hidden" name="_token" value="<{csrf_token()}>">
		<div class="form-group">
			<label for="username">用户名</label>
			<input type="text" class="form-control" name="username" id="username" placeholder="请输入用户名..." value="<{old('username')}>">
		</div>
		<div class="form-group">
			<label for="password">密码</label>
			<input type="password" class="form-control" name="password" id="password" placeholder="请输入密码...">
		</div>
		<div class="form-group">
			<label for="retry_password">密码确认</label>
			<input type="password" class="form-control" name="retry_password" id="retry_password" placeholder="请再次确认密码...">
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" class="" id="readit"> 我已阅读
			</label>
		</div>
		<button type="submit" class="btn btn-default">注册</button>
	</form>
</div>
<script type="text/javascript">
(function($){
	var errors = <{$errors->toArray()|@json_encode nofilter}>;
	for(var i in errors) {
		$('[name="'+ i +'"]').after('<div class="help-block">'+ errors[i][0] +'</div>').closest('.form-group').addClass('has-error');
	}
})(jQuery);
</script>

</body>
</html>