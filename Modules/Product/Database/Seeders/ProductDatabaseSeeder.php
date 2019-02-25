<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Database\Seeders\CategoryTableSeeder;
use Modules\Product\Entities\AttributeUnit;
use EloquentPopulator\Populator;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeGroup;
use Modules\Product\Entities\AttributeType;
use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\Producer;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\Tnved;
use Modules\Product\Entities\TypeProduct;

class ProductDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Populator $populator) {
    Model::unguard();

    //$this->call(AttributeTypeTableSeeder::class);

    $populator->add(ProductCategory::class,4)
              ->add(Tnved::class, 2)
              ->add(TypeProduct::class, 4)
              ->add(LineProduct::class, 5)
              ->add(Producer::class, 2)
              ->add(AttributeUnit::class, 10)
              ->add(AttributeGroup::class, 2)
              ->add(AttributeType::class, 10)
              ->add(Attribute::class, 15)
              ->add(Product::class, 30)
              ->seed();
    /*$populator->add(ProductCategory::class,10)
              ->add(Tnved::class, 10)
              ->add(TypeProduct::class, 10)
              ->add(LineProduct::class, 10)
              ->add(Producer::class, 2)
              ->add(AttributeUnit::class, 10)
              ->add(AttributeGroup::class, 2)
              ->add(AttributeType::class, 3);*/
    /*$this->call(TnvedTableSeeder::class);
    $this->call(ProductCategoryTableSeeder::class);
    $this->call(TypeProductTableSeeder::class);
    $this->call(LineProductTableSeeder::class);
    $this->call(ProducerTableSeeder::class);
    $this->call(AttributeUnitTableSeeder::class);
    $this->call(AttributeGroupTableSeeder::class);
    $this->call(AttributeTableSeeder::class);*/
  }
}
