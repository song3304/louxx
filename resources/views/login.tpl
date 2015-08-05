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
	<h1 class="page-header">登录</h1>
	<form action="<{'auth/authenticate_query'|url nofilter}>" method="POST">
		<input type="hidden" name="_token" value="<{csrf_token()}>">
		<div class="form-group">
			<label for="username">用户名</label>
			<input type="email" class="form-control" name="username" id="username" placeholder="请输入用户名...">
		</div>
		<div class="form-group">
			<label for="password">密码</label>
			<input type="password" class="form-control" name="password" id="password" placeholder="请输入密码...">
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" class="remember"> 记住我
			</label>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
</body>
</html>