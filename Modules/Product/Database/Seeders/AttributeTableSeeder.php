<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Attribute;

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

      $arrAttributes = [
        ['title' => 'Мощьность (P)', 'attribute_type_id' => 4, 'attribute_group_id' => 1],
        ['title' => 'Номинальная частота вращения', 'attribute_type_id' => 3, 'attribute_group_id' => 1],
        ['title' => 'КПД', 'attribute_type_id' => 4, 'attribute_group_id' => 1],
        ['title' => 'COS ф', 'attribute_type_id' => 4, 'attribute_group_id' => 1],
        ['title' => '1п/1н', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Мп/Мн', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Мтах/Мн', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => '1н А (U=380B)', 'attribute_type_id' => 4, 'attribute_group_id' => 1],
        ['title' => 'Масса', 'attribute_type_id' => 4, 'attribute_group_id' => 1],
        ['title' => 'Материал корпуса', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Частота вращения', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'L', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'HD', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'AC', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'C', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'F', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'G', 'attribute_type_id' => 4, 'attribute_group_id' => 6],
        ['title' => 'D', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'DH', 'attribute_type_id' => 2, 'attribute_group_id' => 6],
        ['title' => 'GD', 'attribute_type_id' => 4, 'attribute_group_id' => 6],
        ['title' => 'AB', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'K', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'BB', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'P', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'N', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'T', 'attribute_type_id' => 4, 'attribute_group_id' => 6],
        ['title' => 'M', 'attribute_type_id' => 3, 'attribute_group_id' => 6],
        ['title' => 'S', 'attribute_type_id' => 2, 'attribute_group_id' => 6]
      ];

      foreach ($arrAttributes as $arrAttribute) {
        Attribute::create($arrAttribute);
      }
    }
}
