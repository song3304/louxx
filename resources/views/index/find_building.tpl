<{extends file="extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script src="<{'js/public.js'|static}>"></script>
<link rel="stylesheet" href="<{'js/select2/select2.min.css'|static}>"></script>
<script src="<{'js/select2/select2.min.js'|static}>"></script>
<script src="<{'js/select2/i18n/zh-CN.js'|static}>"></script>
<script src="<{'js/laravel.select.min.js'|static}>"></script>

	<script type="text/javascript">
	(function($){
		$().ready(function(){
			<{call validate selector='#form'}>
		});
	})(jQuery);
	</script>
<{/block}>

<{block "head-styles-plus"}>
<link rel="stylesheet" href="<{'css/common.css'|static}>" />
<link rel="stylesheet" href="<{'css/index/lookbuilding.css'|static}>" />
<{/block}>

<{block "body-container"}>
<div id="page">
	<div class="top">
		<a href="#">
			<img src="<{'image/icon-arrow-left.png'|static}>"/>
		</a>
		<span>帮我找楼</span>
	</div>
	<form action="<{'findBuilding/apply'|url nofilter}>" class="" method="POST" autocomplete="off" id="form">
	<div class="region">
		<p>所处区域</p>
		<div>
			<select id="province" name="province" class="select-model form-control input text" data-id="{{area_id}}" data-params='{"f[parent_id]":"0"}' data-model="area" data-text="{{area_name}}" data-term="{{area_name}}" data-placeholder="请输入省" value="<{$_data.province|default:110000}>"></select>
			<select id="city" name="city" class="select-model form-control input text" data-id="{{area_id}}" data-params='{"f[parent_id]":"<{$_data.province|default:110000}>"}' data-model="area" data-text="{{area_name}}" data-term="{{area_name}}" data-placeholder="请输入市" value=""></select>
			<select id="area" name="area" class="select-model form-control input text" data-id="{{area_id}}" data-params='{"f[parent_id]":"<{$_data.city|default:110100}>"}' data-model="area" data-text="{{area_name}}" data-term="{{area_name}}" data-placeholder="请输入市" value=""></select>
		</div>
	</div>
	<div class="rental">
		<p>租金范围</p>
		<div>
			<input type="number" name="rent_low" id="rent_low" value="" placeholder="最低价" />
			<div></div>
			<input type="number" name="rent_high" id="rent_high" value="" placeholder="最高价"/>
		</div>
	</div>
			
	<div class="remark">
		<p>备注</p>
		<textarea name="note" id="note" rows="" cols=""></textarea>
	</div>
	<div>
		<div class='tel-input'>
			<input type="text" name="phone" id="phone" class="tel" value="" placeholder="请输入手机号" />
		</div>
		<div class="line"></div>
		<div class="middle">
			<div>
				<input type="text" name="validate_code" id="validate_code" value="" placeholder="请输入验证码" class="verify"/>
			</div>
			<input type="button" name="send_code_btn" id="send_code_btn" value="发送验证码" class="send_validate_code"/>
		</div>
		<div class="line"></div>
	</div>
			
	<p class="warmprompt">*您也可以拨打400-xxx-xxxx直接委托需求</p>
			
	<div class="makesure" id="findbuilding_btn">确<span></span>定</div>	
</div>
<{/block}>

<{block "body-scripts-plus"}>
<script>
	!function($){
		var InterValObj; //timer变量，控制时间
		var count = 60; //间隔函数，1秒执行
		var curCount; //当前剩余秒数
		var method = {cacheData: {}};

		toastr.options = {  
					            closeButton: false,  
					            debug: false,  
					            progressBar: false,  
					            positionClass: "toast-top-center",  
					            onclick: null,  
					            showDuration: "300",  
					            hideDuration: "1000",  
					            timeOut: "5000",  
					            extendedTimeOut: "1000",  
					            showEasing: "swing",  
					            hideEasing: "linear",  
					            showMethod: "fadeIn",  
					            hideMethod: "fadeOut"  
        					};

		method.getData = function(url, params) {
			var key = JSON.stringify({url: url, params: params});
			var $dfd = jQuery.Deferred();
	
			if (typeof method.cacheData[key] != 'undefined')
				$dfd.resolve(method.cacheData[key]);
			else {
				$.POST(url, params).done(function(json, textStatus, jqXHR){
					if (json.result == 'success' || json.result == 'api') {
						var items = json.data.data;
						method.cacheData[key] = items;
						$dfd.resolve(method.cacheData[key]);
					} else {
						var args = arguments;
						$dfd.reject.apply($dfd, args);
					}
				}).fail(function(){
					var args = arguments;
					$dfd.reject.apply($dfd, args);
				});
			}
			return $dfd.promise();
		};
		method.replaceData = function(data, format)
		{
			return format.replace(/\{\{([\w\.]+)\}\}/g, function($0, $1){
				var o = $1.split('.');
				var d = data;
				for(var i = 0; i < o.length; ++i)
				{
					var n = o[i];
					if (typeof d != 'undefined' && typeof d[ n ] != 'undefined')
						d = d[n];
					else 
						return null;
				}
				return d;
			});
		};
		method.format = function(items, id, selection, text, pid) {
			var result = [];
			for(var i = 0; i < items.length; ++i) {
				var d = {
					'id': id ? method.replaceData(items[i], id) : items[i].id, 
					'text': text ? method.replaceData(items[i], text) : items[i].text,
					'selection': selection ? method.replaceData(items[i], selection) : items[i].selection,
					'pid': pid ? method.replaceData(items[i], pid) : items[i].pid
				};
				if (typeof items[i].children == 'object' && typeof items[i].children.length != 'undefined')
					d.children = method.format(items[i].children, id, selection, text, pid);
				result.push(d);
			}
			return result;
		};
		method.recursive = function(items, prefix) {
			prefix = typeof prefix == 'undefined' ? '' : prefix;
			var result = [];
			for(var i = 0; i < items.length; ++i) {
				var v = items[i];
				var _class = 'treeline ';
				if (i === 0 && !prefix) //首节点
					_class += 'top-';
				else if (i == items.length - 1) //尾节点
					_class += 'bottom-';
				else
					_class += 'center-';
				_class += v.children ? 'open' : 'line';
	
				var d = {
					'id': v.id,
					'selection': v.selection,
					'text': prefix + '<span class="'+_class+'"></span>' + v.text
				};
				result.push(d);
				if (v.children)
				{
					var ds = method.recursive(v.children, prefix + (i == items.length - 1 ? '<span class="treeline blank"></span>' : '<span class="treeline blank-line"></span>'));
					for(var j = 0; j < ds.length; ++j)
						result.push(ds[j]);
				}
			}
			return result;
		};
		
		$(function(){
			// 处理省市区
			$("#province").on('change',function(){
				$('#city').data('params',{"f[parent_id]":$(this).val()});
				select_change.call($('#city')[0]);
			});
			$("#city").on('change',function(){
				$('#area').data('params',{"f[parent_id]":$(this).val()});
				select_change.call($('#area')[0]);
			});
			
			function select_change(){
				var $this = $(this);
				var id = $this.data('id');
				var text = $this.data('text');
				var selection = $this.data('selection') ? $this.data('selection') : text;
				var params = $this.data('params');
				var values = $this.attr('value') ? $this.attr('value').split(',') : $this.val();
				var url = $.baseuri + $this.data('model')+'/data/json';
				params = $.extend(true, {}, {all: 'true'}, params);
				method.getData(url, params).done(function(json){
					var data = method.format(json, id, selection, text); 
					$this.html('');
					$this.select2($.extend(true, {}, {language: "zh-CN", data: data, allowClear: true})).trigger("change");
				});
			}
			//登录处理
			$('#findbuilding_btn').on('click',function(){
				$('#form').submit();
			});
			//发送验证码
			$('#send_code_btn').on('click',function(){
				curCount = count;
				$("#send_code_btn").attr("disabled", "true");
				$("#send_code_btn").val("请在" + curCount + "秒内输入");
				InterValObj = window.setInterval(SetRemainTimes, 1000); //启动计时器，1秒执行一次
				var phone = $('#phone').val();
				$.POST("<{'sendCode'|url}>",{phone:phone},function(response){
					if(response.result == 'success'){
						toastr.success(response.message);
					}else{
						//发送短信失败
						toastr.warning(response.message);
					}
				});
			});
		});
		function SetRemainTimes() {
			if(curCount == 0) {
				window.clearInterval(InterValObj); //停止计时器
				$("#send_code_btn").removeAttr("disabled"); //启用按钮
				$("#send_code_btn").val("重新发送验证码");
			} else {
				curCount--;
				$("#send_code_btn").val("请在" + curCount + "秒内输入");
			}
		}
	}(jQuery);
</script>
<{/block}>