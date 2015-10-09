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

<{block "head-styles-plus"}>
<style>
	.media {border: 1px #ccc solid;padding: 10px;}
	.media .media-body .media-heading {font-weight: bold;}
	.media .media-body .media-heading small {font-weight: normal; font-size: 0.6em}
	.media .media-body .media-heading .time {font-weight: normal; font-size: 0.5em;color: gray;margin-left:30px;}
	.media .media-body p {padding: 10px; word-break: break-all; word-wrap: break-word; }
</style>
<{/block}>

<{block "head-scripts-plus"}>
<{include file="common/uploader.inc.tpl"}>
<script>
(function($){
$().ready(function(){
	$('a[method]').query();
});
})(jQuery);
</script>
<{/block}>


<{block "block-content-table"}>
<{foreach $_table_data as $item}>
<div class="media alert">
	<{if $item->transport_type == 'receive'}>
	<a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->id}>" method="delete" confirm="您确定删除此条消息？此操作并不会在微信中删除！" data-toggle="tooltip" title="删除" class="text-danger close"><span aria-hidden="true">&times;</span></a>
	<div class="media-left">
		<a href="<{'admin/wechat/user'|url}>/<{$item->user->getKey()}>" target="_blank">
			<img class="media-object" src="<{'attachment'|url}>?id=<{$item.user.avatar_aid}>" alt="" style="width:120px; height:120px;">
		</a>
	</div>
	<{/if}>
	<div class="media-body">
		<h4 class="media-heading page-header">
		<{if $item->transport_type == 'receive'}> <i class="fa fa-send text-info"></i> <{else}> <i class="fa fa-share text-success"></i> <{/if}>
		<{$item->user->nickname}> <small>(<{$item->user->openid}>)</small>
		<i class="time"><{$item->created_at}></i>
		</h4>
		<p>
		<{if $item->type == 'text'}> <{$item->text->content|escape|nl2br nofilter}>
		<{else if $item->type == 'image'}> <a href="<{'attachment'|url}>?id=<{$item->media->aid}>" target="_blank"><img src="<{'attachment'|url}>?id=<{$item->media->aid}>" alt="" onload="resizeImg(this, 320, 200);"></a>
		<{else if $item->type == 'voice'}> <audio src="<{'attachment'|url}>?id=<{$item->media->aid}>" controls="controls"></audio> <a href="<{'attachment/download'|url}>?id=<{$item->media->aid}>" target="_blank">下载</a>
		<{else if $item->type == 'video' || $item->type == 'shortvideo'}> <video src="<{'attachment'|url}>?id=<{$item->media->aid}>" controls="controls" style="max-width:320px;max-height:240px;"></video> <a href="<{'attachment/download'|url}>?id=<{$item->media->aid}>" target="_blank">下载</a>
		<{else if $item->type == 'location'}> <{$item->location->x}>, <{$item->location->y}> <a href="">查看地图</a><br /><{$item->location->label}>
		<{else if $item->type == 'link'}> <a href="<{$item->link->url}>" target="_blank"><{$item->link->title}></a> <br /><{$item->link->description}> 
		<{/if}>
		</p>
		<{if $item->transport_type == 'receive'}><span class="pull-right"><a href="<{'admin'|url}>/<{block "name"}><{/block}>/<{$item->getKey()}>" data-nickname="<{$item->user->nickname}> (<{$item->user->openid}>)" name="reply" data-toggle="tooltip" title="回复" class="btn btn-xs btn-success"><i class="fa fa-reply"></i> 回复</a></span><{/if}>
	</div>
	<{if $item->transport_type == 'send'}>
	<div class="media-right">
		<a href="<{'admin/wechat/user'|url}>/<{$item->user->getKey()}>" target="_blank">
			<img class="media-object" src="<{'attachment'|url}>?id=<{$item.user.avatar_aid}>" alt="" style="width:120px; height:120px;">
		</a>
	</div>
	<{/if}>
	<div class="clearfix"></div>
</div>
<{/foreach}>
<div class="row">
	<div class="col-sm-5 hidden-xs">
		<span><{$_table_data->firstItem()}> - <{$_table_data->lastItem()}> / <{$_table_data->total()}></span>
	</div>
	<div class="col-sm-7 col-xs-12 clearfix"><{$_table_data->render() nofilter}></div>
</div>

<{include file="admin/wechat/message/reply.inc.tpl"}>
<{/block}>