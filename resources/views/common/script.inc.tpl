<script src="<{'static/js/jquery-2.1.0.min.js'|url}>"></script>
<script>jQuery.noConflict();</script>
<script src="<{'static/js/noty/jquery.noty.packaged.min.js'|url}>"></script>
<script src="<{'static/js/noty/themes/default.js'|url}>"></script>
<script src="<{'static/js/common.js'|url}>"></script>
<script src="<{'static/js/bootstrap3/bootstrap.min.js'|url}>"></script>
<script type="text/javascript">
(function($){
	$.fn.extend({trigger_error_bags : function(errors) {
		return this.each(function(){
			var $this = $(this);
			for(var i in errors) {
				var $parent = $('[name="'+ i +'"]', $this).closest('div');
				$('.help-block.validate', $parent).remove();
				for(var n = 0;n < errors[i].length;n++)
					$parent.addClass('has-error').append($('<span id="'+i+'-error" class="help-block validate">'+ errors[i][n] +'</span>'));
			}
		});	
	}
	});
	$.error_bags = <{if !empty($errors)}><{$errors->toArray()|@json_encode nofilter}><{else}>{}<{/if}>;	
})(jQuery);
</script>