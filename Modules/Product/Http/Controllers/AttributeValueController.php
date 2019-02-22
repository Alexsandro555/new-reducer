<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\AttributeValue;

class AttributeValueController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new AttributeValue();
  }

  public function save(Request $request) {
    $request = $request->all();
    foreach($this->model::where('product_id', $request['product_id'])->get() as $attribute) {
      $attribute->delete();
    }
    foreach($request['attributes'] as $attribute) {
      $f=$this->model->firstOrNew(['id' => $attribute['id'], 'product_id' => $attribute['product_id'], 'attribute_id' => $attribute['attribute_id']]);
      $f->fill($attribute);
      $f->save();
    }
    return $this->model->all();
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
