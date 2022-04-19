@extends('layout')

@section('head')
<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>         {{--Editör için eklediğimiz script --}}
@endsection

@section('main')
<main class="container" style="background-color: #fff;">
    <section id="contact-us">
        <h1 style="padding-top:50px;">İçeriği Düzenle !</h1>
        @include('includes.flash-message')
              <!-- Create Form -->
              <div class="contact-form">
                <form action="{{route('blog.update', $post)}}" method="post"  enctype="multipart/form-data">
                    @method('put')
                    @csrf     {{--  <!-- @csrf   sanki kullanıcı oturum açmış gibi işlem yapmamıza olanak sağlıyor --> --}}
                  <!-- Başlık -->
                  <label for="title"><span>Title</span></label>
                  <input type="text" id="title" name="title" value="{{ $post->title}}"/>
                    @error('title')
                        <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror
                  <!-- Resim -->
                  <label for="image"><span>Image</span></label>
                  <input type="file" id="image" name="image" />
                    @error('image')
                        <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror
                  <!-- İçerik -->
                  <label for="body"><span>Body</span></label>
                  <textarea id="body" name="body">{{$post->body}}</textarea>
                  @error('body')
                    <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                  @enderror


                   <!-- Button -->
                  <input type="submit" value="Submit" />
                </form>
              </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    //editör için eklediğimiz script

   CKEDITOR.replace( 'body' );
</script>
@endsection
