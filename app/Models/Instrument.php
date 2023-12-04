<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    protected $fillable=['tag','news_id'];
    protected $table='instrument';
}
