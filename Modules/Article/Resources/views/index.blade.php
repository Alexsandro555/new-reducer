@extends('layouts.root')

@section('title', 'статьи')

@section('menu')
  <left-menu></left-menu>
@endsection

@section('content')
  <section class="section">
    <div class="container catalog">
        <!--<left-menu></left-menu>-->
        <div class="product-catalog">
            <div class="articles">
                @foreach($articles as $article)
                    <div class="article">
                        <div class="article__content">
                            <a href="/article/{{$article->url_key}}"><h2>{{$article->title}}</h2></a><br>
                            <p>
                                {{str_limit(strip_tags($article->content), $limit = 350, $end="...")}}
                            </p>
                            <br>
                            <a class="article--button" href="/article/{{$article->url_key}}">Подробнее</a>
                        </div>
                        <div class="article__image">
                            @if($article->files->count()>0)
                                @foreach($article->files as $fileRecord)
                                    @foreach($fileRecord->config as $files)
                                        @foreach($files as $key => $file)
                                            @if($key == 'medium')
                                                <img src="/storage/{{$file['filename']}}" align="center"/>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @break
                                @endforeach
                            @else
                                <img src="{{asset('images/no-image-medium.png')}}"/>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
  </section>
@endsection

