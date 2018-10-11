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
	<div class="template" id="template">
			<div>
				<p>
					<img src="<{'image/logo2.png'|static}>"/>		
				</p>
				<p class="Login" id="login">
					<span>登录</span>
					<span></span>
					<span>注册</span>
				</p>
			</div>
			<div class="findOffice" id="findOffice">
				<span>找办公楼</span>
			</div>
			<div class="can_bat">
				<p></p>
				<p id="findBuilding"></p>
				<p id="findApply"></p>
				<li></li>
			</div>
			<p>我的收藏</p>
		</div>
			<div class="top">
				<ul class="top_1">
					<li>			
						<img src="<{'image/logo3.png'|static}>"/>
					</li>
					<li>公司信息</li>
					<li class="moreItem" id="moreItem">
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

<{block "body-scripts-plus"}>
	<script>
		!function($){
			$("#template").hide();
			var startX = 0;
			var startY = 0;
			var moveEndX = 0;
			var moveEndY = 0;
			$(function(){
				$("#template").on("touchstart", function(e) {
				    // // 判断默认行为是否可以被禁用
				    // if (e.cancelable) {
				    //     // 判断默认行为是否已经被禁用
				    //     if (!e.defaultPrevented) {
				    //         e.preventDefault();
				    //     }
				    // }   
				    startX = e.originalEvent.changedTouches[0].pageX,
				    startY = e.originalEvent.changedTouches[0].pageY;
				});
				$("#template").on("touchend", function(e) {         
				    // // 判断默认行为是否可以被禁用
				    // if (e.cancelable) {
				    //     // 判断默认行为是否已经被禁用
				    //     if (!e.defaultPrevented) {
				    //         e.preventDefault();
				    //     }
				    // }               
				    moveEndX = e.originalEvent.changedTouches[0].pageX,
				    moveEndY = e.originalEvent.changedTouches[0].pageY,
				    X = moveEndX - startX,
				    Y = moveEndY - startY;
				    //左滑
				    if ( X > 0 ) {
				        $("#template").hide();                
				    }
				    //右滑
				    else if ( X < 0 ) {
				        $("#template").hide();   
				    }
				    //下滑
				    else if ( Y > 0) {
				        $("#template").hide();   
				    }
				    //上滑
				    else if ( Y < 0 ) {
				        $("#template").hide();  
				    }
				    //单击
				    else{ 
				    }
				});

				$("#moreItem").on("click",function(){
					$("#template").show();
				});

				$("#findOffice").on("click",function(){
					window.location.href = "<{'home/index'|url}>";
				});

				$("#findBuilding").on("click",function(){
					window.location.href = "<{'find_building'|url}>";
				});
				$("#findApply").on("click",function(){
					window.location.href = "<{'apply'|url}>";
				});
				$("#login").on("click",function(){
					window.location.href = "<{'register'|url}>";
				});
			});
		}(jQuery)
	</script>
<{/block}>