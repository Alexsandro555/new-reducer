<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Alexusmai\Ruslug\Slug;

class ProductImport implements ToModel
{
  public function model(array $row)
  {
    $product = new Product([
      'title' => str_replace("-"," ", $row[0]),
      'price' => $row[1],
      'url_key' => \Slug::make(str_replace("/"," ",$row[0])),
      'product_category_id' => 2,
      'type_product_id' => 1
    ]);
    return $product;
  }
}