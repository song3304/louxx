<{extends file="extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script src="<{'js/vue.js'|static}>"></script>
<script src="<{'js/index/main.js'|static}>"></script>
<{/block}>

<{block "head-styles-bootstrap"}>
<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/index/index.css'|static}>" />
<{/block}>


<{block "body-container"}>
	<div id="app">
		<div class="template">
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
			<p>我的收藏-xxx-xxx</p>
		</div>
		<div class="place">
			<div>
				<li><img src='<{'image/fix_postion_icon.png'|static}>' />北京</li>
			</div>
			<input type="text" placeholder="关键词" />
			<ul class="selects">
				<input type="text" class="foucs" ref='focus' @focus="focus" @blur="blur" />
				<div @click="regions">区域
					<ul ref='region'>
						<li>1</li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
					</ul>
				</div>
				<div>距离
					<ul ref='distance'>
						<li>1</li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
					</ul>
				</div>
				<div>价格
					<ul ref='price'>
						<li>1</li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
					</ul>
				</div>
			</ul>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
		<div class="list">
			<li>
				<img src="<{'image/bg.png'|static}>" />
			</li>
			<div class="td">
				<li class="td_md1">
					<span>望京大廈A</span>
					<span>m²/天</span>
				</li>
				<p>朝陽-望京 | 建筑面积36877m²</p>
				<div>
					<li>互联网行业</li>
					<li>名企开发</li>
					<li>地标建筑</li>
				</div>
			</div>
		</div>
	</div>
<{/block}>


<{block "body-scripts-plus"}>
	<script type="text/javascript">
		var Region, Distance, Price = false;
		new Vue({
			el: "#app",
			data: function() {
				return {
					index: null,
					region: false,
					price: false,
					distance: false
				}
			},
			created() {

			},
			methods: {
				focus: function() {
					switch(this.index) {
						case 1:
							this.region = false;
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
							this.region = true;
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
				regions: function() {
					this.index = 1;
					this.false = true;
					if(this.region) this.$refs['focus'].blur();
					if(!this.region) this.$refs['focus'].focus();
				}
			}
		})
	</script>
<{/block}>