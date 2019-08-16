@extends('layouts.master')

@section('content')
  <div class="our-products">
    <div class="wrapper">
      <v-layout row wrap>
        <filter-products3 :original="{{$products}}"/>
      </v-layout>
    </div>
  </div>
@endsection