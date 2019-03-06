<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;

class FindController extends Controller
{
  public function index($text='')
  {
    $text = str_replace("_", "/", $text);
    $products = Product::whereRaw("MATCH (title,description) AGAINST ('\"".$text."\"' IN BOOLEAN MODE) OR title LIKE '%".$text."%'")->get();
    return view('find', compact('products', 'text'));
  }
}
