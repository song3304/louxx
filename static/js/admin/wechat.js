//depot controllers

$app.controller('depotController',  function($rootScope, $scope, $query, $uibModal, $log, $element) {
	$scope.dataList = {};
	$scope.load = function(type, page, filters, orders)
	{
		if (!filters) filters = {};
		filters['type'] = type;
		$scope['type'] = type;
		$query.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'page': page, 'filters': filters, 'orders': orders}, function(json){
			if (json.result == 'success')
				$scope.dataList[type] = json.data;
			else
				jQuery.showtips(json);
		}, false);
	};
	$scope.reload = function(type){
		$scope.load(type, $scope.dataList[type].current_page, $scope.dataList[type]['filters'], $scope.dataList[type]['orders']);
	};
	$scope.show = function(type, reload){
		$scope.type = type;
		if (!$scope[type] || reload)
			$scope.load(type, 1);
	};
	$scope.edit = function(type, depotId){
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
			resolve: {
				
			}
		});
		modalInstance.result.then(function (){
			
		}, function () {
			//$log.info('Modal dismissed at: ' + new Date());
		});
	};
	$scope.destroy = function(type, depotId)
	{
		$scope.reload(type);
	}
	
	//读取
	$scope.$on('show', function(e, type, reload){
		$scope.show(type, reload)
	});
	$scope.$on('load', function(e, type, page, filters, orders){
		$scope.load(type, page, filters, orders);
	});
	$scope.$on('reload', function(e, type){
		$scope.reload(type)
	});
	//编辑
	$scope.$on('create', function(e, type){
		$scope.edit(type)
	});
	$scope.$on('edit', function(e, type, depotId){
		$scope.edit(type, depotId);
	});
	//删除
	$scope.$on('destroy', function(e, type, depotId) {
		$scope.destroy(type, depotId);
	});


	//builder date
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
.directive('depotItem',function($compile, $templateRequest, $sce) {
	return {
		restrict: 'A',
		scope: {
			depot: '=depot',
			type: '=depotItem'
		},
		transclude: true,
		require: ['^depotList'],
		replace: true,
		link: function(scope, element, attrs) {	
			var templateUrl = $sce.getTrustedResourceUrl('wechat/depot/' + scope.type);
			$templateRequest(templateUrl).then(function(template) {
				element.html(template);
				$compile(element.contents())(scope);
			}, function() {
				// An error has occurred
			});
		}
	}
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
.controller('depotEditController', function($scope, $uibModalInstance, $query){
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
		
		return $query.post(jQuery.baseuri + 'admin/wechat/depot/data/json',{'pagesize': 2,'filters[type]': $scope.type, 'filters[id]': $scope.depotId}, function(json){
			if (json.result == 'success')
				if (json.data && json.data.data && json.data.data[0]) $scope.depot = json.data.data[0];	else $scope.init();
			else
				jQuery.showtips(json);
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

	$scope.saveNews = function()
	{
		if (!$scope.forms.news) 
			return false;

		var querys = [];
		angular.forEach($scope.forms.news, function(form, index){
			var $form = jQuery('[name="'+form.$name+'"]');

			querys.push($query.form($form, function(json){
				if (json.data) {
					$scope.depot.news[index].id = json.data.id; //如果是新建，则改变文章的id
					form.$setPristine();
					$scope.$apply();
				}
			}, false).fail(function(json){
				$scope.editNews(index);
				jQuery.showtips(json);
			}).done(function(json){
				
			}));
		});

		return jQuery.when.apply(this,querys);
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
		//$scope.depot.news[index] = $scope.depot.news.splice(index-1, 1, $scope.depot.news[index])[0];
		var a = angular.copy($scope.depot.news[index]);var b = angular.copy($scope.depot.news[index - 1]);
		$scope.depot.news[index] = b; $scope.depot.news[index - 1] = a;
		$scope.editNews(index - 1);
	}

	$scope.nextNews = function(index)
	{
		if (index >= $scope.depot.news.length - 1) return false;
		//$scope.depot.news[index] = $scope.depot.news.splice(index+1, 1, $scope.depot.news[index])[0];
		var a = angular.copy($scope.depot.news[index]);var b = angular.copy($scope.depot.news[index + 1]);$scope.depot.news[index] = b; $scope.depot.news[index + 1] = a;
		$scope.editNews(index + 1);
	}

	$scope.updateAttachment = function(form) {
		console.log(this);
		console.log(form);
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
		var submit = function(){
			$query.form(jQuery('[name="forms.depot"]')).done(function(json){
				$scope.depot = json.data;
				$uibModalInstance.close();
				$scope.$emit(json.data.isCreated ? 'show' : 'reload', json.data.type);
			}).always(function(){
				$scope.submiting = false;
			});
		}
		if ($scope.type == 'news')
		{
			$scope.saveNews().done(submit).fail(function(){
				$scope.submiting = false;
			});
		} else {
			submit();
		}
	}
	//附件上传或者移除时
	$scope.$on('uploader.uploaded', function(e, scope, elem, file, json, ids){
		if ($scope.type != 'news' && elem.is('[name="aid"]')){
			$scope.depot[$scope.type].title = json.data.filename;
			$scope.depot[$scope.type].size = json.data.size;
			$scope.depot[$scope.type].format = json.data.ext;
			$scope.$apply();
		}
	});
	$scope.$on('uploader.removed', function(e, scope, elem, file, removeId, ids){
		if ($scope.type != 'news' && elem.is('[name="aid"]')){
			$scope.depot[$scope.type].title = '';
			$scope.depot[$scope.type].size = 0;
			$scope.depot[$scope.type].format = '';
			$scope.$apply();
		}
	});

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

});