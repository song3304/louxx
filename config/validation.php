<?php

return [
	'role' => [
		'store' => [
			'name' => [
				'name' => '组名',
				'rules' => 'required|regex:/[\w\d_\-]*/iu|min:1|unique:roles,{{attribute}},{{id}}',
			],
			'display_name' => [
				'name' => '显示名称',
				'rules' => 'required|string|min:1',
			],
			'description' => [
				'name' => '简介',
				'rules' => [],
			],
			'url' => [
				'name' => '后台路由',
				'rules' => [],
			],
			'perms' => [
				'name' => '权限',
				'rules' => 'array',
			],
		],
		'destroy' => [
			'original_role_id' => [
				'name' => '待删除的组',
				'rules' => 'required|numeric|not_zero',
			],
			'role_id' => [
				'name' => '待转移的组',
				'rules' => 'required|numeric|not_zero|different:original_role_id',
			],
		],
	],
	'permission' => [
		'store' => [
			'name' => [
				'name' => '组名',
				'rules' => 'required|regex:/[\w\d_\-\.]*/iu|min:1|unique:permissions,{{attribute}},{{id}}',
			],
			'display_name' => [
				'name' => '显示名称',
				'rules' => 'required|string|min:1',
			],
			'description' => [
				'name' => '简介',
				'rules' => [],
			],
		],
	],
	'member' => [
		'store' => [
			'username' => [
				'name' => '用户名',
				'rules' => 'required|ansi:2|unique:users,{{attribute}},{{id}}|regex:/^[a-z0-9\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}]*$/iu|max:150|min:3',
				'message' => ['regex' => '用户名必须为汉字、英文、数字'],
			],
			'nickname' => [
				'name' => '昵称',
				'rules' => 'string|min:1',
			],
			'realname' => [
				'name' => '真实姓名',
				'rules' => 'ansi:2|regex:/^[a-z\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}\s]*$/iu|max:50|min:3',
				'message' => ['regex' => '姓名必须为汉字、英文'],
			],
			'password' => [
				'name' => '密码',
				'rules' => 'required|min:6|confirmed',
			],
			'password_confirmation ' => [
				'name' => '确认密码',
				'rules' => 'required',
			],
			'gender' => [
				'name' => '性别',
				'rules' => 'required|not_zero|field',
			],
			'phone' => [
				'name' => '手机',
				'rules' => 'phone|unique:users,{{attribute}},{{id}}',
			],
			'idcard' => [
				'name' => '身份证',
				'rules' => 'idcard|unique:users,{{attribute}},{{id}}',
			],
			'email' => [
				'name' => 'E-Mail',
				'rules' => 'email|unique:users,{{attribute}},{{id}}',
			],
			'avatar_aid' => [
				'name' => '用户头像',
				'rules' => 'numeric',
			],
			'role_ids' => [
				'name' => '用户组',
				'rules' => 'required|array',
			],
			'accept_license' => [
				'name' => '阅读并同意协议',
				'rules' => 'accepted',
			]
		],
		'login' => [
			'username' => [
				'name' => '用户名',
				'rules' => 'required',
			],
			'password' => [
				'name' => '密码',
				'rules' => 'required',
			],
		]
	],
];