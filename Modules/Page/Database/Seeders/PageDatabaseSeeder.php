<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('pages')->insert([
          [
            'title' => 'Контактная информация',
            'url_key' => 'contacts',
            'content' => 'Наша компания расположена по адресу'
          ],
          [
            'title' => 'Доставка и оплата',
            'url_key' => 'delivery',
            'content' => 'Наша компания осуществляет доставку...'
          ],
          [
            'title' => 'Оборудование',
            'url_key' => 'equipment',
            'content' => 'Список нашего оборудования'
          ],
          [
            'title' => 'О компании',
            'url_key' => 'about',
            'content' => 'Что можно сказать о нашей компании...'
          ]
        ]);
        // $this->call("OthersTableSeeder");
    }
}
