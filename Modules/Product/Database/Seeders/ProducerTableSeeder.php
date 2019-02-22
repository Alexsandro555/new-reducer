<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProducerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('producers')->insert([
        [
          'title' => 'kem-p',
          'url_key' => 'kem-p'
        ]
      ]);
        // $this->call("OthersTableSeeder");
    }
}
