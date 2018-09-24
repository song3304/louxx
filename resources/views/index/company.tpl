<{extends file="extends/main.block.tpl"}>

<{block "head-styles-bootstrap"}>
<{/block}>

<{block "head-scripts-plus"}>
<script src="<{'js/public.js'|static}>"></script>
<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/index/company_info.css'|static}>" />
<style>
*{
	margin: 0;
	padding: 0;
} 
</style>
<{/block}>

<{block "body-container"}>
<div id="page">
			<div class="top">
				<ul class="top_1">
					<li>LOGO</li>
					<li>公司信息</li>
					<li>
						<img src="<{'image/more.png'|static}>"/>
					</li>
				</ul>
				<ul class="companyName">
					<{if $_company.logo_id > 0}>
					<img src="<{'attachment/preview'|url}>?id=<{$_company.logo_id}>" alt="<{$_company.name}>" />
					<{else}>
					<img src="<{'image/company.png'|static}>" alt="<{$_company.name}>" />
					<{/if}>
					<span><{$_company.name}></span>
				</ul>
				<ul class="flag">
					<{foreach $_company.tags as $tag}>
					<li><span><{$tag.tag_name}></span></li>
					<{/foreach}>
				</ul>
			</div>
			<div class="main">
				<p>公司人数</p>
				<p><{$_company->people_scale()}></p>
				<p>公司简介</p>
				<p><{$_company.description}></p>
			</div>
		</div>
<{/block}>