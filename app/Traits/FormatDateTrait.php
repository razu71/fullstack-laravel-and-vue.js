<?php


namespace App\Traits;


trait FormatDateTrait
{
    public function getCreatedAtAttribute($date){
        return date('dS M, Y', strtotime($date));
    }
}
