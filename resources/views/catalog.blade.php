@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="true"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="our-products">
    <div class="wrapper content__product-margin">
      <div class="breadcrumbs">
          <v-flex xs12 text-xs-left>
            {{ Breadcrumbs::render() }}
          </v-flex>
      </div>
      <v-flex xs12 text-xs-left class="top-20 bottom-20">
        <p class="headsite">
          <span>{{$model->title}}</span><br>
        </p>
        <v-layout row wrap>
          @if($model->lineProducts)
            @foreach($model->lineProducts as $lineProduct)
              <div class="category-wrapper">
                <div class="category">
                  <div class="category__title">
                    <a class="category-elements" href="/catalog/{{$model->product_category->url_key}}/{{$model->url_key}}/{{$lineProduct->url_key}}">{{$lineProduct->title}}</a>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
            @if($model->typeProducts)
              @foreach($model->typeProducts as $typeProduct)
                <div class="category-wrapper">
                  <div class="category">
                    <div class="category__title">
                      <a class="category-elements" href="/catalog/{{$model->url_key}}/{{$typeProduct->url_key}}">{{$typeProduct->title}}</a>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
        </v-layout>
      </v-flex>
    </div>
  </div>
  <div class="best-sale">
    <div class="wrapper">
    </div>
  </div>
@endsection