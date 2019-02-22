<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
      DB::table('line_products')->insert([
        [
          'title' => '300 оборотов/мин. 2-полюсные',
          'url_key' => '300-oborotorv-min-2-polusnie',
          'type_product_id' => 1
        ],
        [
          'title' => '1000 оборотов/мин. 6-полюсные',
          'url_key' => '1000-oborotov-min-6-polusnie',
          'type_product_id' => 1
        ],
        [
          'title' => '750 оборотов/мин. 8-полюсные',
          'url_key' => '750-oborotov-min-8-polusnie',
          'type_product_id' => 1
        ],
        [
          'title' => '1500 оборотов/мин. 4-полюсные',
          'url_key' => '1500-oborotov-min-4-polusnie',
          'type_product_id' => 1
        ]
      ]);
        // $this->call("OthersTableSeeder");
    }
}
