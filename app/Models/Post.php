<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Qual tabela representa o posts
    // protected $table = 'posts';

    protected $fillable = ['title', 'content', 'image'];
}
