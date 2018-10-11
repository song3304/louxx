<{extends file="extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.9&key=879a6e897959d23c7638450d40cc75e0"></script>
<script src="<{'js/vue.js'|static}>"></script>
<script>
	var city_id = <{if !empty($_city_id)}><{$_city_id}><{else}>0<{/if}>;
	var city_name = <{if !empty($_city_name)}>'<{$_city_name}>'<{else}>null<{/if}>;
	var lat,lon;//经纬度
</script>

<script src="<{'js/index/main.js'|static}>"></script>
<{/block}>

<{block "head-styles-bootstrap"}>
<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/index/index.css'|static}>" />
<{/block}>


<{block "body-container"}>
	<div id="app">
		<!--div class="template">
			<div>
				<p>Logo</p>
				<p class="Login">
					<span>登录</span>
					<span></span>
					<span>注册</span>
				</p>
			</div>
			<div>
				<span>找办公楼</span>
			</div>
			<div class="can_bat">
				<p></p>
				<p></p>
				<p></p>
				<li></li>
			</div>
			<p>我的收藏</p>
		</div-->
		<div class="place">
			<div>
				<li><img src='<{'image/fix_postion_icon.png'|static}>'/>{{city_name}}</li>
			</div>
			<input type="text" :value="keywords" placeholder="关键词" @change="seach_key"/>
			<ul class="selects">
				<input type="text" class="foucs" ref='focus' @focus="focus" @blur="blur" />
				<div @click="choose_regions">{{region_data.name}}
					<ul ref='region'>
						<li v-for="area in areaList" :data-value="area.area_id" @click="set_region">{{area.area_name}}</li>
					</ul>
				</div>
				<div @click="choose_distance">{{distance_data.name}}
					<ul ref='distance' id="distance">
						<li data-value="1" @click="set_distance">1000米以内</li>
						<li data-value="2" @click="set_distance">1000-2000米</li>
						<li data-value="3" @click="set_distance">2000-5000米</li>
						<li data-value="4" @click="set_distance">5000米以上</li>
					</ul>
				</div>
				<div @click="choose_price">{{price_data.name}}
					<ul ref='price'>
						<li data-value="6" @click="set_price">6m²/天</li>
						<li data-value="7" @click="set_price">7m²/天</li>
						<li data-value="8" @click="set_price">8m²/天</li>
						<li data-value="9" @click="set_price">9m²/天</li>
					</ul>
				</div>
			</ul>
		</div>
		<div v-for="building in building_list" class="list" @click="look_buiding(building.id)">
			<li>
				<img v-if="building.pics.length<1" src="<{'image/bg.png'|static}>" />
				<img v-else :src="'<{'attachment/preview'|url}>?id='+building.pics[0].pic_id" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>{{building.building_name}}</span>
					<span><font class="price_per_m">{{building.info.avg_price}}</font>m²/天</span>
				</li>
				<p>{{building.address}} | 建筑面积{{building.info.area_covered}}</p>
				<div>
					<li v-for="tag in building.tags">{{tag.tag_name}}</li>
				</div>
			</div>
		</div>
		<div v-if="building_list.length<1" class="list">
			<li>
				
			</li>
			<div class="td">
				<li class="td_md1">
					<span></span>
					<span></span>
				</li>
				<p>暂无数据</p>
			</div>
		</div>
	</div>
	<div id="map"/>
<{/block}>


<{block "body-scripts-plus"}>
	<script type="text/javascript">
		new Vue({
			el: "#app",
			data: function() {
				return {
					city_id:0,
					city_name:'',
					index: null,
					areaList:[],	//区域列表
					keywords:'',//关键字
					region_data:{name:'区域',value:0}, 		//区域
					distance_data:{name:'距离',value:0},	//距离
					price_data:{name:'价格',value:0}, 			//价格
					building_list:[]
				}
			},
			mounted() {
				var _this = this;
				var map = new AMap.Map("map");
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
					lat = data.position.getLat();
					lon = data.position.getLng();
				}
				//解析定位错误信息
				 function onError(data) {
					 jQuery('#distance').html(''); //定位失败距离不可用
					 
					 //alert('获取经纬度失败.');
				 }
				 
				 if(city_id == 0){
					 map.plugin('AMap.CitySearch', function() {
						var citysearch = new AMap.CitySearch();
						//自动获取用户IP，返回当前城市
						citysearch.getLocalCity(function(status, result) {
							if (status === 'complete' && result.info === 'OK') {
								if (result && result.city && result.bounds) {
									var cityinfo = result.city;
									if(cityinfo != city_name){ //当用户切换城市时跳转
										//window.location.href = '/?city_name='+cityinfo;
										jQuery.post("<{'home/setCity'|url}>",{city_name:cityinfo},function(response){
											if(response.result == 'success'){
												_this.city_id = response.data.city_id;
												_this.city_name = cityinfo;
											}else{
												_this.city_id = 110000;
												_this.city_name = '北京市';
											}
										});
										
									}
						        }
						    } else {
						   		_this.city_id = 110000;
								_this.city_name = '北京市';
						    	//alert('定位城市失败');
						    }
						});
					});
				}else{
					_this.city_id = city_id;
					_this.city_name = city_name;
				}
			},
			watch: {
				city_id: function(val,oldVal){
					this.get_area_list(val);
				},
			    keywords: function(val,oldVal){
			        this.search_building();
		      	},
		      	region_data: {
			      deep: true,
			      handler () {
			        this.search_building();
			      }
		      	},
		      	distance_data: {
			      deep: true,
			      handler () {
			        this.search_building();
			      }
		      	},
		      	price_data: {
			      deep: true,
			      handler () {
			        this.search_building();
		      	  }
		      	}
		    },
			methods: {
				focus: function() {
					switch(this.index) {
						case 1:
							this.$refs.region.style.height = '1.76rem';
							break;
						case 2:
							this.$refs.distance.style.height = '1.76rem';
							break;
						case 3:
							this.$refs.price.style.height = '1.76rem';
							break;
					}
				},
				blur: function() {
					switch(this.index) {
						case 1:
							this.$refs.region.style.height = 0;
							break;
						case 2:
							this.$refs.distance.style.height = 0;
							break;
						case 3:
							this.$refs.price.style.height = 0;
							break;
					}
				},
				choose_regions: function() {
					this.index = 1; //切换到区域
					this.$refs['focus'].focus();
				},
				choose_distance: function(){
					this.index = 2;
					this.$refs['focus'].focus();
				},
				choose_price: function(){
					this.index = 3;
					this.$refs['focus'].focus();
				},
				set_region:function(event){
					_this = jQuery(event.currentTarget);
					this.region_data.name = _this.html();
					this.region_data.value = _this.data('value');
					this.$refs['focus'].blur();
				},
				set_distance:function(event){
					_this = jQuery(event.currentTarget);
					this.distance_data.name = _this.html();
					this.distance_data.value = _this.data('value');
					this.blur();
				},
				set_price:function(event){
					_this = jQuery(event.currentTarget);
					this.price_data.name = _this.html();
					this.price_data.value = _this.data('value');
					this.blur();
				},
				seach_key:function(event){
					_this = jQuery(event.currentTarget);
					this.keywords = _this.val();
				},
				search_building(){ //ajax请求更新数据
					_this = this;
					if(this.city_id<1) return;
					var post_data = {
						keywords:this.keywords,
						area_id:this.region_data.value,
						distance_scope:this.distance_data.value,
						price_scope:this.price_data.value,
						lat:lat,
						lon:lon
					};
					jQuery.post("<{'home/index'|url}>",post_data,function(response){
						if(response.result == 'success'){
							_this.building_list = response.data.buildings;
							//console.log(response.data);
						}else{
							console.log('查找错误',response);
						}
					});
				},
				get_area_list(city_id){ //ajax请求获取区域 
					_this = this;
					jQuery.post("<{'home/getAreaList'|url}>",{city_id:city_id},function(response){
						if(response.result == 'success'){
							_this.areaList = response.data.areaList;
							_this.search_building();
						}else{
							console.log('区域错误:',response);
						}
					});
				},
				look_buiding(building_id){
					window.location.href = "<{'home/office'}>?oid="+building_id;
				}
			}
		})
	</script>
<{/block}>