@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="true"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content">
    <div class="wrapper content__product-margin">
      <div class="breadcrumbs">
        <div class="wrapper">
          <v-flex xs12 text-xs-left>
            {{ Breadcrumbs::render() }}
          </v-flex>
        </div>
      </div>
      <v-flex xs12 text-xs-left class="top-20 bottom-20">
        <p class="headsite">
          <span>{{$model->title}}</span><br>
        </p>
        <v-layout row wrap>
          @if($model->lineProducts)
            @foreach($model->lineProducts as $lineProduct)
              <v-container>
                <v-layout row wrap>
                  <v-flex xs12 text-xs-center>
                    <v-card height="100px">
                      <a class="line-product-elements" href="/catalog/{{$model->product_category->url_key}}/{{$model->url_key}}/{{$lineProduct->url_key}}">{{$lineProduct->title}}</a>
                    </v-card>
                  </v-flex>
                </v-layout>
              </v-container>
            @endforeach
          @endif
          @include('products',['products' => $products])
        </v-layout>
      </v-flex>
      <div class="content-links">
        {{ $products->links() }}
      </div>
    </div>
  </div>
  <div class="best-sale">
    <div class="wrapper">
    </div>
  </div>
@endsection