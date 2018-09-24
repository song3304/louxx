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
					<li>楼层信息</li>
					<li>
						<img src="<{'image/more.png'|static}>"/>
					</li>
				</ul>
				<ul class="floor">
					<li>
						<img src="<{'image/floor.png'|static}>"/>
					</li>
					<li>
						<span><{$_floor.name}></span>
						<!--span>Second Floor</span-->
					</li>
				</ul>
				<ul class="company">
					<li>
						<img src="<{'image/company.png'|static}>"/>
					</li>
					<li>
						<{if count($_floor.companies)>0}>
						共<{count($_floor.companies)}>家企业
						<{else}>
						暂时没有企业信息
						<{/if}>
					</li>
				</ul>
			</div>
			
			<div class="main">
				<{foreach $_floor.companies as $company}>
				<div class="content" onclick="window.location.href='<{'home/company'|url}>?cid=<{$company.id}>';">
					<span><{$company@iteration}>. <{$company.name}></span>
					<img src="<{'image/triangle.png'|static}>"/>
					</a>
				</div>
				<{foreachelse}>
				<div class="content">
					<span>暂无公司信息</span>
				</div>
				<{/foreach}>
			</div>
		</div>
<{/block}>