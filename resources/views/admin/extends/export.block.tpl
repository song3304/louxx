<{extends file="admin/extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script>
(function($){
	$().ready(function(){
		$('[name="<{block "name"}><{/block}>/list"]').addClass('active').closest('li[name="<{block "name"}><{/block}>"]').addClass('active');
		var makeLinks = function(pagesize) {
			if (isNaN(pagesize) || pagesize <= 0) return;
			var total = <{$_total}>;
			var pages = Math.ceil(total / pagesize);
			var $links = $('#links').empty();
			$('#pagesize').text(pagesize);
			for (var i = 1; i <= pages; i++) {
				$links.append('<div class="col-md-3 col-xs-4"><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block name="name"}><{/block}>/export/<{$_of}>?page='+i+'&pagesize='+pagesize+'&<{'filters'|query_string nofilter}>" class="btn btn-link" target="_blank">第'+i+'个</a> ('+ (i == pages ? 0 : total - pagesize * i) + '-' + (total - pagesize * (i - 1)) +')</div>');
			};
		}
		$('#pagesize-slider').on('slideStop', function(e){
			var pagesize = parseInt($(this).data('slider').getValue());
			makeLinks(pagesize);
		});
		makeLinks(<{$_pagesize}>);
		<{block "inline-script-plus"}><{/block}>
	});
})(jQuery);
</script>

<{/block}>

<{block "head-scripts-after"}>
<link rel="stylesheet" href="<{'js/bootstrap-slider/bootstrap-slider.min.css'|static}>">
<script src="<{'js/bootstrap-slider/bootstrap-slider.min.js'|static}>"></script>
<{/block}>

<{block "header"}>
<!-- Form Header -->
<div class="content-header">
	<div class="header-section">
		<h1>
			<i class="fa fa-table"></i><{block "title"}><{/block}>导出<br><small>导出<{block "title"}><{/block}>的数据为PDF或Excel!</small>
		</h1>
	</div>
</div>
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>"><{$_site.title}></a></li>
	<li><a href="<{''|url}>/<{block "namespace"}>admin<{/block}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li class="active">导出</li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-title"}>
<!-- DataTable Title -->
<div class="block-title">
	<h2 class="pull-left"><strong><{block "title"}><{/block}>数据</strong> <{$_table}></h2>
	<div class="block-options pull-right">
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
	</div>
	<div class="clearfix"></div>
</div>
<!-- END DataTable Title -->
<{/block}>

<{block "block-content"}>
<div class="block-content">
	<{block "filter"}><{/block}>
	<p>导出格式：<label for="" class="label label-info"><{$_of}></label></p>
	<p>总：<{$_total}>条数据，</p>
	<p>
	每个文件：<span id="pagesize"><{$_pagesize}></span>条：
	 <div class="input-slider-success">
		<input type="text" id="pagesize-slider" name="pagesize-slider" class="form-control input-slider" data-slider-min="0" data-slider-max="<{$_total}>" data-slider-step="1" data-slider-value="<{$_pagesize}>" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show">
	</div>

	</p>
	<p>点击下面的链接进行下载</p>
	<div class="row" id="links"></div>
	<div class="clearfix"></div>
</div>
<{/block}>