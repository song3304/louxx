<{extends file="admin/extends/list.block.tpl"}>
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

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td><{$item->account->name}>(<{$item->account->account}>)</td>
<td><{$item->user->nickname}>(<{$item->user->openid}>)</td>
<td><{if $item->transport_type == 'send'}> 发送 <i class="fa fa-send text-danger"></i> <{else}> <i class="fa fa-share text-success"></i> 接收 <{/if}></td>
<td> <span class="label label-info"><{$item->type}></span></td>
<{/block}>

<{block "table-tbody-plus"}>
<tr>
	<td colspan="8" style="padding:20px 80px;">
		<{if $item->type == 'text'}> <b>内容：</b> <{$item->text->content}>
		<{else if $item->type == 'image'}> <b>图片：</b> <img src="<{'attachment'|url}>?id=<{$item->image->aid}>" alt="">
		<{else if $item->type == 'voice'}> <b>音频：</b> <audio src="<{'attachment'|url}>?id=<{$item->voice->aid}>" controls="controls"></audio>
		<{else if $item->type == 'voice'}> <b>视频：</b> <video src="<{'attachment'|url}>?id=<{$item->video->aid}>" controls="controls"></video>
		<{else if $item->type == 'location'}> <b>坐标：</b> <{$item->location->x}>, <{$item->location->y}> <br /><{$item->location->label}>
		<{else if $item->type == 'link'}> <b>链接：</b> <a href="<{$item->link->url}>" target="_blank"><{$item->link->title}></a> <br /><{$item->link->description}> 
		<{/if}>
	</td>
</tr>
<{/block}>

<{block "table-td-options"}>
<td class="text-center">
	<div class="btn-group">
		<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->user->getKey()}>/reply" data-toggle="tooltip" title="回复" class="btn btn-xs btn-success"><i class="fa fa-reply"></i> 回复</a>
		<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->id}>" method="delete" confirm="您确定删除此条消息？此操作并不会在微信中删除！" data-toggle="tooltip" title="删除" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
	</div>
</td>
<{/block}>
