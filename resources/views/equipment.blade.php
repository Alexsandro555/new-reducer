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
          <span>Наша продукция</span><br>
        </p>
        <v-layout row wrap>
          @include('products',['products' => $products])
        </v-layout>
      </v-flex>
    </div>
  </div>
@endsection