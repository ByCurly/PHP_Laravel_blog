@extends('layout')


@section('header')

       <!-- header -->
       <header class="header" style="background-image: url({{ asset('images/photography.jpg')}});">
        <div class="header-text">
          <h1>Curly Blog</h1>
          <h4>Güvenilir İçeriklerin Adresi...</h4>
        </div>
        <div class="overlay"></div>
      </header>


@endsection


@section('main')

    <!-- main -->
     <main class="container">
        <h2 class="header-title">Son Blog Yazıları</h2>
        <section class="cards-blog latest-blog">

            @foreach ($posts as $post)
            <div class="card-blog-content">
                <img src="{{asset($post->imagePath)}}" alt="" />
                <p>
                  {{$post->created_at->diffForHumans()}}
                  <span>{{$post->user->name}}</span>
                </p>
                <h4>
                  <a href="{{ route('blog.show', $post)}}">{{$post->title}}</a>
                </h4>
              </div>
            @endforeach

        </section>
      </main>

@endsection

