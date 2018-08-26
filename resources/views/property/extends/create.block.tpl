<{extends file="property/extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script>
(function($){
	$().ready(function(){
		<{call validate selector='#form'}>
		$('[name="<{block "name"}><{/block}>/create"]').addClass('active').parents('li').addClass('active');
		<{block "inline-script-plus"}><{/block}>
	});
})(jQuery);
</script>
<{/block}>

<{block "header"}>
<!-- Form Header -->
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{''|url}>/<{block "namespace"}>property<{/block}>"><{config('settings.title')}></a></li>
	<li><a href="<{''|url}>/<{block "namespace"}>property<{/block}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li class="active">新建</li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-title"}>
<!-- Form Elements Title -->
<div class="block-title">
	<{block "block-title-title"}>
	<h2 class="pull-left"><strong>新建<{block "title"}><{/block}></strong></h2>
	<{/block}>
	<{block "options"}>
	<div class="block-options pull-right">
		<{block "options-toggle"}>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-content" title="折叠/展示" data-original-title="折叠/展示"><i class="fa fa-arrows-v"></i></a>
		<{/block}>
		<{block "options-full"}>
		<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-primary enable-tooltip" data-toggle="block-toggle-fullscreen" title="全屏切换" data-original-title="全屏切换" data-shortcuts="f11"><i class="fa fa-desktop"></i></a>
		<{/block}>
	</div>
	<{/block}>
	<div class="clearfix"></div>
</div>
<!-- END Form Elements Title -->
<{/block}>

<{block "block-content"}>
<div class="block-content">
	<{block "form"}>
	<!-- Form Elements Content -->
	<form action="<{''|url}>/<{block "namespace"}>property<{/block}>/<{block "name"}><{/block}>" method="POST" class="form-horizontal form-bordered" id="form">
		<{csrf_field() nofilter}>
		<{block "fields"}><{/block}>
	</form>
	<!-- END Form Elements Content -->
	<{/block}>
</div>
<{/block}>