<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<{include file="common/title.inc.tpl"}>
	<meta name="renderer" content="webkit">
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<{include file="common/script.inc.tpl"}>
	<{include file="common/validate.inc.tpl"}>
	<{include file="common/uploader.inc.tpl"}>
	<{include file="common/style.inc.tpl"}>
</head>
<body>
<div class="container">
	<h1 class="page-header">注册</h1>
	<form action="<{'member'|url nofilter}>" method="POST" autocomplete="off" id="form">
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
			<label for="password_confirmation">密码确认</label>
			<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="请再次确认密码...">
		</div>
		<div class="form-group radio">
		<{foreach $_fields.gender as $v}>
			<label><input type="radio" class="" name="gender" value="<{$v['id']}>"> <{$v['text']}></label>
		<{/foreach}>
		</div>
		<div class="form-group">
			<label for="password_confirmation">上传图片</label>
			<input type="hidden" class="form-control" name="photo_aid" id="photo_aid" value="0">
		</div>

		<div class="form-group checkbox">
			<label>
				<input type="checkbox" class="" name="accept_license" id="accept_license" value="1"> 我已阅读并同意协议
			</label>
		</div>
		<button type="submit" class="btn btn-default">注册</button>
	</form>
</div>
<script type="text/javascript">
(function($){
	$('#photo_aid').uploader();
	$('#form')<{if}>.validate_addons($.validates).trigger_error_bags($.error_bags).query();
})(jQuery);
</script>
</body>
</html>