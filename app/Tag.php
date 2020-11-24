<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FormatDateTrait;

class Tag extends Model
{
    use FormatDateTrait;
    protected $fillable = ['tagName'];

//    protected $casts = ['created_at' => 'date'];
}
