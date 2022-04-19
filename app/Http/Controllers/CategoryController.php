<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index','show']);
        // $this->middleware('auth') controller ın hepsini auth kontolüne sokmak için kullanılır
        //->except(['index']) fonksiyonu ile index sayfasına herkes erişebilir deiğer sayfalar auth kontolündedir
    }
    public function index()
    {
        $categories = Category::all();
        return view('categories.index-categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create-category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([  //Gereklilik ayarları
            'name' => 'required | unique:categories',
        ]);

        $name=$request->input('name');

        $category = new Category();
        $category->name = $name;

        $category->save();

        return redirect()->back()->with('status', 'Kategori Başarılı bir şekilde olusturuldu');



       // dd('Validation passed. You can now request the input');   //   dd fonksiyonu ile ekrana dönüt sağlıyoruz.
        dd('Her şey yolunda ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        return view('categories.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([  //Gereklilik ayarları
            'name' => 'required | unique:categories',
        ]);
        $name=$request->input('name');

        $category->name = $name;

        $category->save();

        return redirect(route('categories.index'))->with('status', 'Kategori Başarılı bir şekilde Güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('status', 'Kategori Silme İşlemi Başarılı ');
    }
}
