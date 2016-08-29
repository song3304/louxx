<?php

return [

	'title' => '网站标题',
	'title_reverse' => true, //显示标题时，FALSE顺序为：主标题 - 子标题 - 子标题，设置为TRUE，则表示反转显示
	'pagesize' => [
		'common' => 25,
		'export' => 500,
		'admin' => [
			'permissions' => 50,
			'users' => 25,
			'wechat_depots' => 5,
			'wechat-users' => 50,
			'wechat-messages' => 50,
		], 
	],
];
