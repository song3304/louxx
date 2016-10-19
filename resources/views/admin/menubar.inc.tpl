<header class="navbar navbar-default">
<div class="navbar-header">

	<!-- Left Header Navigation -->
	<ul class="nav navbar-nav-custom">
		<!-- Main Sidebar Toggle Button -->
		<li>
			<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
				<i class="fa fa-bars fa-fw"></i>
			</a>
		</li>
		<!-- END Main Sidebar Toggle Button -->

		<!-- Template Options -->
		<!-- Change Options functionality can be found in js/app.js - templateOptions() -->
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
				<i class="gi gi-settings"></i>
			</a>
			<ul class="dropdown-menu dropdown-custom dropdown-options">
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
	<!-- END Left Header Navigation -->
</div>
<{block "menubar-menus"}>
<div class="collapse navbar-collapse pull-right">
<ul class="nav navbar-nav">
	<{* <li>
		<a href="javascript:void(0)">Home</a>
	</li>
	<li>
		<a href="javascript:void(0)">Profile</a>
	</li>
	<li class="dropdown">
		<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Settings <i class="fa fa-angle-down"></i></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:void(0)"><i class="fa fa-asterisk fa-fw pull-right"></i> General</a></li>
			<li><a href="javascript:void(0)"><i class="fa fa-lock fa-fw pull-right"></i> Security</a></li>
			<li><a href="javascript:void(0)"><i class="fa fa-user fa-fw pull-right"></i> Account</a></li>
			<li><a href="javascript:void(0)"><i class="fa fa-magnet fa-fw pull-right"></i> Subscription</a></li>
			<li class="divider"></li>
			<li class="dropdown-submenu">
				<a href="javascript:void(0)" tabindex="-1"><i class="fa fa-chevron-right fa-fw pull-right"></i> More Settings</a>
				<ul class="dropdown-menu">
					<li><a href="javascript:void(0)" tabindex="-1">Second level</a></li>
					<li><a href="javascript:void(0)">Second level</a></li>
					<li><a href="javascript:void(0)">Second level</a></li>
					<li class="divider"></li>
					<li class="dropdown-submenu">
						<a href="javascript:void(0)" tabindex="-1"><i class="fa fa-chevron-right fa-fw pull-right"></i> More Settings</a>
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0)">Third level</a></li>
							<li><a href="javascript:void(0)">Third level</a></li>
							<li><a href="javascript:void(0)">Third level</a></li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Contact <i class="fa fa-angle-down"></i></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:void(0)"><i class="fa fa-envelope-o fa-fw pull-right"></i> By Email</a></li>
			<li><a href="javascript:void(0)"><i class="fa fa-phone fa-fw pull-right"></i> By Phone</a></li>
		</ul>
	</li> *}>
</ul>
</div>
<{/block}>
<div class="clearfix"></div>
</header>

<!-- END Header -->
