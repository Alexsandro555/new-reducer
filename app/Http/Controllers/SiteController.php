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
    }])->inRandomOrder()->take(4)->get();
    $specialProducts = Product::with('files', 'typeProduct', 'lineProduct')->where('special', 1)->inRandomOrder()->take(5)->get();
    $news = [];
    $news = News::inRandomOrder()->take(4)->get();
    return view('index', compact('ourProducts', 'specialProducts', 'news'));
  }

  public function catalog($slug)
  {
    $model = ProductCategory::where('url_key', $slug)->firstOrFail();
    $products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('product_category_id', $model->id)->paginate(30);
    return view('catalog', compact('model', 'products'));
  }

  public function lineProduct($slugProductCategory, $slug)
  {
    $model = TypeProduct::with('products.files')->where('url_key', $slug)->firstOrFail();
    $products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('type_product_id', $model->id)->paginate(30);
    return view('catalog', compact('model', 'products'));
  }

  public function menuLeft() {
    return ProductCategory::with(['typeProducts' => function($query) {
      $query->where('active',1)->orderBy('sort');
    }])->where('active',1)->get();
  }

  public function detail($slug) {
    $groups = AttributeGroup::orderBy('sort', 'asc')->get();
    $product = Product::with('files')->where('url_key',$slug)->first();
    return view('detail', compact('product', 'groups'));
  }
}
