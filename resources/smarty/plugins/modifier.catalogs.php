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
 * Name:     url<br>
 * Purpose:  get the absolute URL
 *
 * @author   Fly <fly@load-page.com>
 * @param string
 * @param boolean
 * @return string
 */
use App\Catalog;
function smarty_modifier_catalogs($name)
{
	return Catalog::getCatalogsByName($name);
}
