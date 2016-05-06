<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="<{'static/js/excanvas.min.js'|url}>"></script><![endif]-->

<!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
<{block "head-scripts-debug"}>
<script src="<{'static/js/debug/eruda.debug.js'|url}>"></script>
<{/block}>
<{block "head-scripts-jquery"}>
<script src="<{'static/js/jquery-2.1.0.min.js'|url}>"></script>
<script>jQuery.noConflict();</script>
<{/block}>
<{block "head-scripts-bootstrap"}>
<script src="<{'static/js/bootstrap3/bootstrap.min.js'|url}>"></script>
<{/block}>
<{block "head-scripts-noty"}>
<script src="<{'static/js/noty/jquery.noty.packaged.min.js'|url}>"></script>
<script src="<{'static/js/noty/themes/default.js'|url}>"></script>
<script src="<{'static/js/common/noty.js'|url}>"></script>
<{/block}>

<{block "head-scripts-inner"}><{/block}>

<{block "head-scripts-common"}>
<script src="<{'static/js/common.js'|url}>"></script>
<{/block}>
<{block name="head-scripts-select2"}>
<link rel="stylesheet" href="<{'static/js/select2.4/select2.min.css'|url}>"></script>
<script src="<{'static/js/select2.4/select2.min.js'|url}>"></script>
<script src="<{'static/js/select2.4/i18n/zh-CN.js'|url}>"></script>
<script src="<{'static/js/laravel.select.js'|url}>"></script>
<{/block}>
<{block "head-scripts-app"}>
<script src="<{'static/js/proui/app.js'|url}>"></script>
<{/block}>
<script>
(function($){
	//Theme auto
	var cookie_theme = $.cookie('proui-theme');
	if (cookie_theme)  $('<link id="theme-link" rel="stylesheet" href="' + cookie_theme + '">').appendTo('head');
})(jQuery);
</script>