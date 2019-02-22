<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('type_products')->insert([
          [
            'title' => 'Классическая серия EVM',
            'url_key' => 'classic-series-evm',
            'tnved_id' => 1
          ],
          [
              'title' => 'Однофазные вибраторы EVM-M',
              'url_key' => 'odnofaznie-vibratory-evm-m',
              'tnved_id' => 1
          ],
          [
            'title' => 'Микровибраторы MV2',
            'url_key' => 'microvibrators-mv2',
            'tnved_id' => 1
          ],
          [
            'title' => 'Вибраторы постоянного тока EVM-DC',
            'url_key' => 'vibrators-postoiannogo-toka-evm-dc',
            'tnved_id' => 1
          ],
          [
              'title' => '10-полюсные вибраторы EVM-D',
              'url_key' => '10-polusnie-vibratory-evm-d',
              'tnved_id' => 1
          ]
        ]);
        // $this->call("OthersTableSeeder");
    }
}
