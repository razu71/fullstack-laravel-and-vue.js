<?php

namespace App;

use App\Traits\FormatDateTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use FormatDateTrait;

    protected $fillable = ['categoryName', 'iconImage'];
}
