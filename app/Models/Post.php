<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //kullanıcı ve post ilişkisi
    public function user() {
        return $this->belongsTo(User::class);
    }

    // post kategori ilişkisi 
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
