@extends('layout')

@section('head')
<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>         {{--Editör için eklediğimiz script --}}
@endsection

@section('main')
<main class="container" style="background-color: #fff;">
    <section id="contact-us">
        <h1 style="padding-top:50px;">Kategori Oluştur</h1>
            @include('includes.flash-message')
              <!-- Create Form -->
              <div class="contact-form">
                <form action="{{route('categories.store')}}" method="post"  >
                    @csrf     {{--  <!-- @csrf   sanki kullanıcı oturum açmış gibi işlem yapmamıza olanak sağlıyor --> --}}
                  <!-- Kategori adı -->
                  <label for="name"><span>Kategori Adı</span></label>
                  <input type="text" id="name" name="name" value="{{old('name')}}"/>
                    @error('name')
                        <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror

                   <!-- Button -->
                  <input type="submit" value="Submit" />
                </form>
              </div>
              <div class="create-categories">
                  <a href="{{route('categories.index')}}"> Kategori Listesi <span>&#8594;</span></a>
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
