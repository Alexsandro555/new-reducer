<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\AttributeUnit;

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

      $arrAttributeUnits = [
        ['title' => 'кВт'],
        ['title' => 'об/мин.'],
        ['title' => 'Нм'],
        ['title' => 'H'],
        ['title' => 'кг'],
        ['title' => 'л'],
        ['title' => 'мм'],
        ['title' => '%'],
      ];

      foreach ($arrAttributeUnits as $arrAttributeUnit) {
        AttributeUnit::create(['title' => $arrAttributeUnit['title']]);
      }
    }
}
