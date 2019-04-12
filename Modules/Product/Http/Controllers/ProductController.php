<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Initializer\Traits\DefaultTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Imports\ProductImport;

class ProductController extends Controller
{
  Use ControllerTrait, DefaultTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Product;
  }

  public function import(Request $request)
  {
    if($request->hasFile('file')) {
      Excel::import(new ProductImport, $request->file('file'));
      return [];
    }
  }
}
