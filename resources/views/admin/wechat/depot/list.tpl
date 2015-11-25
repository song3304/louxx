<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>素材库<{/block}>

<{block "name"}>wechat/depot<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'static/css/admin/wechat.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
<script src="<{'static/js/template.js'|url}>"></script>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/common.js'|url}>"></script>
<script src="<{'static/js/admin/wechat.js'|url}>"></script>
<script>
(function($){
	$().ready(function(){
		$('[name="wechat/depot/list"]').addClass('active').parents('li').addClass('active');
	});
})(jQuery);
</script>
<{/block}>

<{block "block-container"}>
<div class="row">
	<div class="col-xs-12">
		<div class="block">
			<div class="block-title">
				<div class="block-options pull-right">
					<a href="<{'admin/'|url}>" name="create-modal" class="btn btn-alt btn-info btn-sm"><i class="fa fa-plus"></i> 添加素材</a>
				</div>
				<ul class="nav nav-tabs" data-toggle="tabs">
					<li class="active"><a href="#depot-news">图文</a></li>
					<li class=""><a href="#depot-text">文字</a></li>
					<li class=""><a href="#depot-image">图片</a></li>
					<li class=""><a href="#depot-callback">编程</a></li>
					<li class=""><a href="#depot-video">视频</a></li>
					<li class=""><a href="#depot-voice">录音</a></li>
					<li class=""><a href="#depot-music">音乐</a></li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="depot-news">
					<!-- <div class="text-center">正在加载中...</div> -->
					<div class="depot-news-list row" ng-controller="newsController as depots">
						<div class="col-md-4 col-xs-4 depot-col" ng-class="{'multi': depot.news && depot.news.length > 1}" ng-repeat="depot in data">
							<div class="items">
								<div class="item" ng-repeat="news in depot.news">
									<h4 class="title">
										<a href="<{'m/news'|url}>?id={{news.id}}" target="_blank">{{news.title}}</a>
									</h4>
									<div class="cover">
										<img src="<{'attachment'|url}>?id={{news.cover_aid}}" alt="" class="img-responsive">
									</div>
									<p class="description">
										{{news.description}}
									</p>
									<div class="clearfix"></div>
								</div>

								<div class="options">
									<div class="row">
										<div class="col-md-6 col-xs-6 text-center tool">
											<a href="javascript:void(0);" ng-click="reload111()" class=""><i class="glyphicon glyphicon-edit"></i> 编辑</a>
										</div>
										<div class="col-md-6 col-xs-6 text-center tool">
											<a href="<{'admin/wechat/depot'|url}>/{{depot.id}}" confirm="您确定删除本素材吗？" method="delete" ng-success="" class="" no-alert="true"><i class="glyphicon glyphicon-trash text-danger"></i> 删除</a>
										</div>
									</div>
									<!-- <div class="row">
										<div class="col-md-12 col-xs-12 text-center tool">
											<a href="" class=""><i class="glyphicon glyphicon-plus"></i> 添加一条</a>
										</div>
									</div> -->
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="tab-pane" id="depot-text">
					<div class="text-center">正在加载中...</div>
				</div>
				<div class="tab-pane" id="depot-image">
					<div class="text-center">正在加载中...</div>
				</div>
				<div class="tab-pane" id="depot-callback">
					<div class="text-center">正在加载中...</div>
				</div>
				<div class="tab-pane" id="depot-video">
					<div class="text-center">正在加载中...</div>
				</div>
				<div class="tab-pane" id="depot-voice">
					<div class="text-center">正在加载中...</div>
				</div>
				<div class="tab-pane" id="depot-music">
					<div class="text-center">正在加载中...</div>
				</div>
			</div>
		</div>
	</div>
</div>

<{/block}>