<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSupport extends Model
{
    use HasFactory;
        protected $fillable = ['title','phoneNumber','content','supportstatus','type','store_id','status','is_deleted'];

          public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');

    }

}
