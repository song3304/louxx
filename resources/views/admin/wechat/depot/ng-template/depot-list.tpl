
<script type="text/ng-template" id="wechat/depot/list/news">
<div class="depot-list depot-news-list row">
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.news" ng-class="{'multi': depot.news && depot.news.length > 1}" ng-repeat="depot in dataFrom.data">
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
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/text">
<div class="depot-list depot-text-list row">
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.text" ng-repeat="depot in dataFrom.data">
		<div class="items">
			<div class="item">
				<p class="content" ng-bind-html="depot.text.content|nl2br"></p>
				<div class="clearfix"></div>
			</div>
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/image">
<div class="depot-list depot-image-list row">
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.image" ng-repeat="depot in dataFrom.data">
		<div class="items">
			<div class="image">
				<a href="<{'attachment'|url}>?id={{depot.image.aid}}" target="_blank"><img ng-src="<{'attachment'|url}>?id={{depot.image.aid}}" alt="" class="img-responsive"></a>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.image.aid}}" target="_blank">{{depot.image.title}}</a>
				<span class="size pull-right">{{depot.image.size|byte2size}}</span>
			</h4>
			<div class="clearfix"></div>
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/callback">
<div class="depot-list depot-callback-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.callback" ng-repeat="depot in dataFrom.data">
		<div class="items">
			<h4 class="title">
				{{depot.callback.title}}
			</h4>
			<div class="content">
				<span ng-bind-html="depot.callback.callback|nl2br"></span>
			</div>
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/video">
<div class="depot-list depot-video-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.video" ng-repeat="depot in dataFrom.data">
		<div class="items">
			<div class="video">
				<video ng-src="{{'<{'attachment'|url}>?id='+depot.video.aid|trustUrl}}" controls="controls"></video>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.video.aid}}" target="_blank">{{depot.video.title}}</a>
				<span class="size pull-right">{{depot.video.size|byte2size}}</span>
			</h4>
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/voice">
<div class="depot-list depot-voice-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.voice" ng-repeat="depot in dataFrom.data">
		<div class="items">
			<div class="voice">
				<audio ng-src="{{'<{'attachment'|url}>?id='+depot.voice.aid|trustUrl}}" controls="controls"></audio>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.voice.aid}}" target="_blank">{{depot.voice.title}}</a>
				<span class="size pull-right">{{depot.voice.size|byte2size}}</span>
			</h4>
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/music">
<div class="depot-list depot-music-list row" >
	<div class="col-md-4 col-xs-4 depot-col" ng-if="depot.music" ng-repeat="depot in dataFrom.data">
		<div class="items">
			<div class="music">
				<audio ng-src="{{'<{'attachment'|url}>?id='+depot.music.aid|trustUrl}}" controls="controls"></audio>
			</div>
			<h4 class="title">
				<a href="<{'attachment'|url}>?id={{depot.music.aid}}" target="_blank">{{depot.music.title}}</a>
				<span class="size pull-right">{{depot.music.size|byte2size}}</span>
			</h4>
			<div depot-list-options="mode" depot-id="depot.id"></div>
		</div>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list">
<div>
	<!--载入type模板-->
	<div ng-include src="'wechat/depot/list/'+type"></div>
	<div class="depot-none" ng-if="dataFrom.total == 0">还没有素材，添加一个？</div>
	<div class="clearfix"></div>
	<!--页码-->
	<div class="text-center" ng-show="dataFrom.total > 0">
		<uib-pagination boundary-links="true" total-items="dataFrom.total" items-per-page="dataFrom.per_page" ng-model="dataFrom.current_page" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options/edit">
<div class="row">
	<div class="col-md-6 col-xs-6 text-center tool">
		<a href="javascript:void(0);" ng-click="$emit('edit', $parent.$parent.type, depotId)" class=""><i class="glyphicon glyphicon-edit"></i> 编辑{{depot}}</a>
	</div>
	<div class="col-md-6 col-xs-6 text-center tool">
		<a href="<{'admin/wechat/depot'|url}>/{{depotId}}" confirm="您确定删除本素材吗？" method="delete" query="$emit('destroy', $parent.$parent.type)"><i class="glyphicon glyphicon-trash text-danger"></i> 删除</a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options/select">
<div class="row">
	<div class="col-md-12 col-xs-12 text-center tool">
		<a href="" class=""><i class="glyphicon glyphicon-plus"></i> 选定<input type="radio" class="hidden" name="wdid[]" value="{{depotId}}"></a>
	</div>
</div>
</script>

<script type="text/ng-template" id="wechat/depot/list/options">
<div class="options">
	<div ng-include src="'wechat/depot/list/options/'+mode"></div>
	<div class="clearfix"></div>
</div>
</script>