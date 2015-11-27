//depot controllers
angular.module("template/tabs/tabset.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/tabs/tabset.html",
    "<div>\n" +
    "  <div class=\"block-title\"><ul class=\"nav nav-{{type || 'tabs'}}\" ng-class=\"{'nav-stacked': vertical, 'nav-justified': justified}\" ng-transclude></ul></div>\n" +
    "  <div class=\"tab-content\">\n" +
    "    <div class=\"tab-pane\" \n" +
    "         ng-repeat=\"tab in tabs\" \n" +
    "         ng-class=\"{active: tab.active}\"\n" +
    "         uib-tab-content-transclude=\"tab\">\n" +
    "    </div>\n" +
    "  </div>\n" +
    "</div>\n" +
    "");
}]);

$app.controller('depotController',  function($rootScope, $scope, $ajax, $uibModal, $log) {
	$scope.dataList = {};
	$scope.load = function(type, page, filters, orders)
	{
		if (!filters) filters = {};
		filters['type'] = type;
		$scope['type'] = type;
		$ajax.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'page': page, 'pagesize': 2,'filters': filters, 'orders': orders}, function(json){
			if (json.result == 'success')
				$scope.dataList[type] = json.data;
			else
				$.showtips(json);
		}, false);
	};
	$scope.reload = function(type){
		$scope.load(type, $scope.dataList[type].current_page, $scope.dataList[type]['filters'], $scope.dataList[type]['orders']);
	};
	$scope.show = function(type){
		if (!$scope[type])
			$scope.load(type, 1);
	};
	//删除
	$scope.$on('destroy', function(e, type){
		$scope.reload(type);
	});
	$scope.$on('create', function(e, type){

	});
	//编辑
	$scope.$on('edit', function(e, type, depotId){
		$newScope = $rootScope.$new(true, $scope);
		$newScope.type = type;
		$newScope.depotId = depotId;
		var modalInstance = $uibModal.open({
			animation: true,
			templateUrl: 'wechat/depot/edit',
			controller: 'depotEditController',
			size: 'lg',
			backdrop: 'static',
			scope: $newScope,
		});
		modalInstance.result.then(function (){
			
		}, function () {
			$log.info('Modal dismissed at: ' + new Date());
		});
    });

	$scope.types = {'news': '图文','text': '文本','image': '图片','callback': '编程','video': '视频','voice': '录音','music': '音乐'};

	//monitor page change
	angular.forEach($scope.types, function(text, type){
		$scope.$watch('dataList.'+type+'.current_page', function(newValue, oldValue) {
			if (newValue === oldValue) { return; }
			if (!isNaN(oldValue)) //不是无值
				$scope.reload(type);
		});
	});
	
	//init
	$scope.show($scope.type);
}).directive('depotController',function() {
	return {
		restrict: 'A',
		scope: {
			mode: '@mode',
			type: '@depotController'
		},
		controller: 'depotController',
		replace: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/controller';
		}
	}
})
.controller('depotListController',  function($scope){
	$scope.mode = $scope.$parent.mode;

}).directive('depotList',function() {
	return {
		restrict: 'A',
		scope: {
			dataFrom: '=from',
			type: '=depotList'
		},
		//transclude: true,
		require: ['^depotController'],
		controller: 'depotListController',
		replace: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/list';
		},
		link: function(scope){

		}
	};
})
.controller('depotListOptionsController',  function($scope){

}).directive('depotListOptions',function() {
	return {
		restrict: 'A',
		scope: {
			depotId: '=',
			mode: '=depotListOptions'
		},
		//transclude: true,
		require: ['^depotList'],
		controller: 'depotListOptionsController',
		replace: true,
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/list/options';
		},
		link: function(scope){

		}
	};
})
.controller('depotEditController', function($scope, $uibModalInstance, $ajax){
	// $uibModalInstance.close();
	// $uibModalInstance.dismiss('cancel');
	$scope.forms = {}; //form 变量
	$scope.submiting = false; //正在提交

	$scope.init = function(){
		$scope.depot = {
			id: 0,
			type: $scope.type
		};
		$scope.depot[$scope.type] = null;
	}
	$scope.load = function(type, depotId){
		
		return $ajax.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'pagesize': 2,'filters[type]': $scope.type, 'filters[id]': $scope.depotId}, function(json){
			if (json.result == 'success')
				if (json.data && json.data.data && json.data.data[0]) $scope.depot = json.data.data[0];	else $scope.init();
			else
				$.showtips(json);
		}, false);

	}
	
	$scope.createNews = function(){
		if (!$scope.depot.news || !($scope.depot.news instanceof Array))
			$scope.depot.news = [];
		if ($scope.depot.news.length >= 7)
		{
			jQuery.alert('最多只能创建7条图文！');
			return false;
		}
		$scope.depot.news.push({
			id: '',
			title: '',
			cover_id: '',
			cover_in_content: true,
			description: '',
			redirect: true,
			content: '',
			url: ''
		});
		$scope.editNews($scope.depot.news.length - 1);
	}

	$scope.editNews = function(index){
		angular.forEach($scope.depot.news, function(v){
			v.active = false;
		});
		$scope.depot.news[index].active = true;
	}

	$scope.saveNews = function(index)
	{
		//jQuery.de
	}

	$scope.destroyNews = function(index)
	{
		if ($scope.depot.news.length <= 1) return false;
		if ($scope.forms['news'][index].modified)
		{
			jQuery.confirm('您已修改本文章，是否确定删除？',function(){
				$scope.depot.news.splice(index, 1);
				$scope.editNews(index <= 0 ? 0 : index - 1);
				$scope.$apply();
			});
		} else {
			$scope.depot.news.splice(index, 1);
			$scope.editNews(index <= 0 ? 0 : index - 1);
		}
	}

	$scope.prevNews = function(index)
	{
		if (index <= 0) return false;
		$scope.depot.news[index] = $scope.depot.news.splice(index-1, 1, $scope.depot.news[index])[0];
		$scope.editNews(index - 1);
	}

	$scope.nextNews = function(index)
	{
		if (index >= $scope.depot.news.length - 1) return false;
		$scope.depot.news[index] = $scope.depot.news.splice(index+1, 1, $scope.depot.news[index])[0];
		$scope.editNews(index + 1);
	}

	$scope.cancel = function()
	{
		var modified = false;
		for(var i in $scope.form)
			if ( !!$scope.form[i].modified )
				modified = true;

		if (modified)
			jQuery.confirm('内容已修改，您确定不保存？', function(){
				$uibModalInstance.dismiss('cancel');
			});
		else
			$uibModalInstance.dismiss('cancel');
	}

	$scope.save = function()
	{
		$scope.submiting = true;
		console.log($scope.forms.depot);
	}

	if (!isNaN($scope.depotId) && $scope.depotId > 0)
		$scope.load().done(function(){
			if ($scope.type == 'news')
				$scope.editNews(0);
		});
	else
	{
		$scope.init();
		if ($scope.type == 'news') //创建一条空白新闻
			$scope.createNews();
	}

})