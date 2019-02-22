<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('attributes')->insert([
        [
          'title' => 'Вес',
          'url_key' => 'Ves',
          'attribute_type_id' => 4,
          'attribute_unit_id' => 1,
          'attribute_group_id' => 1
        ],
        [
          'title' => 'Вынуждающая сила',
          'url_key' => 'vinugdaushaia-power',
          'attribute_type_id' => 4,
          'attribute_unit_id' => 3,
          'attribute_group_id' => 1
        ],
        [
          'title' => 'Статический момент',
          'url_key' => 'static-moment',
          'attribute_type_id' => 4,
          'attribute_unit_id' => 4,
          'attribute_group_id' => 1
        ],
        [
          'title' => 'Потребляемая мощность',
          'url_key' => 'potreb-power',
          'attribute_type_id' => 4,
          'attribute_unit_id' => 5,
          'attribute_group_id' => 1
        ],
        [
          'title' => 'Номинальный ток',
          'url_key' => 'nominal-tok',
          'attribute_type_id' => 4,
          'attribute_unit_id' => 6,
          'attribute_group_id' => 1
        ],
        [
          'title' => 'Размер A',
          'url_key' => 'razmer-a',
          'attribute_type_id' => 3,
          'attribute_unit_id' => 7,
          'attribute_group_id' => 2
        ],
        [
          'title' => 'Размер B',
          'url_key' => 'razmer-b',
          'attribute_type_id' => 3,
          'attribute_unit_id' => 7,
          'attribute_group_id' => 2
        ],
        [
          'title' => 'Размер C',
          'url_key' => 'razmer-c',
          'attribute_type_id' => 3,
          'attribute_unit_id' => 7,
          'attribute_group_id' => 2
        ],
        [
          'title' => 'Размер D',
          'url_key' => 'razmer-d',
          'attribute_type_id' => 3,
          'attribute_unit_id' => 7,
          'attribute_group_id' => 2
        ],
        [
          'title' => 'Размер E',
          'url_key' => 'razmer-e',
          'attribute_type_id' => 3,
          'attribute_unit_id' => 7,
          'attribute_group_id' => 2
        ],
        [
          'title' => 'Размер F',
          'url_key' => 'razmer-f',
          'attribute_type_id' => 3,
          'attribute_unit_id' => 7,
          'attribute_group_id' => 2
        ],
        [
          'title' => 'Срок годности',
          'url_key' => 'sroc-godnosti',
          'attribute_type_id' => 5,
          'attribute_unit_id' => 8,
          'attribute_group_id' => 1
        ],
        [
          'title' => 'Стоимость годового обслуживания',
          'url_key' => 'pay-year-obslugivanie',
          'attribute_type_id' => 7,
          'attribute_unit_id' => 9,
          'attribute_group_id' => 1
        ],
        /*[
          'title' => 'Форсированный',
          'url_key' => 'forcing',
          'attribute_type_id' => 1,
          'attribute_group_id' => 1
        ],*/
      ]);
        // $this->call("OthersTableSeeder");
    }
}
