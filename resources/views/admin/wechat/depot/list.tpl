<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>素材库<{/block}>

<{block "name"}>wechat/depot<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'static/css/admin/wechat.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
<script src="<{'static/js/angular/angular-1.4.8.min.js'|url}>"></script>
<script src="<{'static/js/angular/ui-bootstrap-tpls-0.14.3.min.js'|url}>"></script>
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
<div class="row" ng-controller="depotController">
	<div class="col-xs-12">
		<div class="block">
			<div class="block-title">
				<div class="block-options pull-right">
					<a href="<{'admin/'|url}>" name="create-modal" class="btn btn-alt btn-info btn-sm"><i class="fa fa-plus"></i> 添加素材</a>
				</div>
				<ul class="nav nav-tabs" data-toggle="tabs">
					<li class="active"><a href="#depot-news" ng-click="show('news')">图文</a></li>
					<li class=""><a href="#depot-text" ng-click="show('text')">文字</a></li>
					<li class=""><a href="#depot-image" ng-click="show('image')">图片</a></li>
					<li class=""><a href="#depot-callback" ng-click="show('callback')">编程</a></li>
					<li class=""><a href="#depot-video" ng-click="show('video')">视频</a></li>
					<li class=""><a href="#depot-voice" ng-click="show('voice')">录音</a></li>
					<li class=""><a href="#depot-music" ng-click="show('music')">音乐</a></li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="depot-news" depot-list="news"></div>
				<div class="tab-pane" id="depot-text" depot-list="text"></div>
				<div class="tab-pane" id="depot-image" depot-list="image"></div>
				<div class="tab-pane" id="depot-callback" depot-list="callback"></div>
				<div class="tab-pane" id="depot-video" depot-list="video"></div>
				<div class="tab-pane" id="depot-voice" depot-list="voice"></div>
				<div class="tab-pane" id="depot-music" depot-list="music"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/ng-template" id="wechat/depot/news">
<div class="depot-list depot-news-list row">
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.news" ng-class="{'multi': depot.news && depot.news.length > 1}" ng-repeat="depot in depots.data">
		<div class="items">
			<div class="item" ng-repeat="item in depot.news">
				<h4 class="title">
					<a href="<{'m/news'|url}>?id={{item.id}}" target="_blank">{{item.title}}</a>
				</h4>
				<div class="cover">
					<img ng-src="<{'attachment'|url}>?id={{item.cover_aid}}" alt="" class="img-responsive">
				</div>
				<p class="description">
					{{item.description}}
				</p>
				<div class="clearfix"></div>
			</div>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/text">
<div class="depot-list depot-text-list row">
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.text" ng-repeat="depot in depots.data">
		<div class="items">
			<div class="item">
				<p class="content" ng-bind-html="depot.text.content|nl2br"></p>
				<div class="clearfix"></div>
			</div>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/image">
<div class="depot-list depot-image-list row">
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.image" ng-repeat="depot in depots.data">
		<div class="items">
			<div class="image">
				<a href="<{'attachment'|url}>?id={{depot.image.aid}}" target="_blank"><img ng-src="<{'attachment'|url}>?id={{depot.image.aid}}" alt="" class="img-responsive"></a>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.image.aid}}" target="_blank">{{depot.image.title}}</a>
				<span class="size pull-right">{{depot.image.size|byte2size}}</span>
			</h4>
			<div class="clearfix"></div>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/callback">
<div class="depot-list depot-callback-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.callback" ng-repeat="depot in depots.data">
		<div class="items">
			<h4 class="title">
				{{depot.callback.title}}
			</h4>
			<div class="content">
				<span ng-bind-html="depot.callback.callback|nl2br"></span>
			</div>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/video">
<div class="depot-list depot-video-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.video" ng-repeat="depot in depots.data">
		<div class="items">
			<div class="video">
				<video ng-src="{{'<{'attachment'|url}>?id='+depot.video.aid|trustUrl}}" controls="controls"></video>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.video.aid}}" target="_blank">{{depot.video.title}}</a>
				<span class="size pull-right">{{depot.video.size|byte2size}}</span>
			</h4>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/voice">
<div class="depot-list depot-voice-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.voice" ng-repeat="depot in depots.data">
		<div class="items">
			<div class="voice">
				<audio ng-src="{{'<{'attachment'|url}>?id='+depot.voice.aid|trustUrl}}" controls="controls"></audio>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.voice.aid}}" target="_blank">{{depot.voice.title}}</a>
				<span class="size pull-right">{{depot.voice.size|byte2size}}</span>
			</h4>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/music">
<div class="depot-list depot-music-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.music" ng-repeat="depot in depots.data">
		<div class="items">
			<div class="music">
				<audio ng-src="{{'<{'attachment'|url}>?id='+depot.music.aid|trustUrl}}" controls="controls"></audio>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.music.aid}}" target="_blank">{{depot.music.title}}</a>
				<span class="size pull-right">{{depot.music.size|byte2size}}</span>
			</h4>
			<div depot-options="edit" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list">
<!--载入type模板-->
<ng-include src="'wechat/depot/'+type"></ng-include>
<div class="depot-none" ng-if="depots.total == 0">还没有素材，添加一个？</div>
<div class="clearfix"></div>
<!--页码-->
<div class="text-center" ng-show="depots.total > 0">
	<uib-pagination boundary-links="true" total-items="depots.total" items-per-page="depots.per_page" ng-model="depots.current_page" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/options/edit">
<div class="row">
	<div class="col-md-6 col-xs-6 text-center tool">
		<a href="javascript:void(0);" ng-click="" class=""><i class="glyphicon glyphicon-edit"></i> 编辑{{depot}}</a>
	</div>
	<div class="col-md-6 col-xs-6 text-center tool">
		<a href="<{'admin/wechat/depot'|url}>/{{depotId}}" confirm="您确定删除本素材吗？" method="delete" ondone="$emit('destroy', $parent.$parent.type)"><i class="glyphicon glyphicon-trash text-danger"></i> 删除</a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/options/select">
<div class="row">
	<div class="col-md-12 col-xs-12 text-center tool">
		<a href="" class=""><i class="glyphicon glyphicon-plus"></i> 选定<input type="radio" class="hidden" name="wdid[]" value="{{::depotId}}"></a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/options">
<div class="options">
	<ng-include src="'wechat/depot/options/'+option"></ng-include>
	<div class="clearfix"></div>
</div>
</script>
<{/block}>