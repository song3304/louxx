<!-- Main Sidebar -->
<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div class="sidebar-scroll">
		<!-- Sidebar Content -->
		<div class="sidebar-content">
			<{block "sidebar-brand"}><{include file="admin/sidebar.brand.inc.tpl"}><{/block}>
			<{block "sidebar-user"}><{include file="admin/sidebar.user.inc.tpl"}><{/block}>
			<{block "sidebar-theme"}><{include file="admin/sidebar.theme.inc.tpl"}><{/block}>
			<{block "sidebar-navigation"}>
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
						<li><a href="<{'admin/member'|url}>" name="member/list">会员列表</a></li>
						<li><a href="<{'admin/member/create'|url}>" name="member/create"><i class="gi gi-plus"></i> 添加会员</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-conversation sidebar-nav-icon"></i>微信管理</a>
					<ul>
						<li><a href="<{'admin/wechat/account'|url}>" name="wechat/account/list" class="col-md-8">多账号管理</a><a href="<{'admin/wechat/account/create'|url}>" name="wechat/account/create" class="col-md-4"><i class="glyphicon glyphicon-plus"></i> 添加</a><div class="clearfix"></div></li>
						<li><a href="<{'admin/wechat/depot'|url}>" name="wechat/depot/list" class="col-md-8">素材管理</a><a href="<{'admin/wechat/depot/create'|url}>" name="wechat/depot/create" class="col-md-4"><i class="glyphicon glyphicon-plus"></i> 添加</a><div class="clearfix"></div></li>
						<li><a href="<{'admin/wechat/menu'|url}>" name="wechat/menu/list">菜单管理</a></li>
						<li><a href="<{'admin/wechat/replay'|url}>" name="wechat/replay/list">自定义回复</a></li>
						<li><a href="<{'admin/wechat/user'|url}>" name="wechat/user/list">用户管理</a></li>
						<li><a href="<{'admin/wechat/message'|url}>" name="wechat/message/list">消息管理</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-lock sidebar-nav-icon"></i>权限管理</a>
					<ul>
						<li><a href="<{'admin/role'|url}>" name="role/list">用户组管理</a></li>
						<li><a href="<{'admin/permission'|url}>" name="permission/list" class="col-md-8">权限管理</a><a href="<{'admin/permission/create'|url}>" name="permission/create" class="col-md-4"><i class="glyphicon glyphicon-plus"></i> 添加</a><div class="clearfix"></div></li>
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
			<{/block}>
		</div>
		<!-- END Sidebar Content -->
	</div>
	<!-- END Wrapper for scrolling functionality -->
</div>
<!-- END Main Sidebar -->

