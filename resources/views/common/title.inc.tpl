<title><{foreach $_site.titles as $v}><{if !$v@first}> - <{/if}><{$v.title}><{/foreach}></title>
<meta name="csrf-token" content="<{csrf_token()}>">