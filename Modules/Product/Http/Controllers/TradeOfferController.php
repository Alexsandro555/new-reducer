<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Sku;
use Modules\Product\Entities\Product;

class TradeOfferController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Sku[]
     */
    public function index()
    {
        return Sku::with('attributes')->get();
    }


    public function create(Request $request)
    {
      $product = Product::findOrFail($request->product_id);
      $sku = $product->skus()->create($request->except(['product_id', 'attr']));
      foreach($request->attr as $key => $attribute) {
        $sku->attr()->attach($key, ['attribute_list_value_id' => $attribute]);
      }
      return Sku::with('attr')->find($sku->id);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
