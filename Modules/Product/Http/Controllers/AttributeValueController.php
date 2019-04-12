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
    $values = $request->values;

    if ($request->direction) {
      $products = Product::findOrFail($request->productIds);
      foreach($products as $product) {
        $nextAttributeValues = next($values);
        foreach($product->attr as $attribute) {
          if(in_array($attribute->id, $request->attributeIds)) {
            $nextValue = next($nextAttributeValues);
            $value = $this->checkValue($attribute->id,trim($nextValue));
            if($value) {
              $product->attr()->attach($attribute->id, ['value' => $value]);
            } else {
              return abort(404);
            }
          }
        }
      }
    } else {
      // Получаем атрибуты и по атрибутам сохраняем значения - так как атрибуты у нас расположены в строках
      $attributes = Attribute::findOrFail($request->attributeIds);
      foreach ($attributes as $attribute) {
        $nextAttributeValues = next($values);
        foreach($attribute->prod as $product) {
          if(in_array($product->id, $request->productIds)) {
            $nextValue = next($nextAttributeValues);
            // проверки на соответствие атрибута типу и приведение
            $value = $this->checkValue($attribute->id,trim($nextValue));
            if($value) {
              $attribute->prod()->attach($product->id, ['value' => $value]);
            } else {
              return abort(404);
            }
          }
        }
      }
    }
    return AttributeValue::all();
  }
}
