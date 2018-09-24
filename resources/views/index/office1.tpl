<!DOCTYPE html>
<html style="font-size:10px;">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="email=no" name="format-detection" />
		<script src="/static/js/public.js" type="text/javascript" charset="utf-8"></script>
		<title></title>
		<link rel="stylesheet" href="<{'css/index/office.css'|static}>" />
		<style type="text/css">
			*{
				margin: 0;
				padding: 0;
			}
			#container {
				height: 24.6rem; 
			}  
		</style>
	</head>
	<body>
		<div id="page">
	<div class="officeTop">
		<div class="officeTop_img">
			<img src="<{'image/bg2.png'|static}>"/>
		</div>
		<ul class="officeTop_1">
			<li>LOGO</li>
			<li>楼层信息</li>
			<li>
				<img src="<{'image/more.png'|static}>"/>
			</li>
		</ul>
		<ul class="officebottom">
			<li>
				<img src="<{'image/map.png'|static}>"/>
			</li>
			<li>
				【朝阳-望京】望京街与阜安西路交叉路口
			</li>
			<li></li>
		</ul>
		</div>
		<div class="officeInfor">
				<li class="officeInfor_1">
					<p>望京SOHO</p>
					<p><span>6.5</span><span>m²/天</span></p>
				</li>
				<li class="officeInfor_2">
					<p>
						<span>朝阳-望京</span>
						<span></span>
						<span>建筑面积36877m²</span>
					</p>
					<p>
						<img src="<{'image/search.png'|static}>"/>
						<input type="text" name="" id="" value="" placeholder="搜索企业"/>
					</p>
				</li>
				<li class="officeInfor_3">
					<p>互联网行业</p>
					<p>名企开发</p>
					<p>地标建筑</p>
				</li>
			</div>
			
			<ul class="officeNav">
				<li class="argument">楼盘参数</li>
				<li></li>
				<li class="facility">周边设施</li>
				<li></li>
				<li class="floorInf">楼层信息</li>
				<li></li>
				<li class="rentout">全部待租</li>
			</ul>
			
			<!--楼盘参数-->
			<div class="floorArgument" style="display: none;">
				<ul>
					<li>
						<p>得房率</p>
						<p>65%</p>
					</li>
					<li>
						<p>业主类型</p>
						<p>大业主+小业主</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>层数</p>
						<p>35层</p>
					</li>
					<li>
						<p>物业等级</p>
						<p>甲级</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>静层高</p>
						<p>2.7米</p>
					</li>
					<li>
						<p>物业费</p>
						<p>24元/m²·月</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>物业类型</p>
						<p>暂无数据</p>
					</li>
					<li>
						<p>开发商</p>
						<p>SOHO中国</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>均价</p>
						<p>6.5元/m²·月</p>
					</li>
					<li>
						<p>停车位数量</p>
						<p>1800</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>停车费</p>
						<p>1500元/月</p>
					</li>
					<li>
						<p>竣工时间</p>
						<p>2013-12-01</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>占地面积</p>
						<p>暂无数据</p>
					</li>
					<li>
						<p>标准层面积</p>
						<p>2500m²</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>地上层数</p>
						<p>33</p>
					</li>
					<li>
						<p>地下层数</p>
						<p>2层</p>
					</li>
				</ul>
				<ul>
					<li>
						<p>容积率</p>
						<p>暂无数据</p>
					</li>
					<li>
						<p>绿化率</p>
						<p>30%</p>
					</li>
				</ul>
			</div>
			
			
			<!--周边设施-->
			<div class="floorFacility" style="">
				<ul class="floorFacilityTop">
					<li>
						<img src="<{'image/restaurant.png'|static}>"/>
						<span>餐饮35</span>
					</li>
					<li>
						<img src="<{'image/hotel.png'|static}>"/>
						<span>酒店35</span>
					</li>
					<li>
						<img src="<{'image/health.png'|static}>"/>
						<span>健身35</span>
					</li>
					<li>
						<img src="<{'image/bank.png'|static}>"/>
						<span>银行35</span>
					</li>
				</ul>
				
				<!--地图-->
				<div id="container"></div> 
			</div>
			
			<!--楼层信息-->
			<div class="floorInfor_s" style="display: none;">
				<div class="floorInfor_s_top">
					<img src="<{'image/floor.png'|static}>"/>
					<span>共35层</span>
					<img src="<{'image/parking_space.png'|static}>"/>
					<span>GF 187个停车位</span>
				</div>
				<ul>
					<li><span>First Floor</span> <span>1层</span></li>
					<li>接待大厅、物业管理办公室</li>
					<img src="<{'image/triangle.png'|static}>"/>
				</ul>
				<ul>
					<li><span>First Floor</span> <span>1层</span></li>
					<li>接待大厅、物业管理办公室</li>
					<img src="<{'image/triangle.png'|static}>"/>
				</ul>
				<ul>
					<li><span>First Floor</span> <span>1层</span></li>
					<li>接待大厅、物业管理办公室</li>
					<img src="<{'image/triangle.png'|static}>"/>
				</ul>
				<ul>
					<li><span>First Floor</span> <span>1层</span></li>
					<li>接待大厅、物业管理办公室</li>
					<img src="<{'image/triangle.png'|static}>"/>
				</ul>
			</div>
			
			<!--全部待租-->
			<div class="floorRentout" style="display: none;">
				<p class="floorRentout_text">
					全部待租（<span>160</span>）
				</p>
				<ul class="floorRentoutNav">
					<li class="floorRentoutNav_s">
						<span>不限</span>
					</li>
					<li>
						<span>0-100m²</span>
					</li>
					<li>
						<span>100-200m²</span>
					</li>
				</ul>
				<ul class="floorRentoutMain">
					<li>
						<img src="<{'image/bg2.png'|static}>"/>
						<span><span class="floorRentoutMainNum">3</span>万元/月</span>
					</li>
					<li>
						<span>139m²</span>
						<span>17-35个工位</span>
					</li>
				</ul>
				<ul class="floorRentoutMain">
					<li>
						<img src="<{'image/bg2.png'|static}>"/>
						<span><span class="floorRentoutMainNum">3</span>万元/月</span>
					</li>
					<li>
						<span>139m²</span>
						<span>17-35个工位</span>
					</li>
				</ul>
				<ul class="floorRentoutMain">
					<li>
						<img src="<{'image/bg2.png'|static}>"/>
						<span><span class="floorRentoutMainNum">3</span>万元/月</span>
					</li>
					<li>
						<span>139m²</span>
						<span>17-35个工位</span>
					</li>
				</ul>
			</div>
		
		</div>
	</body>
	<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.10&key=f29839c73366eb7dc180f512dd722962"></script> 
	<script type="text/javascript">
		var map = new AMap.Map('container', {
	        zoom:11,//级别
	        center: [116.397428, 39.90923],//中心点坐标
	    });
	</script>
</html>
