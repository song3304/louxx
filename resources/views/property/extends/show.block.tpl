<{extends file="property/extends/main.block.tpl"}>

<{block "header"}>
<!-- Form Header -->
<ul class="breadcrumb breadcrumb-top">
	<li><a href="<{''|url}>/<{block "namespace"}>property<{/block}>"><{config('settings.title')}></a></li>
	<li><a href="<{''|url}>/<{block "namespace"}>property<{/block}>/<{block "name"}><{/block}>"><{block "title"}><{/block}>管理</a></li>
	<li>查看<{block "title"}><{/block}></li>
	<li class="active"><{block "subtitle"}><{/block}></li>
</ul>
<!-- END Form Header -->
<{/block}>

<{block "block-container"}><{/block}>