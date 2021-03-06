<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="{{asset('css/vuetify.min.css')}}">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
  @yield('view.style')
  <title>@yield('title')</title>
</head>
<body>
<div id="app" v-cloak>
  <span class="v-cloak--block"></span>
  <v-app class="v-cloak--hidden leader">
    <v-container pa-0 fluid grid-list-xs text-xs-center>
      <v-layout column wrap>
        <header>
          <v-flex xs1>
            <navigation-menu/>
          </v-flex>
          <v-flex xs12 class="hidden-md-and-up" text-xs-center class="top-20">
            <a href="/"><img src="{{asset('images/logo.png')}}"/></a>
          </v-flex>
          <!--Верхнее меню-->
          <div class="header-menu hidden-sm-and-down">
            <div class="wrapper header-menu--center">
              <v-layout row wrap>
                <v-flex xs9 text-xs-left>
                  <v-list class="top-menu">
                    <v-list-tile class="top-menu__item"><a href="/about">О компании</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/article/list">Статьи</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/equipment">Оборудование</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/delivery">Доставка и оплата</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/contacts">Контакты</a></v-list-tile>
                  </v-list>
                </v-flex>
                <v-flex xs3 text-xs-right>
                  <div>
                    <a href="/admin" class="header-menu__auth-btn">Личный кабинет</a>
                  </div>
                </v-flex>
              </v-layout>
            </div>
            <div class="wrapper header-shadow">
              <v-layout row wrap>
                <v-flex class="telephone top-20" xs8 lg7 text-xs-right>
                  <v-layout row wrap>
                    <v-flex xs9>
                      Работаем с <b>{{config('info.time_start')}}</b> до <b>{{config('info.time_end')}}</b><br>
                      <span class="telephone__number">{{config('info.telephone')}}</span><br>
                      <img class="telephone__img" src="{{asset('images/telephone-img.png')}}" align="middle"/>
                      <a class="telephone__link" @click="showCallback">заказать звонок</a>
                    </v-flex>
                    <v-flex xs3 class="text-xs-right">
                      <a href="/"><img src="{{asset('images/logo.png')}}"/></a>
                    </v-flex>
                  </v-layout>
                </v-flex>
                <v-flex xs4 lg3 text-xs-left class="find top-20">
                  <input placeholder="Поиск по сайту" @keyup.enter="search" :value="searchText" class="find-input" type="text"><br><br>
                  <v-layout row wrap>
                    <v-flex xs2 text-xs-center>
                      <a href="/cart"><img src="{{asset('images/cart.png')}}" align="middle"/></a>
                    </v-flex>
                    <cart-widget>
                      <template slot-scope="slotProps">
                          <span class="cart__gold">@{{slotProps.count}}</span> товара на<br>
                          <span class="cart__gold">@{{slotProps.total}}</span> руб.
                      </template>
                    </cart-widget>
                  </v-layout>
                </v-flex>
              </v-layout>
            </div>
          </div>
          <!--Конец верхнего меню-->
        </header>
        @yield('menu')
        @yield('content')
        <footer>
          <div class="wrapper footers">
            <div>
              <v-layout row wrap>
                <v-flex xs2 class="footer__main-site text-xs-right hidden-md-and-down">
                  <v-flex xs11>
                    <a class="official-site" href="#">
                      <span text-xs-left>Посетить</span><br>
                      оффициальный сайт
                    </a>
                  </v-flex>
                  <v-flex xs2></v-flex>
                </v-flex>
                <v-flex xs2 text-xs-left class="hidden-md-and-down">
                  <a href="#"><img src="{{asset('images/social-f.png')}}"/></a>
                  <a href="#"><img src="{{asset('images/social-t.png')}}"/></a>
                  <a href="#"><img src="{{asset('images/social-ok.png')}}"/></a>
                  <a href="#"><img src="{{asset('images/social-v.png')}}"/></a>
                  <a href="#"><img src="{{asset('images/social-y.png')}}"/></a>
                </v-flex>
                <v-flex xs5 class="hidden-md-and-down">
                  <v-layout row wrap>
                    @foreach($productCategory->chunk(4) as $chunkProductCategory)
                      <v-flex xs6 class="footer__links">
                        <v-list class="footer__list">
                          @foreach($chunkProductCategory as $productCategory)
                            <v-list-tile>
                              <a href="/catalog/{{$productCategory->url_key}}">{{$productCategory->title}}</a>
                            </v-list-tile>
                          @endforeach
                        </v-list>
                      </v-flex>
                    @endforeach
                  </v-layout>
                </v-flex>
                <v-flex md3 xs8>
                  <img text-align-center src="{{asset('images/logo-footer.png')}}"/><br>
                  <span class="telephone__number">{{config('info.telephone')}}</span><br>
                  <img class="telephone__img" src="{{asset('images/telephone-img.png')}}" align="middle"/>
                  <a class="telephone__link" @click="showCallback">заказать звонок</a>
                  <div text-xs-center class="footer__address">
                    {{config('info.address')}}
                  </div>
                </v-flex>
              </v-layout>
            </div>
            <div class="hidden-md-and-down footer__menu-down">
              <br>
              <v-layout row wrap>
                <v-flex xs4 class="footer__copyright">
                  Copyright 2019. Все права защищены
                </v-flex>
                <v-flex xs8 text-xs-right>
                  <v-list class="top-menu">
                    <v-list-tile class="top-menu__item"><a href="/about">О компании</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/news/list">Новости</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/equipment">Оборудование</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/delivery">Доставка и оплата</a></v-list-tile>
                    <v-list-tile class="top-menu__item"><a href="/contacts">Контакты</a></v-list-tile>
                  </v-list>
                </v-flex>
              </v-layout>
            </div>
          </div>
        </footer>
      </v-layout>
    </v-container>
    <cart-modal></cart-modal>
    <callback></callback>
  </v-app>
</div>
<script src="{{mix('/js/main.js')}}" type="application/javascript"></script>
</body>
</html>