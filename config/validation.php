<?php

return [
	'role' => [
		'store' => [
			'name' => [
				'name' => '组名',
				'rules' => 'required|regexp:/[\w\d_\-]/|min:1|unique:roles,{{ATTRIBUTE}},{{ID}}',
			],
			'display_name' => [
				'name' => '显示名称',
				'rules' => 'required|string|min:1',
			],
			'description' => [
				'name' => '简介',
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
				'rules' => 'required|regexp:/[\w\d_\-\.]/|min:1|unique:permissions,{{ATTRIBUTE}},{{ID}}',
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
				'rules' => 'required|ansi:2|unique:users,{{ATTRIBUTE}},{{ID}}|regex:/^[a-z0-9\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}]*$/iu|max:150|min:3',
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
				'rules' => 'phone',
			],
			'email' => [
				'name' => '手机',
				'rules' => 'email',
			],
			'avatar_aid' => [
				'name' => '用户头像',
				'rules' => 'numeric',
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
	'wechat-account' => [
		'store' => [
			'name' => [
				'name' => '微信名称',
				'rules' => 'required',
			],
			'description' => [
				'name' => '简介',
				'rules' => [],
			],
			'wechat_type' => [
				'name' => '类型',
				'rules' => 'required|not_zero|field',
			],
			'appid' => [
				'name' => 'APP ID',
				'rules' => 'required|min:10|unique:wechat_accounts,{{ATTRIBUTE}},{{ID}}',
			],
			'account' => [
				'name' => '原始 ID',
				'rules' => 'required|min:10|unique:wechat_accounts,{{ATTRIBUTE}},{{ID}}',
			],
			'appsecret' => [
				'name' => 'APP Secrect',
				'rules' => 'required|min:10',
			],
			'token' => [
				'name' => 'Token',
				'rules' => 'required|min:1',
			],
			'avatar_aid' => [
				'name' => '二维码',
				'rules' => 'numeric',
			],
			'encodingaeskey' => [
				'name' => '加密KEY',
				'rules' => 'min:10',
			],
		],
	],
	'wechat-message' => [
		'store' => [
			'content' => [
				'name' => '内容',
				'rules' => 'required|max:600|min:1',
			],
			'type' => [
				'name' => '类型',
				'rules' => 'required|not_zero|field_name:wechat_message_type',
			],
		],
	],
	'wechat-user' => [
		'store' => [
			'openid' => [
				'name' => 'OPEN ID',
				'rules' => 'required|min:6',
			],
			'nickname' => [
				'name' => '昵称',
				'rules' => 'min:1',
			],
			'gender' => [
				'name' => '性别',
				'rules' => 'field',
			],
			'avatar_aid' => [
				'name' => '头像AID',
				'rules' => 'numeric',
			],
			'country' => [
				'name' => '国家',
				'rules' => [],
			],
			'province' => [
				'name' => '省份',
				'rules' => [],
			],
			'city' => [
				'name' => '城市',
				'rules' => [],
			],
			'language' => [
				'name' => '语言',
				'rules' => [],
			],
			'unionid' => [
				'name' => '唯一ID',
				'rules' => [],
			],
			'remark' => [
				'name' => '备注名',
				'rules' => [],
			],
			'groupid' => [
				'name' => '组ID',
				'rules' => [],
			],
			'is_subscribed' => [
				'name' => '已关注',
				'rules' => 'boolean',
			],
			'subscribed_at' => [
				'name' => '关注时间',
				'rules' => 'date',
			],
			'uid' => [
				'name' => 'UID',
				'rules' => [],
			],
		],
	],

];