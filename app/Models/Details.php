<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    protected $fillable=['important','effect','comment','news_id'];
    protected $table='details';
}
