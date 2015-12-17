<script type="text/ng-template" id="wechat/depot/preview">

</script>

<script type="text/ng-template" id="wechat/depot/selector">
<div class="modal-header">
	<h3 class="modal-title">选择素材</h3>
</div>
<div class="modal-body">
	<div depot-controller="news" mode="selector"></div>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" type="button" ng-click="select()">选择</button>
	<button class="btn btn-warning" type="button" ng-click="cancel()">取消</button>
</div>
</script>