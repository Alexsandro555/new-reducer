<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('attribute_units')->insert([
        [
          'title' => 'кг',
          'url_key' => 'kg'
        ],
        [
          'title' => 'л',
          'url_key' => 'l'
        ],
        [
          'title' => 'kH',
          'url_key' => 'kh'
        ],
        [
          'title' => 'кг/мм',
          'url_key' => 'kg-mm'
        ],
        [
          'title' => 'Вт',
          'url_key' => 'vt'
        ],
        [
          'title' => 'А',
          'url_key' => 'a'
        ],
        [
          'title' => 'мм',
          'url_key' => 'mm'
        ],
        [
          'title' => 'сек.',
          'url_key' => 'sec'
        ],
        [
          'title' => '₽',
          'url_key' => 'rub'
        ]
      ]);
        // $this->call("OthersTableSeeder");
    }
}
