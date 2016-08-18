<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Addons\Core\Controllers\AdminTrait;

use App\Tag;
class TagController extends Controller
{
	use AdminTrait;

	public function data(Request $request)
	{
		$tag = new Tag;
		$builder = $tag->newQuery();
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	
}
