<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty URL modifier plugin
 *
 * Type:     modifier<br>
 * Name:     plugins<br>
 * Purpose:  get the absolute URL
 * @link http://smarty.php.net/manual/en/language.modifier.url.php
 *          url (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param mixed
 * @return string
 */
use App\Template;
function smarty_function_template_include($params, $template)
{	
	$dbt=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,10);
	for($i = 1; $i < count($dbt);$i++)
		if ($dbt[$i]['function'] == __FUNCTION__)
		{
			trigger_error("template_include: cannot use under template_include (nested)", E_USER_NOTICE);
			return;
		}

	$name = '';
	foreach ($params as $_key => $_val) {
		switch ($_key) {
			case 'name':

				$$_key = $_val;
			break;
		}
	}

	if (empty($name)) {
		trigger_error("template_include: missing 'name' parameter", E_USER_NOTICE);
		return;
	}

	$scope = [];
	$tpl = Template::findByName($name);
	if (empty($tpl)) return;
	
	$file = base_path('resources/views/templates/').$tpl->name.'.tpl';
	if (!file_exists($file)) file_put_contents($file, $tpl->html);
	switch ($tpl->type) {
		case 'image':
		case 'video':
		case 'flash':
			$scope['_template'] = $tpl->content;
			break;
		case 'multi-image':
			$scope['_templates'] = $tpl->contents;
			break;
	}

	$template->_subTemplateRender('templates/'.$tpl->name.'.tpl', $template->cache_id, $template->compile_id, 0, $template->cache_lifetime, $scope, 0, true);
}

?>
