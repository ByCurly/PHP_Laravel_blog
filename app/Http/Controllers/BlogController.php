<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


use App\Models\Post;
use App\Models\Category;

class BlogController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index','show']);
        // $this->middleware('auth') controller ın hepsini auth kontolüne sokmak için kullanılır
        //->except(['index']) fonksiyonu ile index sayfasına herkes erişebilir deiğer sayfalar auth kontolündedir
    }

    public function index(Request $request){
        if($request->search){
            $posts = Post::where('title' , 'like' , '%' . $request->search . '%')
            ->orWhere('body' , 'like' , '%' . $request->search . '%')->latest()->paginate(4);
            //paginate() fonksiyonu ile 4 postu çekiyoruz sayfalandırma için kullanıyoruz
        }  elseif($request->category){
            $posts = Category::where('name', $request->category)->firstOrFail()->posts()->paginate(3)->withQueryString();
        }
         else {
            $posts = Post::latest()->paginate(4);
        }
        $categories = Category::all();
        return view('blogPosts.blog', compact('posts', 'categories'));
    }

    public function create(){
        $categories = Category::all();
        return view('blogPosts.create-blog-post', compact('categories'));
    }

    public function store(Request  $request){
        $request->validate([  //Gereklilik ayarları
            'title' => 'required',
            'image' => 'required | image',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $title=$request->input('title');
        $category_id=$request->input('category_id');
        //eski kayıt kontrolü yaptık
        if(Post::latest()->first() !== null){
            $postId =Post::latest()->take(1)->first()->id+1;
        } else {
            $postId = 1;
        }


        $slug = Str::slug($title,'-').'-'.$postId;
        $user_id = Auth::user()->id;
        $body = $request->input('body');

        //File Upluad....
        //post images klasorune public olarak kaydettik
        $imagePath= 'storage/'. $request->file('image')->store('postImages','public');

        $post = new Post();
        $post->title =$title;
        $post->category_id = $category_id;
        $post->slug = $slug;
        $post->user_id = $user_id;
        $post->body = $body;
        $post->imagePath = $imagePath;

        $post->save();

        return redirect()->back()->with('status', 'İçerik Başarılı Bİr Şekilde  Oluşturuldu');



       // dd('Validation passed. You can now request the input');   //   dd fonksiyonu ile ekrana dönüt sağlıyoruz.
        dd('Her şey yolunda ');

    }

    //using route model binding
    public function edit(Post $post){
        if(auth()->user()->id !== $post->user->id){ //url den adresi yazıp diğer kullanıcıları postlarını gücellemeyi engeleldik
            abort(403);
        }
        return view('blogPosts.edit-blog-post', compact('post'));
    }

    //using route model binding
    public function update(Request $request, Post $post){
        if(auth()->user()->id !== $post->user->id){ //url den adresi yazıp diğer kullanıcıları postlarını gücellemeyi engeleldik
            abort(403);
        }
        $request->validate([  //Gereklilik ayarları
            'title' => 'required',
            'image' => 'required | image',
            'body' => 'required'
        ]);

        $title=$request->input('title');

        $postId =$post->id;
        $slug = Str::slug($title,'-').'-'.$postId;
        $body = $request->input('body');

        //File Upluad....
        //post images klasorune public olarak kaydettik
        $imagePath= 'storage/'. $request->file('image')->store('postImages','public');

        
        $post->title =$title;
        $post->slug = $slug;
        
        $post->body = $body;
        $post->imagePath = $imagePath;

        $post->save();

        return redirect()->back()->with('status', 'İçerik Başarılı Bİr Şekilde  Güncellendi');



       // dd('Validation passed. You can now request the input');   //   dd fonksiyonu ile ekrana dönüt sağlıyoruz.
        dd('Her şey yolunda ');
    }
    

    // public function show($slug){
    //    $post = Post::where('slug',$slug)->first();
    // dd($post);
    //     return view('blogPosts.single-blog-post', compact('post'));
    // }
    
    //using route model binding
    public function show(Post $post){
        
        $category = $post->category;

        //benzer postları görüntülemek için ;
        $relatedPosts = $category->posts()->where('id', '!=', $post->id)->latest()->take(3)->get();
        //where('id', '!=', $post->id) okunulan içeriği aşağıda ilişkili olarak gösterilmesini engelledik
        //latest() ==> en son eklenene göre 
        //take(3) ==> 3 adet göster
        return view('blogPosts.single-blog-post', compact('post','relatedPosts'));
    }
    public function destroy(Post $post){
       $post->delete();
       return redirect()->back()->with('status', 'İçerik Başarılı Bİr Şekilde  Silindi');
    }
}
