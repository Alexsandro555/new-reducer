<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\AttributeType;
use Modules\Product\Entities\AttributeListValues;
use Modules\Product\Http\Requests\AttributeRequest;
use Modules\Product\Http\Requests\MultipleAttributeRequest;
use Illuminate\Support\Facades\Log;

class AttributeValueController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new AttributeValue();
  }

  public function index(Request $request)
  {
    return $this->model->all();
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

  private function formatValue($attribute, $value)
  {
    switch ($attribute->attribute_type_id) {
      case AttributeType::BOOLEAN:
        return (boolean)$value;
      case AttributeType::STRING:
        return (string)$value;
      case AttributeType::INTEGER:
        return (integer)$value;
      case AttributeType::DOUBLE:
        return doubleval(str_replace(',','.', $value));
      case AttributeType::TEXT:
        return (string)$value;
      case AttributeType::DECIMAL:
        return floatval($value);
      case AttributeType::LIST:
        $attributeListValue = AttributeListValues::where('title', $value)->where('attribute_id', $attribute->id)->first();
        if(!$attributeListValue) {
          throw new \Modules\Product\Exceptions\NotFoundAttributeListValueException('Аттрибут '.$attribute->title.' не содержит значения с именем: '.$value);
        }
        return AttributeListValues::where('title', $value)->where('attribute_id', $attribute->id)->firstOrFail()->id;
    }
    return null;
  }

  public function saveMultiple(MultipleAttributeRequest $request)
  {
    $values = json_decode($request->values);
    $attributes = Attribute::findOrFail($request->attributeIds);


    foreach($request->productIds as $productId) {
      $row = array_shift($values);
      if(!$row) return AttributeValue::all();

      try {
        foreach($request->attributeIds as $attributeId) {
          $attribute = $attributes->firstWhere('id', $attributeId);
          $cell = array_shift($row);
          if(!$cell) break;
          try {
            $value = $this->formatValue($attribute,trim($cell));
          } catch(\Modules\Product\Exceptions\NotFoundAttributeListValueException $e) {
            Log::error($e->getMessage());
          }
          if($value) {
            $attribute->prod()->attach($productId, ['value' => $value]);
          } else {
            throw new \Modules\Product\Exceptions\FormatAttributeValueException('Неверный формат атрибута '.$attribute->title.' допустимый тип: '.$attribute->attribute_type->title.', передаваемое значение: '.$cell);
          }
        }
      } catch (\Modules\Product\Exceptions\FormatAttributeValueException $e) {
        Log::error($e->getMessage());
      }
    }

    return AttributeValue::all();
  }
}
