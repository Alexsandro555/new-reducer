<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\AttributeType;

class AttributeValueController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new AttributeValue();
  }

  public function save(Request $request)
  {
    $request = $request->all();
    foreach ($request['attributes'] as $attribute) {
      $f = $this->model->firstOrNew(['id' => $attribute['id'], 'product_id' => $attribute['product_id'], 'attribute_id' => $attribute['attribute_id']]);
      $f->fill($attribute);
      $f->save();
    }
    return $this->model->all();
  }

  private function checkValue($id, $value)
  {
    switch ($id) {
      case AttributeType::BOOLEAN:
        return (boolean)$value;
      case AttributeType::STRING:
        return (string)$value;
      case AttributeType::INTEGER:
        return (integer)$value;
      case AttributeType::DOUBLE:
        return (double)$value;
      case AttributeType::TEXT:
        return (string)$value;
      case AttributeType::DECIMAL:
        return (double)$value;
      case AttributeType::LIST:
        return AttributeList::where('title', $nextValue)->firstOrFail()->id;
    }
    return null;
  }

  public function saveMultiple(Request $request)
  {
    // Получаем значения
    $values = json_decode($request->values);

    if ($request->direction) {
      $products = Product::findOrFail($request->productIds);
      $nextAttributeValues = current($values);
      if(!$nextAttributeValues) return abort(404);
      foreach($products as $product) {
        $nextValue = current($nextAttributeValues);
        if(!$nextValue) return abort(404);
        $attributes = Attribute::findOrFail($request->attributeIds);
        foreach($attributes as $attribute) {
          $value = $this->checkValue($attribute->attribute_type_id,trim($nextValue));
          if($value) {
            $attribute->prod()->attach($product->id, ['value' => $value]);
          } else {
            return abort(404);
          }
          $nextValue = next($nextAttributeValues);
          if(!$nextValue) break;
        }
        $nextAttributeValues = next($values);
        if(!$nextAttributeValues) break;
      }
    } else {
      // Получаем атрибуты и по атрибутам сохраняем значения - так как атрибуты у нас расположены в строках
      $attributes = Attribute::findOrFail($request->attributeIds);
      $nextAttributeValues = current($values);
      if(!$nextAttributeValues) return abort(404);
      foreach ($attributes as $attribute) {
        $nextValue = current($nextAttributeValues);
        if(!$nextValue) return abort(404);
        foreach($request->productIds as $productId) {
            // проверки на соответствие атрибута типу и приведение
            $value = $this->checkValue($attribute->attribute_type_id,trim($nextValue));
            if($value) {
              $attribute->prod()->attach($productId, ['value' => $value]);
            } else {
              return abort(404);
            }
          $nextValue = next($nextAttributeValues);
          if(!$nextValue) break;
        }
        $nextAttributeValues = next($values);
        if(!$nextAttributeValues) break;
      }
    }
    return AttributeValue::all();
  }
}
