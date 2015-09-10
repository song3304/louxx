<!-- Main Sidebar -->
<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div class="sidebar-scroll">
		<!-- Sidebar Content -->
		<div class="sidebar-content">
			<!-- Brand -->
			<a href="<{'admin'|url}>" class="sidebar-brand">
				<i class="gi gi-flash"></i><{$_site.title}>
			</a>
			<!-- END Brand -->

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

			<!-- Theme Colors -->
			<!-- Change Color Theme functionality can be found in js/app.js - templateOptions() -->
			<ul class="sidebar-section sidebar-themes clearfix">
				<li class="active">
					<a href="javascript:void(0)" class="themed-background-dark-default themed-border-default" data-theme="default" data-toggle="tooltip" title="Default Blue"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-night themed-border-night" data-theme="<{'static/css/proui/themes/night.css'|url}>" data-toggle="tooltip" title="Night"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-amethyst themed-border-amethyst" data-theme="<{'static/css/proui/themes/amethyst.css'|url}>" data-toggle="tooltip" title="Amethyst"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-modern themed-border-modern" data-theme="<{'static/css/proui/themes/modern.css'|url}>" data-toggle="tooltip" title="Modern"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-autumn themed-border-autumn" data-theme="<{'static/css/proui/themes/autumn.css'|url}>" data-toggle="tooltip" title="Autumn"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-flatie themed-border-flatie" data-theme="<{'static/css/proui/themes/flatie.css'|url}>" data-toggle="tooltip" title="Flatie"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-spring themed-border-spring" data-theme="<{'static/css/proui/themes/spring.css'|url}>" data-toggle="tooltip" title="Spring"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-fancy themed-border-fancy" data-theme="<{'static/css/proui/themes/fancy.css'|url}>" data-toggle="tooltip" title="Fancy"></a>
				</li>
				<li>
					<a href="javascript:void(0)" class="themed-background-dark-fire themed-border-fire" data-theme="<{'static/css/proui/themes/fire.css'|url}>" data-toggle="tooltip" title="Fire"></a>
				</li>
			</ul>
			<!-- END Theme Colors -->

			<!-- Sidebar Navigation -->
			<ul class="sidebar-nav">
				<li>
					<a href="<{''|url}>" class=""><i class="gi gi-stopwatch sidebar-nav-icon"></i>首页</a>
				</li>
				<li class="sidebar-header">
					<span class="sidebar-header-title">基本</span>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-user sidebar-nav-icon"></i>会员管理</a>
					<ul>
						<li><a href="<{'admin/member'|url}>" name="member-list">会员列表</a></li>
						<li><a href="<{'admin/member/create'|url}>" name="member-create"><i class="gi gi-plus"></i> 添加会员</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-conversation sidebar-nav-icon"></i>微信管理</a>
					<ul>
						<li><a href="<{'admin/wechat-account'|url}>" name="wechat-account-list" class="col-md-8">多账号管理</a><a href="<{'admin/wechat-account/create'|url}>" name="wechat-account-create" class="col-md-4"><i class="glyphicon glyphicon-plus"></i> 添加</a><div class="clearfix"></div></li>
						<li><a href="<{'admin/wechat-depot'|url}>" name="wechat-article-list" class="col-md-8" wechat="true">素材管理</a><a href="<{'admin/wechat-article/create'|url}>" name="wechat-article-create" class="col-md-4" wechat="true"><i class="glyphicon glyphicon-plus"></i> 添加</a><div class="clearfix"></div></li>
						<li><a href="<{'admin/wechat-menu'|url}>" name="wechat-menu-list" wechat="true">菜单管理</a></li>
						<li><a href="<{'admin/wechat-replay'|url}>" name="wechat-replay-list" wechat="true">自定义回复</a></li>
						<li><a href="<{'admin/wechat-user'|url}>" name="wechat-user-list" wechat="true">用户管理</a></li>
						<li><a href="<{'admin/wechat-message'|url}>" name="wechat-message-list" wechat="true">消息管理</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-lock sidebar-nav-icon"></i>权限管理</a>
					<ul>
						<li><a href="">用户组管理</a></li>
						<li><a href="">权限管理</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-settings sidebar-nav-icon"></i>系统设置</a>
					<ul>
						<li><a href="">修改密码</a></li>
						<li><a href="">地址管理</a></li>
						<li><a href="">通用字段</a></li>
						<li><a href="">退出系统</a></li>
					</ul>
				</li>
			</ul>
			<!-- END Sidebar Navigation -->

		</div>
		<!-- END Sidebar Content -->
	</div>
	<!-- END Wrapper for scrolling functionality -->
</div>
<!-- END Main Sidebar -->

<div class="modal fade" id="wechat-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">选择需要操作的微信公众号</h4>
			</div>
			<div class="modal-body">
			<p>请新建一个微信账号之后再操作，<a href="<{'admin/wechat-account/create'}>"><i class="glyphicon glyphicon-plus"></i> 新建</a></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<script>
(function($){
$().ready(function(){
	var  $modal = $('#wechat-modal');
	$.GET($.baseuri + 'admin/wechat-account/data/json', null, function(json){
		if (json.result == 'success')
		{
			var $modal_body = $('.modal-body', $modal);
			if (json.data.data.length > 0) $modal_body.empty();
			for(var i = 0; i < json.data.data.length;i++) {
				var v = json.data.data[i];
				$('<div class="row"><div class="col-md-8">'+v['name']+'(<small>'+v['account']+'</small>)'+'</div><div class="col-md-4"><a href="javascript:" data-waid="'+v['id']+'">选择</a></div></div>').appendTo($modal_body);
			}
		} else $.showtips(json);
	}, false);
	$('a[wechat]', '#sidebar').on('click', function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		$modal.modal({backdrop: 'static'});
		$('[data-waid]', $modal).each(function(){
			var $this = $(this);
			$this.attr('href', url + (url.indexOf('?') >= 0 ? '&' : '?') + 'waid=' + $this.data('waid'));
		});
		
		return false;
	});
});
})(jQuery);
</script>
	