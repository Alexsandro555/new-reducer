<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Product\Entities\Product;
//use Modules\Article\Entities\Article;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;
use Modules\Product\Entities\LineProduct;
use Modules\News\Entities\News;
use Modules\Product\Entities\AttributeGroup;
use Modules\Product\Entities\Attribute;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SiteController extends Controller
{
  public function index()
  {
    $ourProducts = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('onsale',1)->where('active',1)->inRandomOrder()->take(4)->get();
    $specialProducts = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('special',1)->where('active',1)->inRandomOrder()->take(5)->get();
    $news = [];
    $news = News::inRandomOrder()->take(4)->get();
    return view('index', compact('ourProducts', 'specialProducts', 'news'));
  }

  public function catalog($slug)
  {
    $model = ProductCategory::with(['typeProducts' => function ($query) {
      $query->where('active', 1);
    }])->where('url_key', $slug)->first();
    /*$products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('product_category_id', $model->id)->where('active',1)->paginate(30);*/
    return view('catalog', compact('model'));
  }

  public function typeProduct($slugProductCategory, $slug)
  {
    $model = TypeProduct::with(['lineProducts' => function($query) {
      $query->where('active',1);
    }])->where('url_key', $slug)->first();

    /*$products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('type_product_id', $model->id)->paginate(30);*/
    return view('catalog', compact('model'));
  }

  public function lineProduct($slugProductCategory, $slugTypeProduct, $slug)
  {
    $model = LineProduct::where('url_key', $slug)->firstOrFail();

    $products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    },'attributes' => function($query) {
      $query->where('filtered',1)->where('attribute_type_id', 8)->where('active',1);
    }])->where('line_product_id', $model->id)->where('active',1)->get();


    $attributes = Attribute::with(['attributeListValue'])->whereHas('lineProducts', function($query) use (&$model) {
      $query->where(['id' => $model->id]);
    })->orWhereHas('typeProducts', function($query) use (&$model) {
      $query->where(['id' => $model->type_product->id]);
    })->orWhereHas('productCategories', function($query) use (&$model) {
      $query->where(['id' => $model->type_product->product_category->id]);
    })->orderBy('sort','asc')->get();

    /*$attributes = $model->type_product->product_category->attributes->where('filtered',1)->where('attribute_type_id', 8)->where('active',1);
    $attributes = $attributes->concat($model->type_product->attributes->where('filtered',1)->where('attribute_type_id', 8)->where('active',1));
    $attributes = $attributes->concat($model->attributes->where('filtered',1)->where('attribute_type_id', 8)->where('active',1));*/
    return view('lineProduct', compact('model','products', 'attributes'));
  }

  public function equipment()
  {
    $products = Product::andFiles()->with(['attributes' => function($query) {
      $query->where('filtered',1)->where('active',1);
    }])->where('special', 1)->where('active',1)->get();
    return view('equipment',compact('products'));
  }

  public function menuLeft()
  {
    return ProductCategory::with(['typeProducts' => function($query) {
      $query->where('active',1)->orderBy('sort');
    }, 'typeProducts.lineProducts' => function($query) {
      $query->where('active',1)->orderBy('sort');
    }])->where('active',1)->orderBy('sort')->get();
  }

  public function detail($slug)
  {
    $groups = AttributeGroup::where('active', 1)->orderBy('sort', 'asc')->get();
    $product = Product::with(['files', 'attributes.attributeListValue'])->where('url_key',$slug)->first();
    return view('detail', compact('product', 'groups'));
  }

  public function products()
  {
    $products = Product::with(['attributes' => function($query) {
      $query->where('attribute_type_id', 8);
    },'files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('product_category_id', 2)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->get();
    return view('test', compact('products', 'attributes'));
  }

  public function sale() {
    $products = Product::with(['attributes','files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('onsale', 1)->get();
    $header = 'Наша продукция';
    return view('sale', compact('products', 'header'));
  }

  public function special() {
    $products = Product::with(['attributes','files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('special', 1)->get();
    $header = 'Лучшие продажи';
    return view('sale', compact('products', 'header'));
  }


  public function filter(Request $request, $lineProductId) {
    $query = Product::query();
    $query = $query->where('line_product_id', $lineProductId);
    $query->with(
      [
        'files',
        'lineProduct.files' => function($query) {
          $query->doesntHave('figure');
        },
        'typeProduct.files' => function($query) {
          $query->doesntHave('figure');
        },
        'productCategory.files' => function($query) {
          $query->doesntHave('figure');
        },
        'attributes' => function($query) {
          $query->with(['attribute_unit','attributeListValue', 'attribute_type']);
        }
      ]
    );
    foreach($request->except('sortBy') as $attributeId => $optionsIds) {
        $query->whereHas('attributeValues', function($q) use ($attributeId, $optionsIds) {
          $q->where('attribute_id', str_replace('param_id','',$attributeId))->whereIn('list_value', $optionsIds);
        });
    }
    $sortyBy = explode("|",$request->sortBy);
    $products = $query->where('active',1)->orderBy($sortyBy[0],$sortyBy[1])->get();

    foreach($products as $product) {
      $product->attributes->each(function($attribute) {
        if($attribute->attribute_type->title == 'Списковый') {
          $value = $attribute->pivot->list_value;
          $attribute->attribute_list_value->forEach(function($list) use($value) {
            if($list == $value) $list->disabled=false;
          });
        }
      });
    }

    dd($products);
    return [];
  }
}
