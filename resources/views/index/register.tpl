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
				<div>
					<input type="text" name="validate_code" id="validate_code" value="" placeholder="请输入验证码" class="verify"/>
				</div>
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
			//登录处理
			$('#register_submit').on('click',function(){
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