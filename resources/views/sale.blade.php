@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="true"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="sale-wrapper">
    <div class="sale">
      <v-layout>
        <v-flex xs12 md9 text-xs-left>
          <v-layout row wrap>
            <v-flex xs12 text-xs-left class="bottom-20">
              <p class="headsite">
                <span>{{$header}}</span><br>
              </p>
              <v-layout row wrap>
                <filter-products :products="{{$products}}"/>
              </v-layout>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </div>
  </div>
@endsection