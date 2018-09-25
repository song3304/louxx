<{extends file="extends/main.block.tpl"}>

<{block "head-styles-bootstrap"}>
<{/block}>

<{block "head-scripts-plus"}>
<script src="<{'js/public.js'|static}>"></script>
<{/block}>


<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/index/floor_info.css'|static}>" />
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
					<li>搜索'<{$_keywords}>'公司结果</li>
					<li>
						<img src="<{'image/more.png'|static}>"/>
					</li>
				</ul>
				<ul class="company">
					<li>
						<img src="<{'image/company.png'|static}>"/>
					</li>
					<li>
						<{if count($_company_list)>0}>
						搜索到<{count($_company_list)}>家公司
						<{/if}>
					</li>
				</ul>
			</div>
			
			<div class="main">
				<{foreach $_company_list as $company}>
				<div class="content" onclick="window.location.href='<{'home/company'|url}>?cid=<{$company.id}>';">
					<span><{$company@iteration}>. <{$company.name}></span>
					<img src="<{'image/triangle.png'|static}>"/>
					</a>
				</div>
				<{foreachelse}>
				<div class="content">
					<span>没有搜索到公司信息</span>
				</div>
				<{/foreach}>
			</div>
		</div>
<{/block}>