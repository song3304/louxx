<title><{foreach $_site.titles as $v}><{if !$v@first}> - <{/if}><{$v.title}><{/foreach}></title>
<meta name="csrf-token" content="<{csrf_token()}>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">