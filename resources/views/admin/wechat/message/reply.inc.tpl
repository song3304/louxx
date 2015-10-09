<div id="reply-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> 回复</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<form action="index.html" id="form" method="post" class="form-horizontal">
				<{csrf_field() nofilter}>
				<{method_field('PUT') nofilter}>
				<input type="hidden" name="type" value="text">
					<div class="form-group">
						<div class="col-md-10 col-md-offset-1">
							<p class="form-control-static" id="nickname"></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-10 col-md-offset-1">
							<textarea id="content1" name="content" class="form-control" placeholder="请输入需要回复的内容"></textarea>
						</div>
					</div>
		
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">关闭</button>
							<button type="submit" class="btn btn-sm btn-primary">提交</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<script>
(function($){
	$('a[name="reply"]').click(function(){
		$('#form').attr('action', $(this).attr('href'));
		$('#content1').val('');
		$('#nickname').text($(this).data('nickname'));

		$('#reply-modal').modal({backdrop: 'static', show: true});
		return false;
	});
	$('#form').query();
})(jQuery);
</script>