<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<{include file="common/title.inc.tpl"}>
		<{include file="admin/common/style.inc.tpl"}>
		<{include file="admin/common/script.inc.tpl"}>
		<script src="<{'static/js/proui/table.js'|url}>"></script>
	</head>

	<body class="page-loading">
		<{include file="admin/common/loading.inc.tpl"}>
		<div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">
			<{include file="admin/sidebar.inc.tpl"}>

			<!-- Main Container -->
			<div id="main-container">
				<{include file="admin/menubar.inc.tpl"}>

				 <!-- Page content -->
				<div id="page-content">
					<!-- Datatables Header -->
					<div class="content-header">
						<div class="header-section">
							<h1>
								<i class="fa fa-table"></i>用户<br><small>可以检索、添加、修改、删除用户!</small>
							</h1>
						</div>
					</div>
					<ul class="breadcrumb breadcrumb-top">
						<li><a href="<{'admin'|url}>"><{$_site.title}></a></li>
						<li><a href="<{'admin/member'|url}>">用户管理</a></li>
						<li class="active">列表</li>
					</ul>
					<!-- END Datatables Header -->

					<!-- Datatables Content -->
					<div class="block full">
						<div class="block-title">
							<h2 class="pull-left"><strong>用户列表</strong> 检索</h2>
							<div class="block-options pull-right">
								<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
								<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
								<!-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary" data-toggle="block-hide"><i class="fa fa-times"></i></a> -->
								<div class=" btn-group btn-group-sm">
									<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="操作" data-original-title="操作"><span class="caret"></span></a>
									<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
										<li class="dropdown-header">操作<i class="fa fa-cog pull-right"></i></li>
										<li>
											<a href="javascript:void(0)"><i class="gi gi-airplane pull-right"></i>审核所选</a>
											<a href="<{'admin/member/0'|url}>" method="delete" selector="#datatable [name='id[]']:checked" confirm="您确定删除这%L项？此操作不可恢复！" class=""><span class="text-danger"><i class="fa fa-times pull-right "></i>删除所选</span></a>
										</li>
										<li class="dropdown-header">导出<i class="fa fa-share pull-right"></i></li>
										<li>
											<a href="javascript:void(0)"><i class="fa fa-print pull-right"></i> 打印</a>
											<a href="javascript:void(0)"><i class="fi fi-csv pull-right"></i> CSV </a>
											<a href="javascript:void(0)"><i class="fi fi-pdf pull-right"></i> PDF</a>
											<a href="javascript:void(0)"><i class="fi fi-xls pull-right"></i> Excel 2003</a>
											<a href="javascript:void(0)"><i class="fi fi-xlsx pull-right"></i> Excel 2007+</a>
										</li>
										<li class="divider"></li>
										
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="block-content table-responsive">
							<table id="datatable" class="table table-vcenter table-condensed table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-left"><input type="checkbox" id="checkAll" > #</th>
										<th class="text-center"><i class="gi gi-user"></i></th>
										<th>用户名</th>
										<th>昵称</th>
										<th>姓名</th>
										<th>性别</th>
										<th>手机</th>
										<th></th>
										<th>注册时间</th>
										<th>最后登录</th>
										<th class="text-center">操作</th>
									</tr>
								</thead>
								<tbody>
									<{foreach $_user_data as $item}>
									<tr id="line-<{$item->id}>">
										<td class="text-left"><input type="checkbox" name="id[]" value="<{$item->id}>">	<{$item->id}></td>
										<td class="text-center"><img src="<{'attachment/resize'|url}>?id=<{$item->avatar_aid}>&width=80&height=80" alt="avatar" class="img-circle"></td>
										<td><{$item->username}></td>
										<td><{$item->nickname}></td>
										<td><{$item->realname}></td>
										<td><span class="label label-primary"><{$item->gender}></span></td>
										<td><{$item->phone}></td>
										<td></td>
										<td><{$item->created_at->format('Y-m-d H:i')}></td>
										<td><{$item->updated_at->format('Y-m-d H:i')}></td>
										<td class="text-center">
											<div class="btn-group">
												<a href="<{'admin/member'|url}>/<{$item->id}>/edit" data-toggle="tooltip" title="编辑" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
												<a href="<{'admin/member'|url}>/<{$item->id}>" method="delete" confirm="您确定删除：<{$item->username}>吗？" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
											</div>
										</td>
									</tr>
									<{/foreach}>
								</tbody>
							</table>
							<div class="row">
								<div class="col-sm-5 hidden-xs">
									
								</div>
								<div class="col-sm-7 col-xs-12 clearfix"><{$_user_data->render() nofilter}></div>
							</div>
						</div>
					</div>
					<!-- END Datatables Content -->
				</div>
				<!-- END Page Content -->

				<{include file="admin/copyright.inc.tpl"}>
			</div>
			<!-- END Main Container -->
		</div>
		<!-- END Page Container -->

		<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
		<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>


		<!-- Bootstrap.js, Jquery plugins and Custom JS code -->
		<!-- <script src="js/plugins.js"></script>-->

<script type="text/javascript">

</script>
		
	</body>
</html>
