<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Initializer\Traits\DefaultTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Imports\ProductImport;
use Modules\Product\Http\Requests\ProductImportRequest;


class ProductController extends Controller
{
  Use ControllerTrait, DefaultTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Product;
  }

  public function import(ProductImportRequest $request)
  {
      Excel::import(new ProductImport, $request->file('file'));
      return [];
  }
}
