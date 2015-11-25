//depot controllers
$app.controller('newsController',  function($scope, $http) {
	$scope.reload = function(page, filters, orders)
	{
		$http.post(jQuery.baseuri + 'admin/wechat/depot/data/json?type=news').success(function(json){
			if (json.result == 'success')
				$scope.data = json.data.data;
			else
				$.showtips(json);
		});
	}
	$scope.reload();
	console.log($scope);
});