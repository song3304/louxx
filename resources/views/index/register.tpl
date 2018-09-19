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
		$(function(){
			//登录处理
			$('#register_submit').on('click',function(){
				$('#form').submit();
			});
			//发送验证码
			$('#send_code_btn').on('click',function(){
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
	}(jQuery);
</script>
<{/block}>