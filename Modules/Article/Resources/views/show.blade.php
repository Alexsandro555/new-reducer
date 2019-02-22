@extends('layouts.root')

@section('title', $article->title)

@section('menu')
    <left-menu></left-menu>
@endsection

@section('content')
    <section class="section">
        <div class="container catalog">
            <!--<left-menu></left-menu>-->
            <div class="product-catalog">
                <h1>
                    {{$article->title}}
                    <img src="{{asset("images/arrowed.png")}}" alt="" align="center">
                </h1>
                <br>
                <div class="article__showcontent">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('view.scripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
      $('.tabs').tabs(
        {
          active: 0
        }
      );
    </script>
@endsection