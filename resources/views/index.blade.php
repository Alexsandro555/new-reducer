@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu/>
    </div>
  </div>
@endsection

@section('content')
  <div class="our-products">
    <div class="wrapper our-products-wrapper">
        <v-layout row wrap>
          <v-flex xs2 class="hidden-md-and-down">
            <div class="left-banner">
              <div class="left-banner__content text-xs-left">
                              <span>Мотор-<br>редукторы<br></span>
                двигатели и<br>компоненты<br>
                <p>
                  <a href="#">Подробнее</a>
                </p>
              </div>
              <img class="left-banner__img-ugl" src="{{asset('images/left-banner-layout-ugl.png')}}"/>
            </div>
          </v-flex>
          <v-flex xs10 text-xs-left class="bottom-20">
            <div class="content__left-our-products">
              <v-layout row wrap>
                <v-flex xs9>
                  <p class="headsite">
                    <span>Наша продукция</span><br>
                    <!--кто мы и что предлагаем-->
                  </p>
                </v-flex>
                <v-flex xs3 text-xs-right>
                  <a href="#" class="content-button content-button--margin">Смотреть каталог</a>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                @include('products',['products' => $ourProducts])
              </v-layout>
            </div>
          </v-flex>
        </v-layout>
    </div>
  </div>
  <div class="best-sale">
    <div class="wrapper">
      <v-flex xs12 text-xs-left class="bottom-20">
        <v-layout row wrap>
          <v-flex xs9>
            <p class="headsite_best-sale">
              <span>Лучшие продажи</span><br>
              популярные продукты
            </p>
          </v-flex>
          <v-flex xs3 text-xs-right>
            <a href="#" class="content-button">Смотреть каталог</a>
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          @include('products',['products' => $specialProducts])
        </v-layout>
      </v-flex>
    </div>
  </div>
  <div class="about">
    <div class="wrapper about__content">
      <v-layout row wrap>
        <v-flex md3 class="hidden-md-and-down">
          <p class="about__brands">
            Наши бренды
          </p>
          <div class="brands--wrapper">
            <div class="brands text-xs-center">
              <img src="{{asset('images/brands-images.png')}}"/>
            </div>
          </div><br>
          <p class="about__social">
            Мы в соцсетях
          </p>
          <a href="#">
            <img src="{{asset('images/about-social-f.png')}}"/>
          </a>
          <a href="#">
            <img src="{{asset('images/about-social-t.png')}}"/>
          </a>
          <a href="#">
            <img src="{{asset('images/about-social-ok.png')}}"/>
          </a>
          <a href="#">
            <img src="{{asset('images/about-social-vk.png')}}"/>
          </a>
          <a href="#">
            <img src="{{asset('images/about-social-y.png')}}"/>
          </a>
        </v-flex>
        <v-flex xs12 md6 text-xs-left pa-2 class="about__info">
          <p class="about__head">
            <span>О компании</span><br>
            особенности покупки в нашем магазине
          </p>
          <p>
            С 2009 года ООО Лидер активно поставляет промышленное оборудование импортного и отечественного производства
            для работы с сухими сыпучими продуктами в строительстве, производстве бетона, пищевой промышленности,
            производстве химических и фармацевтических продуктов, зерноперерабатывающая отрасль и др.
          </p>
          <p>
            Нашими клиентами являются более 3 000 компаний, а совместно с нашими партнерами было реализовано более 800 крупных
            проектов по модернизации производства в различных регионах России и странах СНГ.
          </p>
          <p>
            Наша компания работает только с проверенными поставщиками, выпускающими качественные изделия.
            Поставка оборудования осуществляется в кратчайшие сроки при помощи долгосрочных контрактов
            с нашими партнерами и наличия собственного склада, где всегда имеются наиболее востребованные позиции.
          </p>
          <!--<v-list class="about__list">
            <v-list-tile>Оплата производится по безналичному расчету.</v-list-tile>
            <v-list-tile>Возможна оплата наличными при доставке на объект Заказчика.</v-list-tile>
          </v-list>-->
        </v-flex>
        <v-flex xs3 text-xs-center class="hidden-md-and-down">
          <div text-xs-center>
            <div class="product-wrapper">
              <div class="product__lable-sale">
                Акция!
              </div>
              <img class="product__label--img" src="{{asset('images/label-sale.png')}}"/>
              <div class="product text-xs-center" >

                <div class="product-image-wrapper">
                  <div class="product-image">
                    <img src="{{asset('images/product-image.png')}}"/>
                  </div>
                </div>
                <div class="product__title">
                  <a href="#">Название электродвигателя</a>
                </div>
                <v-layout row wrap>
                  <v-flex xs8 text-xs-center>
                    <span class="product-old-price">25 366.00 руб.</span><br>
                    <span class="product-price-wrapper">
                                                        <span class="product-price">22 366.00</span> руб.
                                                    </span>
                  </v-flex>
                  <v-flex xs4>
                    <img class="btn-sale" src="{{asset('images/btn-sale.png')}}"/>
                  </v-flex>
                </v-layout>
              </div>
            </div>
          </div>
        </v-flex>
      </v-layout>
    </div>
  </div>
  <div class="news">
    <div class="wrapper news__content">
      <v-layout row wrap>
        <v-flex px-3 xs12 md8 text-xs-left>
          <v-layout row wrap>
            <v-flex xs8>
              <p class="about__head">
                <span>Новости индустрии</span><br>
                и нашей компании
              </p>
            </v-flex>
            <v-flex xs3 text-xs-right>
              <a href="/news/list" class="content-button">Все новости</a>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            @foreach($news as $oneNews)
              <v-flex xs3 class="news__block">
                <span class="news__number">{{$oneNews->id}}<span class="news__date">{{$oneNews->updated_at->format('d.m')}}</span></span><br>
                <a class="news__link" href="/news/{{$oneNews->url_key}}">{{$oneNews->title}}</a><br>
                {{str_limit(strip_tags($oneNews->content), $limit = 57, $end="...")}}
              </v-flex>
            @endforeach
          </v-layout>
        </v-flex>
        <v-flex class="hidden-md-and-down" xs4>
          <div class="news__big-image">
            <img src="{{asset('images/big-electric-motor.png')}}"/>
          </div>
        </v-flex>
      </v-layout>
    </div>
  </div>
@endsection