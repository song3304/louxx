<!-- User Info -->
<div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
	<div class="sidebar-user-avatar">
		<a href="<{'property/member'|url}>/<{$_user->getKey()}>">
			<img src="<{'attachment'|url}>?id=<{$_user.avatar_aid}>" alt="avatar">
		</a>
	</div>
	<div class="sidebar-user-name"><{$_user.realname}></div>
	<div class="sidebar-user-links">
		<a href="<{'property/profile'|url}>" data-toggle="tooltip" data-placement="bottom" title="个人资料"><i class="gi gi-user"></i></a>
		<a href="<{'property/profile'|url}>" data-toggle="tooltip" data-placement="bottom" title="Messages"><i class="gi gi-envelope"></i></a>
		<a href="<{'property/profile'|url}>" data-toggle="tooltip" data-placement="bottom" title="修改资料"><i class="gi gi-cogwheel"></i></a>
		<a href="<{'auth/logout'|url}>" data-toggle="tooltip" data-placement="bottom" title="登出"><i class="gi gi-exit"></i></a>
	</div>
</div>
<!-- END User Info -->