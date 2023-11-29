<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    protected $fillable=['text','title','instrument','important','effect','comment'];
    protected $table='news';
}
