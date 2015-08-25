<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<{block "head"}>
	<meta charset="utf-8">
	<{block "head-title"}><{include file="common/title.inc.tpl"}><{/block}>
	<meta name="csrf-token" content="<{csrf_token()}>">
	<{block "head-meta-responsive"}>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<{/block}>
	<{block "head-icons"}>
		<{include file="common/icons.inc.tpl"}>
	<{/block}>
	<{block head-styles}>
		<{include file="admin/common/styles.inc.tpl"}>
	<{/block}>
	<{block head-scripts}>
		<{include file="admin/common/scripts.inc.tpl"}>
		<{block "head-scripts-validate"}><{include file="common/validate.inc.tpl"}><{/block}>
		<{block "head-scripts-plus"}><{/block}>
	<{/block}>
	<{block "head-plus"}><{/block}>
<{/block}>
</head>
<body class="page-loading">
<{block "body-container"}>
	<{include file="admin/common/loading.inc.tpl"}>
	<div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">
		<{include file="admin/sidebar.inc.tpl"}>
		<!-- Main Container -->
		<div id="main-container">
			<{include file="admin/menubar.inc.tpl"}>
			 <!-- Page content -->
			<div id="page-content">
				<{block "header"}>
				<!-- Form Header -->
				<div class="content-header">
					<div class="header-section">
						<h1>
							<i class="hi hi-home"></i>后台<br><small>后台，用户体验的开始！</small>
						</h1>
					</div>
				</div>
				<ul class="breadcrumb breadcrumb-top">
					<li><a href="<{'admin'|url}>"><{$_site.title}></a></li>
					<li class="active">后台首页</li>
				</ul>
				<!-- END Form Header -->
				<{/block}>

				<!-- Form Elements Content -->
				<div class="block full">
					<{block "block-title"}><{/block}>
					<{block "block-content"}><{/block}>
				</div>
				<!-- END Form Elements Content -->
			</div>
			<!-- END Page Content -->

			<{include file="admin/copyright.inc.tpl"}>
		</div>
		<!-- END Main Container -->
	</div>
	<!-- END Page Container -->

	<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
	<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>
<{/block}>
<{block "body-scripts"}><{/block}>
</body>
</html>
