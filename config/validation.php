<?php

return [
	'member' => [
		'store' => [
			'username' => [
				'name' => '用户名',
				'rules' => 'required|ansi:2|unique:users,{{attribute}},{{id}}|regex:/^[a-z0-9\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}]*$/iu|max:150|min:3',
				'message' => [
					'regex' => '[:attribute] 必须为汉字、英文、数字',
				],
			],
			'nickname' => [
				'name' => '昵称',
				'rules' => 'string|min:1',
			],
			'realname' => [
				'name' => '真实姓名',
				'rules' => 'ansi:2|regex:/^[a-z\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}\s]*$/iu|max:50|min:3',
				'message' => [
					'regex' => '[:attribute] 必须为汉字、英文'
				],
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
				'rules' => 'required|not_zero|catalog:fields.gender',
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
				'tag_name' => 'role_ids[]',
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
	'tag' => [
		'store' => [
			'keywords' => [
				'name' => '话题',
				'rules' => 'required|max:50',
			],
		],
	],
    'properter' => [
        'store' => [
            'id' => [
                'name' => '指定用户',
                'rules' => 'required|numeric',
            ],
            'name' => [
                'name' => '物业名称',
                'rules' => 'required'
            ],
            'province'=>[
                'name' => '省',
                'rules' => 'required|numeric',
            ],
            'city'=>[
                'name' => '市',
                'rules' => 'required|numeric',
            ],
            'area'=>[
                'name' => '区',
                'rules' => 'required|numeric',
            ],
            'address'=>[
                'name'=>'详细地址',
                'rules' => 'required'
            ],
            'phone'=>[
                'name' => '电话',
                'rules' => 'required|phone',
            ]
         ]
     ],
    'office' => [
        'store' => [
            'id' => [
                'name' => '指定用户',
                'rules' => 'required|numeric',
            ],
            'name' => [
                'name' => '物业名称',
                'rules' => 'required'
            ],
            'province'=>[
                'name' => '省',
                'rules' => 'required|numeric',
            ],
            'city'=>[
                'name' => '市',
                'rules' => 'required|numeric',
            ],
                'area'=>[
                    'name' => '区',
                    'rules' => 'required|numeric',
                ],
                    'address'=>[
                        'name'=>'详细地址',
                        'rules' => 'required'
                    ],
            'phone'=>[
                    'name' => '电话',
                    'rules' => 'required|phone',
            ],
                    'longitude'=>[
                    'name'=>'经度',
                    'rules' => 'required|numeric'
            ],
                    'latitude'=>[
                    'name' => '纬度',
                    'rules' => 'required|numeric',
                ],
                        'status' => [
                        'name' => '状态',
                        'rules' => 'required|bool'
             ]
                    ]
         ],
];