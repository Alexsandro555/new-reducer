<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\AttributeSkuOption;

class SkuOptionsController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct() {
    $this->model = new AttributeSkuOption;
  }

  public function save(Request $request) {
    /*$arrF = [];
    $options = $request->all();
    foreach($options as $option) {
      $f=$this->model->firstOrNew(['id' => $option['id'], 'sku_id' => $option['sku_id'], 'attribute_id' => $option['attribute_id']]);
      $f->fill($option);
      $f->save();
      array_push($arrF, $f);
    }
    return $arrF;*/
    $options = $this->model->where('sku_id', $request->id)->get();
    foreach($options as $option) {
      $option->delete();
    }
    foreach($request->options as $option) {
      $this->model::create($option);
    }
    return $this->model->all();
  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show()
  {
    return view('product::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('product::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy()
  {
  }
}
