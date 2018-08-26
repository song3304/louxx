<!-- Main Sidebar -->
<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div id="sidebar-scroll">
		<!-- Sidebar Content -->
		<div class="sidebar-content">
			<{block "sidebar-brand"}><{include file="property/sidebar.brand.inc.tpl"}><{/block}>
			<{block "sidebar-user"}><{include file="property/sidebar.user.inc.tpl"}><{/block}>
			<{block "sidebar-theme"}><{include file="property/sidebar.theme.inc.tpl"}><{/block}>
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
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-user sidebar-nav-icon"></i>办公楼管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'property/building'|url}>" name="building/list">办公楼列表</a>
						<a class="col-md-4" href="<{'property/building/create'|url}>" name="building/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'property/floor'|url}>" name="floor/list">楼层列表</a>
						<a class="col-md-4" href="<{'property/floor/create'|url}>" name="floor/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'property/hire'|url}>" name="hire/list">招租列表</a>
						<a class="col-md-4" href="<{'property/hire/create'|url}>" name="hire/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'property/periphery'|url}>" name="periphery/list">周边列表</a>
						<a class="col-md-4" href="<{'property/periphery/create'|url}>" name="periphery/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-shopping-cart sidebar-nav-icon"></i>公司管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'property/company'|url}>" name="company/list">公司列表</a>
						<a class="col-md-4" href="<{'property/company/create'|url}>" name="company/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
					</ul>
				</li>
				<!--li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-balance-scale sidebar-nav-icon"></i>租凭管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'property/banner'|url}>" name="banner/list">租凭列表</a>
						<a class="col-md-4" href="<{'property/banner/create'|url}>" name="banner/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
					</ul>
				</li-->
				<!--li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-line-chart sidebar-nav-icon"></i>财务管理</a>
					<ul>
						<li><a href="<{'property/statistics'|url}>" name="statistics/list">财务报表</a></li>
						<li><a href="<{'property/wechat/statement'|url}>" name="wechat/statement/list">微信入账列表</a></li>
						<li><a href="<{'property/alipay/statement'|url}>" name="alipay/statement/list">支付宝入账列表</a></li>
						<li><a href="<{'property/income'|url}>" name="income/list">收入细明</a></li>
					</ul>
				</li-->
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-settings sidebar-nav-icon"></i>个人信息</a>
					<ul>
						<li><a href="<{'property/profile'|url}>" name="profile/list">修改资料</a></li>
						<li><a href="<{'property/password'|url}>" name="password/list">修改密码</a></li>
					</ul>
				</li>
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

