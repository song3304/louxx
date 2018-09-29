<{extends file="extends/main.block.tpl"}>

<{block "head-scripts-plus"}>
<script src="<{'js/public.js'|static}>"></script>
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
<link rel="stylesheet" href="<{'css/index/register.css'|static}>" />
<{/block}>

<{block "body-container"}>
<div id="page">
			<div class="logo">
				<span>楼查查logo</span>
				<!--<img src=""/>-->
			</div>
			<form action="<{'register/login'|url nofilter}>" class="" method="POST" autocomplete="off" id="form">
			<input type="hidden" name="_token" value="<{csrf_token()}>">
			<div class="form-group">
				<input type="text" name="phone" id="phone" value="" placeholder="请输入手机号" class="phone"/>
			</div>
			<div class="line"></div>
			<div class="middle">
				<input type="text" name="validate_code" id="validate_code" value="" placeholder="请输入验证码" class="verify"/>
				<input type="button" name="send_code_btn" id="send_code_btn" value="发送验证码" class="send_validate_code"/>
			</div>
			<div class="line"></div>
			<div class="register" id="register_submit">登<span></span>录</div>
			</form>
</div>
<{/block}>

<{block "body-scripts-plus"}>
<script>
	!function($){
		var InterValObj; //timer变量，控制时间
		var count = 60; //间隔函数，1秒执行
		var curCount; //当前剩余秒数
		$(function(){
			//登录处理
			$('#register_submit').on('click',function(){
				$('#form').submit();
			});
			
			//发送验证码
			$('#send_code_btn').on('click',function(){
				if (verifyIntervarl()) {
					var phone = $('#phone').val();
					$.POST("<{'sendCode'|url}>",{phone:phone},function(response){
						if(response.result == 'success'){
							toastr.success(response.message);
						}else{
							//发送短信失败
							toastr.warning(response.message);
						}
					});
				}
			});
			$("#phone").on("focus", function() {
				$("#_token").hide();
			});
			$("#validate_code").on("focus", function() {
				$("#_token").hide();
			})
		});

		function verifyIntervarl() {
			curCount = count;
			var phone = $("#phone").val();
			if (invalidatePhone(phone)) {
				return false;
			}
			if (phone != "") {
				//设置button效果，开始计时
				$("#send_code_btn").attr("disabled", "true");
				$("#send_code_btn").val("请在" + curCount + "秒内输入");
				InterValObj = window.setInterval(SetRemainTimes, 1000); //启动计时器，1秒执行一次
				return true;
			} else {
				$("#_token").html("  手机号不能为空");
				$("#_token").show();
				return false;
			}
		};

		//验证手机号
		function invalidatePhone(phone) {
			if(phone == '') {
				$("#_token").html("  请先填写手机号");
				$("#_token").show();
				return true;
			}
			var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
			if(!myreg.test(phone)) {
				$("#_token").html("  请输入有效的手机号");
				$("#_token").show();
				return true;
			}
			return false;
		};

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