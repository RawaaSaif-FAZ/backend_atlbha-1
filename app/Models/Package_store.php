<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package_store extends Model
{
    use HasFactory;
         protected $fillable = ['package_id','store_id','start_at','end_at','period'];

}
