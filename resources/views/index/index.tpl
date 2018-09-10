<{extends file="extends/main.block.tpl"}>

<{block "body-container"}>

<div id="app">
	<example></example>
	<passport-clients></passport-clients>
</div>
<script src="<{'js/app.js'|static nofilter}>"></script>

<{/block}>