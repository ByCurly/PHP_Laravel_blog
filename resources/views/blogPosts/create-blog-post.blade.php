@extends('layout')

@section('head')
<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>         {{--Editör için eklediğimiz script --}}
@endsection

@section('main')
<main class="container" style="background-color: #fff;">
    <section id="contact-us">
        <h1 style="padding-top:50px;">İçerik Oluştur</h1>
        @include('includes.flash-message')
              <!-- Create Form -->
              <div class="contact-form">
                <form action="{{route('blog.store')}}" method="post"  enctype="multipart/form-data">
                    @csrf     {{--  <!-- @csrf   sanki kullanıcı oturum açmış gibi işlem yapmamıza olanak sağlıyor --> --}}
                  <!-- Başlık -->
                  <label for="title"><span>Title</span></label>
                  <input type="text" id="title" name="title" value="{{old('title')}}"/>
                    @error('title')
                        <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror
                  <!-- Resim -->
                  <label for="image"><span>Image</span></label>
                  <input type="file" id="image" name="image" />
                    @error('image')
                        <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror
                  <!--Drop Down-->
                  <label for="categories"><span>Kategori Seçiniz:</span></label>
                  <select style="padding:10px;" name="category_id" id="categories">
                      <option selected disabled>Kategoriler</option>                      
                      @foreach ($categories as $category )
                      <option value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                  </select>
                  @error('category_id')
                        <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror
                  <!-- İçerik -->
                  <label for="body"><span>Body</span></label>
                  <textarea id="body" name="body">{{old('body')}}</textarea>
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
