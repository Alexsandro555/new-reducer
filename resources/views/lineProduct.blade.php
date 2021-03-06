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
        <v-flex xs12 text-xs-left>
          {{ Breadcrumbs::render() }}
        </v-flex>
      </div>
      <v-flex xs12 text-xs-left class="bottom-20">
        <p class="headsite">
          <span>{{$model->title}}</span><br>
        </p>
        <v-layout row wrap>
          <div class="content__items"><filter-products :line-product-id="{{$model->id}}" :products="{{$products}}" :attributes="{{$attributes}}"/></div>
        </v-layout>
      </v-flex>
      </v-flex>
    </div>
  </div>
@endsection