<header class="navbar navbar-default">
<div class="navbar-header">
	<ul class="nav navbar-nav-custom pull-right visible-xs">
		<li>
			<a href="javascript:void(0)" data-toggle="collapse" data-target="#horizontal-menu-collapse" class="collapsed" aria-expanded="false">菜单</a>
		</li>
	</ul>
	<!-- Left Header Navigation -->
	<ul class="nav navbar-nav-custom">
		<!-- Main Sidebar Toggle Button -->
		<li>
			<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
				<i class="fa fa-bars fa-fw"></i>
			</a>
		</li>
	</ul>
	<!-- END Left Header Navigation -->
</div>
<ul class="nav navbar-nav-custom pull-right hidden-xs">
	<!-- Template Options -->
	<!-- Change Options functionality can be found in js/app.js - templateOptions() -->
	<li class="dropdown">
		<a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown">
			<i class="gi gi-settings"></i>
		</a>
		<ul class="dropdown-menu dropdown-custom dropdown-options dropdown-menu-right">
			<li class="dropdown-header text-center">菜单栏样式</li>
			<li>
				<div class="btn-group btn-group-justified btn-group-sm">
					<a href="javascript:void(0)" class="btn btn-primary" id="options-header-default">浅色</a>
					<a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse">深色</a>
				</div>
			</li>
			<li class="dropdown-header text-center">页面风格</li>
			<li>
				<div class="btn-group btn-group-justified btn-group-sm">
					<a href="javascript:void(0)" class="btn btn-primary" id="options-main-style">内容深色</a>
					<a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt">标题深色</a>
				</div>
			</li>
		</ul>
	</li>
	<!-- END Template Options -->
</ul>

<{block "menubar-menus"}>
<div class="collapse navbar-collapse" id="horizontal-menu-collapse"> 
	<ul class="nav navbar-nav">
		<!--{pluginclude file="property/menubar.inc.tpl"}-->
	</ul>
</div>
<{/block}>
<div class="clearfix"></div>
</header>

<!-- END Header -->
