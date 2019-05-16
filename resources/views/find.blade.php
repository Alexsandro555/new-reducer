@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="false"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content">
    <v-layout row wrap>
      <v-flex xs12 text-xs-left class="top-20 bottom-20">
        @if($products->isNotEmpty())
          <h1>Результаты поиска</h1>
          @include('products',['products' => $products])
        @else
          <h1>По вашему запросу ничего не найдено</h1>
        @endif
      </v-flex>
    </v-layout>
  </div>
@endsection