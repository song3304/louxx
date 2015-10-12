<{extends file="admin/extends/main.block.tpl"}>

<{block "header"}>
<!-- Form Header -->
<div class="content-header">
	<div class="header-section">
		<h1>
			<i class="gi gi-wifi_alt"></i><{block "title"}><{/block}>管理<br><small>查看<{block "title"}><{/block}>资料!</small>
		</h1>
	</div>
</div>
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{'admin'|url}>"><{$_site.title}></a></li>
	<li><a href="<{'admin'|url}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li>查看<{block "title"}><{/block}></li>
	<li class="active"><{block "subtitle"}><{/block}></li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-container"}><{/block}>