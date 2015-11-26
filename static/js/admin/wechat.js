//depot controllers


$app.controller('depotController',  function($scope, $ajax) {
	$scope.load = function(type, page, filters, orders)
	{
		if (!filters) filters = {};
		filters['type'] = type;
		$scope['type'] = type;
		$ajax.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'page': page, 'pagesize': 2,'filters': filters, 'orders': orders}, function(json){
			if (json.result == 'success')
				$scope[type] = json.data;
			else
				$.showtips(json);
		}, false);
	};
	$scope.reload = function(type){
		$scope.load(type, $scope[type].current_page, $scope[type]['filters'], $scope[type]['orders']);
	};
	$scope.show = function(type){
		if (!$scope[type])
			$scope.load(type, 1);
	};
	$scope.$on('destroy', function(e, type){
		$scope.reload(type);
	});


	//monitor page change
	['news','text','image','callback','video','voice','music'].forEach(function(type){
		$scope.$watch(type+'.current_page', function(newValue, oldValue) {
			if (newValue === oldValue) { return; }
			if (!isNaN(oldValue)) //不是无值
				$scope.reload(type);
		});
	});
	
	//init
	$scope.show('news');
})
.controller('depotListController',  function($scope){

}).directive('depotList',function() {
	return {
		restrict: 'A',
		scope: {
			depots: '=depotList',
			type: '@depotList'
		},
		//transclude: true,
		require: ['^depotController'],
		controller: 'depotListController',
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/list';
		}
	};
})
.controller('depotOptionsController',  function($scope){

}).directive('depotOptions',function() {
	return {
		restrict: 'A',
		scope: {
			depotId: '=',
			option: '@depotOptions'
		},
		//transclude: true,
		require: ['^depotList'],
		controller: 'depotOptionsController',
		templateUrl: function(element, attrs) {
			return attrs.templateUrl || 'wechat/depot/options';
		},
		link: function(scope){
			scope.destroy = function(a){
				console.log(a);
			}

			
		}
	};
});