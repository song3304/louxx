<!-- Main Sidebar -->
<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div id="sidebar-scroll">
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
						<li><a class="col-md-8" href="<{'admin/member'|url}>" name="member/list">会员列表</a>
						<a class="col-md-4" href="<{'admin/member/create'|url}>" name="member/create"><i class="gi gi-plus"></i> 添加</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-sitemap sidebar-nav-icon"></i>物业管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/properter'|url}>" name="properter/list">物业列表</a>
						<a class="col-md-4" href="<{'admin/properter/create'|url}>" name="properter/create"><i class="glyphicon glyphicon-plus"></i>添加</a></li>
						<li><a class="col-md-12" href="<{'admin/properter-audit'|url}>" name="properter-audit/list">物业审核列表</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-shopping-cart sidebar-nav-icon"></i>办公楼管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/building'|url}>" name="building/list">办公楼列表</a>
						<a class="col-md-4" href="<{'admin/building/create'|url}>" name="building/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/hire'|url}>" name="hire/list">招租列表</a>
						<a class="col-md-4" href="<{'admin/hire/create'|url}>" name="hire/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/floor'|url}>" name="floor/list">楼层列表</a>
						<a class="col-md-4" href="<{'admin/floor/create'|url}>" name="floor/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/company'|url}>" name="company/list">公司列表</a>
						<a class="col-md-4" href="<{'admin/company/create'|url}>" name="company/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/periphery'|url}>" name="periphery/list">周边列表</a>
						<a class="col-md-4" href="<{'admin/periphery/create'|url}>" name="periphery/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/article'|url}>" name="article/list">资讯列表</a>
						<a class="col-md-4" href="<{'admin/article/create'|url}>" name="article/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/tag'|url}>" name="order/list">标签列表</a>
						<a class="col-md-4" href="<{'admin/tag/create'|url}>" name="tag/create"><i class="glyphicon glyphicon-plus"></i> 添加</a>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-balance-scale sidebar-nav-icon"></i>租凭管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/banner'|url}>" name="banner/list">租凭列表</a>
						<a class="col-md-4" href="<{'admin/banner/create'|url}>" name="banner/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/find-building'|url}>" name="find-building/list">找楼列表</a>
						<a class="col-md-4" href="<{'admin/find-building/create'|url}>" name="find-building/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-line-chart sidebar-nav-icon"></i>财务管理</a>
					<ul>
						<li><a href="<{'admin/statistics'|url}>" name="statistics/list">财务报表</a></li>
						<li><a href="<{'admin/wechat/statement'|url}>" name="wechat/statement/list">微信入账列表</a></li>
						<li><a href="<{'admin/alipay/statement'|url}>" name="alipay/statement/list">支付宝入账列表</a></li>
						<li><a href="<{'admin/income'|url}>" name="income/list">收入细明</a></li>
					</ul>
				</li>
				<{pluginclude file="admin/sidebar.inc.tpl"}>
				<li><a href="<{'auth/logout'|url}>"><i class="gi gi-exit sidebar-nav-icon"></i>退出系统</a></li>
			</ul>
			<!-- END Sidebar Navigation -->
			<{/block}>
		</div>
		<!-- END Sidebar Content -->
	</div>
	<!-- END Wrapper for scrolling functionality -->
</div>
<!-- END Main Sidebar -->

