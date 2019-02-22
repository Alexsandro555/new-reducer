<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Product\Entities\Product;
use Modules\Article\Entities\Article;
use Modules\Product\Entities\ProductCategory;

class SiteController extends Controller
{
  public function index()
  {
    $ourProducts = Product::with('files', 'typeProduct', 'lineProduct')->inRandomOrder()->take(4)->get();
    $specialProducts = Product::with('files', 'typeProduct', 'lineProduct')->where('special', 1)->inRandomOrder()->take(5)->get();
    $news = Article::inRandomOrder()->take(4)->get();
    return view('index', compact('ourProducts', 'specialProducts', 'news'));
  }

  public function catalog($slug)
  {
    $products = Product::with('typeProduct')->with('files')->whereHas('typeProduct', function ($query) use ($slug) {
      $query->where('url_key', $slug);
    })->whereNull('line_product_id')->get();
    $typeProduct = TypeProduct::where('url_key', $slug)->first();
    $id = $typeProduct->id;
    return view('catalog', compact('products', 'typeProduct', 'id'));
  }

  public function menuLeft() {
    return ProductCategory::with(['typeProducts' => function($query) {
      $query->orderBy('sort');
    }, 'typeProducts.lineProducts'])->get();
  }
}
