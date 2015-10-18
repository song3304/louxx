<!-- User Info -->
<div class="sidebar-section sidebar-user clearfix">
	<div class="sidebar-user-avatar">
		<a href="<{'admin/member'|url}>">
			<img src="<{'attachment'|url}>?aid=<{$_user.avatar_aid}>" alt="avatar">
		</a>
	</div>
	<div class="sidebar-user-name"><{$_user.realname}></div>
	<div class="sidebar-user-links">
		<a href="<{'admin/member'|url}>" data-toggle="tooltip" data-placement="bottom" title="Profile"><i class="gi gi-user"></i></a>
		<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Messages"><i class="gi gi-envelope"></i></a>
		<!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
		<a href="<{'admin/member/edit'|url}>" data-toggle="tooltip" data-placement="bottom" title="修改资料"><i class="gi gi-cogwheel"></i></a>
		<a href="<{'auth/logout'|url}>" data-toggle="tooltip" data-placement="bottom" title="登出"><i class="gi gi-exit"></i></a>
	</div>
</div>
<!-- END User Info -->