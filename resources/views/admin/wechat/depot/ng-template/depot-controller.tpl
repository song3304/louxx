<script type="text/ng-template" id="wechat/depot/controller">
<div class="row">
	<div class="col-xs-12">
		<div class="block">
			<uib-tabset type="tabs">
				<uib-tab ng-repeat="(key,text) in types" heading="{{text}}"  select="show(key)">
					<div depot-list="key" from="dataList[key]"></div>
				</uib-tab>
			</uib-tabset>
	</div>
</div>
</script>