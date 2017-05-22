<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<{include file="common/title.inc.tpl"}>
	<meta name="csrf-token" content="<{csrf_token()}>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<{include file="common/icons.inc.tpl"}>
	<{include file="admin/common/styles.inc.tpl"}>
	<{include file="admin/common/scripts.inc.tpl"}>
	<script src="<{'js/chart/flot/jquery.flot.min.js'|static}>"></script>
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
				<!-- Dashboard Header -->
				<!-- For an image header add the class 'content-header-media' and an image as in the following example -->
				<div class="content-header content-header-media">
					<div class="header-section">
						<div class="row">
							<!-- Main Title (hidden on small devices for the statistics to fit) -->
							<div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
								<h1>欢迎 <strong><{$_user.nickname}></strong> <{if $_user.gender.name=='male'}>先生<{else if $_user.gender.name=='female'}>女士<{/if}><br><small>学而时习之！</small></h1>
							</div>
							<!-- END Main Title -->

							<!-- Top Stats -->
							<div class="col-md-8 col-lg-6">
								<div class="row text-center">
									<div class="col-xs-4 col-sm-3">
										<h2 class="animation-hatch">
											￥<strong>100</strong><br>
											<small><i class="fa fa-thumbs-o-up"></i> 总销售</small>
										</h2>
									</div>
									<div class="col-xs-4 col-sm-3">
										<h2 class="animation-hatch">
											￥<strong>100</strong><br>
											<small><i class="fa fa-heart-o"></i> 总</small>
										</h2>
									</div>
									<div class="col-xs-4 col-sm-3">
										<h2 class="animation-hatch">
											￥<strong>100</strong><br>
											<small><i class="fa fa-calendar-o"></i> 总</small>
										</h2>
									</div>
									<!-- We hide the last stat to fit the other 3 on small devices -->
									<div class="col-sm-3 hidden-xs">
										<h2 class="animation-hatch">
											<strong>100</strong><br>
											<small><i class="fa fa-map-marker"></i> 总用户</small>
										</h2>
									</div>
								</div>
							</div>
							<!-- END Top Stats -->
						</div>
					</div>
					<!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
				</div>
				<!-- END Dashboard Header -->

				<!-- Mini Top Stats Row -->
				<div class="row">
					<div class="col-sm-6 col-lg-3">
						<!-- Widget -->
						<a href="#" class="widget widget-hover-effect1">
							<div class="widget-simple">
								<div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
									<i class="gi gi-charts"></i>
								</div>
								<h3 class="widget-content text-right animation-pullDown">
									+ <strong>￥100</strong><br>
									<small>本周销售</small>
								</h3>
							</div>
						</a>
						<!-- END Widget -->
					</div>
					<div class="col-sm-6 col-lg-3">
						<!-- Widget -->
						<a href="#" class="widget widget-hover-effect1">
							<div class="widget-simple">
								<div class="widget-icon pull-left themed-background-spring animation-fadeIn">
									<i class="gi gi-coins"></i>
								</div>
								<h3 class="widget-content text-right animation-pullDown">
									+ <strong>￥100</strong><br>
									<small>本周</small>
								</h3>
							</div>
						</a>
						<!-- END Widget -->
					</div>
					<div class="col-sm-6 col-lg-3">
						<!-- Widget -->
						<a href="#" class="widget widget-hover-effect1">
							<div class="widget-simple">
								<div class="widget-icon pull-left themed-background-fire animation-fadeIn">
									<i class="gi gi-shopping_cart"></i>
								</div>
								<h3 class="widget-content text-right animation-pullDown">
									+ <strong>￥100</strong>
									<small>本周</small>
								</h3>
							</div>
						</a>
						<!-- END Widget -->
					</div>
					<div class="col-sm-6 col-lg-3">
						<!-- Widget -->
						<a href="#" class="widget widget-hover-effect1">
							<div class="widget-simple">
								<div class="widget-icon pull-left themed-background-amethyst animation-fadeIn">
									<i class="gi gi-qrcode"></i>
								</div>
								<h3 class="widget-content text-right animation-pullDown">
									+ <strong>100</strong>
									<small>本周用户</small>
								</h3>
							</div>
						</a>
						<!-- END Widget -->
					</div>
				</div>
				<!-- END Mini Top Stats Row -->

				<!-- Widgets Row -->
				<div class="row">
					<div class="col-md-6" style='display:none;'>
						<!-- Timeline Widget -->
						<div class="widget">
							<div class="widget-extra themed-background-dark">
								<h3 class="widget-content-light">
									 <strong>动态</strong>
								</h3>
							</div>
							<div class="widget-extra">
								
							</div>
						</div>
						<!-- END Timeline Widget -->
					</div>
					<div class="col-md-6">
						<!-- Your Plan Widget -->
						<div class="widget">
							<div class="widget-extra themed-background-dark">
								<h3 class="widget-content-light">
									财务 <strong>一览</strong>
								</h3>
							</div>
							<div class="widget-advanced widget-advanced-alt">
								<!-- Widget Header -->
								<div class="widget-header text-center themed-background">
									<h3 class="widget-content-light text-left pull-left animation-pullDown">
										<strong>收入</strong><br>
										<small>单位：元</small>
									</h3>
									<!-- Flot Charts (initialized in js/pages/index.js), for more examples you can check out http://www.flotcharts.org/ -->
									<div id="dash-widget-chart" class="chart"></div>
								</div>
								<!-- END Widget Header -->
							</div>
						</div>
						<!-- END Your Plan Widget -->

					</div>
				</div>
				<!-- END Widgets Row -->
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


	<script>
	(function($){
		// Get the elements where we will attach the charts
		var dashWidgetChart = $('#dash-widget-chart');

		// Random data for the chart
		var dataEarnings = [[1, 1560], [2, 1650], [3, 1320], [4, 1950], [5, 1800], [6, 2400], [7, 2100], [8, 2550], [9, 3300], [10, 3900], [11, 4200], [12, 4500]];
		var dataSales = [[1, 500], [2, 420], [3, 480], [4, 350], [5, 600], [6, 850], [7, 1100], [8, 950], [9, 1220], [10, 1300], [11, 1500], [12, 1700]];

		// Array with month labels used in chart
		var chartMonths = [[1, '11周前'], [2, '10周前'], [3, '9周前'], [4, '8周前'], [5, '7周前'], [6, '6周前'], [7, '5周前'], [8, '4周前'], [9, '3周前'], [10, '2周前'], [11, '1周前'], [12, '本周']];

		// Initialize Dash Widget Chart
		$.plot(dashWidgetChart,
			[
				{
					data: dataEarnings,
					lines: {show: true, fill: false},
					points: {show: true, radius: 6, fillColor: '#cccccc'}
				},
				{
					data: dataSales,
					lines: {show: true, fill: false},
					points: {show: true, radius: 6, fillColor: '#ffffff'}
				}
			],
			{
				colors: ['#ffffff', '#353535'],
				legend: {show: false},
				grid: {borderWidth: 0, hoverable: true, clickable: true},
				yaxis: {show: false},
				xaxis: {show: false, ticks: chartMonths}
			}
		);

		// Creating and attaching a tooltip to the widget
		var previousPoint = null, ttlabel = null;
		dashWidgetChart.bind('plothover', function(event, pos, item) {

			if (item) {
				if (previousPoint !== item.dataIndex) {
					previousPoint = item.dataIndex;

					$('#chart-tooltip').remove();
					var x = item.datapoint[0], y = item.datapoint[1];

					// Get xaxis label
					var monthLabel = item.series.xaxis.options.ticks[item.dataIndex][1];

					if (item.seriesIndex === 1) {
						ttlabel = '<strong>' + y + '</strong> sales in <strong>' + monthLabel + '</strong>';
					} else {
						ttlabel = '$ <strong>' + y + '</strong> in <strong>' + monthLabel + '</strong>';
					}

					$('<div id="chart-tooltip" class="chart-tooltip">' + ttlabel + '</div>')
						.css({top: item.pageY - 50, left: item.pageX - 50}).appendTo("body").show();
				}
			}
			else {
				$('#chart-tooltip').remove();
				previousPoint = null;
			}
	});
	})(jQuery);
	</script>
</body>
</html>
