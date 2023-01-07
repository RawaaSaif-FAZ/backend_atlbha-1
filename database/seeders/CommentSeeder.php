<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            'comment_text' => 'منتج جيد',
            'rateing' => 4,
            'comment_for'=>'product',
            'user_id' => 3,
            'product_id'=>2
        ]);
          Comment::create([
            'comment_text' => 'متجر جيد',
            'rateing' => 4,
           'comment_for'=>'store',
            'user_id' => 3,
            'store_id'=>1
        ]);
        
    }
}