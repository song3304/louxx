<{extends file="extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
	<script src="<{'js/public.js'|static}>"></script>
	<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.9&key=879a6e897959d23c7638450d40cc75e0"></script>
	<script src="<{'js/flexslider/jquery.flexslider-min.js'|static}>"></script>
<{/block}>

<{block "head-styles-bootstrap"}>
<{/block}>

<{block "head-styles-plus"}>
<link href="<{'js/flexslider/flexslider.css'|static}>" rel="stylesheet">
<link rel="stylesheet" href="<{'css/index/office.css'|static}>" />
<style>
*{
	margin: 0;
	padding: 0;
}
#container {
	height: 24.6rem; 
} 
.marker {
            color: #000;
            padding: 4px 10px;
            border: 1px solid #fff;
            white-space: nowrap;
            font-size: 12px;
            font-family: "";
            background-color: #fff;
        }
.flexslider .slides img {
  width: 100%;
  height: 25rem;
  display: block;
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
	<div class="officeTop">
		<div class="officeTop_img">
			<div class="flexslider officeTop_img" id="homeSlider">
				<ul class="slides">
					<{foreach $_office.pics as $pic}>
					<li><a><img src="<{'attachment/preview'|url}>?id=<{$pic.pic_id}>" class="img-responsive"></a></li>
					<{foreachelse}>
					<{/foreach}>
				</ul>
			</div>	
					
		</div>
		<ul class="officeTop_1">
			<li>
				<img src="<{'image/logo3.png'|static}>"/>			
			</li>
			<li><{$_office.building_name}></li>
			<li class="moreItem" id="moreItem">
				<img src="<{'image/more.png'|static}>"/>
			</li>
		</ul>
		<ul class="officebottom">
			<li>
				<img src="<{'image/map.png'|static}>"/>
			</li>
			<li>
				【<{$_office.village_name}>】<{$_office.address}>
			</li>
			<li></li>
		</ul>
		</div>
		<div class="officeInfor">
				<li class="officeInfor_1">
					<p><{$_office.building_name}></p>
					<p>
						<{if !empty($_office.info)}>
						<span><{$_office.info.avg_price}></span><span>m²/天</span>
						<{else}>
						暂无
						<{/if}>
					</p>
				</li>
				<li class="officeInfor_2">
					<p>
						<span><{$_office.village_name}>-<{$_office.address}></span>
						<span></span>
						<span>建筑面积<{$_office.info.area_covered}>m²</span>
					</p>
					<p>
						<img src="<{'image/search.png'|static}>"/>
						<input type="text" name="keywords" id="search_company" value="" placeholder="搜索企业"/>
					</p>
				</li>
				<li class="officeInfor_3">
					<{foreach $_office.tags as $tag}>
					<p><{$tag.tag_name}></p>
					<{/foreach}>
				</li>
			</div>
			
			<ul class="officeNav">
				<li class="argument current">楼盘参数</li>
				<li></li>
				<li class="facility">周边设施</li>
				<li></li>
				<li class="floorInf">楼层信息</li>
				<li></li>
				<li class="rentout">全部待租</li>
			</ul>
			
			<!--楼盘参数-->
			<div class="floorArgument infoToggle">
				<ul>
					<li>
						<p>得房率</p>
						<p><{$_office.info.occupancy_rate|default:'--'}>%</p>
					</li>
					<li>
						<p>业主类型</p>
						<p><{$_office.info->owner_tag()}></p>
					</li>
				</ul>
				<ul>
					<li>
						<p>层数</p>
						<p><{$_office.info.floor_cnt|default:'--'}>层</p>
					</li>
					<li>
						<p>物业等级</p>
						<p><{$_office.info->level_tag()}></p>
					</li>
				</ul>
				<ul>
					<li>
						<p>静层高</p>
						<p><{$_office.info.floor_height|default:'--'}>米</p>
					</li>
					<li>
						<p>物业费</p>
						<p><{$_office.info.property_price|default:'--'}>元/m²·月</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>物业类型</p>
						<p><{$_office.info.property_type|default:'--'}></p>
					</li>
					<li>
						<p>开发商</p>
						<p><{$_office.info.developer|default:'--'}></p>
					</li>
				</ul>
				<ul>
					<li>
						<p>均价</p>
						<p><{$_office.info.avg_price|default:'--'}>元/m²·月</p>
					</li>
					<li>
						<p>停车位数量</p>
						<p><{$_office.info.parking_space_cnt|default:'--'}></p>
					</li>
				</ul>
				<ul>
					<li>
						<p>停车费</p>
						<p><{$_office.info.parking_price|default:'--'}>元/月</p>
					</li>
					<li>
						<p>竣工时间</p>
						<p><{$_office.info.publish_time|default:'无'}></p>
					</li>
				</ul>
				<ul>
					<li>
						<p>占地面积</p>
						<p><{$_office.info.area_covered|default:'--'}></p>
					</li>
					<li>
						<p>标准层面积</p>
						<p><{$_office.info.standard_area|default:'--'}>m²</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>地上层数</p>
						<p><{$_office.info.upstairs_cnt|default:'--'}>层</p>
					</li>
					<li>
						<p>地下层数</p>
						<p><{$_office.info.downstairs_cnt|default:'--'}>层</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>容积率</p>
						<p><{$_office.info.plot_ratio|default:'--'}>%</p>
					</li>
					<li>
						<p>绿化率</p>
						<p><{$_office.info.green_ratio|default:'--'}>%</p>
					</li>
				</ul>
			</div>
			
			
			<!--周边设施-->
			<div class="floorFacility infoToggle" style="display: none;">
				<ul class="floorFacilityTop">
					<li data-flag = "0">
						<img src="<{'image/restaurant.png'|static}>"/>
						<span>餐饮<{if count($_peripheries_info[0].list)>0}><{count($_peripheries_info[0].list)}><{/if}></span>
					</li>
					<li data-flag = "1">
						<img src="<{'image/hotel.png'|static}>"/>
						<span>酒店<{if count($_peripheries_info[1].list)>0}><{count($_peripheries_info[1].list)}><{/if}></span>
					</li>
					<li data-flag = "2">
						<img src="<{'image/health.png'|static}>"/>
						<span>健身<{if count($_peripheries_info[2].list)>0}><{count($_peripheries_info[2].list)}><{/if}></span>
					</li>
					<li data-flag = "3">
						<img src="<{'image/bank.png'|static}>"/>
						<span>银行<{if count($_peripheries_info[3].list)>0}><{count($_peripheries_info[3].list)}><{/if}></span>
					</li>
				</ul>
				
				<!--地图-->
				<div id="container"></div> 
			</div>
			
			<!--楼层信息-->
			<div class="floorInfor_s infoToggle floorFloorInf" style="display: none;">
				<div class="floorInfor_s_top">
					<img src="<{'image/floor.png'|static}>"/>
					<span>共<{$_office.info.floor_cnt|default:'--'}>层</span>
					<img src="<{'image/parking_space.png'|static}>"/>
					<span>GF <{$_office.info.parking_space_cnt|default:'--'}>个停车位</span>
				</div>
				<{foreach $_floor_list as $floor}>
				<ul class="floor_bref" data-fid="<{$floor.id}>">
					<li><span><{$floor.name}></span></li>
					<li><{$floor.description}></li>
					<img src="<{'image/triangle.png'|static}>"/>
				</ul>
				<{/foreach}>
			</div>
			
			<!--全部待租-->
			<div class="floorRentout infoToggle" style="display: none;">
				<p class="floorRentout_text">
					全部待租（<span><{count($_hire_info_list)|default:'暂无'}></span>）
				</p>
				<ul class="floorRentoutNav">
					<li class="floorRentoutNav_s" data-rage="[]">
						<span>不限</span>
					</li>
					<li data-rage="[0,100]">
						<span>0-100m²</span>
					</li>
					<li data-rage="[100,200]">
						<span>100-200m²</span>
					</li>
					<li data-rage="[200,500]">
						<span>200-500m²</span>
					</li>
				</ul>
				<{foreach $_hire_info_list as $hire}>
				<ul class="floorRentoutMain" data-area="<{$hire.acreage|default:0}>">
					<li>
						<{if count($hire.pics)>0}>
						<img src="<{'attachment/preview'|url}>?id=<{$hire.pics[0].pic_id}>"/>
						<{else}>
						<img src="<{'image/bg2.png'|static}>"/>
						<{/if}>
						<span><span class="floorRentoutMainNum">3</span>万元/月</span>
					</li>
					<li>
						<span><{$hire.acreage|default:'--'}>m²</span>
						<span><{$hire.min_station_cnt|default:'-'}>-<{$hire.max_station_cnt|default:'-'}>个工位</span>
					</li>
				</ul>
				<{/foreach}>
				<ul class="floorRentoutMain_no_data">
					暂无数据
				</ul>
			</div>
		
		</div>
<{/block}>

<{block "body-scripts-plus"}>
	<script type="text/javascript">
		//地图处理
		var peripheries_info = <{json_encode($_peripheries_info) nofilter}>;
		var map = new AMap.Map('container', {
			resizeEnable: true,
		    dragEnable:true,
		    scrollWheel:true,
		    doubleClickZoom:true,
		    keyboardEnable:true,
	        zoom:13,//级别
	        center: [<{$_office.longitude}>, <{$_office.latitude}>],//中心点坐标
	    });
	    
	    AMap.plugin([
			'AMap.ToolBar',
		    'AMap.Scale',
		    'AMap.OverView',
		    'AMap.MapType',
		    'AMap.Geolocation',
		   ], function(){
		   		// 在图面添加工具条控件，工具条控件集成了缩放、平移、定位等功能按钮在内的组合控件
		        map.addControl(new AMap.ToolBar());
		        // 在图面添加比例尺控件，展示地图在当前层级和纬度下的比例尺
		        map.addControl(new AMap.Scale());
		});
	    
	    //添加办公楼自己坐标
	    marker = new AMap.Marker({
            title: '<{$_office.building_name}>',
            icon: "<{'image/mark_red.png'|static}>",
            position: [<{$_office.longitude}>, <{$_office.latitude}>]
        });
       
        marker.setMap(map);
	    
	    //当前所有坐标
	    var current_markers = [];
	    function setMarks(flag){
	    	//删除所有坐标 
	    	current_markers.forEach(function(value,index){
	    		value.setMap(null);
	    		value = null;
	    	});
	    	current_markers = [];
	    	//根据标记添加所有点
	    	for(var j=0;j<peripheries_info[flag].list.length;j++){
	    			var mk = new AMap.Marker({
			            title: peripheries_info[flag].list[j].name,
			            icon: "<{'image/mark_blue.png'|static}>",
			            position: [peripheries_info[flag].list[j].longitude, peripheries_info[flag].list[j].latitude]
			        });
			        current_markers.push(mk);
			        mk.setMap(map);
	    	}
	    	
	    }
	    
	    function showAllMarks(){
	    	for(var i=0;i<peripheries_info.length;i++){
	    		for(var j=0;j<peripheries_info[i].list.length;j++){
	    			var mk = new AMap.Marker({
			            title: peripheries_info[i].list[j].name,
			            icon: "<{'image/mark_blue.png'|static}>",
			            position: [peripheries_info[i].list[j].longitude, peripheries_info[i].list[j].latitude]
			        });
			        current_markers.push(mk);
			        mk.setMap(map);
	    		}
	    	}
	    }
	    
	    (function($){
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

	    	//tag切换处理
	   		$('.officeNav li').on('click',function(){
	   			var class_name = $(this).attr('class');
	   			$(this).addClass('current').siblings().removeClass('current');
	   			var fix_class = 'floor'+class_name.substring(0,1).toUpperCase()+class_name.substring(1);
	   			$('.infoToggle').hide();
	   			$('.'+fix_class).show();
	   		});
	    	//租凭切换处理
	    	$('.floorRentoutNav li').on('click',function(){
	    		var rage = $(this).data('rage');
	    		$("")

	    		$(this).addClass('floorRentoutNav_s').siblings().removeClass('floorRentoutNav_s');
	    		$('.floorRentoutMain').each(function(){
	    			var area = parseInt($(this).data('area'));
	    			if(rage.length<1 || (area >= rage[0] && area <= rage[1])){
	    				$(this).show();
	    			}else{
	    				$(this).hide();
	    			}
	    		});
	    		if($('.floorRentoutMain :visible').length<1){
	    			$('.floorRentoutMain_no_data').show();
	    		}else{
	    			$('.floorRentoutMain_no_data').hide();
	    		}
	    	});
	    	//地图切换
	    	$('.floorFacilityTop li').on('click',function(){
	   			$(this).addClass('floorFacilityTopLiSpanOn').siblings().removeClass('floorFacilityTopLiSpanOn');
	    		var flag = parseInt($(this).data('flag'));
	    		setMarks(flag);
	    	});
	    	//进入楼层页
	    	$('.floor_bref').on('click',function(){
	    		var fid = $(this).data('fid');
	    		window.location.href = "<{'home/floor'|url}>?fid="+fid;
	    	});
	    	//搜索企业
	    	$('#search_company').on('keyup',function(){
	    		var keywords = $(this).val();
	    		window.location.href = "<{'home/findCompany'|url}>?keywords="+keywords;
	    	});
	    	$(function(){
			    $("#homeSlider").flexslider({
					animation: 'slide',
					directionNav: false,
					controlNav: false,
					touch: true,
				});
	    		//默认显示所有周边点
	    		showAllMarks();
	    	});
	    })(jQuery);
	</script>
<{/block}>