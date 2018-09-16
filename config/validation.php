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
		],
	    'register' => [
	        'phone' => [
	            'name' => '手机',
				'rules' => 'required|phone',//|unique:users,{{attribute}},{{id}}
	        ],
	        'validate_code' => [
	            'name' => '验证码',
	            'rules' => 'required',
	        ],
	    ]
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
    'properter-apply' => [
        'store' => [
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
           'status' => [
                'name' => '状态',
                'rules' => 'required|bool'
           ],
           'note'=>[
                'name' => '备注',
                'rules' => [],
           ],
           'valide_code' =>[
               'name' => '验证码',
               'rules' => 'required',
           ],
           'audit_note'=>[
                'name' => '审核备注',
                'rules' => [],
           ],
           'uid' => [
               'name' => '指定用户',
               'rules' => 'numeric',
           ],
        ]
    ],
    'building' => [
        'store' => [
            'property_id' => [
                'name' => '所属物业',
                'rules' => 'required|numeric',
            ],
            'village_name' => [
                'name' => '小区名',
                'rules' => 'required'
            ],
            'building_name' => [
                'name' => '办公楼名',
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
            'longitude'=>[
                'name'=>'经度',
                'rules' => 'required|numeric'
            ],
            'latitude'=>[
                'name' => '纬度',
                'rules' => 'required|numeric',
            ],
            'pic_ids' => [
                'name' => '办公楼图片',
                'rules' => 'required|array',
            ],
            'tag_ids' => [
                'name' => '标签',
                'rules' => 'required|array',
            ],
            //办公楼详情
            'occupancy_rate' => [
                'name' => '得房率(0-100)',
                'rules' => 'required|numeric'
            ],
            'owner_type' => [
                'name' => '业主类型(0.大业主+小业主)',
                'rules' => 'numeric'
            ],
            'floor_cnt' => [
                'name' => '楼层数',
                'rules' => 'required|numeric'
            ],
            'level' => [
                'name' => '物业类型 ',
                'rules' => 'numeric'
            ],
            'floor_height' => [
                'name' => '每层净高(m)',
                'rules' => 'required'
            ],
            'property_price' => [
                'name' => '物业费(平方/月)',
                'rules' => 'required'
            ],
            'property_type' => [
                'name' => '物业类型',
                'rules' => 'required'
            ],
            'developer' => [
                'name' => '开发商',
                'rules' => 'required'
            ],
            'avg_price' => [
                'name' => '均价 元/平方 天',
                'rules' => 'required'
            ],
            'parking_space_cnt' => [
                'name' => '停车位',
                'rules' => 'required|numeric'
            ],
            'parking_price' => [
                'name' => '停车费 元/月',
                'rules' => 'required'
            ],
            'publish_time' => [
                'name' => '竣工时间',
                'rules' => 'required|date'
            ],
            'area_covered' => [
                'name' => '占地面积',
                'rules' => 'required'
            ],
            'standard_area' => [
                'name' => '标准层面积',
                'rules' => 'required'
            ],
            'upstairs_cnt' => [
                'name' => '楼上层数',
                'rules' => 'numeric'
            ],
            'downstairs_cnt' => [
                'name' => '楼下层数',
                'rules' => 'numeric'
            ],
            'plot_ratio' => [
                'name' => '容积率',
                'rules' => 'required'
            ],
            'green_ratio' => [
                'name' => '绿化率',
                'rules' => 'required'
            ]
        ]
     ],
    'floor' => [
        'store' => [
            'oid' => [
                'name' => '所属办公楼',
                'rules' => 'required|numeric',
            ],
            'name' => [
                'name' => '楼层名',
                'rules' => 'required'
            ],
            'description'=>[
                'name'=>'楼层描述',
                'rules' => 'required'
            ],
            'porder' => [
                'name' => '排序',
                'rules' => 'required|numeric'
            ]
         ]
     ],
    'company' => [
        'store' => [
            'oid' => [
                'name' => '所属办公楼',
                'rules' => 'required|numeric',
            ],
            'name' => [
                'name' => '公司名',
                'rules' => 'required'
            ],
            'logo_id' => [
                'name' => '公司logo',
                'rules' => 'required|numeric',
            ],
            'description'=>[
                'name'=>'楼层描述',
                'rules' => 'required'
            ],
            'people_cnt' => [
                'name' => '人数',
                'rules' => 'required|numeric'
            ],
            'fids' => [
                'name' => '楼层',
                'rules' => 'required|array',
            ],
            'tag_ids' => [
                'name' => '标签',
                'rules' => 'required|array',
            ],
         ]
    ],
    'tag' => [
        'store' => [
            'type' => [
                'name' => '类型',
                'rules' => 'required|numeric',
            ],
            'tag_name' => [
                'name' => '标签名',
                'rules' => 'required'
            ]
         ]
     ],
    'article' => [
        'store' => [
            'title' => [
                'name' => '标题',
                'rules' => 'required'
            ],
            'pic_id' => [
                'name' => '图片',
                'rules' => 'numeric'
            ],
            'contents' => [
                'name' => '内容',
                'rules' => 'required'
            ]
        ]
    ],
    'hire' => [
        'store' => [
            'oid' => [
                'name' => '所属办公楼',
                'rules' => 'required|numeric',
            ],
            'fid' => [
                'name' => '楼层',
                'rules' => 'required|numeric',
            ],
            'rent' => [
                'name' => '租金(元/月)',
                'rules' => 'required|numeric'
            ],
            'per_rent' => [
                'name' => '每平方租金(元/天)',
                'rules' => 'required|numeric',
            ],
            'acreage'=>[
                'name'=>'面积(平方)',
                'rules' => 'required|numeric'
            ],
            'min_station_cnt' => [
                'name' => '最小工位',
                'rules' => 'required|numeric'
            ],
            'max_station_cnt' => [
                'name' => '最大工位',
                'rules' => 'required|numeric',
             ],
            'status' => [
                'name' => '状态',
                'rules' => 'numeric',
            ],
            'note' => [
                'name' => '备注',
                'rules' => [],
            ],
            'pic_ids' => [
                'name' => '租赁图片',
                'rules' => 'required|array',
            ],
        ]
    ],
    'periphery' => [
        'store' => [
            'oid' => [
                'name' => '所属办公楼',
                'rules' => 'required|numeric',
            ],
            'name' => [
                'name' => '场所名',
                'rules' => 'required'
            ],
            'type' => [
                'name' => '类型',
                'rules' => 'required|numeric',
            ],
            'longitude'=>[
                'name'=>'经度',
                'rules' => 'required|numeric'
            ],
            'latitude'=>[
                'name' => '纬度',
                'rules' => 'required|numeric',
            ]
        ]
    ],
    'find-building' => [
        'store' => [
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
            'rent_low'=>[
                'name' => '最低价',
                'rules' => 'numeric',
            ],
            'rent_high'=>[
                'name' => '最高价',
                'rules' => 'required|numeric',
            ],
            'phone'=>[
                'name' => '电话',
                'rules' => 'required|phone',
            ],
            'valid_code'=>[
                'name' => '验证码',
                'rules' => 'required',
            ]
        ]
    ]
];