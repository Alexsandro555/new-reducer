<?php

namespace App\Http\Controllers;

use Modules\Product\Entities\Product;

class TestController extends Controller
{
    public function test()
    {
      return view('test')->with('products', Product::where('active', 1)->orderBy('title', 'desc')->take(10)->get());
    }
}
