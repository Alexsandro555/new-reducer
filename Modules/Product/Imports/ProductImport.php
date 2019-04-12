<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Alexusmai\Ruslug\Slug;
use Illuminate\Support\Facades\Storage;
use Modules\Files\Classes\ImageHandler;
use Modules\Product\Entities\TypeProduct;

class ProductImport implements ToModel
{
  public function model(array $row)
  {
    /*$product = new Product([
      'title' => $row[0],
      'price' => $row[1],
      'url_key' => \Slug::make(str_replace("/"," ",$row[0])),
      'product_category_id' => 2,
      'type_product_id' => 1
    ]);*/

    $fileNames = Storage::files('/public/source');
    foreach($fileNames as $fileName) {
      $typeProduct = TypeProduct::where('name', 'image-product')->first();
      $file = Storage::get($fileName);
      $fileHandler = new ImageHandler();
      $fileHandler->upload($file, $typeProduct->config);
    }
    return $product;
  }
}