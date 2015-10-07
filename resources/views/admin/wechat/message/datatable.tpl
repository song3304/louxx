<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信消息<{/block}>

<{block "name"}>wechat/message<{/block}>

<{block "filter"}>
<{include file="admin/wechat/message/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>公众号</th>
<th>用户</th>
<th>传送</th>
<th>类型</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'account', orderable: false, 'render': function(data, type, full){
		return data.name + '(' + data.account + ')';
	}},
	{'data': 'user', orderable: false, 'render': function(data, type, full){
		return data.nickname + '(' + data.openid + ')';
	}},
	{'data': 'transport_type', orderable: false, 'render': function(data, type, full){
		return data == 'send' ? '发送 <i class="fa fa-send text-danger"></i>' : '<i class="fa fa-share text-success"></i> 接收';
	}},
	{'data': 'type', orderable: false, 'render': function(data, type, full){
		return '<span class="label label-info">'+data+'</span>';
	}}
];
<{/block}>

<{block "datatable-columns-options"}>
var columns_options = [{'data': null, orderable: false, 'render': function (data, type, full){
	return '<div class="btn-group">\
		<a href="<{'admin'|url}>/<{block "name"}><{/block}>/'+full['id']+'/reply" data-toggle="tooltip" title="回复" class="btn btn-xs btn-success"><i class="fa fa-reply"></i> 回复</a>'
		+'<a href="<{'admin'|url}>/<{block "name"}><{/block}>/'+full['id']+'" method="delete" confirm="您确定删除此条消息？此操作并不会在微信中删除！" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div>';
	}
}];
<{/block}>

<{block "datatable-onCreateRow"}>
var onCreateRow = function(row, data, dataIndex){
	var html = '';
	switch(data.type)
	{
		case 'text':
			html = data.text ? '<b>文本：</b>' + data.text.content : '';
			break;
		case 'image':
			html = data.image ? '<b>图片：</b> <img src="<{'attachment'|url}>?id='+data.image.aid+'" />' : '';
			break;
		case 'voice':
			html = data.voice ? '<b>音频：</b> <audio src="<{'attachment'|url}>?id='+data.voice.aid+'" controls="controls"></audio>' : '';
			break;
		case 'video':
			html = data.video ? '<b>视频：</b> <video src="<{'attachment'|url}>?id='+data.video.aid+'" controls="controls"></video>' : '';
			break;
		case 'location':
			html = data.location ? '<b>坐标：</b>' + data.location.x + ', ' + data.location.y + '<br />' + data.location.label : '';
			break;
		case 'link':
			html = data.link ? '<b>链接：</b> <a href="'+ data.link.url +'">' + data.link.title + '</a>' + '<br />' + data.link.description : '';
			break;
	}
	$.datatable_config.datatable.row(row).child('<tr><td colspan="7" style="padding:20px 80px;">'+ html +'</td></tr>').show();
};
<{/block}>

