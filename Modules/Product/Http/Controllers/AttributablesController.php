<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\Attributable;
use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;

class AttributablesController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct() {
    $this->model = new Attributable;
  }

  public function save(Request $request) {
    if($request->line_product_id) {
      foreach ($request->selectedRemainAttr as $attribute_id) {
        $this->model->attributable_type = LineProduct::class;
        $this->model->attributable_id = $request->line_product_id;
        $this->model->attribute_id = $attribute_id;
        $this->model->save();
      }
    }
    if($request->type_product_id) {
      foreach ($request->selectedRemainAttr as $attribute_id) {
        $this->model->attributable_type = TypeProduct::class;
        $this->model->attributable_id = $request->type_product_id;
        $this->model->attribute_id = $attribute_id;
        $this->model->save();
      }
    }
    if($request->product_category_id) {
      foreach ($request->selectedRemainAttr as $attribute_id) {
        $this->model->attributable_type = ProductCategory::class;
        $this->model->attributable_id = $request->product_category_id;
        $this->model->attribute_id = $attribute_id;
        $this->model->save();
      }
    }
    return $this->model;
  }
}
