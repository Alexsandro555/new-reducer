<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('attribute_groups')->insert([
        [
          'title' => 'Техн. характеристики',
          'url_key' => 'tech-characteristics'
        ],
        [
          'title' => 'Размеры',
          'url_key' => 'sizes'
        ]
      ]);
        // $this->call("OthersTableSeeder");
    }
}
