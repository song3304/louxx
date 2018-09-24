<{extends file="extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script src="<{'js/public.js'|static}>"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.9&key=879a6e897959d23c7638450d40cc75e0"></script>
<{/block}>

<{block "head-styles-bootstrap"}>
<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/index/office.css'|static}>" />
<style>
*{
	margin: 0;
	padding: 0;
}
#container {
	height: 24.6rem; 
}  
</style>
<{/block}>

<{block "body-container"}>
<div id="page">
	<div class="officeTop">
		<div class="officeTop_img">
			<{foreach $_office.pics as $pic}>
				<img src="<{'attachment/preview'|url}>?id=<{$pic.pic_id}>"/>
			<{foreachelse}>
				<img src="<{'image/bg2.png'|static}>"/>
			<{/foreach}>			
		</div>
		<ul class="officeTop_1">
			<li>LOGO</li>
			<li><{$_office.building_name}></li>
			<li>
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
						<input type="text" name="" id="" value="" placeholder="搜索企业"/>
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
					<li>
						<img src="<{'image/restaurant.png'|static}>"/>
						<span>餐饮<{if count($_peripheries_info[1].list)>0}><{count($_peripheries_info[1].list)}><{/if}></span>
					<li>
						<img src="<{'image/hotel.png'|static}>"/>
						<span>酒店<{if count($_peripheries_info[2].list)>0}><{count($_peripheries_info[2].list)}><{/if}></span>
					</li>
					<li>
						<img src="<{'image/health.png'|static}>"/>
						<span>健身<{if count($_peripheries_info[3].list)>0}><{count($_peripheries_info[3].list)}><{/if}></span>
					</li>
					<li>
						<img src="<{'image/bank.png'|static}>"/>
						<span>银行<{if count($_peripheries_info[4].list)>0}><{count($_peripheries_info[4].list)}><{/if}></span>
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
	        zoom:11,//级别
	        center: [116.397428, 39.90923],//中心点坐标
	    });
	    
	    (function($){
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
	    	//进入楼层页
	    	$('.floor_bref').on('click',function(){
	    		var fid = $(this).data('fid');
	    		window.location.href = "<{'home/floor'|url}>?fid="+fid;
	    	});
	    })(jQuery);
	</script>
<{/block}>