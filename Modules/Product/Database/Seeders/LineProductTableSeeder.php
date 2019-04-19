<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\LineProduct;

class LineProductTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $arrLineProducts = [
      ['title' => 'NMRV', 'type_product_id' => 1],
    ];

    foreach ($arrLineProducts as $arrLineProduct) {
      LineProduct::create(['title' => $arrLineProduct['title'],  'type_product_id' => $arrLineProduct['type_product_id']]);
    }
  }
}
