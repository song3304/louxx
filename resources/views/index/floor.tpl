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
	<div class="template" id="template">
			<div>
				<p>
					<img src="<{'image/logo2.png'|static}>"/>		
				</p>
				<{if !empty($user->phone)}>
				<p class="Login">
					<span><{if !empty($user->nickname)}><{$user->nickname}>-<{/if}><{$user.phone}> 已登录</span>
				</p>
				<{else}>
				<p class="Login" id="login">
					<span>登录</span>
					<span></span>
					<span>注册</span>
				</p>
				<{/if}>
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
					<li>楼层信息</li>
					<li class="moreItem" id="moreItem">
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

<{block "body-scripts-plus"}>
	<script type="text/javascript">
		!function($){
			$(function(){
				$("#template").hide();	
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
		}(jQuery);
	</script>
<{/block}>	

