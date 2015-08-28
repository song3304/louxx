<{extends file="admin/extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script>
(function($){
	$().ready(function(){
		<{call validate selector='#form'}>
		$('a[name="<{block "name"}><{/block}>-create"]').addClass('active').closest('li[name="<{block "name"}><{/block}>"]').addClass('active');
		<{block "inline-script-plus"}><{/block}>
	});
})(jQuery);
</script>
<{/block}>

<{block "header"}>
<!-- Form Header -->
<div class="content-header">
	<div class="header-section">
		<h1>
			<i class="hi hi-edit"></i><{block "title"}><{/block}>管理<br><small>新建<{block "title"}><{/block}>资料!</small>
		</h1>
	</div>
</div>
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{'admin'|url}>"><{$_site.title}></a></li>
	<li><a href="<{'admin'|url}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li class="active">新建</li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-title"}>
<!-- Form Elements Title -->
<div class="block-title">
	<h2 class="pull-left"><strong>新建<{block "title"}><{/block}></strong></h2>
	<div class="block-options pull-right">
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换"><i class="fa fa-desktop"></i></a>
	</div>
	<div class="clearfix"></div>
</div>
<!-- END Form Elements Title -->
<{/block}>

<{block "block-content"}>
<div class="block-content">
	<{block "form"}>
	<!-- Form Elements Content -->
	<form action="<{'admin'|url}>/<{block "name"}><{/block}>" method="POST" class="form-horizontal form-bordered" id="form">
		<{csrf_field() nofilter}>
		<{block "fields"}><{/block}>
	</form>
	<!-- END Form Elements Content -->
	<{/block}>
</div>
<{/block}>