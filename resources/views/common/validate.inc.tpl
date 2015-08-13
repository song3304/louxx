<script src="<{'static/js/jquery.validate.min.js'|url}>"></script>
<script src="<{'static/js/jquery.validate.addons.js'|url}>"></script>
<script>
(function($){
	//给validator设置默认值
	$.validator.setDefaults({
		errorClass: "help-block validate",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).closest('div').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('div').removeClass('has-error').addClass('has-success');
		},
		errorPlacement: function(error, element) {
			var $parent = element.closest('div');
			$('.help-block.validate', $parent).remove();
			error.appendTo($parent);
		},
		submitHandler:function(form){
			var $form = $(form);
			$.query($form.attr('action'), $form.serializeArray(), $form.attr('method'), function(json) {
				$form.triggerHandler('query', [json, form]);
			});
			return false;
			//form.submit();
		}
	});
	$.validates = <{if !empty($_validates)}><{$_validates|@json_encode nofilter}><{else}>{}<{/if}>;
})(jQuery);
</script>