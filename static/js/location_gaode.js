// JavaScript Document
(function($){
	function siteMap(){
		var maplv = 17;
		var default_px = [121.52315400,31.30530700];
		var center_point,map,marker,geolocation;
        var iconImg = new AMap.Icon({
        	size:new AMap.Size(23,25), // 图标尺寸
        	image:"http://map.baidu.com/image/us_mk_icon.png", // Icon的图像
        	imageOffset: new AMap.Pixel(-46,-21),   // 图像相对展示区域的偏移量
        	imageSize:  new AMap.Size(9, 25)   // 根据所设置的大小拉伸或压缩图片
        });
			
		//创建地图函数：
		this.createMap = function(){
		    map = new AMap.Map("map", {
		    	  resizeEnable: true,
		    	  dragEnable:true,
		    	  scrollWheel:true,
		    	  doubleClickZoom:true,
		    	  keyboardEnable:true
		    });
		    center_point = arguments[0] ? arguments[0] : new AMap.LngLat(default_px[0], default_px[1]);//定义一个中心点坐标
		    map.setZoomAndCenter(maplv,center_point);//设定地图的中心点和坐标并将地图显示在地图容器中
		    map.setCenter(center_point);
		}
		//地图控件添加函数：
		this.addMapControl = function(){
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
		}
		//创建marker
		this.addMarker = function(point){
				var is_open = typeof(arguments[1]) == "undefined" ? true : arguments[1];
			    var shop_title = $('#name').val();
			    if(shop_title=='' || shop_title==null) shop_title='位置.';
			    var shop_address = $('#address').val();
			    if(shop_address==''||typeof(shop_address) == "undefined") shop_address='点击地图,切换位置.';
			    
		        marker = new AMap.Marker({position:point});//,{icon:iconImg}
		        var iw = new AMap.InfoWindow({
		        	content:"<b class='iw_poi_title' title='" + shop_title + "'>" + shop_title + "</b><div class='iw_poi_content'>"+shop_address+"</div>",
		        	offset:new AMap.Pixel(0,-15)
		        });
		        marker.setMap(map);
		        /*
		        label.setStyle({
		            borderColor:"#808080",
		            color:"#333",
		            cursor:"pointer"
		        });*/

		        marker.on("click",function(){
		        	iw.open(map,point);
		        });
		        
		        iw.on("close",function(){
//		                marker.getLabel().show();
		        });
		        
		        iw.on("click",function(){
		        	iw.open(map,point);
		        })

		        is_open&&iw.open(map,point);
		}
		
		this.initMap = function(){
			 center_point = arguments[0] ? arguments[0] : AMap.LngLat(default_px[0], default_px[1]);
			 this.createMap(center_point);//创建地图
			 this.addMapControl();//向地图添加控件
			 this.addMarker(center_point);//向地图中添加marker
			 
			 _self = this;
		     map.on("click", function(e) {//  
		    	map.remove(marker);
				var point = new AMap.LngLat(e.lnglat.getLng(), e.lnglat.getLat());
				_self.addMarker(point);

				$("#latitude").val(e.lnglat.getLat().toFixed(8));
				$("#longitude").val(e.lnglat.getLng().toFixed(8));	
			}, false);
		};
		// 自动定位
		this.autoPosition = function(){
			_this = this;
			//加载地图，调用浏览器定位服务
		    map = new AMap.Map('map', {
		        resizeEnable: true
		    });
		    map.plugin('AMap.Geolocation', function() {
		        geolocation = new AMap.Geolocation({
		            enableHighAccuracy: true,//是否使用高精度定位，默认:true
		            timeout: 10000,          //超过10秒后停止定位，默认：无穷大
		            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
		            zoomToAccuracy: true,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
		            buttonPosition:'RB'
		        });
		        map.addControl(geolocation);
		        geolocation.getCurrentPosition();
		        AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
		        AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
		    });
		   //解析定位结果
		    function onComplete(data) {
		        var center_point = new AMap.LngLat(data.position.getLng(),data.position.getLat());
		        _this.addMapControl();//向地图添加控件
		        _this.addMarker(center_point);//向地图中添加marker
		        map.on("click", function(e) {//  
			    	map.remove(marker);
					var point = new AMap.LngLat(e.lnglat.getLng(), e.lnglat.getLat());
					_this.addMarker(point);

					$("#latitude").val(e.lnglat.getLat().toFixed(8));
					$("#longitude").val(e.lnglat.getLng().toFixed(8));	
				}, false);
		    }
		    //解析定位错误信息
		    function onError(data) {
		        //document.getElementById('tip').innerHTML = '定位失败';
		    	_this.initMap();
		    }
		    
		};
	}
	
	$(document).ready(function() {
		var site_map = new siteMap;
		var latitude=$("#latitude").val();//纬度
		var longitude=$("#longitude").val();//经度
		if(latitude=='' && longitude==''){
			site_map.autoPosition();
		}else{
			center_point = new AMap.LngLat(longitude,latitude);
			site_map.initMap(center_point);
		}
	});
	
})(jQuery);








