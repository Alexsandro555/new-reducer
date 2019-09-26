<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Alexusmai\Ruslug\Slug;
use Modules\Files\Entities\FileListView;

class ProductImport implements ToModel
{
  public function model(array $row)
  {
    $product = new Product([
      'title' => $row[0],
      'price' => $row[1]=='По запросу'?null:$row[1],
      'need_order' => $row[1]=='По запросу'?1:0,
      'url_key' => \Slug::make(str_replace("/"," ",$row[0])),
      'product_category_id' => request('product_category_id'),
      'active' => 1,
      'type_product_id' => request('type_product_id', null),
      'line_product_id' => request('line_product_id', null),
      'file_list_view_id' => FileListView::where('title', $row[2])->pluck('id')->first()
    ]);
    return $product;
  }
}