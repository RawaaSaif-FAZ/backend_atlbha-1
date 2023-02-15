<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = ['title','page_content','page_desc','seo_title','seo_link','seo_desc','tags','user_id','status','image','postcategory_id','store_id','is_deleted'];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
      public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function page_categories()
    {
       return $this->belongsToMany(
        Page_category::class,
            'pages_page_categories',
            'page_id',
            'page_category_id'
            );
    }

    public function postcategory()
    {
        return $this->belongsTo(Postcategory::class);
    }
    public function setImageAttribute($image)
    {
        if (!is_null($image)) {
            if (gettype($image) != 'string') {
                $i = $image->store('images/posts', 'public');
                $this->attributes['image'] = $image->hashName();
            } else {
                $this->attributes['image'] = $image;
            }
        }
    }

    public function getImageAttribute($image)
    {
        if (is_null($image)) {
            return   asset('assets/media/man.png');
        }
        return asset('storage/images/posts') . '/' . $image;
    }
  

}
