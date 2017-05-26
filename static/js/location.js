// JavaScript Document
(function($){
	function siteMap(){
		var maplv = 17;
		var default_px = [113.38431,31.71998];
		var center_point,map,marker;
        var iconImg = new BMap.Icon("http://map.baidu.com/image/us_mk_icon.png",new BMap.Size(23,25),{imageOffset: new BMap.Size(-46,-21),infoWindowOffset:new BMap.Size(17,1),offset:new BMap.Size(9,25)});
			
		//创建地图函数：
		this.createMap = function(){
		    map = new BMap.Map("map");//在百度地图容器中创建一个地图
		    center_point = arguments[0] ? arguments[0] : new BMap.Point(default_px[0], default_px[0]);//定义一个中心点坐标
		    map.centerAndZoom(center_point,maplv);//设定地图的中心点和坐标并将地图显示在地图容器中
		    map.setCenter(center_point);
		}
		//地图事件设置函数：
		this.setMapEvent = function(){
		    map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
		    map.enableScrollWheelZoom();//启用地图滚轮放大缩小
		    map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
		    map.enableKeyboard();//启用键盘上下左右键移动地图
		}
		//地图控件添加函数：
		this.addMapControl = function(){
		    //向地图中添加缩略图控件
		    var ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:1});
		    map.addControl(ctrl_ove);
		    var top_right_navigation = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT});
		    map.addControl(top_right_navigation);
		    //向地图中添加比例尺控件
		    var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
		    map.addControl(ctrl_sca);
		    var size = new BMap.Size(10, 20);
		    var ctrl_list = new BMap.CityListControl({anchor:BMAP_ANCHOR_TOP_LEFT,offset: size});
		    map.addControl(ctrl_list);
		}
		//创建marker
		this.addMarker = function(point){
				var is_open = typeof(arguments[1]) == "undefined" ? true : arguments[1];
			    var shop_title = $('#name').val();
			    if(shop_title=='' || shop_title==null) shop_title='位置.';
			    var shop_address = $('#address').val();
			    if(shop_address=='') shop_address='点击地图,切换位置.';
			    
		        marker = new BMap.Marker(point);//,{icon:iconImg}
		        var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + shop_title + "'>" + shop_title + "</b><div class='iw_poi_content'>"+shop_address+"</div>");
		        var label = new BMap.Label(shop_title,{"offset":new BMap.Size(0,20)});
		        marker.setLabel(label);
		        label.hide();
		        map.addOverlay(marker);
		        label.setStyle({
		            borderColor:"#808080",
		            color:"#333",
		            cursor:"pointer"
		        });

		        marker.addEventListener("click",function(){
		            this.openInfoWindow(iw);
		        });
		            
		        iw.addEventListener("open",function(){
		        	marker.getLabel().hide();
		        });
		        
		        iw.addEventListener("close",function(){
//		                marker.getLabel().show();
		        });
		        
		        iw.addEventListener("click",function(){
		        	marker.openInfoWindow(iw);
		        })

		        is_open&&marker.openInfoWindow(iw);
		}
		
		this.initMap = function(){
			 center_point = arguments[0] ? arguments[0] : new BMap.Point(default_px[0], default_px[1]);
			 this.createMap(center_point);//创建地图
			 this.setMapEvent();//设置地图事件
			 this.addMapControl();//向地图添加控件
			 this.addMarker(center_point);//向地图中添加marker
			 
			 _self = this;
		     map.addEventListener("click", function(e) {//  
		        map.removeOverlay(marker);
				var point = new BMap.Point(e.point.lng, e.point.lat);
				_self.addMarker(point,false);

				$("#latitude").val(e.point.lat.toFixed(8));
				$("#longitude").val(e.point.lng.toFixed(8));	
			}, false);
		};
	}
	
	$(document).ready(function() {
		var site_map = new siteMap;
		var latitude=$("#latitude").val();//纬度
		var longitude=$("#longitude").val();//经度
		if(latitude=='' && longitude==''){
			if (navigator.geolocation){
				navigator.geolocation.getCurrentPosition(function (position){
					bd = GPS.bd_encrypt(position.coords.latitude, position.coords.longitude);
					$("#latitude").val(bd.lat); 
					$("#longitude").val(bd.lon);	
					center_point = new BMap.Point(bd.lon,bd.lat);
					site_map.initMap(center_point);
				},
				function showError(error)
				{
					switch(error.code) 
					{
						case error.PERMISSION_DENIED:
						  alert("用户拒绝定位请求.");
						  break;
						case error.POSITION_UNAVAILABLE:
						  alert("位置信息不可用.");
						  break;
						case error.TIMEOUT:
						  alert("请求获得用户位置超时.");
						  break;
						case error.UNKNOWN_ERROR:
						  alert("发生了一个未知错误.");
						  break;
					}
					site_map.initMap();
				});
			}else{
				site_map.initMap();
			}
		}else{
			site_map.initMap();
		}
	});
	
})(jQuery);








